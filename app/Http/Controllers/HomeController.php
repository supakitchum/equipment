<?php

namespace App\Http\Controllers;

use App\TaskCalEquipment;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        if (checkRole('superadmin') || checkRole('admin')) {
            return view('admin.dashboard');
        } elseif (checkRole('user')) {
            return view('user.dashboard');
        } else{
            return view('engineer.dashboard')->with([
                "counts" => [
                    TaskCalEquipment::where('user_id',auth()->user()->id)->count(),
                    TaskCalEquipment::where('user_id',auth()->user()->id)->where('state',0)->count(),
                    TaskCalEquipment::where('user_id',auth()->user()->id)->where('state',1)->count(),
                ],
                "works" => TaskCalEquipment::leftjoin('equipments','task_cal_equipments.equipment_id','=','equipments.id')
                    ->select('task_cal_equipments.*','equipments.name as equipment_name','equipments.code')
                    ->where('user_id',auth()->user()->id)
                    ->where('task_cal_equipments.state',0)
                    ->orderBy('task_cal_equipments.created_at','desc')
                    ->get()
            ]);
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->back();
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
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
