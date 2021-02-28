@extends('layouts.template')
@section('content')
<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h4>Tambah Galeri</h4>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('master/galeri/store')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="judul" class="col-sm-2 control-label">{{ __('Judul') }}</label>
                  <div class="col-sm-8">
                    <input id="judul" type="text" class="form-control{{ $errors->has('judul') ? ' is-invalid' : '' }}" name="judul" value="{{ old('judul') }}" autofocus>
                    @if ($errors->has('judul'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('judul') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">{{ __('title') }}</label>

                  <div class="col-sm-8">
                    <textarea cols="4" rows="3" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title">{{ old('title') }}</textarea>
                    @if ($errors->has('title'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label for="photo" class="col-sm-2 control-label">{{ __('Photo') }}</label>
                  <div class="col-sm-8">
                    <input id="photo" type="file" class="form-control{{ $errors->has('photo') ? ' is-invalid' : '' }}" name="photo">
                    @if ($errors->has('photo'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('photo') }}</strong>
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
                  <a href="{{ url('master/galeri/list')}}" class="btn-default btn">Kembali</a>
                </div>
                
              </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
@endsection