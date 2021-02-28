<div class="table-responsive">
	<br>
	 @if(Auth::user()->level != 3)
		<a href="{{url ('perencanaan/rencana-strategis-opd/tambah-tujuan')}}" data-toggle="tooltip" title="Tambah Tujuan"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tujuan</button></a> &nbsp;
		<a href="{{url ('perencanaan/rencana-strategis-opd/tambah-indikator-tujuan')}}" data-toggle="tooltip" title="Tambah Indikator Tujuan"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Indikator Tujuan</button>&nbsp; &nbsp; &nbsp;
        <a href="{{url('perencanaan/rencana-strategis-opd/tambah-sasaran')}}" data-toggle="tooltip" title="Tambah Sasaran"><button class="btn btn-sm btn-warning"><i class="fa fa-plus"></i> Sasaran</button></a>&nbsp;
        <a href="{{url('perencanaan/rencana-strategis-opd/tambah-indikator-sasaran')}}" data-toggle="tooltip" title="Tambah Target Kinerja Sasaran"><button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Indikator Sasaran</button></a>
      @endif
		<br>
		<br>
		<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
			<thead>
			<tr style="background-color: #007bff; vertical-align: middle;">
				<th rowspan="2">Misi</th>
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
				@foreach($misi as $m)
				<tr style="background-color: #7abaff; font-weight: bolder;">
					<td colspan="19" >Misi Ke : {{$m->nomor}}. {{$m->nama}}</td>
				</tr>
				
				@foreach($tujuan as $t)
				
				<tr >
					<td></td>
					<td colspan="18" style="background-color: #7abaff; font-weight: bolder;">{{$t->tujuan_nama}}</td>
				</tr>
				@foreach(collect($sasaran)->where('tujuan_id', $t->id) as $s)
				
				<tr style="font-size: 12px; font-weight: bold;">
					<td></td>
					<td></td>
					<td colspan="16">{{$s->sasaran_nama}}</td>
					<td style="text-align: center;">
						{{-- <a href="{{route ('renstra-sasaran.edit',$s->sasaran_id) }}" data-toggle="tooltip" title="Edit Sasaran" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a>
                        <form action="{{ route('renstra-sasaran.destroy',$s->sasaran_id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Sasaran"><i class="fa fa-trash-o" ></i></button>
                        </form> --}}
					</td>
				
				@foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
				{{-- @foreach(collect($target_is1)->where('indikator_sasaran_id', $is->id) as $ts1) --}}
				
					<tr style="font-size: 11px;">
						<td></td>
						<td></td>
						<td></td>
						<td>{{$is->indikator_sasaran}}</td>
						<td style="text-align: center;">{{$is->satuan_nama}}</td>
						<td style="text-align: center;">{{$is->kondisi_awal}}</td>
						{{-- <td style="text-align: center;">{{$ts1->target}}</td>
						<td style="text-align: right;">{{($ts1->pagu)}}</td> --}}
						<td>
						<a href="{{url('perencanaan/renstra-indikator-sasaran/editIndikatorSasaran',$is->id) }}" data-toggle="tooltip" title="Edit Indikator Sasaran" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a>
                        <form action="{{ url('perencanaan/renstra-indikator-sasaran/destroyIndikatorSasaran',$is->id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Indikator Sasaran"><i class="fa fa-trash-o" ></i></button>
                        </form>
					</td>
					</tr>

				{{-- @endforeach --}}
				@endforeach
				@endforeach
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>