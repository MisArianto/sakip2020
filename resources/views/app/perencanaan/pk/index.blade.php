@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<div class="box-header">
	<h4> Perjanjian Kinerja @foreach($opds as $o)
		{{$o->organisasi_nama}}
	@endforeach 
    </h4>

   
	</div>


<div class="box-body">
@if(Auth::user()->level != 2)
	<form action="{{ url ('perencanaan/perjanjian-kinerja/data')}}" method="POST">
		@csrf

		<div class="row">
	          <div class="col-md-12">

	            <div class="col-md-6">
	              <select class="form-control select2" name="organisasi_no" id="organisasi_no">
		            <option value="">-- Pilih OPD --</option>
		            @foreach($opd as $data)
		            <option @if($data->organisasi_no == $dinas) selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
		            @endforeach
	              </select>
	            </div>

	            <div class="col-md-2">
				<select name="tahun" id="tahun" class="form-control">
					<option value="">Pilih Tahun</option>
					<option @if('2017' == $tahun) selected @endif value="2017">Tahun 2017</option>
					<option @if('2018' == $tahun) selected @endif value="2018">Tahun 2018</option>
					<option @if('2019' == $tahun) selected @endif value="2019">Tahun 2019</option>
					<option @if('2020' == $tahun) selected @endif value="2020">Tahun 2020</option>
					<option @if('2021' == $tahun) selected @endif value="2021">Tahun 2021</option>
				</select>
			</div>

				<div class="col-md-4">
	    		<button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>

	          </div>
	          </div>
	    </div>


	</form>
	@endif
	

	@if(Auth::user()->level != 1)
	<form action="{{ url('perencanaan/perjanjian-kinerja/data') }}" method="POST">
		@csrf
		
		<input type="hidden" name="organisasi_no" value="{{ Auth::user()->organisasi_no }}">

		<div class="row">
			<div class="col-md-2">
				<select name="tahun" id="tahun" class="form-control">
					<option value="">Pilih Tahun</option>
					<option @if('2017' == $tahun) selected @endif value="2017">Tahun 2017</option>
					<option @if('2018' == $tahun) selected @endif value="2018">Tahun 2018</option>
					<option @if('2019' == $tahun) selected @endif value="2019">Tahun 2019</option>
					<option @if('2020' == $tahun) selected @endif value="2020">Tahun 2020</option>
					<option @if('2021' == $tahun) selected @endif value="2021">Tahun 2021</option>
				</select>
			</div>

			<div class="col-md-2">
				<button class="btn btn-success"><i class="fa fa-search"></i></button>
			</div>
		</div>
	</form>
	@endif

	<br>

	<ul class="nav nav-pills">
			<li class="active"><a data-toggle="tab" href="#EselonII">Eselon II</a></li>
			<li><a data-toggle="tab" href="#EselonIII">Eselon III</a></li>
			<li><a data-toggle="tab" href="#EselonIV">Eselon IV</a></li>
	</ul>
	<br>
	<div class="tab-content">
		<div id="EselonII" class="tab-pane fade in active">@include('app.perencanaan.pk._eselonII')</div>
		<div id="EselonIII" class="tab-pane fade">@include('app.perencanaan.pk._eselonIII')</div>
		<div id="EselonIV" class="tab-pane fade">@include('app.perencanaan.pk._eselonIV')</div>
	</div>

	

</div>


@endsection

@push('scripts')
<script>

function ConfirmDelete() {
    var x = confirm("Yakin akan menghapus data?");
    if (x) return true; else return false;
}


</script>
@endpush

