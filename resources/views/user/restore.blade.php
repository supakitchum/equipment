@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <div class="alert alert-warning text-center">
                    <h3 class="p-0 m-0"><i class="fa fa-warning"></i> กรุณานำครุภัณฑ์นี้ไปคืนเพื่อซ่อมบำรุง</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" class="text-center"><b>รายละเอียดครุภัณฑ์</b></td>
                            </tr>
                            <tr>
                                <td><b>ชื่อ</b></td>
                                <td>{{ $equipment->name }}</td>
                            </tr>
                            <tr>
                                <td><b>หมวดหมู่</b></td>
                                <td>{{ $equipment->category }}</td>
                            </tr>
                            <tr>
                                <td><b>ประเภท</b></td>
                                <td>{{ $equipment->type }}</td>
                            </tr>
                            <tr>
                                <td><b>เลขครุภัณฑ์</b></td>
                                <td>{{ $equipment->code }}</td>
                            </tr>
                            <tr>
                                <td><b>รหัสครุภัณฑ์</b></td>
                                <td>{{ $equipment->serial }}</td>
                            </tr>
                            <tr>
                                <td><b>รายละเอียด</b></td>
                                <td>{{ $equipment->description }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" class="text-center"><b>รายละเอียดการยืม</b></td>
                            </tr>
                            <tr>
                                <td><b>คำร้องขอ</b></td>
                                <td>{!! $reserving->description !!}</td>
                            </tr>
                            <tr>
                                <td><b>ร้องขอเมื่อ</b></td>
                                <td>{{ $reserving->created_at }}</td>
                            </tr>
                            <tr>
                                <td><b>อนุมัติเมื่อ</b></td>
                                <td>{{ $reserving->updated_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
