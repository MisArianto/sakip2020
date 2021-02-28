@extends('layouts.template')
@section('content')
<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h4>Edit Laporan Hasil Evaluasi</h4>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('lhe.update', $model->id)}}" class="form-horizontal" method="POST">
              @csrf

              <input type="hidden" name="_method" value="PUT">

              <div class="box-body">

                <div class="form-group">
                  <label for="nilai" class="col-sm-2 control-label">{{ __('Nilai') }}</label>

                  <div class="col-sm-8">
                    <input id="nilai" type="text" class="form-control{{ $errors->has('nilai') ? ' is-invalid' : '' }}" name="nilai" value="{{ $model->nilai }}">
                    @if ($errors->has('nilai'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('nilai') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

              <!-- /.box-body -->
              <div class="box-footer ">
                <div class="col-sm-10">
                <div class=" pull-right">
                  <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                  <a href="{{ route('lhe.index')}}" class="btn-default btn">Kembali</a>
                </div>
                
              </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
@endsection