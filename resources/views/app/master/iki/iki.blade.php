@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
 <div class="box-header">

					<h4>Indikator Kinerja Individu Pegawai 
					{{-- <a href="{{ route('iki.index') }}" class="btn btn-default"> Back</a> --}}
					</h4>
</div>	
<div class="box-body">
			<table class="table table-responsive  table-hover ">
				@foreach($pimpinans as $pimpinan)
				@foreach($pegawais as $pegawai)
				<tr>
					<td style="font-weight: bold;">Nama Pegawai</td>
					<td style="font-weight: bold;">:</td>
					<td>{{$pegawai->nama}}</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Jabatan</td>
					<td style="font-weight: bold;">:</td>
					<td>{{$pegawai->jabatan}}</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Nama Pimpinan</td>
					<td style="font-weight: bold;">:</td>
					<td>{{$pimpinan->nama}}</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Jabatan Pimpinan</td>
					<td style="font-weight: bold;">:</td>
					<td>{{$pimpinan->jabatan}}</td>
				</tr>
				@endforeach
				@endforeach
			</table>

			<br>


			<h4>URAIAN</h4>

			<div class="table-responsive">
				<table class="table table-responsive table-hover table-bordered">
					<thead>
						<tr style="background-color: #007bff; color: #fff;">
							<td style="text-align: center; width: 3%;">No</td>
							<td>Sasaran Strategis</td>
							<td>Satuan</td>
							<td>Target</td>
						</tr>
					</thead>
					<body>
						@foreach($ikis as $iki)
						<tr>
							<td style="text-align: center;">{{ $no++ }}</td>
							<td>{{ $iki->sasaran_strategis }}</td>
							<td>{{ $iki->satuan_nama }}</td>
							<td>{{ $iki->target }}</td>
						</tr>
						@endforeach
					</body>
				</table>
			</div>
			
				
	</div>
</div>


@endsection


@push('scripts')

<script>

	$('#tahun').prop('disabled', true);

	$('#id_pegawai').on('change', function(){
		$('#tahun').prop('disabled', false);
	});

	$('#tahun').on('change', function(){
		$(this).closest('form').submit();
	});
</script>

@endpush
