<?php

namespace App\Http\Controllers\Engineer;

use App\Equipment;
use App\TaskCalEquipment;
use App\TaskCalLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
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
        $results = TaskCalEquipment::leftjoin('equipments','task_cal_equipments.equipment_id','=','equipments.id')
            ->select('task_cal_equipments.*','equipments.name as equipment_name','equipments.code')
            ->where('user_id',auth()->user()->id)
            ->where('task_cal_equipments.state',0)
            ->get();
        return view('engineer.task.index')->with([
            'results' => $results
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $task = TaskCalEquipment::find($id);

            Equipment::find($task->equipment_id)->update([
                'equipment_state' => 0
            ]);

            $task->update([
                'state' => 1
            ]);

            TaskCalLog::where('task_id',$id)->update([
                'complete_date' => Carbon::now()
            ]);

            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'อัพเดทสถานะสำเร็จ'
                ]
            ]);
        }catch (\Exception $e){
            return redirect()->back()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'อัพเดทสถานะไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
