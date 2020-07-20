<?php

namespace App\Http\Controllers\Admin;

use App\Equipment;
use App\ReservingLog;
use App\ReservingTool;
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
        $results = ReservingTool::where('reserving_state', '=', '0')->whereNull('approved_by')->get();
        return view('admin.reserving.index')->with(['results' => $results]);
    }

    public function dataTable()
    {
        $results = ReservingTool::join('users','reserving_tools.user_id','=','users.id')
            ->where('reserving_state', '=', '0')
            ->whereNull('approved_by')
            ->select('reserving_tools.*','users.name as username')
            ->get();
        $dataTable = [];
        foreach ($results as $index => $result) {
            $dataTable[] = [
                $index + 1,
                $result->username,
                $result->description,
                reservingState((int)$result->reserving_state),
                $result->created_at->format('Y-m-d H:m:s'),
                $result->updated_at->format('Y-m-d H:m:s'),
                ' <div class="row">
                                                <div class="col-12 mb-1">
                                                    <button data-toggle="modal"
                                                            data-reserving_id="' . $result->id . '"
                                                            data-target="#exampleModal"
                                                            class="btn btn-success w-100"><i
                                                            class="fa fa-check"></i><br>ยอมรับ
                                                    </button>
                                                </div>
                                                <div class="col-12">
                                                    <form
                                                        action="' . route('admin.reserving.update', ['id' => $result->id]) . '"
                                                        method="post">
                                                        ' . csrf_field() . '
                                                        ' . method_field('put') . '
                                                        <input type="hidden" id="reserving_id" name="reserving_id"
                                                               value="' . $result->id . '">
                                                        <button name="method" value="1"
                                                                class="btn btn-danger w-100"><i
                                                                class="fa fa-close"></i><br>ปฎิเสธ
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>'
            ];
        }
        return response()->json([
            'data' => $dataTable
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = ReservingTool::where('reserving_state', '=', '0')->where('id', $id)->get();
        return view('admin.reserving.index')->with(['results' => $results]);
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
        if ($request->get('method') == 0) {
            try {
                //  อนุมัติ
                $result = ReservingTool::find($request->reserving_id);
                $uid = $result->user_id;
                $result->reserving_state = '1';
                $result->approved_by = auth()->user()->id;
                $result->equipment_id = $request->equipment_id;
                $result->save();

                $log = ReservingLog::where('reserving_id', $request->reserving_id)->update([
                    'approve_date' => Carbon::now()
                ]);

                $equipment = Equipment::where('code', $request->code)->update([
                    'equipment_state' => '1'
                ]);
                sendApproveNotification($uid, route('user.histories.show', ['id' => $request->reserving_id]));
                return redirect(route('admin.reserving.index'))->with([
                    'status' => [
                        'class' => 'success',
                        'message' => 'อนุมัติคำร้อง รหัส #' . $request->reserving_id . ' เรียบร้อยแล้ว'
                    ]
                ]);
            } catch (\Exception $exception) {
                return redirect(route('admin.reserving.index'))->with([
                    'status' => [
                        'class' => 'danger',
                        'message' => 'อนุมัติคำร้อง รหัส #' . $request->reserving_id . ' ไม่สำเร็จ กรุณาตรวจสอบข้อมูลให้ถูกต้อง และลองใหม่อีกครั้ง'
                    ]
                ]);
            }
        } else if ($request->get('method') == 1) {
            try {
                //  ปฎิเสธ
                $result = ReservingTool::find($request->reserving_id);
                $uid = $result->user_id;
                $result->reserving_state = '2';
                $result->approved_by = auth()->user()->id;
                $result->save();

                $log = ReservingLog::where('reserving_id', $request->reserving_id)->update([
                    'reject_date' => Carbon::now()
                ]);

                sendRejectNotification($uid, route('user.histories.show', ['id' => $request->reserving_id]));
                return redirect(route('admin.reserving.index'))->with([
                    'status' => [
                        'class' => 'success',
                        'message' => 'ปฎิเสธคำร้อง รหัส #' . $request->reserving_id . ' เรียบร้อยแล้ว'
                    ]
                ]);
            } catch (\Exception $exception) {
                return redirect(route('admin.reserving.index'))->with([
                    'status' => [
                        'class' => 'danger',
                        'message' => 'ปฎิเสธคำร้อง รหัส #' . $request->reserving_id . ' ไม่สำเร็จ กรุณาตรวจสอบข้อมูลให้ถูกต้อง และลองใหม่อีกครั้ง'
                    ]
                ]);
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
