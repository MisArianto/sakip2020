@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<div class="box-header">
	<h4> Rencana Strategis @foreach($opd as $o)
		{{$o->organisasi_nama}}
	@endforeach 
    </h4>
	</div>

<div class="box-body">


	@if(Auth::user()->level != 2)
	<form action="{{ url ('perencanaan/rencana-strategis/dataRenstra')}}" method="POST">
		{{ csrf_field() }}

		<div class="row">
	          <div class="col-md-12">

	            <div class="col-md-6">
	              <select class="form-control select2" name="organisasi_no" id="organisasi_no">
	            <option value="">-- Pilih OPD --</option>
	            @foreach($opds as $data)
	            <option value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
	            @endforeach
	              </select>
	            </div>
				<div class="col-md-4">
	    		<button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>

	          </div>
	          </div>
	    </div>
	</form>
	
    <br>
    @endif


	<ul class="nav nav-pills">
			<li class="active"><a data-toggle="tab" href="#tujuan">Tujuan</a></li>
			<li><a data-toggle="tab" href="#sasaran">Sasaran</a></li>
			<li><a data-toggle="tab" href="#progkeg">Program & Kegiatan</a></li>
	</ul>
    <div class="tab-content">
		<div id="tujuan" class="tab-pane fade in active">@include('app.perencanaan.renstra._tujuan')</div>
		<div id="sasaran" class="tab-pane fade">@include('app.perencanaan.renstra._sasaran')</div>
		<div id="progkeg" class="tab-pane fade">@include('app.perencanaan.renstra._program-kegiatan')</div>
	</div>

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

