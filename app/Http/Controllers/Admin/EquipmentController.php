<?php

namespace App\Http\Controllers\Admin;

use App\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('admin.equipment.index');
    }

    public function dataTable()
    {
        $results = Equipment::all();
        $dataTable = [];
        foreach ($results as $index => $result) {
            $dataTable[] = [
                $index + 1,
                $result->code,
                \QrCode::size(100)->generate($result->code),
                $result->name,
                $result->category,
                $result->type,
                $result->description,
                equipmentState($result->equipment_state),
                ' <div class="row">
                    <div class="col-12 mb-2">
                        <a href="' . route("admin.equipments.edit", ["id" => $result->id]) . '" class="btn btn-primary w-100"><i class="fa fa-print"></i></a>
                    </div>
                    <div class="col-12 mb-2">
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
            'name' => 'required|string',
            'category' => 'required|string',
            'type' => 'required|string',
            'maintenance_date' => 'required|string',
            'maintenance_type' => 'required|string',
            'description' => 'string|nullable',
            'equipment_state' => 'required'
        ]);
        while (true){
            $code = random_string();
            $check = Equipment::where('code',$code)->count();
            if ($check == 0)
                break;
        }
        $create = Equipment::create([
            'code' => $code,
            'name' => $validator['name'],
            'category' => $validator['category'],
            'type' => $validator['type'],
            'maintenance_date' => $validator['maintenance_date'],
            'maintenance_type' => $validator['maintenance_type'],
            'description' => $validator['description'],
            'equipment_state' => $validator['equipment_state']
        ]);
        if ($create){
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
        $validator = $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'type' => 'required|string',
            'maintenance_date' => 'required|string',
            'maintenance_type' => 'required|string',
            'description' => 'string|nullable',
            'equipment_state' => 'required'
        ]);
        $update = Equipment::find($id)->update($validator);
        if ($update){
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'แก้ไขข้อมูล สำเร็จ'
                ]
            ]);
        }else{
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'แก้ไขข้อมูล ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
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
        if ($del){
            return redirect()->back()->with([
                'status' => [
                    'class' => 'success',
                    'message' => 'ลบ '.$result->name.' สำเร็จ'
                ]
            ]);
        }else{
            return redirect()->back()->withInput()->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'ลบ '.$result->name.' ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
                ]
            ]);
        }
    }
}
