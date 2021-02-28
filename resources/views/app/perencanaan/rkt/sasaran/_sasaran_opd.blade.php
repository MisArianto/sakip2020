<div class="table-responsive tab-content">
		
				<table class="table table-responsive table-hover table-bordered" style="font-size: 12px;">
					<thead>
					<tr style="background-color: #007bff; vertical-align: middle;">
						<th rowspan="2">Tujuan</th>
						<th rowspan="2">Sasaran</th>
						<th rowspan="2">Indikator Sasaran</th>
						<th rowspan="2" style="text-align: center;">Satuan</th>
				        {{-- <th colspan="2" style="text-align: center;">Target Renstra</th> --}}
				        <th style="text-align: center;">Target</th>
				        
						{{-- <th rowspan="2" style="text-align: center;  width: 50px;">Aksi</th>		 --}}
					</tr>
					 
					</thead>
					<tbody>
						
						
						@foreach($tujuan as $t)
						
						<tr >
							<td colspan="18" style="background-color: #7abaff; font-weight: bolder;">{{$t->tujuan_nama}}</td>
						</tr>
						@foreach(collect($sasaran)->where('tujuan_nomor', $t->tujuan_nomor) as $s)
						
						<tr style="font-size: 12px;">
							<td></td>
							<td style="font-weight: bold;" colspan="17">{{$s->sasaran_nama}}</td>
						</tr>
						@foreach(collect($indikator_sasaran)->where('sasaran_nomor', $s->sasaran_nomor) as $is)
						
							<tr style="font-size: 11px;">
								<td></td>
								<td></td>
								<td>{{$is->indikator_sasaran}}</td>
								<td style="text-align: center;">{{$is->satuan_nama}}</td>
								{{-- <td style="text-align: center;">{{$is->target_t3}}</td>
								<td style="text-align: right;">{{($is->pagu_t3)}}</td> --}}
								<td style="text-align: center;">{{$is->target_t3}}</td>
								
								{{-- <td> --}}
									{{-- <a href="{{url('perencanaan/rkt-sasaran/editRKT',$is->id) }}" data-toggle="tooltip" title="Edit Target Sasaran RKT" class="btn btn-warning btn-xs"><i class="fa fa-edit" ></i></a> --}}
		                       {{--  <form action="{{ url('perencanaan/renstra-indikator-sasaran/destroyIndikatorSasaran',$is->id) }}" method='POST' style="display: inline;">
		                            {{ csrf_field() }}

		                            <input type="hidden" name="_method" value="DELETE">
		                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Indikator Sasaran"><i class="fa fa-trash-o" ></i></button>
		                        </form> --}}
								{{-- </td> --}}
							</tr>
						

						@endforeach
						@endforeach
						@endforeach
					</tbody>
				</table>
			</div>