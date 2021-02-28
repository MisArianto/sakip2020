@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
    
    <div class="box-header">
        <h4> Edit Capaian Indikator Sasaran RKT Perangkat Daerah</h4>
    </div>
    <br>
    <div class="box-body">

    <form action="{{ url ('capaian/sasaran/update',$model->id)}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
              <div class="col-md-12">
                <br>
                    <div class="col-md-2">
                      <label for="">Triwulan I</label><br><br>
                      <input type="text" name="tw_1" value="{{ $model->tw_1 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Target Triwulan I</label><br><br>
                      <input type="text" name="target1" value="{{ $model->target1 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Kinerja I</label><br><br>
                      <input type="text" name="kinerja1" value="{{ $model->kinerja_1 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Anggaran</label><br><br>
                      <input type="text" name="a_1" value="{{ $model->a_1 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Rekomendasi</label><br><br>
                      <input type="text" name="rkmn_1" value="{{ $model->rkmn_1 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Realisasi</label><br><br>
                      <input type="text" name="real_1" value="{{ $model->real_1 }}">
                    </div>

                    <br>
                    <br>
                    <br>
                    {{-- <div class="pull-right">
                        <button type="submit" class="btn btn-sm btn-primary" title="Simpan">Simpan</button>
                        <a href="" class="btn btn-sm btn-default">Kembali</a>
                    </div> --}}
              </div>
        </div>
        <hr>
       <div class="row">
              <div class="col-md-12">
                <br>
                    <div class="col-md-2">
                      <label for="">Triwulan II</label><br><br>
                      <input type="text" name="tw_2" value="{{ $model->tw_2 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Target Triwulan II</label><br><br>
                      <input type="text" name="target2" value="{{ $model->target2 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Kinerja II</label><br><br>
                      <input type="text" name="kinerja2" value="{{ $model->kinerja_2 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Anggaran</label><br><br>
                      <input type="text" name="a_2" value="{{ $model->a_2 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Rekomendasi</label><br><br>
                      <input type="text" name="rkmn_2" value="{{ $model->rkmn_2 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Realisasi</label><br><br>
                      <input type="text" name="real_2" value="{{ $model->real_2 }}">
                    </div>

              </div>
        </div>
        <hr>

        <div class="row">
              <div class="col-md-12">
                <br>
                    <div class="col-md-2">
                      <label for="">Triwulan III</label><br><br>
                      <input type="text" name="tw_3" value="{{ $model->tw_3 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Target Triwulan III</label><br><br>
                      <input type="text" name="target3" value="{{ $model->target3 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Kinerja III</label><br><br>
                      <input type="text" name="kinerja3" value="{{ $model->kinerja_3 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Anggaran</label><br><br>
                      <input type="text" name="a_3" value="{{ $model->a_3 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Rekomendasi</label><br><br>
                      <input type="text" name="rkmn_3" value="{{ $model->rkmn_3 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Realisasi</label><br><br>
                      <input type="text" name="real_3" value="{{ $model->real_3 }}">
                    </div>
              </div>
        </div>
        <hr>

         <div class="row">
              <div class="col-md-12">
                <br>
                    <div class="col-md-2">
                      <label for="">Triwulan IV</label><br><br>
                      <input type="text" name="tw_4" value="{{ $model->tw_4 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Target Triwulan IV</label><br><br>
                      <input type="text" name="target4" value="{{ $model->target4 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Kinerja IV</label><br><br>
                      <input type="text" name="kinerja4" value="{{ $model->kinerja_4 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Anggaran</label><br><br>
                      <input type="text" name="a_4" value="{{ $model->a_4 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Rekomendasi</label><br><br>
                      <input type="text" name="rkmn_4" value="{{ $model->rkmn_4 }}">
                    </div>

                    <div class="col-md-2">
                      <label for="">Realisasi</label><br><br>
                      <input type="text" name="real_4" value="{{ $model->real_4 }}">
                    </div>
              </div>
        </div>

        <br>
        <br>
        <br>

        <hr>

         <div class="row">
              <div class="col-md-12">
                <br>
                    <div class="col-md-4">
                      <label for="">Pagu</label><br><br>
                      <input type="text" name="pagu" value="{{ $model->pagu }}">
                    </div>
              </div>
        </div>

        <br>
        <br>
        <br>

        <div class="row">
              <div class="col-md-12">
                <div class="pull-right">
                        <button type="submit" class="btn btn-sm btn-primary" title="Simpan">Simpan</button>
                        <a href="{{ url('capaian') }}" class="btn btn-sm btn-default">Kembali</a>
                    </div>
              </div>
        </div>

    </form>
  </div> 

</div>
@endsection
