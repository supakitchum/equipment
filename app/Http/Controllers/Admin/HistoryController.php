<?php

namespace App\Http\Controllers\Admin;

use App\ReservingTool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;

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
        if (checkRole('admin')) {
            $results = ReservingTool::join('reserving_logs', 'reserving_tools.id', '=', 'reserving_logs.reserving_id')
                ->leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
                ->leftjoin('users', 'reserving_tools.user_id', '=', 'users.id')
                ->where('approved_by', auth()->user()->id)
                ->select('users.name as username', 'reserving_logs.approve_date', 'reserving_logs.transfer_date', 'reserving_logs.reject_date', 'reserving_logs.request_date', 'reserving_logs.return_date', 'reserving_logs.return_reason', 'equipments.name as equipment_name', 'equipments.code', 'reserving_tools.reserving_state', 'reserving_tools.description', 'equipments.code', 'equipments.serial')
                ->get();
        } else if (checkRole('superadmin')) {
            $results = ReservingTool::join('reserving_logs', 'reserving_tools.id', '=', 'reserving_logs.reserving_id')
                ->leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
                ->leftjoin('users', 'reserving_tools.user_id', '=', 'users.id')
                ->leftjoin('users as admin', 'reserving_tools.approved_by', '=', 'admin.id')
                ->select('admin.name as admin_name', 'reserving_tools.approved_by', 'users.name as username', 'reserving_logs.approve_date', 'reserving_logs.transfer_date', 'reserving_logs.reject_date', 'reserving_logs.request_date', 'reserving_logs.return_date', 'reserving_logs.return_reason', 'equipments.name as equipment_name', 'equipments.code', 'reserving_tools.reserving_state', 'reserving_tools.description', 'equipments.code', 'equipments.serial')
                ->get();
        }
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
        //
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

    public function excel(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        if (!isset($from) && !isset($to)) {
            $from = Carbon::yesterday();
            $to = Carbon::today();
        } else{
            $from = Carbon::parse($from.' 00:00:00')->subYear(543);
            $to = Carbon::parse($to.' 00:00:00')->subYear(543);
        }
        $reservings = ReservingTool::leftjoin('reserving_logs', 'reserving_tools.id', '=', 'reserving_logs.reserving_id')
            ->leftjoin('users', 'reserving_tools.user_id', '=', 'users.id')
            ->leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id');
        foreach ($request->state as $state) {
            $reservings = $reservings->orWhere('reserving_tools.reserving_state', $state);
        }

        $reservings = $reservings->whereBetween('reserving_tools.created_at', [$from, $to])
            ->select(
                'reserving_tools.*',
                'reserving_logs.approve_date',
                'reserving_logs.transfer_date',
                'reserving_logs.reject_date',
                'reserving_logs.request_date',
                'reserving_logs.return_date',
                'reserving_logs.return_reason',
                'users.name as username',
                'equipments.name as equipment_name',
                'equipments.code',
                'equipments.serial'
            )
            ->orderBy('users.name')
            ->get();
        $fetch_data = array();
        $header = array();
        $text_from = $request->from;
        $text_to = $request->to;
        array_push($header,[
            'ประวัติการทำรายการ ส่วนของเครื่องมือแพทย์' => 'ช่วงวันที่ '.$text_from.' - '.$text_to
        ]);
        foreach ($reservings as $reserving) {
            array_push($fetch_data, [
                "ชื่อผู้ร้อง" => $reserving->username,
                "เลขครุภัณฑ์" => $reserving->code,
                "รหัสครุภัณฑ์" => $reserving->serial,
                "ชื่ออุปกรณ์" => $reserving->equipment_name,
                "สถานะ" => reservingState($reserving->reserving_state,false),
                "จำนวนวันที่ถูกยืม" => isset($reserving->approve_date) ? (string)Carbon::parse($reserving->approve_date)->diff(Carbon::now())->days : '',
                "วันสร้างครุภัณฑ์" => isset($reserving->created_at) ? Carbon::parse($reserving->created_at)->addYear(543) : '',
                "วันที่ร้องขอ" => isset($reserving->request_date) ? Carbon::parse($reserving->request_date)->addYear(543) : '',
                "วันที่อนุมัติการยืม" => isset($reserving->approve_date) ? Carbon::parse($reserving->approve_date)->addYear(543) : '',
                "วันที่ปฎิเสธ" => isset($reserving->reject_date) ? Carbon::parse($reserving->reject_date)->addYear(543) : '',
                "วันที่แลกเปลี่ยน" => isset($reserving->transfer_date) ? Carbon::parse($reserving->transfer_date)->addYear(543) : '',
                "วันที่คืน" => isset($reserving->return_date) ? Carbon::parse($reserving->return_date)->addYear(543) : '',
                "เหตุผลที่คืน" => $reserving->return_reason,
            ]);
        }
        return \Excel::create('ประวัติการทำรายการ ส่วนของเครื่องมือแพทย์ ตั้งแต่' . $text_from . ' ถึง ' . $text_to, function ($excel) use ($fetch_data, $text_from, $text_to,$header) {
            $excel->setTitle('ประวัติการทำรายการ ส่วนของเครื่องมือแพทย์');
            $excel->sheet(str_replace('/','-',$text_from).' ถึง '.str_replace('/','-',$text_to), function ($sheet) use ($fetch_data,$header) {
                $sheet->fromArray($header, null, null, true);
                $sheet->fromArray($fetch_data, null, null, true);
                $sheet->row(1, 'test');
            });
        })->export('xlsx');
    }
}
