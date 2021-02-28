@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<div class="box-header">
	<h4>RKT
		@if(Auth::user()->level == 2)
		@foreach($opds as $o)
		{{$o->organisasi_nama}}
		@endforeach
		@endif
    </h4>
    </div>


@if(Auth::user()->level != 2)
<form action="{{ url ('perencanaan/rkt-opd/dataRkt')}}" method="POST">
	{{ csrf_field() }}
	<div class="row">
          <div class="col-md-12">
				
	            <div class="col-md-4">
	              <select class="form-control select2" name="organisasi_no" id="organisasi_no">
		            <option value="">-- Pilih OPD --</option>
		            @foreach($opd as $data)
		            <option value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
		            @endforeach
	              </select>
	            </div>
				

	          <div class="col-md-2">
	          	<select class="form-control select2" name="tahun" id="tahun">
	          		<option value="">--Pilih Tahun--</option>
	          		@for($i=2017;$i<2022;$i++)
	          		<option value="{{$i}}">{{$i}}</option>
	          		@endfor
	          	</select>
	          </div>

				<div class="col-md-2">
	    			<button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>
	          	</div>
          </div>
    </div>
</form>
@endif
<br>
<div class="box-body">
@if(Auth::user()->level != 2)
@foreach($opds as $o)
	<h4 style="font-weight: bold; color: salmon;">{{$o->organisasi_nama}}</h4>
@endforeach
@endif

<ul class="nav nav-pills">
	<li class="active"><a data-toggle="tab" href="#sasaran">Target Sasaran</a></li>
	<li><a data-toggle="tab" href="#progkeg">Target Program dan Kegiatan</a></li>
</ul>
	
	<div class="tab-content">
			<div id="sasaran" class="tab-pane fade in active">
				@include('app.perencanaan.rkt.sasaran._sasaran_opd')
			</div>

			<div id="progkeg" class="tab-pane fade">
				@include('app.perencanaan.rkt.program._program_kegiatan')
				
			</div>
			</div>
		</div>

</div>
@endsection

