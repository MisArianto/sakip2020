<div class="table-responsive">
	<br>
	 @if(Auth::user()->level != 3)
		
		<a href="{{url ('perencanaan/rencana-strategis/tambah-indikator-tujuan')}}" data-toggle="tooltip" title="Tambah Indikator Tujuan" class="btn btn-sm btn-warning">Tambah</a>
        {{-- <a href="{{url('perencanaan/rencana-strategis-opd/tambah-sasaran')}}" data-toggle="tooltip" title="Tambah Sasaran"><button class="btn btn-sm btn-warning"><i class="fa fa-plus"></i> Sasaran</button></a>&nbsp;
        <a href="{{url('perencanaan/rencana-strategis-opd/tambah-indikator-sasaran')}}" data-toggle="tooltip" title="Tambah Target Kinerja Sasaran"><button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Indikator Sasaran</button></a> --}}
      @endif
		<br>
		
		<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
			<thead>
				<tr style="background-color: #007bff; text-align: center; color: #fff;">
					<th width="8">No</th>
					<th>Nama Indikator</th>
					<th style="text-align: center;">Satuan</th>
					<th style="text-align: center;">Kondisi Akhir</th>
				</tr>

			</thead>
			<tbody>
				@foreach(collect($indikator_tujuan)->where('tujuan_id', $tujuan->id) as $it)
				<tr>
					<td align="center">{{$no++}}</td>
					<td>{{$it->indikator_tujuan}}</td>
					<td align="center">{{$it->satuan_nama}}</td>
					<td align="center">{{$it->kondisi_akhir}}</td>
				</tr>
				@endforeach
			</tbody>
				
			</tbody>
		</table>
	</div>