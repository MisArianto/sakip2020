	<div class="table-responsive">
	@if(Auth::user()->level == 2)
	<a href="{{url('perencanaan/pk/create-eselon-III')}}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah PK Eselon III">Tambah</button></a>
	
	@endif
		<table class="table table-responsive table-hover table-bordered">
			<thead>
				<tr style="background-color: #007bff; vertical-align: middle; color: #fff;">
					<th style="width: 10px;">#</th>
					<th>Program</th>
					<th>Sasaran Program</th>
					<th>Indikator Program</th>
					<th style="text-align: center;">Satuan</th>
					<th style="text-align: center;">Target</th>
					<th style="text-align: center;" >Aksi</th>		
				</tr>
			</thead>
			<tbody>
				@if(count($eselonIII)>0)
				@foreach(collect($eselonIII)->unique('program_id') as $data)
				<tr>
					<td align="center">{{$no++}}.</td>
					<td colspan="5">{{$data->program_nama}}</td>
				</tr>
				@foreach(collect($eselonIII)->unique('indikator_program_id')->where('program_id', $data->program_id) as $ip)
				<tr>
					<td></td>
					<td></td>
						<td>{{$ip->sasaran_program}}</td>
						<td>{{$ip->indikator_program_nama}}</td>
						<td align="center">{{$ip->satuan_nama}}</td>
						<td align="center">{{$ip->target}}</td>
						@if(Auth::user()->level != '3')
	                    <td style="text-align: center;">
	                        <a href="{{url('perencanaan/perjanjian-kinerja/edit-eselon-III',$ip->id)}}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit" ></i></a>
	                        <form action="{{ url('perencanaan/perjanjian-kinerja/destroy-eselon-III',$ip->id) }}" method='POST' style="display: inline;">
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
