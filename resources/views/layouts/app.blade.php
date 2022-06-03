<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (Auth::check())
    <meta name="user_id" content="{{ Auth::user()->id }}" />
    @endif
    <title>{{ config('app.name', 'mumefa-project') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("template/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset("template/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("template/css/adminlte.min.css")}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset("template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    @yield('plugin-css')
    @yield('custom-css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('template/img/logo_sispk.jpg')}}" alt="logo-default"
                height="60" width="60">
        </div>
        <!-- Navbar -->
        @include('components.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('components.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset("template/plugins/jquery/jquery.min.js")}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset("template/plugins/jquery-ui/jquery-ui.min.js")}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset("template/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset("template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
    @yield('plugin-js')
    <!-- AdminLTE App -->
    <script src="{{asset("template/js/adminlte.js")}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset("template/js/demo.js")}}"></script>
    {{-- <script src="{{asset("template/js/popper.js")}}"></script> --}}
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
    @yield('js')
</body>

</html>
