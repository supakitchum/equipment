@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-globe text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">จำนวนคำร้องขอยืม</p>
                                    <p class="card-title" id="quick1">{{ $counts[0] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            อัพเดทตอนนี้
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">ครุภัณฑ์ที่ยืมอยู่</p>
                                    <p class="card-title" id="quick2">{{ $counts[1] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar-o"></i>
                            Last day
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-vector text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">คำร้องขอแลกเปลี่ยนรออนุมัติ</p>
                                    <p class="card-title" id="quick3">{{ $counts[2] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i>
                            In the last hour
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-favourite-28 text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">ครุภัณฑ์ที่ถูกเรียกคืน</p>
                                    <p class="card-title" id="quick4">{{ $counts[3] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            Update now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">รายการครุภัณฑ์ที่ถูกเรียกคืน</h5>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table" id="dataTable1">
                                <thead>
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
                                <th>เลขครุภัณฑ์</th>
                                <th>รหัสครุภัณฑ์</th>
                                <th>หมวดหมู่</th>
                                <th>ประเภท</th>
                                <th>รายละเอียด</th>
                                </thead>
                                <tbody>
                                @foreach($restores as $index=>$result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->code }}</td>
                                        <td>{{ $result->serial }}</td>
                                        <td>{{ $result->category }}</td>
                                        <td>{{ $result->type }}</td>
                                        <td>{{ $result->description }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">รายการครุภัณฑ์ที่คุณยืมอยู่</h5>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table" id="dataTable2">
                                <thead>
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
                                <th>เลขครุภัณฑ์</th>
                                <th>รหัสครุภัณฑ์</th>
                                <th>หมวดหมู่</th>
                                <th>ประเภท</th>
                                <th>รายละเอียด</th>
                                </thead>
                                <tbody>
                                @foreach($reserving as $index=>$result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->code }}</td>
                                        <td>{{ $result->serial }}</td>
                                        <td>{{ $result->category }}</td>
                                        <td>{{ $result->type }}</td>
                                        <td>{{ $result->description }}</td>
                                    </tr>
                                @endforeach
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
    @include('widget.dataTable',array('tables' => ['dataTable1','dataTable2']))
@endsection
