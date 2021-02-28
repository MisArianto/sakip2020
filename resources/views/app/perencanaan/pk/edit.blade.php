@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h4>Edit Perjanjian Kinerja</h4>
            </div>
                <form action="{{ route('perjanjian-kinerja.update',$model->id) }}" class="form-horizontal" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                        
                        @if(Auth::user()->level ==  2)

                            <div class="form-group">
                            <label for="indikator_sasaran_id" class="col-sm-2 control-label">Indikator Sasaran</label>
                            <div class="col-sm-8">
                                <select id="indikator_sasaran_id" class="select2 form-control{{ $errors->has('indikator_sasaran_id') ? ' is-invalid' : '' }} select2" name="indikator_sasaran_id">
                                <option value="">--Pilih Indikator Sasaran--</option>
                                @foreach($indikator_sasaran as $is)
                                <option @if($is->id == $model->indikator_sasaran_id) selected @endif value="{{ $is->id }}">{{ $is->indikator_sasaran }}</option>
                                @endforeach
                                </select>

                                @if ($errors->has('indikator_sasaran_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('indikator_sasaran_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>

                        @endif

                        <div class="form-group">
                            <label for="jabatan_id" class="col-sm-2 control-label">Jabatan</label>
                            <div class="col-sm-8">
                                <select id="jabatan_id" class="form-control{{ $errors->has('jabatan_id') ? ' is-invalid' : '' }} select2" name="jabatan_id">
                                <option value="">--Pilih Jabantan--</option>
                                @foreach($jabatans as $data)
                                <option @if($data->jabatan_id == $model->jabatan_id) selected @endif value="{{ $data->jabatan_id }}">{{ $data->jabatan_nama }}</option>
                                @endforeach
                                </select>

                                @if ($errors->has('jabatan_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('jabatan_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="tahun" class="col-sm-2 control-label">{{ __('Tahun') }}</label>
                            <div class="col-sm-8">
                                <select id="tahun" class="form-control {{ $errors->has('tahun') ? ' is-invalid' : '' }} select2" name="tahun">
                                <option value="">--Pilih Tahun--</option>
                                <option @if('2018' == $model->tahun) selected @endif value="2018">2018</option>
                                <option @if('2019' == $model->tahun) selected @endif value="2019">2019</option>
                                <option @if('2020' == $model->tahun) selected @endif value="2020">2020</option>
                                <option @if('2021' == $model->tahun) selected @endif value="2021">2021</option>
                                </select>
                                @if ($errors->has('tahun'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('tahun') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="target" class="col-sm-2 control-label">{{ __('Target') }}</label>
                            <div class="col-sm-8">
                                <input id="target" type="text" class="form-control {{ $errors->has('target') ? ' is-invalid' : '' }}" placeholder="Target" name="target" value="{{ $model->target }}">

                                @if ($errors->has('target'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="pagu" class="col-sm-2 control-label">{{ __('Pagu') }}</label>
                            <div class="col-sm-8">
                                <input id="pagu" type="text" class="form-control {{ $errors->has('pagu') ? ' is-invalid' : '' }}" placeholder="Pagu" name="pagu" value="{{ $model->pagu }}">

                                @if ($errors->has('pagu'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>


                        <br>
                            <div class="row" align="right">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                                    <a href="{{ route('perjanjian-kinerja.index') }}" class="btn-default btn">Batal</a>
                                    
                                </div>
                            </div>
                    </form>


                     
             
</div>
@endsection
