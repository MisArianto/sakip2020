<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>e-sakip</title>
  <link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  {{-- <link rel="stylesheet" href="{{ asset ('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('bower_components/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('dist/css/AdminLTE.css')}}">
  <link rel="stylesheet" href="{{ asset ('dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/font.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/icon-font.min.css') }}"> --}}

  <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

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
  </style>
  @toastr_css
</head>
<body id="page-top">
<div id="wrapper">

  {{-- <header class="main-header">
    <a href="/home" class="logo">
      <span class="logo-mini" style="font-family: Philosopher;"><img src="{{ asset ('img/E-SAKIP_WHITE_LOGO_CIRCLE.png')}}" width="25px;" title="e-sakip" alt=""></span>
      <span class="logo-lg" style="font-family: Philosopher;"><img src="{{ asset ('img/E-SAKIP_WHITE.png')}}" width="100px;" title="e-sakip" alt=""></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
    
      <div class="navbar-custom-menu">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              @guest
                <li style="font-size: 12px;">
                    <a  href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
              @else
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 13px;"><i class="fa fa-user" >&nbsp&nbsp</i>{{ Auth::user()->nama }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu" style=" ">
                  <li style="font-size: 12px;"><a href="{{ url('user/profile')}}">Profil</a></li>
                  <li style="font-size: 12px;"><a href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                  </li>
                </ul>
              </li>
              @endguest
             
            </ul>
          </div>
      </div>
    </nav>
  </header> --}}
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
{{-- @include('layouts.footer') --}}
@include('app.master._modal')

{{-- <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>

<script src="{{ asset ('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset ('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset ('bower_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{ asset ('dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset ('dist/js/demo.js') }}"></script>
<script src="{{ asset ('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset ('assets/js/jquery.media.js') }}"></script>
<script src="{{ asset ('assets/js/select2.min.js') }}"></script>
<script src="{{ asset ('node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset ('assets/js/jquery.masknumber.min.js') }}"></script> --}}

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('sb-admin/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{ asset('sb-admin/vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('sb-admin/js/demo/chart-area-demo.js')}}"></script>
<script src="{{ asset('sb-admin/js/demo/chart-pie-demo.js')}}"></script>

<script>
  $(document).ready(function() {
    $('.select2').select2();
    $(".preloader").fadeOut();
});
</script>

@stack('scripts')
@include('sweet::alert')
@jquery
@toastr_js
@toastr_render
</body>
</html>

