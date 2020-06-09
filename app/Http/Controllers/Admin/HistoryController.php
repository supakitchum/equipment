<?php

namespace App\Http\Controllers\Admin;

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
            ->leftjoin('users','reserving_tools.user_id','=','users.id')
            ->select('users.name as username','reserving_logs.approve_date','reserving_logs.transfer_date','reserving_logs.reject_date','reserving_logs.request_date','reserving_logs.return_date','reserving_logs.return_reason','equipments.name as equipment_name','equipments.code','reserving_tools.reserving_state','reserving_tools.description')
            ->get();
        return view('admin.history.index')->with(['results' => $results]);
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
        //
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
