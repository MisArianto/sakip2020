	<div class="table-responsive">
	@if(Auth::user()->level == 2)
	<a href="{{url('perencanaan/pk/create-eselon-IV')}}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah PK Eselon IV">Tambah</button></a>
	
	@endif
		<table class="table table-responsive table-hover table-bordered">
			<thead>
				<tr style="background-color: #007bff; vertical-align: middle; color: #fff;">
					<th style="width: 10px;">#</th>
					<th>Kegiatan</th>
					<th>Sasaran Kegiatan</th>
					<th>Indikator Kegiatan</th>
					<th style="text-align: center;">Satuan</th>
					<th style="text-align: center;">Target</th>
					<th style="text-align: center;" >Aksi</th>		
				</tr>
			</thead>
			<tbody>
				@if(count($eselonIV)>0)
				@foreach(collect($eselonIV)->unique('kegiatan_id') as $data)
				<tr>
					<td align="center">{{$no++}}.</td>
					<td colspan="5">{{$data->kegiatan_nama}}</td>
				</tr>
				@foreach(collect($eselonIV)->unique('kegiatan_id')->where('kegiatan_id', $data->kegiatan_id) as $ik)
				<tr>
					<td></td>
					<td></td>
						<td>{{$ik->sasaran_kegiatan}}</td>
						<td>{{$ik->indikator_kegiatan_nama}}</td>
						<td align="center">{{$ik->satuan_nama}}</td>
						<td align="center">{{$ik->target}}</td>
						@if(Auth::user()->level != '3')
	                    <td style="text-align: center;">
	                        <a href="{{url('perencanaan/perjanjian-kinerja/edit-eselon-IV',$ik->id)}}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit" ></i></a>
	                        <form action="{{ url('perencanaan/perjanjian-kinerja/destroy-eselon-IV',$ik->id) }}" method='POST' style="display: inline;">
	                        @csrf

	                            <input type="hidden" name="_method" value="DELETE">
	                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash-o"></i></button>
	                        </form>
	                    </td>
	                    @endif
					</tr>
					
				
				@endforeach
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
