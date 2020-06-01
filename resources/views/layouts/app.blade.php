<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body class="{{ isset($class) ? $class:''}}">
@if(\Request::is('login'))
    <div class="wrapper ">
        @yield('content')
    </div>
@else
    <div class="wrapper ">
        @include('layouts.sidebar')
        <div class="main-panel">
            <!-- Navbar -->
            @include('layouts.navbar')
            <!-- End Navbar -->
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>
@endif
@include('layouts.js')
@yield('script')
</body>

</html>
