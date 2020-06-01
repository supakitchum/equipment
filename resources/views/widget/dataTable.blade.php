<script>
    $(document).ready(function () {
        @foreach($tables as $table)
        $('#{{ $table }}').dataTable({
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
            }
            @if(isset($ajax))
            ,
            "ajax": '{{ $ajax }}'
            @endif
        });
        @endforeach
    });
</script>
