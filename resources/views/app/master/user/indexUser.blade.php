@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
        
    <div class="box-header">
        <h4>Profil User </h4>
    </div>
    
    <div class="box-body">
      <form action="{{ route('user.update', Auth::user()->id)}}" class="form-horizontal" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="PUT">

              <div class="box-body">
                <div class="form-group">
                  <label for="nama" class="col-sm-2 control-label">{{ __('Nama') }}</label>
                  <div class="col-sm-8">
                    <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ Auth::user()->nama }}" autofocus>
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
                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ Auth::user()->username }}" readonly>
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
                    <input id="password" type="password" minlength="6" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password Baru">
                    @if ($errors->has('password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                  	<input type="hidden" name="level" id="level" class="form-control" value="{{Auth::user()->level}}">
                    <input type="hidden" name="opd" id="opd" class="form-control" value="{{ Auth::user()->organisasi_no }}">
              </div>
              <!-- /.box-body -->
              <div class="box-footer ">
                <div class="col-sm-10">
                <div class=" pull-right">
                  <button type="submit" class="btn btn-primary">{{ __('Rubah') }}</button>
                </div>
                
              </div>
              </div>
              <!-- /.box-footer -->
            </form>
    </div>

</div>
@stop        

