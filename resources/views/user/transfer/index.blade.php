@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="card-title">รายการครุภัณฑ์</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable1">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>ชื่ออุปกรณ์</th>
                                <th>สถานะ</th>
                                <th>ผู้ยืม</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($results as $index => $result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->equipment_name }}</td>
                                        <td>{!! reservingState((int)$result->reserving_state) !!}</td>
                                        <td>{{ $result->username }}</td>
                                        <td>
                                            <button class="w-100 btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="choose('{{ $result->equipment_name }}','{{ $result->equipment_id }}','{{ $result->equipment_code }}','{{ $result->id }}')">ขอยืม</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="card-title">รายการคำร้องแลกเปลี่ยนของฉัน</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable3">
                                <thead class="">
                                <th>ชื่ออุปกรณ์</th>
                                <th>ผู้ครอบครอง</th>
                                <th>ร้องขอเมื่อ</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($my_requests as $index => $result)
                                    <tr>
                                        <td>{{ $result->equipment_name }}</td>
                                        <td>{{ $result->username }}</td>
                                        <td>{{ $result->created_at }}</td>
                                        <td>
                                            <button class="w-100 btn btn-danger">ยกเลิก</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="card-title">คำร้องขอแลกเปลี่ยนรออนุมัติ</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable2">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>ชื่ออุปกรณ์</th>
                                <th>รายละเอียดคำร้อง</th>
                                <th>ผู้ขอยืม</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($requests as $index => $result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->equipment_name }}</td>
                                        <td>{!! $result->description !!}</td>
                                        <td>{{ $result->username }}</td>
                                        <td>
                                            <form action="{{ route('user.transfers.update',['id' => $result->id]) }}" method="post">
                                                @method('put')
                                                @csrf
                                                <button type="submit" name="method" value="1" class="w-100 mb-2 btn btn-success"><i class="fa fa-check"></i> อนุมัติ</button>
                                            </form>
                                            <form action="{{ route('user.transfers.update',['id' => $result->id]) }}" method="post">
                                                @method('put')
                                                @csrf
                                                <button type="submit" name="method" value="0" class="w-100 btn btn-danger"><i class="fa fa-close"></i> ปฎิเสธ</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">สร้างคำร้องขอ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('widget.form',[
                       'action' => route('user.transfers.store'),
                       'id' => 'transfer-form',
                       'method' => 'post',
                       'grid' => true,
                       'button' => false,
                       'elements' => [
                           [
                               'col' => 'd-none',
                               'tag' => 'input',
                               'name' => 'equipment_id',
                               'id' => 'equipment_id',
                               'label' => '',
                               'type' => 'hidden',
                               'placeholder' => '',
                               'readonly' => true
                           ],
                           [
                               'col' => 'd-none',
                               'tag' => 'input',
                               'name' => 'reserving_id',
                               'id' => 'reserving_id',
                               'label' => '',
                               'type' => 'hidden',
                               'placeholder' => '',
                               'readonly' => true
                           ],
                           [
                               'col' => 'col-sm-12 col-lg-12',
                               'tag' => 'input',
                               'name' => 'name',
                               'id' => 'name',
                               'label' => 'ชื่ออุปกรณ์',
                               'type' => 'text',
                               'placeholder' => '',
                               'required' => true,
                               'readonly' => true
                           ],
                           [
                               'col' => 'col-sm-12 col-lg-12',
                               'tag' => 'input',
                               'name' => 'code',
                               'id' => 'code',
                               'label' => 'รหัสอุปกรณ์',
                               'type' => 'text',
                               'required' => true,
                               'placeholder' => '',
                               'readonly' => true
                           ],
                           [
                               'col' => 'col-sm-12 col-lg-12',
                               'tag' => 'textarea',
                               'name' => 'description',
                               'id' => 'description',
                               'label' => 'รายละเอียดคำร้อง',
                               'required' => true
                           ],
                       ],
                       ])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                            <button type="button" onclick="submitForm()" class="btn btn-primary">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable1','dataTable2','dataTable3']))
    <script>
        function submitForm() {
            document.getElementById("transfer-form").submit();
        }
        function choose(name,id,code,reserving_id) {
            $('#equipment_id').val(id)
            $('#name').val(name)
            $('#code').val(code)
            $('#reserving_id').val(reserving_id)
        }
    </script>
@endsection
