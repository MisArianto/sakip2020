

{!! Form::model($model, [
'route'  => $model->exists ? ['user.update', $model->id] : 'user.store',
'method' => $model->exists ? 'PUT' : 'POST',
'id'     => 'form'
]) !!}
<div class="form-group">
	{!! Form::hidden (null,'user',['id' => 'nameTable']) !!}
</div>

<div class="form-group">
	<label for="nama" class="control-label">Nama</label>
	{!! Form::text('nama',null, ['class' => 'form-control', 'id' => 'nama']) !!}
</div>
<div class="form-group">
	<label for="username" class="control-label">Username</label>
	{!! Form::text('username',null, ['class' => 'form-control', 'id' => 'username']) !!}
</div>
<div class="form-group">
	<label for="password" class="control-label">Password</label>
	{!! Form::text('password',null, ['class' => 'form-control', 'id' => 'password']) !!}
</div>
<div class="form-group">
	<label for="level" class="control-label">Status</label>
	{!! Form::select('level', [null => 'Pilih Status'] + ['1' => 'Admin','2'=>'OPD'], null, ['class' => 'form-control select2', 'required']) !!}

</div>
<div class="form-group">
	<label for="organisasi_no" class="control-label">Organisasi</label>
	{!! Form::select('organisasi_no', App\Models\Organisasi::where('organisasi_jenis','=','ORG')->pluck('organisasi_nama', 'id')->prepend('Pilih OPD ', ''), old('organisasi_no'), ['class' => 'form-control select2',  'required']) !!}
</div>



{!! Form::close() !!}

