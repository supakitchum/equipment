<?php

namespace App\Http\Controllers\User;

use App\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dataTable()
    {
        $results = Equipment::all();
        $dataTable = [];
        foreach ($results as $index => $result) {
            if ($result->equipment_state == 0){
                $button = ' <div class="row">
                    <div class="col-12 mb-2">
                        <button data-toggle="modal" onclick="choose('."'".$result->name ."'".',"'.$result->id.'","'.$result->code.'")" data-target="#exampleModal" class="btn btn-primary w-100">
                            ขอยืม
                        </button>
                    </div>
                   </div>';
            } else{
                $button = '';
            }
            $dataTable[] = [
                $index + 1,
                $result->name,
                $result->category,
                $result->type,
                $result->description,
                equipmentState($result->equipment_state),
                $button
            ];
        }
        return response()->json([
            'data' => $dataTable
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.equipment.index');
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
