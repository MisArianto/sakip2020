<div class="table-responsive">
	{{-- <br>
	@if(Auth::user()->level != 3)
        <a href="{{url ('perencanaan/renstra-program/create')}}" data-toggle="tooltip" title="Tambah Program dan Kegiatan"><button class="btn btn-sm btn-success">Tambah</button></a>&nbsp;
        <a href="{{url ('perencanaan/renstra-program-indikator/tambah')}}" data-toggle="tooltip" title="Tambah Indikator Program"><button class="btn btn-sm btn-success"><i class="fa fa-plus">&nbsp;</i> Indikator Program</button></a>
      @endif --}}
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
		        <th colspan="2" style="text-align: center;">Kondisi Akhir</th>
				<!--<th rowspan="2" style="text-align: center;  width: 6%;">Aksi</th>-->		
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
				
				
				
			

					@foreach(collect($program)->unique('program_no') as $p)
					<tr style="font-size: 12px;font-weight: bold; background-color: #7abaff;">
						
						<td colspan="18" >{{$p->program_no}} &nbsp; {{$p->program_nama}}</td>
						
						{{-- <td></td> --}}
						
					@foreach(collect($program)->unique('kegiatan_no')->where('program_no', $p->program_no) as $k)

					<tr>
						<td colspan="2"></td>
						<td>{{$k->kegiatan_nama}}</td>
						<td >{{$k->indikator_kegiatan}}</td>
						<td style="text-align: center;">{{$k->satuan_nama}}</td>
						<td style="text-align: center;">{{$k->perencanaan_awal}}</td>
						<td style="text-align: center;">{{$k->target_t1}}</td>
						<td style="text-align: right;">{{$k->pagu_t1}}</td>
						<td style="text-align: center;">{{$k->target_t2}}</td>
						<td style="text-align: right;">{{$k->pagu_t2}}</td>
						<td style="text-align: center;">{{$k->target_t3}}</td>
						<td style="text-align: right;">{{$k->pagu_t3}}</td>
						<td style="text-align: center;">{{$k->target_t4}}</td>
						<td style="text-align: right;">{{$k->pagu_t4}}</td>
						<td style="text-align: center;">{{$k->target_t5}}</td>
						<td style="text-align: right;">{{$k->pagu_t5}}</td>
						<td style="text-align: center;">{{$k->target_kondisi_akhir}}</td>
						<td style="text-align: right;">{{$k->pagu_kondisi_akhir}}</td>
						
						{{-- <td>
							<span class="text-danger">tombol aksi sedang perbaikan</span> --}}
							
					</tr>
					</tr>
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>