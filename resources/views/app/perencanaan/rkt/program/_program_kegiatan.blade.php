<div class="table-responsive">
		
				<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
					<thead>
					<tr style="background-color: #007bff; vertical-align: middle;">
						
						<th rowspan="2" colspan="2">Program</th>
						<th rowspan="2">Kegiatan</th>
						<th rowspan="2">Indikator Kegiatan</th>
						<th rowspan="2" style="text-align: center;">Satuan</th>
				        <th colspan="2" style="text-align: center;">Target RKT</th>
						{{-- <th rowspan="2" style="text-align: center;  width: 50px;">Aksi</th>		 --}}
					</tr>
					 <tr style="background-color: #007bff; font-size: 12px;">
				        <th style="text-align: center;">Target</th>
				        <th style="text-align: center;">Pagu</th>
				        
				      </tr>
					</thead>
					<tbody>
						
							@foreach($program as $p)
							<tr style="font-weight: bold; background-color: #7abaff;">
								<td colspan="19" >{{$p->program_no}} &nbsp;{{$p->program_nama}}</td>
							</tr>
							@foreach(collect($kegiatan)->where('program_no', $p->program_no) as $k)
								
								<tr style=" font-size: 12px;">
									<td colspan="2"></td>
									<td>{{$k->kegiatan_nama}}</td>
									<td>{{$k->indikator_kegiatan}}</td>
									<td style="text-align: center;">{{$k->satuan_nama}}</td>
									<td style="text-align: center;">{{$k->target_t3}}</td>
									<td style="text-align: right;">{{($k->pagu_t3)}}</td>
									
									{{-- <td></td> --}}
							</tr>
							
						@endforeach
						@endforeach
					</tbody>
				</table>
			</div>