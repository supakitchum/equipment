@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <h2 class="card-title">รายการครุภัณฑ์</h2>
                            </div>
                            <div class="col-4 col-lg-2">
                                <a href="{{ route('admin.equipments.print',['code' => 'all']) }}" target="_blank" class="btn btn-primary w-100"><i class="fa fa-print"></i> พิมพ์ทั้งหมด</a>
                            </div>
                            <div class="col-12 col-lg-2">
                                <a href="{{ route('admin.equipments.create') }}" class="btn btn-success w-100"><i
                                        class="fa fa-plus"></i> เพิ่ม</a>
                            </div>
                            <div class="col-12 col-lg-2">
                                <button data-toggle="modal" data-target="#returnModal" class="btn btn-info w-100"><i
                                        class="fa fa-rotate-left"></i> คืนครุภัณฑ์
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="">
                                <th>ลำดับ</th>
                                <th>เลขครุภัณฑ์</th>
                                <th>รหัส</th>
                                <th>QR Code</th>
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
        </div>
    </div>
    <!-- Modal -->
    @section('assignModal_body')
        @csrf
        @method('PUT')
        <input type="hidden" name="assign" value="1">
        <div class="row">
            <div class="col-12" id="step1">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th class="text-center">ลำดับ</th>
                        <th>ชื่อ</th>
                        <th class="text-center">จำนวนงานตอนนี้</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach($engineers as $index => $engineer)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $engineer->name }}</td>
                                <td class="text-center">{{ $engineer->total_task }}</td>
                                <td>
                                    <button type="button"
                                            onclick="nextStep('{{ $engineer->id }}','{{ $engineer->name }}')"
                                            class="btn btn-success w-100"><i
                                            class="fa fa-check-circle"></i>
                                        มอบงานให้
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 d-none" id="step2">
                <input type="hidden" id="engineer_id" name="engineer_id" value="">
                <div class="form-group">
                    <label for="task_name">ชื่อช่าง</label>
                    <input id="engineer_name" type="text" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label for="task_name">ชื่องาน <span class="text-danger">(*)</span></label>
                    <input type="text"
                           class="form-control{{ $errors->has('task_name') ? ' is-invalid' : '' }}"
                           name="task_name" id="task_name" required>
                </div>
                <div class="form-group">
                    <label for="due_date">วันที่กำหนด <span class="text-danger">(*)</span></label>
                    <input type="date"
                           class="form-control{{ $errors->has('due_date') ? ' is-invalid' : '' }}"
                           name="due_date" id="due_date" required>
                </div>
                <div class="form-group">
                    <label for="description">รายละเอียด <span class="text-danger">(*)</span></label>
                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                              name="description" id="description" required></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">มอบหมายงาน</button>
            </div>
        </div>
    @endsection
    @include('widget.modal',[
        'size' => 'lg',
        'id' => 'assignModal',
        'footer' => false,
        'title' => '<b><i class="fa fa-address-book" aria-hidden="true"></i> รายชื่อช่าง</b>',
        'form' => [
            'id' => 'assign-form',
            'action' => '',
            'method' => 'post'
        ],
        'as' => 'assignModal'
    ]);

    @section('restoreModal_body')
        @csrf
        <input type="hidden" name="reserving_id" id="reserving_reserving_id" value="">
        <div class="form-group">
            <label>ชื่อครุภัณฑ์</label>
            <input class="form-control" id="reserving_equipment_name" type="text" disabled>
        </div>
        <div class="form-group">
            <label>รหัสครุภัณฑ์</label>
            <input class="form-control" id="reserving_equipment_code" type="text" disabled>
        </div>
        <div class="form-group">
            <label>ชื่อผู้ยืม</label>
            <input class="form-control" id="reserving_username" type="text" disabled>
        </div>
        <div class="form-group">
            <label>ยืมเมื่อ</label>
            <input class="form-control" id="reserving_approved_at" type="text" disabled>
        </div>
    @endsection
    @include('widget.modal',[
        'id' => 'restoreModal',
        'title' => '<b><i class="fa fa-rotate-right" aria-hidden="true"></i> เรียกคืนครุภัณฑ์</b>',
        'confirmButtonText' => 'เรียกคืน',
        'form' => [
            'id' => 'restore-form',
            'action' => route('admin.equipments.restore'),
            'method' => 'post'
        ],
        'as' => 'restoreModal',
    ]);
    @section('returnModal_body')
        @csrf
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
        <div class="form-group">
            สถานะอุปกรณ์<br>
            <span id="status"><span class="badge badge-info">ยังไม่ทราบ</span></span>
        </div>
        <div class="form-group">
            <label for="code">รหัสครุภัณฑ์</label>
            <input onchange="onchangeCode()" onmouseup="document.getElementById('return_code').select();" required class="form-control" type="text" id="return_code" name="code"/>
        </div>
        <div class="form-group">
            <label>ชื่อครุภัณฑ์</label>
            <input required id="return_name" readonly class="form-control" type="text">
        </div>
        <div class="form-group">
            <label>หมวดหมู่</label>
            <input id="return_category" readonly class="form-control" type="text" value="">
        </div>
        <div class="form-group">
            <label>ประเภท</label>
            <input id="return_type" readonly class="form-control" type="text" value="">
        </div>
        <div class="form-group">
            <label>เหตุผลการคืน</label>
            <textarea class="form-control" type="text" name="return_reason"></textarea>
        </div>
    @endsection
    @include('widget.modal',[
        'id' => 'returnModal',
        'title' => '<b><i class="fa fa-rotate-right" aria-hidden="true"></i> คืนครุภัณฑ์</b>',
        'confirmButtonText' => 'บันทึก',
        'confirmButtonId' => 'return-submit-btn',
        'confirmButtonDisabled' => true,
        'form' => [
            'id' => 'return-form',
            'action' => route('admin.equipments.return'),
            'method' => 'post'
        ],
        'as' => 'returnModal',
    ]);
