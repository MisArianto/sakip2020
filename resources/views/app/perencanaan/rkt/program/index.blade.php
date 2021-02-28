@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<h3>  Target Indikator Program RKT Tahun 2019
      {{-- @if(Auth::user()->level == 1)
        <a href="{{url ('perencanaan/renstra-program/create')}}"><button class="btn btn-primary">Tambah</button></a>
      @endif --}}
    </h3>


<form action="{{ url ('perencanaan/rkt-program/dataProgram')}}" method="POST">
	{{ csrf_field() }}
	<div class="row">
          <div class="col-md-12">

            @if(Auth::user()->level == 1)
	            <div class="col-md-6">
	              <select class="form-control select2" name="organisasi_no" id="organisasi_no">
		            <option value="">-- Pilih OPD --</option>
		            @foreach($opd as $data)
		            <option value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
		            @endforeach
	              </select>
	            </div>
				@endif

	          <div class="col-md-2">
	          	<select class="form-control select2" name="tahun" id="tahun">
	          		<option value="">--Pilih Tahun--</option>
	          		@for($i=2017;$i<2022;$i++)
	          		<option value="{{$i}}">{{$i}}</option>
	          		@endfor
	          	</select>
	          </div>
			<div class="col-md-4">
    		<button type="submit" class="btn btn-s btn-warning" title="Cari"><i class="fa fa-search"></i></button>

          </div>
          </div>
    </div>
</form>
<br>
	{{-- <table class="table table-responsive ">
		@foreach($opds as $o)
		<tr>
			<td style="width: 7%;">Nama Organisasi</td>
			<td style="width: 2%;">:</td>
			<td>{{$o->organisasi_nama}}</td>
		</tr>
		@endforeach
		<tr>
			<td>Periode</td>
			<td >:</td>
			<td>2016-2021</td>
		</tr>
	</table> --}}
    @foreach($opds as $o)
		<h4 style="font-weight: bold; color: salmon;">{{$o->organisasi_nama}}</h4>
		@endforeach
    {{-- <h5>Periode 2016-2021</h5> --}}
	<div class="table-responsive">
		
		<table class="table table-responsive table-bordered table-hover">
			<thead>
			<tr style="background-color: #007bff; vertical-align: middle;">
				
				<th rowspan="2">Indikator Sasaran</th>
				<th rowspan="2" colspan="2">Program</th>
				<th rowspan="2">Target</th>
				<th rowspan="2">Pagu</th>

				{{-- <th rowspan="2">Indikator Program</th> --}}
				{{-- <th rowspan="2" style="text-align: center;">Satuan</th>
		        <th rowspan="2" style="text-align: center;">Capaian Awal</th>
		        <th colspan="2" style="text-align: center;">Tahun 2017</th>
		        <th colspan="2" style="text-align: center;">Tahun 2018</th>
		        <th colspan="2" style="text-align: center;">Tahun 2019</th>
		        <th colspan="2" style="text-align: center;">Tahun 2020</th>
		        <th colspan="2" style="text-align: center;">Tahun 2021</th>
		        <th colspan="2" style="text-align: center;">Kondisi Akhir</th>
				<th rowspan="2" style="text-align: center;  width: 50px;">Aksi</th>		
			</tr>
			 <tr style="background-color: #007bff; font-size: 12px;">
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		      </tr> --}}
			</thead>
			<tbody>
				
				
				
				
				@foreach($indikator_sasaran as $is)
					<tr style="font-weight: bold; background-color: #7abaff; font-size: 13px;">
						<td colspan="5">{{$is->indikator_sasaran_nama}}</td>
					</tr>

					@foreach($program as $p)
					@if($is->indikator_sasaran_id==$p->indikator_sasaran_id )
					<tr style="font-size: 12px;">
						<td></td>
						<td>{{$p->program_no}}</td>
						<td>{{$p->program_nama}}</td>
						<td></td>
						<td></td>
						{{-- <td></td> --}}
						{{-- <td style="text-align: center;">{{$is->satuan_nama}}</td>
						<td style="text-align: center;">{{$is->perencanaan_awal}}</td>
						<td style="text-align: center;">{{$is->target_t1}}</td>
						<td style="text-align: right;">{{($is->pagu_t1)}}</td>
						<td style="text-align: center;">{{$is->target_t2}}</td>
						<td style="text-align: right;">{{($is->pagu_t2)}}</td>
						<td style="text-align: center;">{{$is->target_t3}}</td>
						<td style="text-align: right;">{{($is->pagu_t3)}}</td>
						<td style="text-align: center;">{{$is->target_t4}}</td>
						<td style="text-align: right;">{{($is->pagu_t4)}}</td>
						<td style="text-align: center;">{{$is->target_t5}}</td>
						<td style="text-align: right;">{{($is->pagu_t5)}}</td>
						<td style="text-align: center;">{{$is->target_kondisi_akhir}}</td>
						<td style="text-align: right;">{{$is->pagu_kondisi_akhir}}</td>
						<td></td> --}}
					</tr>
					@endif
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>

</div>
@endsection

