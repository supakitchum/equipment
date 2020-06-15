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
                            <th>ข้อความ</th>
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
                                    @if($result->status == 1)
                                        <a href="{{ $result->link }}">{{ $result->link }}</a>
                                    @else
                                        <a href="#" onclick="readNotification({{ $result->id }},'{{ $result->link }}')">{{ $result->link }}</a>
                                    @endif
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
    <script>
        $(document).ready(function () {
            $('#dataTable').dataTable({
                "responsive": true,
                "language": {
                    "lengthMenu": "แสดง _MENU_ รายการ ต่อหน้า",
                    "loadingRecords": "กำลังดาวน์โหลดข้อมูล",
                    "zeroRecords": "ไม่พบข้อมูล",
                    "info": "แสดงรายการที่ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "infoEmpty": "แสดงรายการที่ 0 ถึง 0 ของ 0 รายการ",
                    "infoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                    "search": "ค้นหา :",
                    "paginate": {
                        "first": "อันแรก",
                        "last": "สุดท้าย",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    }
                },
                "order": [[ 0, "desc" ]]
            });
        });
    </script>

@endsection
