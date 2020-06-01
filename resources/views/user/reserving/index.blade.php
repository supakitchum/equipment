@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <h2 class="card-title">รายการคำร้องขอ</h2>
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('user.reserving.create') }}" class="btn btn-success w-100"><i
                                        class="fa fa-plus"></i> สร้างคำร้องขอ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>รายละเอียดคำร้อง</th>
                                <th>สถานะ</th>
                                <th>ร้องขอเมื่อ</th>
                                <th>อัพเดทล่าสุดเมื่อ</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($results as $index => $result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{!! $result->description !!}</td>
                                        <td>{!! reservingState((int)$result->reserving_state) !!}</td>
                                        <td>{{ $result->created_at }}</td>
                                        <td>{{ $result->updated_at }}</td>
                                        <td>
                                            @if($result->reserving_state == 0)
                                                <form action="{{ route('user.reserving.destroy',['id' => $result->id]) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger w-100"><i class="fa fa-close"></i> ยกเลิกคำร้อง</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="card-title">รายการครุภัณฑ์ที่ยืมอยู่</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable2">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>ชื่ออุปกรณ์</th>
                                <th>สถานะ</th>
                                <th>ร้องขอเมื่อ</th>
                                <th>อัพเดทล่าสุดเมื่อ</th>
                                </thead>
                                <tbody>
                                @foreach($reserved as $index => $result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->equipment_name }}</td>
                                        <td>{!! reservingState((int)$result->reserving_state) !!}</td>
                                        <td>{{ $result->created_at }}</td>
                                        <td>{{ $result->updated_at }}</td>
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
    @include('widget.dataTable',array('tables' => ['dataTable','dataTable2']))
@endsection
