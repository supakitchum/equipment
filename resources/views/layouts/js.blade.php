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
<script>
    var count = 0;
    $(document).ready(function () {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        demo.initChartsPages();
    });

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
                if (count !== data.result.unread) {
                    count = data.result.unread;
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
