<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="../assets/img/favicon.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>
    {{ env('APP_NAME') }}
</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<!-- CSS Files -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="{{ asset('demo/demo.css') }}" rel="stylesheet" />
<link href="{{ asset('css/main.css') }}" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link href="{{ asset('css/datetimepicker/datepicker.css') }}" rel="stylesheet" media="screen">

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
{{--@if ($errors->any())--}}
{{--    <script>--}}
{{--        Swal.fire({--}}
{{--            icon: 'error',--}}
{{--            title: 'พบข้อผิดพลาด',--}}
{{--            html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>'--}}
{{--        })--}}
{{--    </script>--}}
{{--@endif--}}
