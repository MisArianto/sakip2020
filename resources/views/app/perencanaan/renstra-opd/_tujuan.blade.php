<div class="table-responsive">
	<br>		
		@if(Auth::user()->level != 3)
	        <a href="{{url ('perencanaan/rencana-strategis-opd/tambah-tujuan')}}" data-toggle="tooltip" title="Tambah Tujuan"><button class="btn btn-sm btn-success">Tambah</button></a> &nbsp;
	        <a href="{{url ('perencanaan/rencana-strategis-opd/tambah-indikator-tujuan')}}" data-toggle="tooltip" title="Tambah Indikator Tujuan"><button class="btn btn-sm btn-success"><i class="fa fa-plus">&nbsp;</i> Indikator</button></a>
		@endif
	<br>
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
					<td colspan="6" >Misi Ke : {{$m->nomor}}. {{$m->nama}}</td>
				</tr>
				@foreach(collect($tujuan)->where('misi_id', $m->id) as $t)
				<tr style="font-weight: bold;" >
					<td></td>
					<td colspan="4">{{$t->tujuan_nama}}</td>
					@if(Auth::user()->level != 3)
					<td display="inline" style="text-align: center;">
                        {{-- <a href="{{url ('perencanaan/rencana-strategis-opd/tambah-tujuan')}}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Tujuan"><i class="fa fa-edit" ></i></a>
                        <form action="{{ route('renstra-tujuan.destroy',$t->tujuan_id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Tujuan"><i class="fa fa-trash-o" ></i></button>
                        </form> --}}
					</td>
					@endif
					
				</tr>
				@foreach(collect($indikator_tujuan)->where('tujuan_id', $t->id) as $it)
 				<tr >
					<td colspan="2"></td>
					<td>{{$it->indikator_tujuan_nama}}</td>
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
				@foreach(collect($sasaran)->where('tujuan_id', $t->id) as $s)
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td>{{$s->sasaran_nama}}</td>
					
				</tr>
				@endforeach
				@endforeach
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>