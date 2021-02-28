@extends('public.template2')

@section('content')

<div style="padding-top: 70px;">
<div class="row">
    <div class="col-md-6 col-lg-6" style="margin-top: 50px;padding-bottom:50px;">
        
        {{-- <img src="{{ asset('img/E-SAKIP_COLOR.png') }}" width="300px;" alt=""> --}}
        <br>
        <br>
        <h1 style="color:#7793ed;font-family: 'viga';">SISTEM AKUNTABILITAS KINERJA INSTANSI PEMERINTAH</h1>
        <br>
        <h2 style="color:#7793ed;font-family: 'viga';">KABUPATEN KEPULAUAN MERANTI</h2>
        <br>
        <a href="#dokumen" class="btn btn-success btn-lg"><i class="fa fa-book"></i> Dokumen</a>
        <a  href="{{ route('login') }}" class="btn btn-info btn-lg"><i class="fa fa-lock"></i>  Login</a>
    </div>
    <div class="col-md-6 col-lg-6">
        <img src="{{ asset('images/office.svg') }}" style="width:100%;"/>
    </div>
</div>


<h2 class="text-center text-muted" style="margin-top:100px;margin-bottom:20px;">DOKUMEN PUBLIK</h2>
<br>
<div class="row" style="padding-top:20px;padding-bottom:100px;">
    <div class="col-md-6 col-lg-6">
        <img src="{{ asset('images/2021.svg') }}" style="width:100%;"/>
    </div>
    <div class="col-md-6 col-lg-6 text-center" id="dokumen" style="padding-top:100px;">
        <div class="table-responsive">
            <table class="table" style="background-color: transparent;">
                <tr >
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 10%;" title="Perencanaan Kinerja"><a href="{{url('perencanaan-kinerja')}}"><img style="border-radius: 25px; width: 100px;" src="{{ asset('img/new_plan.png') }}" alt=""></a></th>
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 10%;" title="Pengukuran Kinerja"><a href="{{url('capaian-kinerja')}}"><img style="border-radius: 25px; width: 100px;" src="{{ asset('img/new_ukuran.png') }}" alt=""></a></th>
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 10%;" title="Pelaporan Kinerja"><a href="{{url('pelaporan-kinerja')}}"><img style="border-radius: 25px; width: 100px;" src="{{ asset('img/new_laporan.png') }}" alt=""></a></th>
                    <th style="font-size: 16px; text-align: center;vertical-align: middle;  width: 10%;" title="Evaluasi Kinerja"><a href="{{url('evaluasi-kinerja')}}"><img style="border-radius: 25px; width: 100px;" src="{{ asset('img/new_evaluasi.png') }}" alt=""></a></th>
                    </th>
                    
            </table>
        </div>
    </div>
</div>

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
