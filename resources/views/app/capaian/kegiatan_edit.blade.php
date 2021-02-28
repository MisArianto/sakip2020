@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
    
    <div class="box-header">
        <h4> Edit Target Indikator Kegiatan RKT Perangkat Daerah</h4>
    </div>

    <form action="{{ url ('capaian/kegiatan/update',$model->id)}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
              <div class="col-md-12">
                    <div class="col-md-2">
                      <input type="text" name="tw_1" value="{{ $model->tw_1 }}">
                    </div>

                    <div class="col-md-2">
                      <input type="text" name="tw_2" value="{{ $model->tw_2 }}">
                    </div>

                    <div class="col-md-2">
                      <input type="text" name="tw_3" value="{{ $model->tw_3 }}">
                    </div>

                    <div class="col-md-2">
                      <input type="text" name="tw_4" value="{{ $model->tw_4 }}">
                    </div>
    
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-sm btn-primary" title="Cari">Update</button>
                    </div>
              </div>
        </div>
    </form>

</div>
@endsection
