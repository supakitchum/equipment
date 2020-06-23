<?php

namespace App\Http\Controllers\Admin;

use App\Equipment;
use App\ReservingLog;
use App\ReservingTool;
use App\TaskCalEquipment;
use App\TaskCalLog;
use App\User;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
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
        $engineers = User::leftjoin(\DB::raw('(SELECT * FROM `task_cal_equipments` WHERE state = 0) task_cal_equipments'),
            function ($join) {
                $join->on('users.id', '=', 'task_cal_equipments.user_id');
            })
            ->where('users.role', 'engineer')
            ->select(\DB::raw('COUNT(task_cal_equipments.id) AS total_task'), 'users.*')
            ->groupBy('users.id')
            ->orderBy('total_task', 'desc')
            ->get();
        return view('admin.equipment.index')->with([
            'engineers' => $engineers
        ]);
    }

    public function dataTable()
    {
        $results = Equipment::all();
        $dataTable = [];
        foreach ($results as $index => $result) {
            if ($result->equipment_state == 0 || $result->equipment_state == 4) {
                $engineer = '<div class="col-12 mb-2">
                        <button data-toggle="modal" data-target="#assignModal" data-eid="' . $result->id . '" class="btn btn-warning w-100"><i class="fa fa-wrench" aria-hidden="true"></i></button>
                    </div>';
            } elseif ($result->equipment_state == 1) {
                $engineer = '<div class="col-12 mb-2">
                             <button type="button" class="btn btn-warning w-100" data-eid="' . $result->id . '" data-toggle="modal" data-target="#restoreModal">
                                        <i class="fa fa-rotate-right"></i>
                             </button>
                             </div>';
            } else {
                $engineer = '';
            }
            $dataTable[] = [
                $index + 1,
                $result->code,
                $result->serial,
                \QrCode::size(100)->generate($result->code),
                $result->name,
                $result->category,
                $result->type,
                $result->description,
                equipmentState($result->equipment_state),
                ' <div class="row">
                    <div class="col-12 mb-2">
                        <a target="_blank" href="' . route("admin.equipments.print", ["code" => $result->code]) . '" class="btn btn-primary w-100"><i class="fa fa-print"></i></a>
                    </div>
                    ' . $engineer . '<div class="col-12 mb-2">
                        <a href="' . route("admin.equipments.edit", ["id" => $result->id]) . '" class="btn btn-info w-100"><i class="fa fa-edit"></i></a>
                    </div>
                    <div class="col-12">
                    <form action="' . route("admin.equipments.destroy", ["id" => $result->id]) . '" method="post">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger w-100"><i class="fa fa-trash"></i></button>
                    </form>
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
        return view('admin.equipment.create');
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
            'name' => 'required',
            'category' => 'required|string',
            'type' => 'required|string',
            'description' => 'string|nullable',
            'equipment_state' => 'required',
            'serial' => 'required',
            'code' => 'required'
        ]);

        if ($validator['name'] == 1) {
            $name = "Infusomat Space P";
        } else if ($validator['name'] == 2) {
            $name = "Pole Clamp";
        } else if ($validator['name'] == 3) {
            $name = "Power Supply";
        } else {
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'บันทึกข้อมูลครุภัณฑ์ ไม่สำเร็จ ไม่พบอุปกรณ์นี้'
                ]
            ]);
        }
        $create = Equipment::create([
            'code' => $validator['code'],
            'name' => $name,
            'category' => $validator['category'],
            'type' => $validator['type'],
            'description' => $validator['description'],
            'equipment_state' => $validator['equipment_state'],
            'serial' => $validator['serial'],

        ]);
        if ($create) {
            return redirect(route('admin.equipments.index'))->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'บันทึกข้อมูลครุภัณฑ์ สำเร็จ'
                ]
            ]);
        } else {
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'บันทึกข้อมูลครุภัณฑ์ ไม่สำเร็จ กรุณาตรวจสอบข้อมูล และลองใหม่อีกครั้ง'
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
        $result = Equipment::find($id);
        return view('admin.equipment.edit')->with([
            'id' => $id,
            'result' => $result
        ]);
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
        if (isset($request->assign) && $request->assign == 1) {
            //  มอบหมายงานให้ช่าง
            $validator = $request->validate([
                'engineer_id' => 'required',
                'due_date' => 'required',
                'description' => 'required|string',
                'task_name' => 'required|string'
            ]);
            try {
                DB::beginTransaction();
                Equipment::find($id)->update([
                    'equipment_state' => '2'
                ]);

                $new_task = TaskCalEquipment::create([
                    'task_name' => $request->task_name,
                    'equipment_id' => $id,
                    'user_id' => $request->engineer_id,
                    'due_date' => $request->due_date,
                    'description' => $request->description,
                    'state' => 0
                ]);

                TaskCalLog::create([
                    'task_id' => $new_task->id,
                    'assign_date' => Carbon::now(),
                    'complete_date' => null
                ]);
                DB::commit();
                sendAlertNotification($validator['engineer_id'], route('engineer.tasks.show', ['id' => $new_task->id]));
                return redirect()->back()->with([
                    'status' => [
                        'class' => 'success',
                        'message' => 'บันทึกมอบหมายงานสำเร็จ'
                    ]
                ]);
            } catch (\Exception $exception) {
                DB::rollBack();
                return redirect()->back()->withInput()->with([
                    'status' => [
                        'class' => 'danger',
                        'message' => 'บันทึกไม่สำเร็จ กรุณาตรวจสอบข้อมูลให้ครบถ้วน'
                    ]
                ]);
            }
        } else {
            $validator = $request->validate([
                'name' => 'required|string',
                'category' => 'required|string',
                'type' => 'required|string',
                'description' => 'string|nullable',
                'equipment_state' => 'required',
                'serial' => 'required'
            ]);
            $update = Equipment::find($id)->update($validator);
            if ($update) {
                return redirect()->back()->with([
                    'status' => [
                        'class' => 'success',
                        'message' => 'แก้ไขข้อมูล สำเร็จ'
                    ]
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'status' => [
                        'class' => 'danger',
                        'message' => 'แก้ไขข้อมูล ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
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
        $result = Equipment::find($id);
        $del = $result->delete();
        if ($del) {
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ลบ ' . $result->name . ' สำเร็จ'
                ]
            ]);
        } else {
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ลบ ' . $result->name . ' ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }

    public function reserved($id)
    {
        $equipment = Equipment::find($id);
        $reserving = ReservingTool::where('equipment_id', $id)->where('reserving_state', '1')->first();
        $user = User::find($reserving->user_id);
        return response()->json([
            'user' => $user->name,
            'reserving' => $reserving,
            'equipment' => $equipment
        ]);
    }

    public function restore(Request $request)
    {
        try {
            $reserving = ReservingTool::find($request->reserving_id);
            if ($reserving->reserving_state !== '1') {
                return redirect()->back()->withInput()->with([
                    'status' => [
                        'class' => 'danger',
                        'message' => 'อุปกรณ์ที่คุณเรียกคืน ไม่ได้อยู่ในสถานะถูกยืม กรุณาตรวจสอบข้อมูลใหม่และลองอีกครั้ง'
                    ]
                ]);
            }

            $reserving->update([
                'restore_state' => 1
            ]);
            sendRestoreNotification($reserving->user_id, route('notification.restore', ['id' => $reserving->id]));
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ส่งข้อความเพื่อเรียกคืนอุปกรณ์สำเร็จ'
                ]
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ส่งข้อความเพื่อเรียกคืนอุปกรณ์ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }

    public function return(Request $request)
    {
        try {
            DB::beginTransaction();
            $equipment = Equipment::where('code', $request->code)->first();
            $reserving = ReservingTool::where('equipment_id', $equipment->id)->where('reserving_state', '1')->first();

            if ($reserving->restore_state){
                Equipment::find($equipment->id)->update([
                    'equipment_state' => '4'
                ]);
            } else{
                Equipment::find($equipment->id)->update([
                    'equipment_state' => '0'
                ]);
            }
            ReservingTool::find($reserving->id)->update([
                'reserving_state' => '5',
                'restore_state' => 0
            ]);

            ReservingLog::where('reserving_id', $reserving->id)->update([
                'return_date' => Carbon::now(),
                'return_reason' => $request->return_reason ?: null
            ]);
            DB::commit();
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'แก้ไขสถานะสำเร็จ'
                ]
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'บันทึกไม่สำเร็จ กรุณาตรวจสอบข้อมูลให้ครบถ้วน'
                ]
            ]);
        }
    }

    public function printQR($code){
        if ($code == 'all'){
            $equipments = Equipment::all();
        }else{
            $equipments = Equipment::where('code',$code);
            if ($equipments->count() == 0){
                return redirect(route('admin.equipments.index'))->with([
                    'status' => [
                        'class' => 'danger',
                        'message' => 'ไม่พบเลขครุภัณฑ์นี้ในระบบ'
                    ]
                ]);
            }
            $equipments = $equipments->get();
        }

        $pdf = \PDF::loadView('pdf',[
            'equipments' => $equipments
        ]);
        return @$pdf->stream();

    }
}
