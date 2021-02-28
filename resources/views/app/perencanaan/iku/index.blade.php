@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
                     
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h3> IKU RPJMD</h3>
    @foreach($periode as $p)
    <h4>Periode {{$p->periode}}</h4>
    @endforeach
    
	@if(Auth::user()->level == 1)
	<a href="perencanaan/iku/create"><button class="btn btn-sm btn-primary">Tambah</button></a>
	@endif

<br>
	<div class="table-responsive table-bordered">
		<table class="table table-responsive table-bordered table-hover">
				<thead>
					<tr  style="font-size: 13px; background-color: #007bff;">			
						<th style=" text-align: center; vertical-align: center; " rowspan="2">Sasaran Strategis</th>
						<th style=" text-align: center; vertical-align: center; " rowspan="2">Indikator Kinerja Utama</th>
						<th style=" text-align: center; vertical-align: center; " rowspan="2">Satuan</th>
						<th style=" text-align: center; vertical-align: center; " colspan="4"> Penjelasan</th>
						@if(Auth::user()->level == 1)
						<th style=" text-align: center; vertical-align: center;  width: 50px;" rowspan="2">Aksi</th>
						@endif
					</tr>
					<tr style="font-size: 13px; background-color: #007bff;">
						<th style=" text-align: center; vertical-align: center; ">Alasan</th>
						<th style=" text-align: center; vertical-align: center; ">Formulasi/Cara Pengukuran</th>
						<th style=" text-align: center; vertical-align: center; width: 10%;">Sumber Data</th>
						<th style=" text-align: center; vertical-align: center;  ">Keterangan</th>
					</tr>
				</thead>
			<tbody>
				@foreach($sasaran as $s)
				<tr style="background-color: #7abaff; font-weight: bold;">
					<td colspan="8">{{$s->sasaran_nama}}</td>
				</tr>
				@foreach($indikator_sasaran as $is)
				@if($s->id==$is->sasaran_id)
				<tr style="font-size:  12px;">
					<td></td>
					<td>{{$is->indikator_sasaran}}</td>
					<td style="text-align: center;">{{$is->satuan_nama}}</td>
					{{-- @foreach($iku as $i)
					@if($is->id==$i->indikator_sasaran_id)
					<tr> --}}
					<td>{{$is->alasan}}</td>
					<td>{{$is->formulasi}}</td>
					<td>{{$is->sumber_data}}</td>
					<td>{{$is->keterangan}}</td>
					{{-- @if(Auth::user()->level == 1)
					<td></td>
					@endif --}}
				</tr>
				@endif
     			@endforeach
     			@endforeach
		  </tbody>
      </table>
                    
	</div>


                     
             
</div>
@endsection
