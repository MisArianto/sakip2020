	<div class="table-responsive">
	@if(Auth::user()->level == 2)
	<a href="{{route ('perjanjian-kinerja.create')}}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah PK Eselon II">Tambah</button></a>
	
	@endif
		<table class="table table-responsive table-hover table-bordered">
			<thead>
				<tr style="background-color: #007bff; vertical-align: middle; color: #fff;">
					<th style="width: 10px;">#</th>
					<th>Sasaran Strategis</th>
					<th>Indikator Sasaran</th>
					<th style="text-align: center;">Satuan</th>
					<th style="text-align: center;">Target</th>
					<th style="text-align: center;" >Aksi</th>		
				</tr>
			</thead>
			<tbody>
				@foreach(collect($eselon)->unique('sasaran_id') as $data1)
				<tr>
					<td align="center">{{$no++}}.</td>
					<td colspan="5">{{$data1->sasaran_nama}}</td>
				</tr>
					@foreach(collect($eselon)->unique('indikator_sasaran_id')->where('sasaran_id', $data1->sasaran_id) as $is)
					<tr>
						<td></td>
						<td></td>
						<td>{{$is->indikator_sasaran_nama}}</td>
						<td align="center">{{$is->satuan_nama}}</td>
						<td align="center">{{$is->target}}</td>
						@if(Auth::user()->level != '3')
	                    <td style="text-align: center;">
	                        <a href="{{route('perjanjian-kinerja.edit',$is->id)}}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit" ></i></a>
	                        <form action="{{ route('perjanjian-kinerja.destroy',$is->id) }}" method='POST' style="display: inline;">
	                        @csrf

	                            <input type="hidden" name="_method" value="DELETE">
	                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash-o"></i></button>
	                        </form>
	                    </td>
	                    @endif
					</tr>
					
				
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>


{{-- 	<div class="table-responsive">
	@if(Auth::user()->level == 2)
	<a href="{{route ('perjanjian-kinerja.create')}}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah PK Eselon II">Tambah</button></a>
	
	@endif
		<table class="table table-responsive table-hover table-bordered">
			<thead>
				<tr style="background-color: #007bff; vertical-align: middle; color: #fff;">
					<th style="width: 10px;">#</th>
					<th>Sasaran Strategis</th>
					<th>Indikator Sasaran</th>
					<th style="text-align: center;">Satuan</th>
					<th style="text-align: center;">Target</th>
					<th style="text-align: center;" >Aksi</th>		
				</tr>
			</thead>
			<tbody>
				@foreach($sasaran as $data1)
				<tr>
					<td align="center">{{$no++}}.</td>
					<td colspan="5">{{$data1->sasaran_nama}}</td>
				</tr>
					@foreach(collect($indikator_kinerja)->where('sasaran_nomor', $data1->sasaran_nomor) as $is)
					<tr>
						<td></td>
						<td></td>
						<td>{{$is->indikator_sasaran_nama}}</td>
						<td align="center">{{$is->satuan_nama}}</td>
						<td align="center">{{$is->target}}</td>
						@if(Auth::user()->level != '3')
	                    <td style="text-align: center;">
	                        <a href="{{route('perjanjian-kinerja.edit',($is->id))}}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit" ></i></a>
	                        <form action="{{ route('perjanjian-kinerja.destroy',$is->id) }}" method='POST' style="display: inline;">
	                        @csrf

	                            <input type="hidden" name="_method" value="DELETE">
	                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash-o"></i></button>
	                        </form>
	                    </td>
	                    @endif
					</tr>
					
				
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div> --}}