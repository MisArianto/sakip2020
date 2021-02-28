<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>e-sakip | Log in</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assetsLogin/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Google fonts - Popppins for copy-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
    <!-- orion icons-->
    <link rel="stylesheet" href="{{ asset('assetsLogin/css/orionicons.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assetsLogin/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assetsLogin/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page-holder d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center py-5">
          <div class="col-5 col-lg-7 mx-auto mb-5 mb-lg-0">
            <div class="pr-lg-5"><img src="{{ asset('assetsLogin/img/undraw_authentication_fsn5.svg')}}" alt="" class="img-fluid"></div>
          </div>
          <div class="col-lg-5 px-lg-4">
            {{-- <h1 class="text-base text-primary text-uppercase mb-4">eSakip Meranti</h1> --}}
            <h2 class="mb-4 text-center">Welcome!</h2>
            <div class="text-center mb-4">
              <a href="{{ url('/') }}"><img src="{{ asset('img/E-SAKIP_COLOR.png') }}" alt="" width="200px;"></a>
              <br>
              <br>
              <h5 class="text-base text-primary text-uppercase mb-4">
              Sistem Akuntabilitas Kinerja Instansi Pemerintah Kabupaten Kepulauan Meranti </h5>
            </div>
            
            <form id="loginForm" method="POST" action="{{ route('login') }}" class="mt-4">
              @csrf
              <div class="form-group mb-4">
                <input type="text" name="username" placeholder="Username" class="form-control shadow form-control-lg {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username') }}">
                 @if ($errors->has('username'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('username') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="form-group mb-4">
                <input type="password" name="password" id="password" placeholder="Password" class="form-control shadow form-control-lg text-violet {{ $errors->has('[password]') ? ' is-invalid' : '' }}">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>
              <div class="form-group mb-4">
                <div class="custom-control custom-checkbox">
                  <input id="customCheck1" type="checkbox" class="custom-control-input">
                  <label for="customCheck1" class="custom-control-label" id="label">Tampilkan Password</label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary shadow px-5">Log in</button>
            </form>
          </div>
        </div>
        <p class="mt-5 mb-0 text-gray-400 text-center">Login eSakip {{date('Y')}}</p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)                 -->
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{ asset('assetsLogin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assetsLogin/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{ asset('assetsLogin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assetsLogin/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{ asset('assetsLogin/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="{{ asset('assetsLogin/js/front.js')}}"></script>

    <script type="text/javascript">
    	$(document).ready(function(){

    		$(document).on('click', '#customCheck1', function(){
	    		let x = document.getElementById("password");
	      		let label = document.getElementById("label");

			    if($("#customCheck1").is(':checked'))
			    {
				    x.type = "text";
			        label = 'Sembunikan Password'
			    }
				else
				{
				    x.type = "password";
			        label = 'Tampilkan Password'
				}
    		})
    	})
    
  </script>
  </body>
</html>

