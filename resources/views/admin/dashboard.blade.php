@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-wrench text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">ครุภัณฑ์ทั้งหมด</p>
                                    <p class="card-title" id="quick1">{{ $counts[0] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            อัพเดทตอนนี้
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-wrench text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">ครุภัณฑ์คงเหลือ</p>
                                    <p class="card-title" id="quick2">{{ $counts[1] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar-o"></i>
                            Last day
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-list text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">คำร้องขอรออนุมัติ</p>
                                    <p class="card-title" id="quick3">{{ $counts[2] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i>
                            In the last hour
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-check-circle text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">ครุภัณฑ์ที่ถูกยืม</p>
                                    <p class="card-title" id="quick4">{{ $counts[3] }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            Update now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if(checkRole('superadmin'))
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <h5 class="card-title">รายการครุภัณฑ์ที่ถูกยืม</h5>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-6 text-right">
                                            <label for="filter" class="mt-3">กรองโดยรายชื่อสมาชิก :</label>
                                        </div>
                                        <div class="col-6">
                                            <select onchange="getData()" style="background-color: #FFFFFF !important;"  class="selectpicker form-control p-0 m-0 show-tick" data-live-search="true" id="filter">
                                                <option value="0" selected>ทั้งหมด</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <thead>
                                    <th>ลำดับ</th>
                                    <th>ชื่อครุภัณฑ์</th>
                                    <th>เลขครุภัณฑ์</th>
                                    <th>รหัสครุภัณฑ์</th>
                                    <th>สถานะ</th>
                                    <th>ผู้ยืม</th>
                                    <th>ยืมไปแล้ว</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">รายการคำร้องล่าสุด 10 รายการ</h5>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table" id="last_reserving_table">
                                <thead>
                                <th>ลำดับ</th>
                                <th>รายละเอียดคำร้อง</th>
                                <th>สถานะ</th>
                                <th>ร้องขอเมื่อ</th>
                                <th>อัพเดทล่าสุดเมื่อ</th>
                                <th></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            @if(sizeof($reserving) > 10)
                                <a href="{{ route('admin.reserving.index') }}" class="btn btn-info w-100 text-center">ดูรายการทั้งหมด ({{ sizeof($reserving) }})</a>
                            @endif
                        </div>
                    </div>
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
                    <h5 class="modal-title">อนุมัติคำร้อง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.reserving.update',['id' => 0]) }}" method="post">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="method" value="0">
                        <input type="hidden" required id="equipment_id" name="equipment_id" value="">
                        <div class="row">
                            <div class="col-12 text-center" id="loadingMessage">
                                <img src="https://static.thenounproject.com/png/59262-200.png">
                            </div>
                            <div class="col-12 text-center">
                                <canvas id="canvas" hidden></canvas>
                            </div>
                            <div class="col-12 text-center">
                                <button onclick="scanQRCode()" type="button" class="btn btn-primary"><i
                                        class="fa fa-qrcode"></i> Scan QR Code
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="reserving_id" name="reserving_id" value="">
                        <div class="form-group">
                            สถานะอุปกรณ์<br>
                            <span id="status">ยังไม่ทราบ</span>
                        </div>
                        <div class="form-group">
                            <label for="code">รหัสครุภัณฑ์</label>
                            <input onchange="onchangeCode()" onmouseup="document.getElementById('code').select();" class="form-control" type="text" id="code" name="code"/>
                        </div>
                        <div class="form-group">
                            <label>ชื่อครุภัณฑ์</label>
                            <input id="name" readonly class="form-control" type="text" value="">
                        </div>
                        <div class="form-group">
                            <label>หมวดหมู่</label>
                            <input id="category" readonly class="form-control" type="text" value="">
                        </div>
                        <div class="form-group">
                            <label>ประเภท</label>
                            <input id="type" readonly class="form-control" type="text" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button id="submitButton" disabled type="submit" class="btn btn-success">อนุมัติคำร้อง</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var last_table = $('#last_reserving_table').DataTable({
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
            "ajax": '{{ route('dataTable.dashboard.reserving',['uid' => auth()->user()->id]) }}'
        });

        setInterval(function () {
            last_table.ajax.reload()
        },5000)

        var apiUrl = '{{ route('dataTable.dashboard.reserved') }}'
        var table_reserved;
        var start = true;
        function getData() {
            var uid = $('#filter').val()
            console.log(uid)
            if (start) {
                table_reserved = $('#dataTable').DataTable({
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
                    "ajax": uid == 0 ? apiUrl : apiUrl + `?filter=${uid}`
                });
                start = false;
            }else{
                table_reserved.destroy();
                table_reserved = $('#dataTable').DataTable({
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
                    "ajax": uid == 0 ? apiUrl : apiUrl + `?filter=${uid}`
                });
            }
        }
        getData()
    </script>
    <script>
        var video = document.createElement("video");
        var canvasElement = document.getElementById("canvas");
        var canvas = canvasElement.getContext("2d");
        var loadingMessage = document.getElementById("loadingMessage");

        function scanQRCode() {
            // Use facingMode: environment to attemt to get the front camera on phones
            navigator.mediaDevices.getUserMedia({video: {facingMode: "environment"}}).then(function (stream) {
                video.srcObject = stream;
                video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
                video.play();
                requestAnimationFrame(tick);
            });
        }

        function drawLine(begin, end, color) {
            canvas.beginPath();
            canvas.moveTo(begin.x, begin.y);
            canvas.lineTo(end.x, end.y);
            canvas.lineWidth = 4;
            canvas.strokeStyle = color;
            canvas.stroke();
        }

        function tick() {
            loadingMessage.innerText = "⌛ กำลังโหลดภาพจากกล้อง..."
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                loadingMessage.hidden = true;
                canvasElement.hidden = false;

                canvasElement.height = 250;
                canvasElement.width = 250;
                canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                var code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });
                if (code) {
                    drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                    drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                    drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                    drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                    $('#code').val(code.data)
                    getDetail(code.data);
                    video.pause();
                    video.srcObject = null;
                    return;
                }
            }
            requestAnimationFrame(tick);
        }

        function getDetail(code) {
            $.get('/api/equipment/' + code, function (data, status) {
                if (data.code == 0) {
                    if (data.result !== null) {
                        $('#name').val(data.result.name)
                        $('#category').val(data.result.category)
                        $('#type').val(data.result.type)
                        $('#equipment_id').val(data.result.id)
                        if (data.result.equipment_state !== '0') {
                            $('#status').html('<span class="badge badge-warning">ถูกใช้งานอยู่</span>')
                            $('#submitButton').prop('disabled', true);
                        } else {
                            $('#status').html('<span class="badge badge-success">พร้อมใช้งาน</span>')
                            $('#submitButton').prop('disabled', false);
                        }
                    } else {
                        Swal.fire('ไม่พบข้อมูล', 'ไม่พบอุปกรณ์จากรหัสนี้', 'error')
                        $('#code').val('');
                    }
                }
            })
        }

        function onchangeCode() {
            getDetail($('#code').val());
        }

        $('#exampleModal').on('show.bs.modal', function (event) {
            $('#code').val('')
            $('#name').val('')
            $('#category').val('')
            $('#type').val('')
            $('#equipment_id').val('')
            var button = $(event.relatedTarget)
            var reserving_id = button.data('reserving_id')
            var modal = $(this)
            modal.find('#reserving_id').val(reserving_id)
            setTimeout(function () {
                $('#code').focus();
            },500)
        })
    </script>
@endsection
