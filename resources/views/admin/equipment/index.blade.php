@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <h2 class="card-title">รายการครุภัณฑ์</h2>
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('admin.equipments.create') }}" class="btn btn-success w-100"><i
                                        class="fa fa-plus"></i> เพิ่ม</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>รหัส</th>
                                <th>QR Code</th>
                                <th>ชื่อ</th>
                                <th>หมวดหมู่</th>
                                <th>ประเภท</th>
                                <th>รายละเอียด</th>
                                <th>สถานะ</th>
                                <th></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable'],'ajax' => route('admin.equipments.dataTable')))
@endsection
