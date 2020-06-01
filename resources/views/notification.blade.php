@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3><i class="fa fa-inbox"></i> แจ้งเตือนทั้งหมด</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                        <tr>
                            <th>แจ้งเมื่อ</th>
                            <th>ข้อมูล</th>
                            <th>ลิงค์</th>
                            <th>สถานะ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $index=>$result)
                            <tr>
                                <td>{{ $result->created_at }}</td>
                                <td>{{ $result->text }}</td>
                                <td>
                                    <a href="{{ $result->link }}">{{ $result->link }}</a>
                                </td>
                                <td>{{ $result->status == 1 ? 'อ่านแล้ว' : 'ยังไม่ได้อ่าน' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable']))
@endsection
