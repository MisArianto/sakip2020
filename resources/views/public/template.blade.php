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
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  {{-- <link rel="stylesheet" href="{{ asset ('bower_components/bootstrap/dist/css/bootstrap.css')}}"> --}}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset ('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset ('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset ('dist/css/AdminLTE.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/preloader.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset ('dist/css/skins/_all-skins.min.css')}}">
  {{-- <link rel="stylesheet" href="{{ asset ('css/jquery.dataTables.min.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset ('assets/css/font.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/treeview.css')}}">
  <link rel="stylesheet" href="{{ asset ('assets/css/select2.min.css')}}">
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
{{-- my font --}}
    <link href="https://fonts.googleapis.com/css2?family=Viga&display=swap" rel="stylesheet">
  {{-- <link rel="stylesheet" href="{{ asset ('js/jquery-1.10.2.min.js')}}"> --}}
  
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->

  <style>

    #body { 
      /* background: url(img/bg_4.jpg) no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover; */
      /*background-color: #d6d6d6; */
      font-family: Arial, Helvetica, sans-serif;
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
 
</head>
<script>
$(document).ready(function(){
$(".preloader").fadeOut();
})
</script>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body id="body">

        <div class="preloader">
          <div class="loading">
          <img src="{{ asset('img/preloader.gif') }}" width="80">
            <p>Harap Tunggu...</p>
          </div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
       
            @include('layouts.header')
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        
        <!-- /.navbar-custom-menu -->
      
  <!-- Full Width Column -->
  {{-- <div class="content-wrapper bg" style="background-image: url(img/bg.jpg);"> --}}
    <div class="container">
      <!-- Content Header (Page header) -->
      <!-- {{-- <section class="content-header">
        <h1>
          Top Navigation
          <small>Example 2.0</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Layout</a></li>
          <li class="active">Top Navigation</li>
        </ol>
      </section> --}} -->

      <!-- Main content -->
      <section class="content">
        
        @yield('content')
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  {{-- </div> --}}
  <!-- /.content-wrapper -->
  {{-- @include('app.footer') --}}
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<!-- Bootstrap 3.3.7 -->
{{-- <script src="{{ asset ('bower_components/bootstrap/dist/js/bootstrap.js')}}"></script> --}}
<script src="{{ asset ('assets/js/zohoviewer/jquery.zohoviewer.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ asset ('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset ('bower_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{ asset ('assets/js/treeview.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset ('assets/js/select2.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset ('dist/js/demo.js') }}"></script>
<script src="{{ asset('js/configToastr.js')}}"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
{{-- <script src="{{ asset ('js/jquery.dataTables.min.js') }}"></script> --}}
<script>

  $(document).ready(function() {
    $('.select2').select2();
    // $(".preloader").fadeOut();
  $('[data-toggle="tooltip"]').tooltip(); 
});

</script>
@stack('scripts')
</body>
</html>

