<?php

namespace App\Http\Controllers\API;

use App\ReservingTool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataTable extends Controller
{
    //  API for Dashboard
    function reserved_equipment()
    {
        if (isset(\request()->filter) && \request()->filter != 0) {
            $equipments = ReservingTool::leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
                ->leftjoin('users', 'reserving_tools.user_id', '=', 'users.id')
                ->where('reserving_state', '1')
                ->where('reserving_tools.user_id', \request()->filter)
                ->select('equipments.name as equipment_name', 'equipments.code', 'equipments.serial', 'equipments.code', 'equipments.equipment_state', 'users.name as username', 'reserving_tools.updated_at', 'reserving_tools.created_at')
                ->get();
            $dataTable = [];
            foreach ($equipments as $index => $equipment) {
                $dataTable[] = [
                    $index + 1,
                    $equipment->equipment_name,
                    $equipment->code,
                    $equipment->serial,
                    equipmentState($equipment->equipment_state),
                    $equipment->username,
                    $equipment->updated_at->diffForHumans()
                ];
            }
        } else {
            $equipments = ReservingTool::leftjoin('equipments', 'reserving_tools.equipment_id', '=', 'equipments.id')
                ->leftjoin('users', 'reserving_tools.user_id', '=', 'users.id')
                ->where('reserving_state', '1')
                ->select('equipments.name as equipment_name', 'equipments.code', 'equipments.serial', 'equipments.code', 'equipments.equipment_state', 'users.name as username', 'reserving_tools.updated_at', 'reserving_tools.created_at')
                ->get();
            $dataTable = [];
            foreach ($equipments as $index => $equipment) {
                $dataTable[] = [
                    $index + 1,
                    $equipment->equipment_name,
                    $equipment->code,
                    $equipment->serial,
                    equipmentState($equipment->equipment_state),
                    $equipment->username,
                    $equipment->updated_at->diffForHumans()
                ];
            }
        }
        return response()->json([
            "data" => $dataTable
        ]);
    }

    function reserving_equipment()
    {
        $reserving = ReservingTool::where('reserving_state','=','0')->whereNull('approved_by')->get();
        $dataTable = [];
        foreach ($reserving as $index => $result) {
            $dataTable[] = [
                $index + 1,
                $result->description,
                reservingState((int)$result->reserving_state),
                $result->created_at->format('Y-m-d H:m:s'),
                $result->updated_at->format('Y-m-d H:m:s'),
                '<div class="row">
                                                    <div class="col-12 mb-1">
                                                        <button data-toggle="modal"
                                                                data-reserving_id="'.$result->id.'"
                                                                data-target="#exampleModal"
                                                                class="btn btn-success w-100"><i
                                                                class="fa fa-check"></i><br>ยอมรับ
                                                        </button>
                                                    </div>
                                                    <div class="col-12">
                                                        <form
                                                            action="'.route('admin.reserving.update',['id' => $result->id]).'"
                                                            method="post">
                                                            ' . csrf_token() . '
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
            "data" => $dataTable
        ]);
    }
}
