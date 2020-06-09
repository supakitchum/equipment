@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">รายการงานที่ได้รับ</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>ชื่องาน</th>
                                <th>ชื่อครุภัณฑ์</th>
                                <th>รหัสครุภัณฑ์</th>
                                <th>วันที่กำหนด</th>
                                <th>รายละเอียด</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($results as $index => $result)
                                    <tr>
                                        <td>{{ $result->task_name }}</td>
                                        <td>{{ $result->equipment_name }}</td>
                                        <td>{{ $result->code }}</td>
                                        <td>{{ $result->due_date }}</td>
                                        <td>{{ $result->description }}</td>
                                        <td>
                                            <form id="submit-{{ $result->id }}"
                                                  action="{{ route('engineer.tasks.update',['id' => $result->id]) }}"
                                                  method="post">
                                                @csrf
                                                @method('put')
                                            </form>
                                            <button class="btn btn-success w-100"
                                                    onclick="confirmForm('{{ $result->id }}')">
                                                <i class="fa fa-check-circle"></i>
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
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable']))
    <script>
        function confirmForm(id) {
            Swal.fire({
                title: 'ยืนยันสถานะ',
                text: "คุณซ่อมอุปกรณ์ชิ้นนี้เสร็จแล้ว ใช่หรือไม่?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28d06b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ฉันซ่อมเสร็จแล้ว',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.value) {
                    document.getElementById('submit-' + id).submit();
                }
            })
        }
    </script>
@endsection
