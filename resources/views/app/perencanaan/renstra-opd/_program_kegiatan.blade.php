<div class="table-responsive">
	<br>
	@if(Auth::user()->level != 3)
        <a href="{{url ('perencanaan/renstra-program/create')}}" data-toggle="tooltip" title="Tambah Program dan Kegiatan"><button class="btn btn-sm btn-success">Tambah</button></a>&nbsp;
        <a href="{{url ('perencanaan/renstra-program-indikator/tambah')}}" data-toggle="tooltip" title="Tambah Indikator Program"><button class="btn btn-sm btn-success"><i class="fa fa-plus">&nbsp;</i> Indikator Program</button></a>
      @endif
      <br>
		<table class="table table-responsive table-hover table-bordered" id="progKegRenstra" style="font-size: 11px;">
			<thead>
			<tr style="background-color: #007bff; vertical-align: middle;">
				
				{{-- <th rowspan="2">Indikator Sasaran</th> --}}
				<th rowspan="2" colspan="2">Program</th>
				<th rowspan="2">Kegiatan</th>
				<th rowspan="2">Indikator</th>
				<th rowspan="2" style="text-align: center;">Satuan</th>
		        <th rowspan="2" style="text-align: center;">Capaian Awal</th>
		        <th colspan="2" style="text-align: center;">Tahun 2017</th>
		        <th colspan="2" style="text-align: center;">Tahun 2018</th>
		        <th colspan="2" style="text-align: center;">Tahun 2019</th>
		        <th colspan="2" style="text-align: center;">Tahun 2020</th>
		        <th colspan="2" style="text-align: center;">Tahun 2021</th>
		        {{-- <th colspan="2" style="text-align: center;">Kondisi Akhir</th> --}}
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
		        {{-- <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th> --}}
		      </tr>
			</thead>
			<tbody>
				
				
				
				
				{{-- @foreach($indikator_sasaran as $is)
					<tr style="font-weight: bold; background-color: #00a6c6; font-size: 13px;">
						<td colspan="19">{{$is->indikator_sasaran_nama}}</td>
						<td></td>
					</tr> --}}

					@foreach($program as $p)
					{{-- @if($is->id==$p->indikator_sasaran_id) --}}
					<tr style="font-size: 12px;font-weight: bold; background-color: #7abaff;">
						{{-- <td></td> --}}
						{{-- <td>{{$p->program_no}}</td> --}}
						<td colspan="16" >{{$p->program_no}} &nbsp; {{$p->program_nama}}</td>
						<td style="text-align: center;">
							<a href="{{url ('perencanaan/renstra-program-indikator/edit',$p->id) }}" data-toggle="tooltip" title="Edit {{$p->program_nama}}" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a>
	                        <form action="{{ url('perencanaan/renstra-program-indikator/destroy',$p->id) }}" method='POST' style="display: inline;">
	                            {{ csrf_field() }}

	                            <input type="hidden" name="_method" value="DELETE">
	                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus {{$p->program_nama}}"><i class="fa fa-trash-o" ></i></button>
	                        </form>
						</td>
						{{-- <td> --}}
							{{-- <a href="{{route ('renstra-program.edit',$p->renstra_id) }}" data-toggle="tooltip" title="Edit Sasaran" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a>
	                        <form action="{{ route('renstra-program.destroy',$p->renstra_id) }}" method='POST' style="display: inline;">
	                            {{ csrf_field() }}

	                            <input type="hidden" name="_method" value="DELETE">
	                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Sasaran"><i class="fa fa-trash-o" ></i></button>
	                        </form> --}}
						{{-- </td> --}}
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
					{{-- @endif --}}
					@foreach(collect($kegiatan)->where('program_no', $p->program_no) as $k)
					<tr style="font-size: 11px;">
						<td colspan="2"></td>
						<td>{{-- {{$k->kegiatan_no}}  --}}{{$k->kegiatan_nama}}</td>
						<td>{{$k->indikator_kegiatan}}</td>
						<td>{{$k->satuan_nama}}</td>
						<td style="text-align: center;">{{$k->perencanaan_awal}}</td>
						<td style="text-align: center;">{{$k->target_t1}}</td>
						<td style="text-align: right; font-size: 9px;">{{($k->pagu_t1)}}</td>
						<td style="text-align: center;">{{$k->target_t2}}</td>
						<td style="text-align: right; font-size: 9px;">{{($k->pagu_t2)}}</td>
						<td style="text-align: center;">{{$k->target_t3}}</td>
						<td style="text-align: right; font-size: 9px;">{{($k->pagu_t3)}}</td>
						<td style="text-align: center;">{{$k->target_t4}}</td>
						<td style="text-align: right; font-size: 9px;">{{($k->pagu_t4)}}</td>
						<td style="text-align: center;">{{$k->target_t5}}</td>
						<td style="text-align: right; font-size: 9px;">{{($k->pagu_t5)}}</td>
						{{-- <td style="text-align: center;">{{$k->target_kondisi_akhir}}</td>
						<td style="text-align: right; font-size: 9px;">{{$k->pagu_kondisi_akhir}}</td> --}}
						<td style="text-align: center;">
							<a href="{{route ('renstra-program.edit',$k->renstra_id) }}" data-toggle="tooltip" title="Edit {{$k->kegiatan_nama}}" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a>
	                        <form action="{{ route('renstra-program.destroy',$k->renstra_id) }}" method='POST' style="display: inline;">
	                            {{ csrf_field() }}

	                            <input type="hidden" name="_method" value="DELETE">
	                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus {{$k->kegiatan_nama}}"><i class="fa fa-trash-o" ></i></button>
	                        </form>
						</td>
					</tr>
				@endforeach
				@endforeach
				{{-- @endforeach --}}
			</tbody>
		</table>
	</div>