<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>e-sakip</title>
  <link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- {{-- <link rel="stylesheet" href="{{ asset ('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('bower_components/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('dist/css/AdminLTE.css')}}">
  <link rel="stylesheet" href="{{ asset ('dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/font.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/icon-font.min.css') }}"> --}} -->

  <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('sb-admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{ asset('css/loading.css')}}" rel="stylesheet">
  <link href="{{ asset('css/spinner.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset ('css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/select2-bootstrap4.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/pretty-print-json.css') }}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/default.min.css">

  <style>
    .select2 {
    width:100%!important;
    }
    .bg {
        height: 100%; 
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background-color: #fff;
    }
    .preloader .loading {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%,-50%);
      font: 14px arial;
    }

    .layar{
      display: none;
    }
  </style>

  @yield('style')

  @auth
    <script>
    window.user = @json(auth()->user());
    </script>
  @endauth

</head>
<body id="page-top">
<div id="wrapper">

  @include('layouts.sidebar')
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('layouts.header')
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>  
  </div>
</div>
@include('app.master._modal')

<script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<!-- <script src="{{ asset ('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> -->
<!-- <script src="{{ asset ('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script> -->
<!-- <script src="{{ asset ('bower_components/fastclick/lib/fastclick.js')}}"></script> -->
<!-- <script src="{{ asset ('dist/js/adminlte.min.js')}}"></script> -->
<!-- <script src="{{ asset ('dist/js/demo.js') }}"></script> -->
<!-- <script src="{{ asset ('assets/js/jquery.dataTables.min.js') }}"></script> -->
<!-- <script src="{{ asset ('assets/js/jquery.media.js') }}"></script> -->
<script src="{{ asset ('js/select2.min.js') }}"></script>
<!-- <script src="{{ asset ('node_modules/sweetalert/dist/sweetalert.min.js') }}"></script> -->
<script src="{{ asset ('assets/js/jquery.masknumber.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('sb-admin/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{ asset('sb-admin/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{ asset('js/configToastr.js')}}"></script>
<script src="{{ asset('js/sakip_script.js')}}"></script>
<script src="{{ asset('js/pretty-print-json.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>

<!-- imask.js currency -->
<script src="https://unpkg.com/imask"></script>


<script>
  $(document).ready(function() {
    // $('.select2').select2();
    $(".preloader").fadeOut();
});
</script>

@yield('scripts')
<!-- @stack('scripts') -->

</body>
</html>

