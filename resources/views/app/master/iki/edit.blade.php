@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
    {{-- <div class="box-header with-border"> --}}
    <div class="box-header">

    <h4>Edit Indikator Kinerja Individu</h4>

   </div>
   
<br><br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ route('iki.update',$model->id) }}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="pegawai_id" class="col-sm-2 control-label">Nama Pegawai</label>
                <div class="col-sm-8">
                    <select id="pegawai_id" class="form-control{{ $errors->has('pegawai_id') ? ' is-invalid' : '' }} select2" name="pegawai_id">
                    <option value="">--Pilih Pegawai--</option>
                    @foreach($pegawais as $pegawai)
                    <option @if($model->pegawai_id == $pegawai->id) selected @endif {{ old('pegawai_id') ? 'selected' : '' }} value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('pegawai_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('pegawai_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="pimpinan_id" class="col-sm-2 control-label">Nama Pimpinan</label>
                <div class="col-sm-8">
                    <select id="pimpinan_id" class="form-control{{ $errors->has('pimpinan_id') ? ' is-invalid' : '' }} select2" name="pimpinan_id">
                    <option value="">--Pilih Pimpinan--</option>
                    @foreach($pimpinans as $pimpinan)
                    <option @if($model->pimpinan_id == $pimpinan->id) selected @endif {{ old('pimpinan_id') ? 'selected' : '' }} value="{{ $pimpinan->id }}">{{ $pimpinan->nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('pimpinan_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('pimpinan_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="sasaran_strategis" class="col-sm-2 control-label">Sasaran Strategis</label>
                <div class="col-sm-8">
                    <input id="sasaran_strategis" type="text" class="form-control{{ $errors->has('sasaran_strategis') ? ' is-invalid' : '' }}" name="sasaran_strategis" value="{{ $model->sasaran_strategis }}">

                    @if ($errors->has('sasaran_strategis'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sasaran_strategis') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label for="satuan_id" class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-8">
                    <select id="satuan_id" class="form-control{{ $errors->has('satuan_id') ? ' is-invalid' : '' }} select2" name="satuan_id">
                    <option value="">--Pilih Satuan--</option>
                    @foreach($satuans as $satuan)
                    <option @if($model->satuan_id == $satuan->id) selected @endif {{ old('satuan_id') ? 'selected' : '' }} value="{{ $satuan->id }}">{{ $satuan->satuan_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('satuan_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('satuan_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>


            <div class="form-group">
                <label for="target" class="col-sm-2 control-label">Target</label>
                <div class="col-sm-8">
                <input id="target" type="text" class="form-control{{ $errors->has('target') ? ' is-invalid' : '' }}" name="target" value="{{ $model->target }}">

                    @if ($errors->has('target'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('target') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

                
            <div class="form-group">
                <label for="tahun" class="col-sm-2 control-label">Tahun</label>
                <div class="col-sm-8">
                    <select id="tahun" class="form-control{{ $errors->has('tahun') ? ' is-invalid' : '' }} select2" name="tahun">
                        <option value="">--pilih Tahun--</option>
                        <option @if($model->tahun == '2017') selected @endif value="2017">2017</option>
                        <option @if($model->tahun == '2018') selected @endif value="2018">2018</option>
                        <option @if($model->tahun == '2019') selected @endif value="2019">2019</option>
                        <option @if($model->tahun == '2020') selected @endif value="2020">2020</option>
                        <option @if($model->tahun == '2021') selected @endif value="2021">2021</option>
                    </select>

                    @if ($errors->has('tahun'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('tahun') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <br>
            <div class="row" align="right">
                <div class="col-sm-8 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    <a href="{{route('iki.index')}}" class="btn-default btn"> Kembali</a>
                    
                </div>
            </div>
        </form>
        <br>
    </div>           
             
</div>
@endsection