@endsection
@section('script')
    @include('widget.dataTable',array('tables' => ['dataTable'],'ajax' => route('admin.equipments.dataTable')))
    <script>
        $("#return_code").keyup(function (event) {
            if (event.keyCode === 13) {
                getDetail($('#return_code').val());
            }
        })

        function nextStep(engineer_id, engineer_name) {
            $('#engineer_id').val(engineer_id);
            $('#step1').attr('class', 'col-12 d-none')
            $('#step2').attr('class', 'col-12')
            $('#engineer_name').val(engineer_name)
        }

        $('#restoreModal').on("show.bs.modal", function (e) {
            var equipment_id = $(e.relatedTarget).data('eid');
            $.get('{{ route('admin.equipments.reserved',['id' => '']) }}/' + equipment_id, function (res, error) {
                $('#reserving_equipment_name').val(res.equipment.name)
                $('#reserving_equipment_code').val(res.equipment.code)
                $('#reserving_username').val(res.user)
                $('#reserving_approved_at').val(res.reserving.updated_at)
                $('#reserving_reserving_id').val(res.reserving.id)
            })
        });

        $('#restoreModal').on("hide.bs.modal", function (e) {
            $('#reserving_equipment_name').val('')
            $('#reserving_equipment_code').val('')
            $('#reserving_username').val('')
            $('#reserving_approved_at').val('')
        });

        $('#returnModal').on("show.bs.modal", function (e) {
            $('#return_code').val('')
            $('#return_name').val('')
            $('#return_category').val('')
            $('#return_type').val('')
            $('#return_equipment_id').val('')
            $('#status').html('<span class="badge badge-info">ยังไม่ทราบ</span>')
            setTimeout(function () {
                $('#return_code').focus();
            },500)
        });

        $('#assignModal').on("show.bs.modal", function (e) {
            var equipment_id = $(e.relatedTarget).data('eid');
            var link = '{{ route('admin.equipments.index') }}';
            $('#assign-form').attr('action', `${link}/${equipment_id}`);
        });
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
                    $('#return_code').val(code.data)
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
                        $('#return_name').val(data.result.name)
                        $('#return_category').val(data.result.category)
                        $('#return_type').val(data.result.type)
                        $('#return_equipment_id').val(data.result.id)
                        if (data.result.equipment_state === '1') {
                            $('#status').html('<span class="badge badge-success">คืนได้</span>')
                            $('#return-submit-btn').prop('disabled', false);
                        } else {
                            $('#status').html('<span class="badge badge-danger">ครุภัณฑ์นี้คืนไม่ได้</span>')
                            $('#return-submit-btn').prop('disabled', true);
                        }
                    } else {
                        Swal.fire('ไม่พบข้อมูล', 'ไม่พบอุปกรณ์จากรหัสนี้', 'error')
                        $('#return_code').val('');
                    }
                }
            })
        }

        function onchangeCode() {
            getDetail($('#return_code').val());
        }
    </script>
@endsection
