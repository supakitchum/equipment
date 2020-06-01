@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="card-title">เปลี่ยนผู้ยืม</h2>
                            </div>
                            <div class="col-lg-3">
                                <a href="{{ route('user.reserving.index') }}" class="btn btn-primary w-100"><i
                                        class="fa fa-list"></i> รายการ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h5>ข้อมูลอุปกรณ์</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="font-weight-bold">ชื่อ :</td>
                                        <td>{{ $equipment->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">รหัส :</td>
                                        <td>{{ $equipment->code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">รายละเอียด :</td>
                                        <td>{{ $equipment->description }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">สถานะ :</td>
                                        <td>{!! equipmentState($equipment->state) !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">คุณยืมมาเมื่อ :</td>
                                        <td>{{ $order->created_at }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12">
                                <hr>
                                <h5>โอนให้</h5>
                                <div class="table-responsive">
                                    <table class="table" id="dataTable">
                                        <thead>
                                        <th>ลำดับ</th>
                                        <th>ชื่อ</th>
                                        <th>อีเมล</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $index=>$user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <button onclick="checkTransfer('{{ $user->id }}','{{ $user->email }}')" class="btn btn-success w-100">
                                                        <i class="fa fa-check-circle"></i> โอนให้
                                                    </button>
                                                </td>
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
        </div>
    </div>
    <form class="d-none" id="formUser" action="{{ route('user.reserving.update',['id' => $id]) }}" method="post">
        @method('put')
        @csrf
        <input required name="user_id" id="user_id" type="text">
    </form>
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable']))
    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        function checkTransfer(id,name) {
            $('#user_id').val(id)
            swalWithBootstrapButtons.fire({
                title: 'ยืมยันการเปลี่ยนผู้ยืม',
                text: "คุณต้องการเปลี่ยนอุปกรณ์นี้ไปที่ " + name + " ใช่หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่ใช่',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                   $('#formUser').submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            })
        }
    </script>
@endsection
