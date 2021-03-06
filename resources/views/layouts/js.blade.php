<!--   Core JS Files   -->
<script src="{{ asset('js/core/jquery.min.js') }}"></script>
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Chart JS -->
<script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/paper-dashboard.min.js') }}"
        type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
{{--<script src="{{ asset('demo/demo.js') }}"></script>--}}
<script src="{{ asset('js/jsQR.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
<script src="{{ asset('js/datetimepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/datetimepicker/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('js/datetimepicker/locales/bootstrap-datepicker.th.js') }}"></script>

<script>
    $('.datepicker').datepicker();
    var count = 0;
    function readNotification(id,href) {
        $.get('/notification/'+id, function (data, status) {
            if (data.code === 0) {
                window.location.assign(href)
            }
        });
    }

    function getNotification() {
        $.get('/notifications/create', function (data, status) {
            if (data.code === 0) {
                if (count !== data.result.messages.length) {
                    count = data.result.messages.length;
                    $('#unread_count').text(data.result.unread)
                    data.result.messages.forEach((message) => {
                        if (message.status === 0){
                            $('#notification_messages').append(`<a href="#" class="dropdown-item" style="background-color: #f1f1f1;" onclick="readNotification(${message.id},'${message.link}')">${message.text}<br><small class="text-dark">${message.created_at}</small></a>`)
                        }else{
                            $('#notification_messages').append(`<a class="dropdown-item" href="${message.link}">${message.text}<br><small class="text-dark">${message.created_at}</small></a>`)
                        }
                    })
                    $('#notification_messages').append(`<a class="dropdown-item text-center" style="padding-right: 15px" href="/notifications">ดูแจ้งเตือนทั้งหมด</a>`)
                }
            }
        })
    }

    getNotification();
    setInterval(getNotification, 5000);
</script>
@if (session('status'))
    <script>
        @if(session('status')["class"] == "success")
        Swal.fire({
            icon: 'success',
            title: '{{ session('status')["message"] }}',
        })
        @elseif(session('status')["class"] == "warning")
        Swal.fire({
            icon: 'warning',
            title: '{{ session('status')["message"] }}',
        })
        @elseif(session('status')["class"] == "danger")
        Swal.fire({
            icon: 'error',
            title: '{{ session('status')["message"] }}',
        })
        @endif
    </script>
@endif
