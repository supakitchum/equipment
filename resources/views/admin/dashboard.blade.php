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
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">รายการคำร้องล่าสุด 10 รายการ</h5>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>
                                <th>ลำดับ</th>
                                <th>รายละเอียดคำร้อง</th>
                                <th>สถานะ</th>
                                <th>ร้องขอเมื่อ</th>
                                <th>อัพเดทล่าสุดเมื่อ</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($reserving as $index => $result)
                                    @if($index < 10)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{!! $result->description !!}</td>
                                            <td>{!! reservingState((int)$result->reserving_state) !!}</td>
                                            <td>{{ $result->created_at }}</td>
                                            <td>{{ $result->updated_at }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-12 mb-1">
                                                        <button data-toggle="modal"
                                                                data-reserving_id="{{ $result->id }}"
                                                                data-target="#exampleModal"
                                                                class="btn btn-success w-100"><i
                                                                class="fa fa-check"></i><br>ยอมรับ
                                                        </button>
                                                    </div>
                                                    <div class="col-12">
                                                        <form
                                                            action="{{ route('admin.reserving.update',['id' => $result->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" id="reserving_id" name="reserving_id"
                                                                   value="{{ $result->id }}">
                                                            <button name="method" value="1"
                                                                    class="btn btn-danger w-100"><i
                                                                    class="fa fa-close"></i><br>ปฎิเสธ
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
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
    @include('widget.dataTable',array('tables' => ['dataTable']))
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
