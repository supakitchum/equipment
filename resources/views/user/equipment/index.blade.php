@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">รายการครุภัณฑ์</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>ลำดับ</th>
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

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">สร้างคำร้องขอ</h5>
                            <button type="button" class="close" data-dismiss="modal"  aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('widget.form',[
                       'action' => route('user.reserving.store'),
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
                            <button type="button" class="btn btn-primary">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable'],'ajax' => route('user.equipments.dataTable')))
    <script>
        function choose(name,id,code) {
            $('#equipment_id').val(id)
            $('#name').val(name)
            $('#code').val(code)
        }
    </script>
@endsection
