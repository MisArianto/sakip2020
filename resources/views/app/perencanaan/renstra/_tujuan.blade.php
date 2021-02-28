<div class="table-responsive">
	{{-- <br>
	 @if(Auth::user()->level != 3)
		<a href="{{url ('perencanaan/rencana-strategis/tambah-tujuan')}}" data-toggle="tooltip" title="Tambah Tujuan"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tujuan</button></a> &nbsp;
		<a href="{{url ('perencanaan/rencana-strategis/tambah-indikator-tujuan')}}" data-toggle="tooltip" title="Tambah Indikator Tujuan"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Indikator Tujuan</button></a>
      @endif --}}
		<br>
		<table class="table table-responsive table-bordered table-hover" >
			<thead>
			<tr style="background-color: #007bff; color: #fff;">
				<th style="">Misi</th>
				<th >Tujuan</th>
				<th >Indikator</th>
				<th  style="text-align: center;">Satuan</th>
		        <th  style="text-align: center;">Kondisi Akhir</th>
				<!--<th  style="text-align: center;  width: 7%;">Aksi</th>-->		
			</tr>
			 
			</thead>
			<tbody>
				
				@foreach(collect($sasaran)->unique('misi_id') as $m)
				<tr style="background-color: #7abaff; font-weight: bolder;">
					<td colspan="6" >Misi Ke : {{$m->nomor}}. {{$m->nama}}</td>
				</tr>
				@foreach(collect($sasaran)->unique('tujuan_id')->where('misi_id', $m->misi_id) as $t)
				
				<tr style="font-weight: bold;" >
					<td></td>
					<td colspan="4">{{$t->tujuan_nama}}</td>
					{{-- @if(Auth::user()->level != 3)
					<td display="inline" style="text-align: center;">
                        <a href="{{route ('renstra-tujuan.edit',$t->tujuan_id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Tujuan"><i class="fa fa-edit" ></i></a>
                        <form action="{{ route('renstra-tujuan.destroy',$t->tujuan_id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Tujuan"><i class="fa fa-trash-o" ></i></button>
                        </form>
					</td>
					@endif --}}
					
				</tr>
				@foreach(collect($sasaran)->unique('indikator_tujuan_id')->where('tujuan_id', $t->tujuan_id) as $it)
 				<tr >
					<td colspan="2"></td>
					<td>{{$it->indikator_tujuan}}</td>
					<td style="text-align: center;">{{$it->satuan_nama}}</td>
					<td style="text-align: center;">{{$it->kondisi_akhir}}</td>
					{{-- @if(Auth::user()->level != 3)
					<td display="inline" style="text-align: center;">
						<a href="{{url('perencanaan/renstra-tujuan-indikator/editIndikatorRenstra',$it->indikator_tujuan_id) }}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Indikator Tujuan"><i class="fa fa-edit" ></i></a>
                        <form action="{{ url('perencanaan/renstra-tujuan-indikator/destroyIndikatorRenstra',$it->indikator_tujuan_id) }}" method='POST' style="display: inline;">
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Indikator Tujuan"><i class="fa fa-trash-o" ></i></button>
                        </form>
					</td>
					@endif --}}
				</tr>
				@endforeach
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>