<!DOCTYPE html>
<html>
<head>
	<title>Cetak PK PDF</title>

	<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
	<div class="text-center">
		<label class="mb-5">Laporan Monitoring dan Evaluasi Bulanan {{ date('Y') }}<br>Capaian Perjanjian Kinerja {{ get_name_opd(Auth::user()->organisasi_no) }} Kab. Kepulauan Meranti</label>
	</div>

	<table style="width: 100%" class="mb-3">
		<tr>
			<td>OPD</td>
			<td>:</td>
			<td><strong>{{ get_name_opd(Auth::user()->organisasi_no) }}</strong></td>
		</tr>
		<tr>
			<td>Tahun</td>
			<td>:</td>
			<td><strong>{{ $tahun }}</strong></td>
		</tr>
	</table>

	<table class="table table-bordered" style="font-size: 10px;">
		<thead>
			<tr>
				<th rowspan="2" class="text-center">No.</th>
				<th rowspan="2" class="text-center">Indikator</th>
				<th rowspan="2" class="text-center">Satuan</th>
				<th colspan="4" class="text-center">TW I</th>
				<th colspan="4" class="text-center">TW II</th>
				<th colspan="4" class="text-center">TW III</th>
				<th colspan="4" class="text-center">TW IV</th>
			</tr>
			<tr>
				<th>Target</th>
				<th>Kinerja</th>
				<th>Anggaran</th>
				<th>Rekomendasi</th>
				<th>Target</th>
				<th>Kinerja</th>
				<th>Anggaran</th>
				<th>Rekomendasi</th>
				<th>Target</th>
				<th>Kinerja</th>
				<th>Anggaran</th>
				<th>Rekomendasi</th>
				<th>Target</th>
				<th>Kinerja</th>
				<th>Anggaran</th>
				<th>Rekomendasi</th>
			</tr>
		</thead>
		<tbody>
			@foreach($csos as $cso)
			<tr>
				<td>{{ $no++ }}</td>
				<td>{{ $cso->indikator_sasaran_nama }}</td>
				<td>{{ $cso->satuan_nama }}</td>
				<td>{{ $cso->target1 }}</td>
				<td>{{ $cso->kinerja1 }}</td>
				<td>{{ $cso->anggaran1 }}</td>
				<td>{{ $cso->rekomendasi1 }}</td>
				<td>{{ $cso->target2 }}</td>
				<td>{{ $cso->kinerja2 }}</td>
				<td>{{ $cso->anggaran2 }}</td>
				<td>{{ $cso->rekomendasi2 }}</td>
				<td>{{ $cso->target3 }}</td>
				<td>{{ $cso->kinerja3 }}</td>
				<td>{{ $cso->anggaran3 }}</td>
				<td>{{ $cso->rekomendasi3 }}</td>
				<td>{{ $cso->target4 }}</td>
				<td>{{ $cso->kinerja4 }}</td>
				<td>{{ $cso->anggaran4 }}</td>
				<td>{{ $cso->rekomendasi4 }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<table align="right">
		<tr>
			<td class="text-center">Selatpanjang, {{ date('d F Y') }}</td>
		</tr>
		<tr>
			<td class="text-center">KABUPATEN KEPULAUAN MERANTI</td>
		</tr>
		<tr>
			<td class="text-center mt-5"><br><br><br></td>
		</tr>
		<tr>
			<td class="text-center">Nama Kepala Dinas</td>
		</tr>
		<tr>
			<td class="text-center">jabatan</td>
		</tr>
		<tr>
			<td class="text-center">nip</td>
		</tr>
	</table>

	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</body>
</html>