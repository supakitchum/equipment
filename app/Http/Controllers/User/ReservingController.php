<?php

namespace App\Http\Controllers\User;

use App\Equipment;
use App\Message;
use App\Notification;
use App\ReservingLog;
use App\ReservingTool;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservingController extends Controller
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

        return view('user.reserving.index')->with([
                'results' => ReservingTool::where('user_id', auth()->user()->id)->where('reserving_state','0')->orWhere('reserving_state', '4')->get(),
                'reserved' => ReservingTool::where('user_id', auth()->user()->id)
                    ->leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
                    ->where('reserving_state', '1')
                    ->select(
                        'reserving_tools.*',
                        'equipments.name as equipment_name'
                    )
                    ->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.reserving.create')->with([
            'results' => Equipment::where('equipment_state', '0')->groupBy('name')->get()
        ]);
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
            'name' => 'required'
        ]);

        //  สร้างข้อมูลการยืม
        $create = ReservingTool::create([
            'user_id' => auth()->user()->id,
            'equipment_id' => null,
            'approved_by' => null,
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

            // Send notification
            User::sendAllAdminNotification('REQUEST',1,route('admin.reserving.show', ['id' => $create->id]));

            return redirect(route('user.reserving.index'))->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ส่งคำร้องขอเรียบร้อย กรุณารอผู้ดูแลตรวจสอบ'
                ]
            ]);
        } else {
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
        $order = ReservingTool::find($id);
        $equipment = Equipment::find($order->equipment_id);
        $users = User::where('role','user')->where('id','!=',auth()->user()->id)->get();
        return view('user.reserving.transfer')->with([
            'order' => $order,
            'equipment' => $equipment,
            'users' => $users,
            'id' => $id
        ]);
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
        $old = ReservingTool::find($id);
        $new_user = User::find($request->user_id);
        if ($new_user->count() == 0){
            return redirect()->back()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ส่งคำร้องขอไม่สำเร็จ เนื่องจากไม่พบผู้ใช้ที่ต้องการ'
                ]
            ]);
        }

        // Log
        $old_log = ReservingLog::where('reserving_id',$id)->update([
            'transfer_date' => Carbon::now()
        ]);

        $create = ReservingTool::create([
            'user_id' => $request->user_id,
            'equipment_id' => $old->equipment_id,
            'approved_by' => null,
            'reserving_state' => '0',
            'description' => "ฉันต้องการส่งต่อการยืมอุปกรณ์นี้ไปให้ ". $new_user->email
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
            User::sendAllAdminNotification('TRANSFER',2,route('admin.reserving.show', ['id' => $create->id]));
            $old->reserving_state = '4';
            $old->save();
            return redirect(route('user.reserving.index'))->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ส่งคำร้องขอเรียบร้อย กรุณารอผู้ดูแลตรวจสอบ'
                ]
            ]);
        } else {
            return redirect()->back()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ส่งคำร้องขอไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
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
        $request = ReservingTool::find($id);
        $request->reserving_state = '2';

        $result = Equipment::find($request->equipment_id);
        $result->equipment_state = '0';

        ReservingLog::where('reserving_id', $request->id)->update([
            'reject_date' => Carbon::now()
        ]);

        try {
            $request->save();
            $result->save();
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ยกเลิกคำร้องขอสำเร็จ'
                ]
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ยกเลิกคำร้องขอไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }
}
