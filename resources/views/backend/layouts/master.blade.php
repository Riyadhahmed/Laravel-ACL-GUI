<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Landacquisitionctg') }} | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="Description" lang="en" content="ADD SITE DESCRIPTION">
    <meta name="author" content="ADD AUTHOR INFORMATION">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- icons -->
{{--<link rel="apple-touch-icon" href="{{ asset('/assets/img/apple-touch-icon.png') }}">--}}
{{--<link rel="shortcut icon" href="favicon.ico">--}}
<!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/assets/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('/assets/css/_all-skins.min.css') }}">
    <link href="{{ asset('/assets/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/custom_admin_style.css') }}">
    <!-- JQuery scripts -->
    <!-- jQuery 3 -->
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>

    <!-- Override CSS file - add your own CSS rules -->
{{--<link rel="stylesheet" href="{{ asset('/assets/css/styles.css') }}">--}}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-black layout-top-nav fixed">
<div class="se-pre-con"></div>
<div class="wrapper">

    <header class="main-header">
        @include('backend.layouts.header')
    </header>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">

            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <footer class="main-footer">
            @include('backend.partials.modal')
            @include('backend.layouts.footer')
        </footer>
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- /.row -->
</div>
<!-- /.content-wrapper -->


<!-- AdminLTE App -->
<script src="{{ asset('/assets/js/adminlte.min.js') }}"></script>

<!-- Datatable library -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>

<script src="{{ asset('/assets/js/bootstrap-notify.min.js') }}"></script>


<!-- Sweet Alert library -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}">
<script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>


<script>
    $.fn.modal.Constructor.prototype.enforceFocus = function () {
    };

    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 5000); // <-- time in milliseconds
</script>
<script>

    function notify_view(type, message) {

        $.notify({
            message: message
        }, {
            type: type,
            offset: {
                x: '30',
                y: '85'
            },
            spacing: 10,
            z_index: 1031,
            delay: 200,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
    }
</script>
</body>
</html>