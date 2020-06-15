<?php

namespace App\Http\Controllers\User;

use App\Equipment;
use App\ReservingLog;
use App\ReservingTool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
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
        $results = ReservingTool::join('reserving_logs','reserving_tools.id','=','reserving_logs.reserving_id')
            ->leftjoin('equipments','reserving_tools.equipment_id','=','equipments.id')
            ->where('user_id',auth()->user()->id)
            ->select('reserving_logs.approve_date','reserving_logs.return_date','reserving_logs.return_reason','reserving_logs.transfer_date','reserving_logs.reject_date','reserving_logs.request_date','equipments.name as equipment_name','equipments.code','reserving_tools.reserving_state','reserving_tools.description')
            ->get();
        return view('user.history.index')->with(['results' => $results]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reserving = ReservingTool::find($id);
        if ($reserving->user_id !== auth()->user()->id){
            return redirect(route('notifications.index'))->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ไม่พบข้อมูล'
                ]
            ]);
        }
        $equipment = Equipment::find($reserving->equipment_id);
        if ($reserving->reserving_state == 1){
            return view('user.history.show')->with([
                'reserving' => $reserving,
                'equipment' => $equipment
            ]);
        }else{
            return view('user.history.reject')->with([
                'reserving' => $reserving,
                'equipment' => $equipment
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
