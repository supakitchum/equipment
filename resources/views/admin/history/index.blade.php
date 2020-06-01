@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="card-title">ประวัติการทำรายการ</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable1">
                            <thead class="">
                            <th>ลำดับ</th>
                            <th>ชื่อผู้ร้อง</th>
                            <th>ชื่ออุปกรณ์</th>
                            <th>รายละเอียด</th>
                            <th>สถานะ</th>
                            <th>ร้องขอเมื่อ</th>
                            <th>อนุมัติเมื่อ</th>
                            <th>ส่งต่อเมื่อ</th>
                            <th>ปฎิเสธเมื่อ</th>
                            </thead>
                            <tbody>
                            @foreach($results as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result->username }}</td>
                                <td>{{ $result->equipment_name?: '-' }}</td>
                                <td>{!! $result->description !!}</td>
                                <td>{!! reservingState($result->reserving_state) !!}</td>
                                <td>{{ $result->request_date?:'-' }}</td>
                                <td>{{ $result->approve_date ?:'-' }}</td>
                                <td>{{ $result->transfer_date ?:'-' }}</td>
                                <td>{{ $result->reject_date ?:'-' }}</td>
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
    @include('widget.dataTable',array('tables' => ['dataTable1']))
@endsection
