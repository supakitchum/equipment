@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10 col-12">
                                <h3 class="card-title">ประวัติการทำรายการ</h3>
                            </div>
                            <div class="col-lg-2 col-12">
                                <button data-toggle="modal" data-target="#printHistoryModal" class="btn btn-info w-100">
                                    <i class="fa fa-file-excel-o"></i> นำออกประวัติ
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable1">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>เลขครุภัณฑ์</th>
                                <th>รหัสครุภัณฑ์</th>
                                <th>ชื่ออุปกรณ์</th>
                                <th>ชื่อผู้ร้อง</th>
                                <th>สถานะ</th>
                                <th>ร้องขอเมื่อ</th>
                                <th>อนุมัติเมื่อ</th>
                                @if(checkRole('superadmin'))
                                    <th>ผู้อนุมัติ</th>
                                @endif
                                <th>ส่งต่อเมื่อ</th>
                                <th>คืนเมื่อ</th>
                                <th>เหตุผลการคืน</th>
                                <th>ปฎิเสธเมื่อ</th>
                                </thead>
                                <tbody>
                                @foreach($results as $index => $result)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $result->code?: '-' }}</td>
                                        <td>{{ $result->serial?: '-' }}</td>
                                        <td>{{ $result->equipment_name?: '-' }}</td>
                                        <td>{{ $result->username }}</td>
                                        <td>{!! reservingState($result->reserving_state) !!}</td>
                                        <td>{{ $result->request_date?:'-' }}</td>
                                        <td>{{ $result->approve_date ?:'-' }}</td>
                                        @if(checkRole('superadmin'))
                                            <td>{{ $result->admin_name }}</td>
                                        @endif
                                        <td>{{ $result->transfer_date ?:'-' }}</td>
                                        <td>{{ $result->return_date ?:'-' }}</td>
                                        <td>{{ $result->return_reason ?:'-' }}</td>
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
        <!-- Modal -->
        @section('printHistoryModal_body')
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="from">จากวันที่</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" id="from" name="from" data-provide="datepicker" data-date-format="yyyy/mm/dd" value="{{ \Carbon\Carbon::yesterday()->addYear(543)->format('Y/m/d') }}" class="form-control w-100"
                                   data-date-language="th-th"/>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="end">ถึงวันที่</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" id="end" name="to" data-provide="datepicker" data-date-format="yyyy/mm/dd" value="{{ \Carbon\Carbon::today()->addYear(543)->format('Y/m/d') }}" class="form-control w-100"
                                   data-date-language="th-th"/>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label>สถานะ</label>
                    <div class="form-group">
                        <input type="checkbox" value="1" name="state[]" checked>
                        <label class="form-check-label">
                            Approved
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" value="2" name="state[]">
                        <label class="form-check-label">
                            Rejected
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" value="3" name="state[]">
                        <label class="form-check-label">
                            Transferred
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" value="4" name="state[]">
                        <label class="form-check-label">
                            Transferring
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" value="5" name="state[]">
                        <label class="form-check-label">
                            Return
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    ​<button type="submit" class="btn btn-success w-100">ออกรายงาน</button>
                </div>
            </div>
        @endsection
        @include('widget.modal',[
            'size' => 'md',
            'id' => 'printHistoryModal',
            'footer' => false,
            'title' => '<b><i class="fa fa-file-excel-o" aria-hidden="true"></i> นำออกรายงาน</b>',
            'form' => [
                'id' => 'printHistoryForm',
                'action' => route('admin.excel'),
                'method' => 'post'
            ],
            'as' => 'printHistoryModal'
        ]);
    </div>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable1']))
@endsection
