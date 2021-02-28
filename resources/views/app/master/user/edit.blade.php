@extends('layouts.template')
@section('content')
<div class="box box-default" style="padding: 10px;">
<div class="box-header with-border">
    <h4>Edit User</h4>
</div>
<!-- /.box-header -->
<!-- form start -->
<form action="{{ route('user.update',$user->id) }}" class="form-horizontal" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group">
        <label for="nama" class="col-sm-2 control-label">{{ __('Nama') }}</label>
        <div class="col-sm-8">
            <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ $user->nama }}" autofocus>

            @if ($errors->has('nama'))
                <span class="text-danger">
                    <strong>{{ $errors->first('nama') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="username" class="col-sm-2 control-label">{{ __('Username') }}</label>
        <div class="col-sm-8">
            <input id="username"  type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $user->username }}">

            @if ($errors->has('username'))
                <span class="text-danger">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>
    </div>
    
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">{{ __('Password') }}</label>
        <div class="col-sm-8">
            <input id="password" minlength="6" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password Baru..">

            {{-- @if ($errors->has('password'))
                <span class="text-danger">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif --}}
        </div>
    </div>

    <div class="form-group">
        <label for="level" class="col-sm-2 control-label">{{ __('Tipe') }}</label>
        <div class="col-sm-8">
            <select name="level" id="level" class="form-control">
                <option value="">Pilih Otorisasi</option>
                <option @if($user->level=='1') selected @endif value="1">Admin</option>
                <option @if($user->level=='2') selected @endif value="2">User</option>
                <option @if($user->level=='3') selected @endif value="3">Pemeriksa</option>
            </select>
            @if ($errors->has('level'))
                <span class="text-danger">
                    <strong>{{ $errors->first('level') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="level" class="col-sm-2 control-label">{{ __('Nama OPD') }}</label>
        <div class="col-sm-8">
            <select name="opd" id="opd" class="form-control select2">
                <option  value="">Pilih OPD</option>
                @foreach ($opds as $data)
                <option @if($user->organisasi_no==$data->organisasi_no) selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
    <div class="row" align="right">
        <div class="col-sm-8 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            <a href="{{route('user.index')}}" class="btn btn-danger">Batal</a>
            
        </div>
    </div>
</form>
@endsection