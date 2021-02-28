@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<div class="box-header">
	<h4> Tujuan Renstra  &nbsp;
      @if(Auth::user()->level != 3)
        <a href="{{url ('perencanaan/renstra-tujuan/create')}}" data-toggle="tooltip" title="Tambah Tujuan"><button class="btn btn-sm btn-primary">Tambah</button></a>
        <a href="{{url ('perencanaan/renstra-tujuan-indikator/create')}}" data-toggle="tooltip" title="Tambah Indikator Tujuan"><button class="btn btn-sm btn-primary"><i class="fa fa-plus">&nbsp;</i> Indikator</button></a>
      @endif
    </h4>
</div>

<div class="box-body">


@if(Auth::user()->level != 2)
<form action="{{ url ('perencanaan/renstra-tujuan/dataTujuan')}}" method="POST">
	{{ csrf_field() }}

	<div class="row">
          <div class="col-md-12">

            <div class="col-md-6">
              <select class="form-control select2" name="organisasi_no" id="organisasi_no">
            <option value="">-- Pilih OPD --</option>
            @foreach($opd as $data)
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
@endif
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
		
		<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
			<thead>
			<tr style="background-color:  #007bff;">
				<th style="width: 3%;">Misi</th>
				<th>Tujuan</th>
				<th>Indikator Tujuan</th>
				<th style="text-align: center;">Satuan</th>
				<th style="text-align: center;">Kondisi Akhir</th>
				@if(Auth::user()->level != 3)
				<th style="text-align: center;  width: 8%;">Aksi</th>
				@endif		
			</tr>
			</thead>
			<tbody>
				
				@foreach($misi as $m)
				<tr style="background-color: #7abaff; font-weight: bolder;">
					<td colspan="6" >Misi Ke : {{$m->misi_no}}. {{$m->misi_nama}}</td>
				</tr>
				@foreach(collect($tujuan)->where('misi_nomor', $m->misi_no) as $t)
				
				<tr style="font-weight: bold;" >
					<td></td>
					<td colspan="4">{{$t->tujuan_nomor}}. &nbsp; {{$t->tujuan_nama}}</td>
					@if(Auth::user()->level != 3)
					<td display="inline" style="text-align: center;">
						{{-- <div class="btn-group"> --}}
                        <a href="{{route ('renstra-tujuan.edit',$t->tujuan_id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Tujuan"><i class="fa fa-edit" ></i></a>
                        <form action="{{ route('renstra-tujuan.destroy',$t->tujuan_id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Tujuan"><i class="fa fa-trash-o" ></i></button>
                        </form>
                        {{-- </div> --}}
					</td>
					@endif
					
				</tr>
				@foreach(collect($indikator_tujuan)->where('tujuan_nomor', $t->tujuan_nomor) as $it)
 				<tr >
					<td colspan="2"></td>
					<td>{{$it->it_nama}}</td>
					<td style="text-align: center;">{{$it->satuan_nama}}</td>
					<td style="text-align: center;">{{$it->kondisi_akhir}}</td>
					@if(Auth::user()->level != 3)
					<td display="inline" style="text-align: center;">
						<a href="{{url('perencanaan/renstra-tujuan-indikator/editIndikatorRenstra',$it->id) }}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Indikator Tujuan"><i class="fa fa-edit" ></i></a>
                        <form action="{{ url('perencanaan/renstra-tujuan-indikator/destroyIndikatorRenstra',$it->id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Indikator Tujuan"><i class="fa fa-trash-o" ></i></button>
                        </form>
						{{-- <a href="#" data-toogle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a> --}}
					</td>
					@endif
				</tr>
				@endforeach
				@endforeach
				@endforeach
			</tbody>
		</table>
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

