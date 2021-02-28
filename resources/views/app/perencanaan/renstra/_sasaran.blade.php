<div class="table-responsive">
	{{-- <br>
	 @if(Auth::user()->level != 3)
        <a href="{{url('perencanaan/rencana-strategis/tambah-sasaran')}}" data-toggle="tooltip" title="Tambah Sasaran"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Sasaran</button></a>&nbsp;
        <a href="{{url('perencanaan/rencana-strategis/tambah-indikator-sasaran')}}" data-toggle="tooltip" title="Tambah Target Kinerja Sasaran"><button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Indikator Sasaran</button></a>
      @endif --}}
		<br>
		<table class="table table-responsive table-bordered table-hover" >
			<thead>
			<tr style="background-color: #007bff; color: #fff;">
				<th>Tujuan </th>
				<th colspan="2">Sasaran </th>
				<th>Indikator </th>
				<th style="text-align: center;">Satuan</th>
		        <th style="text-align: center;">Kondisi Awal</th>
		        <th style="text-align: center;">Kondisi Akhir</th>
				<!--<th style="text-align: center;  width: 7%;">Aksi</th>-->		
			</tr>
			 
			</thead>
			<tbody>
				
				@foreach(collect($sasaran)->unique('tujuan_id') as $t)
				
				<tr >
					<td colspan="8" style="font-weight: bolder;">{{$t->tujuan_nama}}</td>
				</tr>
				@foreach(collect($sasaran)->unique('sasaran_id')->where('tujuan_id', $t->tujuan_id) as $s)
				<tr>
					<td></td>
				<td colspan="6"><b>{{$s->sasaran_nama}}</b></td>
					{{-- <td align="center">
						<a href="{{url('perencanaan/rencana-strategis/sasaran/edit',$s->sasaran_id) }}" data-toggle="tooltip" title="Edit Tujuan" ><i class="fa fa-edit"></i></a>
						<a onclick="return ConfirmDelete();" href="{{ url('perencanaan/rencana-strategis/sasaran/delete', $s->sasaran_id) }}" data-toggle="tooltip" title="Hapus Tujuan" ><i class="fa fa-trash"></i></a>
					</td> --}}
				</tr>

				@foreach(collect($sasaran)->unique('indikator_sasaran_id')->where('sasaran_id', $s->sasaran_id) as $is)
				<tr>
					<td colspan="3"></td>
					<td>{{$is->indikator_sasaran}}</td>
					<td align="center">{{$is->satuan_nama}}</td>
					<td align="center">{{$is->kondisi_awal}}</td>
					<td align="center">{{$is->target_akhir}}</td>
					{{-- <td align="center">
						<a href="{{url('perencanaan/rencana-strategis/indikator-sasaran/edit',$is->indikator_sasaran_id) }}" data-toggle="tooltip" title="Edit Tujuan" ><i class="fa fa-edit"></i></a>
						<a onclick="return ConfirmDelete();" href="{{ url('perencanaan/rencana-strategis/indikator-sasaran/delete', $is->indikator_sasaran_id) }}" data-toggle="tooltip" title="Hapus Tujuan" ><i class="fa fa-trash"></i></a>
					</td> --}}
					
				</tr>
				
				@endforeach
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>