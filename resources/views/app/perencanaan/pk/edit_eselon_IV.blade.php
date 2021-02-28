@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #007bff; ">Edit Perjanjian Kinera Eselon 4</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/perjanjian-kinerja/update-eselon-IV', $model->id) }}" class="form-horizontal" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            
            @if(Auth::user()->level == 1)

            <div class="form-group">
                <label for="organisasi_no" class="col-sm-2 control-label">Nama Dinas</label>
                <div class="col-sm-8">
                    <select id="organisasi_no" class="form-control{{ $errors->has('organisasi_no') ? ' is-invalid' : '' }} select2" name="organisasi_no">
                    <option value="">--Pilih Dinas--</option>
                    @foreach($orgs as $data)
                    <option @if($data->organisasi_no === $model->organisasi_no) selected @endif org_no="{{ $data->organisasi_no }}" value="{{ $data->id }}">{{ $data->organisasi_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('organisasi_no'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('organisasi_no') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>


            <div class="form-group">
                <label for="indikator_program_id" class="col-sm-2 control-label">Indikator Sasaran</label>
                <div class="col-sm-8">
                    <select id="indikator_program_id" class="form-control{{ $errors->has('indikator_program_id') ? ' is-invalid' : '' }} select2" name="indikator_program_id">
                    </select>

                    @if ($errors->has('indikator_program_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_program_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            @elseif(Auth::user()->level == 2)

                <div class="form-group">
                <label for="indikator_kegiatan_id" class="col-sm-2 control-label">Indikator Kegiatan</label>
                <div class="col-sm-8">
                    <select id="indikator_kegiatan_id" class="select2 form-control{{ $errors->has('indikator_kegiatan_id') ? ' is-invalid' : '' }} select2" name="indikator_kegiatan_id">
                    <option value="">--Pilih Indikator Kegiatan--</option>
                    @foreach($indikator_kegiatan as $ik)
                    <option @if($ik->id === $model->indikator_kegiatan_id) selected @endif value="{{ $ik->id }}">{{ $ik->indikator_kegiatan }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('indikator_kegiatan_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_kegiatan_id') }}</strong>
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
                    <option @if($data->jabatan_id === $model->jabatan_id) selected @endif value="{{ $data->jabatan_id }}">{{ $data->jabatan_nama }}</option>
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
                   <option @if($model->tahun == '2018') selected @endif value="2018">2018</option>
                    <option @if($model->tahun == '2019') selected @endif value="2019">2019</option>
                    <option @if($model->tahun == '2020') selected @endif value="2020">2020</option>
                    <option @if($model->tahun == '2021') selected @endif value="2021">2021</option>
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
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('perjanjian-kinerja.index') }}" class="btn-default btn">Batal</a>
                        
                    </div>
                </div>
        </form>
    </div>
             
</div>
@stop


