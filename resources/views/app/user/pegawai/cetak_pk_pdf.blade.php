<!DOCTYPE html>
<html>
<head>
	<title>Cetak PK PDF</title>
</head>
<body>
	<h1>Perjanjian Kinerja Eselon II Tahun {{ date('Y') }}</h1>

	<table style="width: 100%">
		<tr>
			<td>Nama Pejabat</td>
			<td>:</td>
			<td><strong>{{ $model->nama }}</strong></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><strong>{{ $model->jabatan }}</strong></td>
		</tr>
		<tr>
			<td>Nama Pimpinan</td>
			<td>:</td>
			<td><strong>Drs. Irwan, M.Si</strong></td>
		</tr>
		<tr>
			<td>Jabatan Pimpinan</td>
			<td>:</td>
			<td><strong>Bupati Kepulauan Meranti</strong></td>
		</tr>
	</table>

	<h2>Perjanjian Kinerja</h2>
	<table style="width: 100%">
		<tr>
			<thead>
				<th>No.</th>
				<th>Sasaran Strategis</th>
				<th>Indikator Kinerja</th>
				<th>Satuan</th>
				<th>Target</th>
			</thead>
			<tbody>
				<tr>
					<td></td>
				</tr>
			</tbody>
		</tr>
	</table>

</body>
</html>