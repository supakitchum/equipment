@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">ประวัติงาน</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>ชื่องาน</th>
                                <th>ชื่อครุภัณฑ์</th>
                                <th>รหัสครุภัณฑ์</th>
                                <th>ได้รับงานเมื่อ</th>
                                <th>เสร็จสิ้นเมื่อ</th>
                                <th>สถานะ</th>
                                </thead>
                                <tbody>
                                @foreach($results as $index => $result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->task_name }}</td>
                                        <td>{{ $result->equipment_name }}</td>
                                        <td>{{ $result->code }}</td>
                                        <td>{{ $result->assign_date ?: '-' }}</td>
                                        <td>{{ $result->complete_date ?: '-' }}</td>
                                        <td>{!! taskState($result->state) !!}</td>
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
    @include('widget.dataTable',array('tables' => ['dataTable']))
@endsection
