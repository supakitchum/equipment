<?php

namespace App\Http\Controllers\User;

use App\Equipment;
use App\ReservingLog;
use App\ReservingTool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = ReservingTool::join('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
            ->join('users','reserving_tools.user_id','=','users.id')
            ->where('reserving_state', '1')
            ->where('user_id','!=',auth()->user()->id)
            ->select(
                'reserving_tools.*',
                'users.name as username',
                'equipments.name as equipment_name',
                'equipments.id as equipment_id',
                'equipments.code as equipment_code'
            )
            ->get();
        $requests = ReservingTool::leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
            ->leftjoin('users','reserving_tools.user_id','=','users.id')
            ->where('reserving_state', '0')
            ->where('approved_by',auth()->user()->id)
            ->select(
                'reserving_tools.*',
                'users.name as username',
                'equipments.name as equipment_name',
                'equipments.id as equipment_id',
                'equipments.code as equipment_code'
            )
            ->get();
        $my_requests = ReservingTool::leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
            ->leftjoin('users','reserving_tools.approved_by','=','users.id')
            ->where('reserving_state', '0')
            ->where('user_id',auth()->user()->id)
            ->whereNotNull('approved_by')
            ->select(
                'reserving_tools.*',
                'users.name as username',
                'equipments.name as equipment_name',
                'equipments.id as equipment_id',
                'equipments.code as equipment_code'
            )
            ->get();
        return view('user.transfer.index')->with(
            [
                'results' => $results,
                'requests' => $requests,
                'my_requests' => $my_requests
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'description' => 'required',
            'equipment_id' => 'required',
            'reserving_id' => 'required',
            'name' => 'required'
        ]);
        $old_reserved = ReservingTool::find($request->reserving_id);
        //  สร้างข้อมูลการยืม
        $create = ReservingTool::create([
            'user_id' => auth()->user()->id,
            'equipment_id' => $validator['equipment_id'],
            'approved_by' => $old_reserved->user_id,
            'reserving_state' => '0',
            'description' => "<b>ชื่ออุปกรณ์ที่ต้องการยืม</b><br>".$validator['name'] . "<br><b>รายละเอียดคำร้อง</b><br>".$validator['description']
        ]);
        if ($create) {
            //  สร้าง Log
            ReservingLog::create([
                'reserving_id' => $create->id,
                'approve_date' => null,
                'transfer_date' => null,
                'reject_date' => null,
                'request_date' => Carbon::now()
            ]);

            sendRequestNotification($old_reserved->user_id,route('user.transfers.show',['id' => $create->id]));

            return redirect(route('user.transfers.index'))->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ส่งคำร้องขอเรียบร้อย กรุณารอผู้ดูแลตรวจสอบ'
                ]
            ]);
        }else{
            return redirect()->back()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ส่งคำร้องขอไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  $id = reserving_id
        $validator = $request->validate([
            'method' => 'required'
        ]);
        if ($validator['method'] == 1){
            try{
                DB::beginTransaction();
                //  ยอมรับให้คนอื่นยืมต่อ
                $now = Carbon::now();
                $reserving = ReservingTool::find($id);
                $reserving_log = ReservingLog::where('reserving_id',$id)->first();
                $old_reserved = ReservingTool::where('equipment_id',$reserving->equipment_id)->where('reserving_state','1');

                //  Update Log
                $old_reserved_log = ReservingLog::where('reserving_id',$old_reserved->first()->id)->update([
                    "transfer_date" => $now
                ]);

                //  Update Old Reserving Transaction
                $old_reserved->update(["reserving_state" => "3"]);

                sendApproveNotification($reserving->user_id,route('user.transfers.show',['id' => $reserving->id]));

                //  Update New Reserving Transaction
                $reserving->reserving_state = '1';
                $reserving->save();
                $reserving_log->update([
                    "approve_date" => $now
                ]);
                DB::commit();
                return redirect(route('user.transfers.index'))->with([
                    'status' => [
                        'class' => 'success',
                        'message' => 'อนุมัติคำร้องขอเรียบร้อย'
                    ]
                ]);
            } catch (\Exception $e){
                DB::rollBack();
                throw $e;
            }
        } else{
            try{
                DB::beginTransaction();
                //  ปฎิเสธ
                $now = Carbon::now();
                $reserving = ReservingTool::find($id);
                $reserving_log = ReservingLog::where('reserving_id',$id)->first();

                //  Update New Reserving Transaction
                $reserving->reserving_state = '2';
                $reserving->save();
                $reserving_log->update([
                    "reject_date" => $now
                ]);
                DB::commit();
                return redirect(route('user.transfers.index'))->with([
                    'status' => [
                        'class' => 'success',
                        'message' => 'ปฎิเสธคำร้องขอเรียบร้อย กรุณารอผู้ดูแลตรวจสอบ'
                    ]
                ]);
            } catch (\Exception $e){
                DB::rollBack();
                throw $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
