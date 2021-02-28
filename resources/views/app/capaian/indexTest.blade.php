@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
	
	<div class="box-header">
		<h4> Capaian Kinerja {{ $tahun }}</h4>
	</div>

	<form action="{{ url ('capaian/capaianRequestTest')}}" method="POST">
		{{ csrf_field() }}
		<div class="row">
			  <div class="col-md-12">
					@if(Auth::user()->level == 1)
					<div class="col-md-6">
					  <select class="form-control select2" name="organisasi_no" id="organisasi_no">
						<option value="">-- Pilih OPD --</option>
						<option value="KAB">Kabupaten Kepulauan Meranti</option>
						@foreach($orgs as $data)
						<option @if($data->organisasi_no == $req_opd) selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
						@endforeach
					  </select>
					</div>
					@elseif(Auth::user()->level == 2)
					<input type="hidden" name="organisasi_no" value="{{ Auth::user()->organisasi_no }}">
					@elseif(Auth::user()->level == 3)
					<input type="hidden" name="organisasi_no" value="{{ Auth::user()->organisasi_no }}">
					@endif
	
	
				  <div class="col-md-2">
					  <select class="form-control select2" name="tahun" id="tahun">
						  <option value="">--Tahun--</option>
						  @for($i=2017;$i<2022;$i++)
						  <option @if($i == $tahun_int) selected @endif value="{{$i}}">{{$i}}</option>
						  @endfor
					  </select>
				  </div>
	
					<div class="col-md-4">
						<button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>
					  </div>
			  </div>
		</div>
	</form>
	<br>

	{{-- @foreach($opds as $o)
		<h4 style="font-weight: bold; color: salmon;">{{$o->organisasi_nama}}</h4>
	@endforeach --}}

	<div class="box-body">
		{{-- <ul class="nav nav-pills">
			<li class="active"><a data-toggle="tab" href="#sasaran">Sasaran</a></li>
			<li><a data-toggle="tab" href="#program">Program</a></li>
			<li><a data-toggle="tab" href="#kegiatan">Kegiatan</a></li>
		</ul> --}}
		<div class="tab-content">
			{{-- content sasaran --}}
			<div id="sasaran" class="tab-pane fade in active">
				<div class="table-responsive">
					<div class="table-responsive">
					    @include('app.capaian._sasaranTest')
					</div>
				</div>
			</div>
			{{-- end content sasaran --}}

			{{-- content program --}}
			{{-- <div id="program" class="tab-pane">
				<div class="table-responsive">
					<div class="table-responsive">
					    @include('app.capaian._program')
					</div>
				</div>
			</div> --}}
			{{-- end content program --}}

			{{-- content kegiatan --}}
			{{-- <div id="kegiatan" class="tab-pane">
				<div class="table-responsive">
					<div class="table-responsive">
						@include('app.capaian._kegiatan')
					</div>
				</div>
			</div> --}}
			{{-- end content kegiatan --}}

		</div>
	</div>
</div>
@endsection
