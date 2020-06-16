@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class=" fa fa-tasks"></i> รายละเอียดงาน</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="2" class="text-center"><b>รายละเอียดงาน</b></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>ชื่องาน</b></td>
                                        <td>{{ $task->task_name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>วันที่กำหนด</b></td>
                                        <td>{{ $task->due_date }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>คำอธิบาย</b></td>
                                        <td>{{ $task->description }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>สถานะ</b></td>
                                        <td>{!! $task->state ?  '<span class="badge badge-success text-uppercase">เสร็จสิ้น</span>' : '<span class="badge badge-info text-uppercase">กำลังดำเนินการ</span>'!!}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-lg-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="2" class="text-center"><b>รายละเอียดครุภัณฑ์</b></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>ชื่อ</b></td>
                                        <td>{{ $equipment->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>เลขครุภัณฑ์</b></td>
                                        <td>{{ $equipment->code }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>รหัสครุภัณฑ์</b></td>
                                        <td>{{ $equipment->serial }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>หมวดหมู่</b></td>
                                        <td>{{ $equipment->category }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>ประเภท</b></td>
                                        <td>{{ $equipment->type }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>คำอธิบาย</b></td>
                                        <td>{{ $equipment->description }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><b>สถานะ</b></td>
                                        <td>{!! equipmentState($equipment->equipment_state) !!}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
