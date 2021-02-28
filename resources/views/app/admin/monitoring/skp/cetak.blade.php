<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="{{ asset ('bower_components/font-awesome/css/font-awesome.min.css')}}">
</head>
<body onload="print()">

<h3 align="center">Monitoring Sistem SKP</h3>
<br>
<table border="1" width="100%" style="border-collapse: collapse;">
	<thead style="background-color: #dbdbdb;">
		<tr>
			<th>#</th>
			<th class="text-center">OPD</th>
			<th class="text-center">Tahun 2018</th> 
			<th class="text-center">Tahun 2019</th>
			<th class="text-center">Tahun 2020</th>
			<th class="text-center">Tahun 2021</th>
		</tr>
	</thead>
	<tbody>

		@foreach(collect($orgs)->unique('organisasi_nama') as $value)
		<tr>
			<td>{{ $no++ }}</td>
			<td>{{ $value->organisasi_nama }}</td>
		@foreach(collect($skps)->where('organisasi_nama', $value->organisasi_nama)->unique('organisasi_nama') as $data)

		<?php
		$jumlah_pegawai_2018 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2018')->unique('pegawai_id')->count();
		$jumlah_pegawai_2019 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2019')->unique('pegawai_id')->count();
		$jumlah_pegawai_2020 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2020')->unique('pegawai_id')->count();
		$jumlah_pegawai_2021 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2021')->unique('pegawai_id')->count();

		$cekOrg = collect($skps)->where('organisasi_no', $data->organisasi_no)->first();
		//$jumlah_pegawai_2021 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2021')->unique('pegawai_id')->count();

		if($data->organisasi_no == '2.01.06.01.')
		{
			$total_pegawai = DB::table('pegawai')->where('organisasi_nama', 'like', '%' . 'PERINDUSTRIAN' . '%')->count();

		}elseif($data->organisasi_no == '3.01.03.02.')
		{
			$total_pegawai = DB::table('pegawai')->where('organisasi_nama', 'like', '%' . 'PAJAK' . '%')->count();

		}else{

			$total_pegawai = DB::table('pegawai')->where('organisasi_nama', $data->organisasi_nama)->count();
		}

		?>

			@if($total_pegawai == 0)
			<td class="text-center">
				<div class="progress">
				  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				    <span class="sr-only">0 % Complete (danger)</span>
				    0%
				  </div>
				</div>
			</td>
			<td class="text-center">
				<div class="progress">
				  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				    <span class="sr-only">0 % Complete (danger)</span>
				    0%
				  </div>
				</div>
			</td>
			<td class="text-center">
				<div class="progress">
				  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				    <span class="sr-only">0 % Complete (danger)</span>
				    0%
				  </div>
				</div>
			</td>
			@else

			@if($jumlah_pegawai_2018 == 0)
			<td class="text-center" title="2018 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2018/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2018/$total_pegawai * 100,2)}}%">
				    <span class="sr-only">{{ round($jumlah_pegawai_2018/$total_pegawai * 100,2) }}% Complete (danger)</span>
				    {{ round($jumlah_pegawai_2018/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@else
			<td class="text-center" title="2018 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2018/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2018/$total_pegawai * 100,2)}}%;color:red;">
				    <span class="sr-only">{{ round($jumlah_pegawai_2018/$total_pegawai * 100,2) }}% Complete (success)</span>
				    {{ round($jumlah_pegawai_2018/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@endif

			@if($jumlah_pegawai_2019 == 0)
			<td class="text-center" title="2019 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2019/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2019/$total_pegawai * 100,2)}}%">
				    <span class="sr-only">{{ round($jumlah_pegawai_2019/$total_pegawai * 100,2) }}% Complete (danger)</span>
				    {{ round($jumlah_pegawai_2019/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@else
			<td class="text-center" title="2019 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2019/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2019/$total_pegawai * 100,2)}}%;color:red;">
				    <span class="sr-only">{{ round($jumlah_pegawai_2019/$total_pegawai * 100,2) }}% Complete (success)</span>
				    {{ round($jumlah_pegawai_2019/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@endif

			@if($jumlah_pegawai_2020 == 0)
			<td class="text-center" title="2020 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2020/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2020/$total_pegawai * 100,2)}}%">
				    <span class="sr-only">{{ round($jumlah_pegawai_2020/$total_pegawai * 100,2) }}% Complete (danger)</span>
				    {{ round($jumlah_pegawai_2020/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@else
			<td class="text-center" title="2020 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2020/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2020/$total_pegawai * 100,2)}}%;color:red;">
				    <span class="sr-only">{{ round($jumlah_pegawai_2020/$total_pegawai * 100,2) }}% Complete (success)</span>
				    {{ round($jumlah_pegawai_2020/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@endif
			
			@if($jumlah_pegawai_2021 == 0)
			<td class="text-center" title="2021 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2021/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2021/$total_pegawai * 100,2)}}%">
				    <span class="sr-only">{{ round($jumlah_pegawai_2021/$total_pegawai * 100,2) }}% Complete (danger)</span>
				    {{ round($jumlah_pegawai_2021/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@else
			<td class="text-center" title="2021 - {{ $data->organisasi_nama }}">
				<div class="progress">
				  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ round($jumlah_pegawai_2021/$total_pegawai * 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{round($jumlah_pegawai_2021/$total_pegawai * 100,2)}}%;color:red;">
				    <span class="sr-only">{{ round($jumlah_pegawai_2021/$total_pegawai * 100,2) }}% Complete (success)</span>
				    {{ round($jumlah_pegawai_2021/$total_pegawai * 100,2) }}%
				  </div>
				</div>
			</td>
			@endif

			@endif

		@endforeach
		</tr>
		@endforeach
	</tbody>
</table>
</body>
</html>
