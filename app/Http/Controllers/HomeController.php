<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\ReservingTool;
use App\TaskCalEquipment;
use App\User;
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
            $countEquipment = Equipment::all()->count();
            $reservedEquipment = Equipment::where('equipment_state','1')->count();
            return view('admin.dashboard')->with([
                "counts" => [
                    $countEquipment,
                    $countEquipment-$reservedEquipment,
                    ReservingTool::where('reserving_state','0')->count(),
                    $reservedEquipment
                ],
                "users" => User::where('role','user')->get(),
                "reserving" => ReservingTool::where('reserving_state','=','0')->whereNull('approved_by')->get()
            ]);
        } elseif (checkRole('user')) {
            $reserving = ReservingTool::leftjoin('equipments','reserving_tools.equipment_id','=','equipments.id')->where('user_id',auth()->user()->id)->where('reserving_state','1');
            $restore = ReservingTool::leftjoin('equipments','reserving_tools.equipment_id','=','equipments.id')->where('user_id',auth()->user()->id)->where('reserving_tools.restore_state',1);
            return view('user.dashboard')->with([
                "counts" => [
                    ReservingTool::where('reserving_state','0')->where('user_id',auth()->user()->id)->count(),
                    $reserving->count(),
                    ReservingTool::where('reserving_state','0')->where('approved_by',auth()->user()->id)->count(),
                    $restore->count(),
                ],
                "restores" => $restore->get(),
                "reserving" => $reserving->get()
            ]);
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
