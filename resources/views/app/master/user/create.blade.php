@extends('layouts.template')
@section('content')
<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h4>Tambah User</h4>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('user.store')}}" class="form-horizontal" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="nama" class="col-sm-2 control-label">{{ __('Nama') }}</label>
                  <div class="col-sm-8">
                    <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" autofocus>
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
                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" autofocus>
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
                    <input id="password" type="password" minlength="6" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                    @if ($errors->has('password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label for="level" class="col-sm-2 control-label">{{ __('Status') }}</label>
                  <div class="col-sm-8">
                      <select name="level" id="level" class="form-control select2">
                          <option  {{ old('level') ? 'selected' : '' }} value="">Pilih Otorisasi</option>
                          <option value="1">Admin</option>
                          <option value="2">User</option>
                          <option value="3">Pemeriksa</option>
                      </select>
                      @if ($errors->has('level'))
                          <span class="text-danger">
                              <strong>{{ $errors->first('level') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
                <div class="form-group">
                    <label for="opd" class="col-sm-2 control-label">{{ __('Nama OPD') }}</label>
                    <div class="col-sm-8">
                        <select name="opd" id="opd" class="form-control select2">
                            <option value="">Pilih OPD</option>
                            
                            @foreach($opd as $data)
                            <option {{ old('opd') ? 'selected' : '' }} value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                            @endforeach
                            
                        </select>
                        @if ($errors->has('opd'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('opd') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer ">
                <div class="col-sm-10">
                <div class=" pull-right">
                  <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                  <a href="{{ route('user.index')}}" class="btn-default btn">Kembali</a>
                </div>
                
              </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
@endsection