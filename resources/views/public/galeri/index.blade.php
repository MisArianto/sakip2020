@extends('public.template2')

@section('content')

<div class="row">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="{{ asset('img/turkey.jpg') }}" alt="First slide">
          <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{ asset('img/macbook.jpg') }}" alt="Second slide">
          <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{ asset('img/workstation.jpg') }}" alt="Third slide">
          <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</div>

<br>

<div class="row">
	@foreach($galeris as $galeri)
    <div class="col-md-3">
        <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="{{ url('/galeri/'.$galeri->photo) }}" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">{{ $galeri->judul }}</h5>
            <p class="card-text">{{ substr($galeri->title, 0, 50) . '...' }}</p>
            <a href="{{ url('galeris',$galeri->slug) }}" class="btn btn-primary">Selengkapnya</a>
          </div>
        </div>
    </div>
    @endforeach
</div>




	{{-- <br>
	<br>
    <center>
    <img src="{{ asset('img/E-SAKIP_WHITE.png') }}" width="300px;" alt="">
    <br> 
    <h3 style="font-family: Philosopher; font-weight: bold;color:white;">Sistem Akuntabilitas Kinerja Instansi Pemerintah</h3>
    <h4 style="font-family: Philosopher; font-weight: bold;color:white;">Kabupaten Kepulauan Meranti</h4>
    <span style="color: #fff; font-size: 25px;"></span><br>

    </center> 

        <div class="box-body">
        <div class="table-responsive">
            <table class="table" style="background-color: transparent;">
                <tr >
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 25%;" data-toggle="tooltip" title="Perencanaan Kinerja"><a href="{{url('perencanaan-kinerja')}}"><img style="border-radius: 25px; width: 150px;" src="{{ asset('img/new_plan.png') }}" alt=""></a></th>
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 25%;" data-toggle="tooltip" title="Pengukuran Kinerja"><a href="{{url('capaian-kinerja')}}"><img style="border-radius: 25px; width: 150px;" src="{{ asset('img/new_ukuran.png') }}" alt=""></a></th>
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 25%;" data-toggle="tooltip" title="Pelaporan Kinerja"><a href="{{url('pelaporan-kinerja')}}"><img style="border-radius: 25px; width: 150px;" src="{{ asset('img/new_laporan.png') }}" alt=""></a></th>
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 25%;" data-toggle="tooltip" title="Evaluasi Kinerja"><a href="{{url('evaluasi-kinerja')}}"><img style="border-radius: 25px; width: 150px;" src="{{ asset('img/new_evaluasi.png') }}" alt=""></a></th>
                    </th>
                    
            </table>
        </div>
        <br>
        <center>
        	<a href="http://sipd.merantikab.go.id/e-planning/login" target="_blank"><button class="btn btn-primary"  style="color: #000000; font-weight: bold;">e-Planning</button></a> &nbsp; &nbsp;
		    <a href="http://e-budgeting.merantikab.go.id" target="_blank"><button class="btn btn-danger" style="color: #000000; font-weight: bold;">e-Budgeting</button></a> 
        	 
        </center>
        </div> --}}

						
@endsection      
