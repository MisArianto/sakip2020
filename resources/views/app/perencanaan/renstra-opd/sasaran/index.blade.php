@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<h3> Sasaran Renstra  &nbsp;
      @if(Auth::user()->level != 3)
        <a href="{{route('renstra-sasaran.create')}}" data-toggle="tooltip" title="Tambah Sasaran"><button class="btn btn-sm btn-primary">Tambah</button></a>
        <a href="{{url('perencanaan/renstra-indikator-sasaran/create')}}" data-toggle="tooltip" title="Tambah Target Kinerja Sasaran"><button class="btn btn-primary btn-sm"><i class="fa fa-plus">&nbsp; </i> Indikator</button></a>
      @endif
    </h3>

@if(Auth::user()->level != 2)
<form action="{{ url ('perencanaan/renstra-sasaran/dataSasaran')}}" method="POST">
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
			<tr style="background-color: #007bff; vertical-align: middle;">
				<th rowspan="2">Tujuan</th>
				<th rowspan="2">Sasaran</th>
				<th rowspan="2">Indikator Sasaran</th>
				<th rowspan="2" style="text-align: center;">Satuan</th>
		        <th rowspan="2" style="text-align: center;">Capaian Awal</th>
		        <th colspan="2" style="text-align: center;">Tahun 2017</th>
		        <th colspan="2" style="text-align: center;">Tahun 2018</th>
		        <th colspan="2" style="text-align: center;">Tahun 2019</th>
		        <th colspan="2" style="text-align: center;">Tahun 2020</th>
		        <th colspan="2" style="text-align: center;">Tahun 2021</th>
		        <th colspan="2" style="text-align: center;">Kondisi Akhir</th>
				<th rowspan="2" style="text-align: center;  width: 6%;">Aksi</th>		
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
		      </tr>
			</thead>
			<tbody>
				
				
				@foreach($tujuan as $t)
				
				<tr >
					<td colspan="18" style="background-color: #7abaff; font-weight: bolder;">{{$t->tujuan_nama}}</td>
				</tr>
				@foreach(collect($sasaran)->where('tujuan_nomor', $t->tujuan_nomor) as $s)
				
				<tr style="font-size: 12px; font-weight: bold;">
					<td></td>
					<td colspan="16">{{$s->sasaran_nama}}</td>
					<td style="text-align: center;">
						<a href="{{route ('renstra-sasaran.edit',$s->sasaran_id) }}" data-toggle="tooltip" title="Edit Sasaran" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a>
                        <form action="{{ route('renstra-sasaran.destroy',$s->sasaran_id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Sasaran"><i class="fa fa-trash-o" ></i></button>
                        </form>
					</td>
				
				@foreach(collect($indikator_sasaran)->where('sasaran_nomor', $s->sasaran_nomor) as $is)
				
					<tr style="font-size: 11px;">
						<td></td>
						<td></td>
						<td>{{$is->indikator_sasaran_nama}}</td>
						<td style="text-align: center;">{{$is->satuan_nama}}</td>
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
						<td style="text-align: center;">
						<a href="{{url('perencanaan/renstra-indikator-sasaran/editIndikatorSasaran',$is->id) }}" data-toggle="tooltip" title="Edit Indikator Sasaran" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a>
                        <form action="{{ url('perencanaan/renstra-indikator-sasaran/destroyIndikatorSasaran',$is->id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Indikator Sasaran"><i class="fa fa-trash-o" ></i></button>
                        </form>
					</td>
					</tr>

				@endforeach
				@endforeach
				@endforeach
			</tbody>
		</table>
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

