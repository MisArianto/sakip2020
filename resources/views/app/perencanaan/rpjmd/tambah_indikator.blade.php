@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Tambah Indikator Program RPJMD</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
                            <form action="{{ route('rpjmd-program.store') }}" class="form-horizontal" method="POST">
                               {{ csrf_field() }}
                                

                                <div class="form-group">
                                    <label for="indikator_sasaran_id" class="col-sm-2 control-label">{{ __('Indikator Sasaran') }}</label>
                                    <div class="col-sm-8">
                                        <select name="indikator_sasaran_id" id="indikator_sasaran_id" class="form-control select2">
                                            <option value="">Pilih Indikator Sasaran</option>
                                            
                                            @foreach($indikator_sasaran as $data)
                                            <option class="responsive"   value="{{$data->indikator_sasaran_id}}">{{$data->indikator_sasaran}}</option>
                                            @endforeach
                                            
                                        </select>
                                        @if ($errors->has('indikator_sasaran_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('indikator_sasaran_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="program_no" class="col-sm-2 control-label">{{ __('Program') }}</label>
                                    <div class="col-sm-8">
                                        <select name="program_no" id="program_no" class="form-control select2">
                                            <option value="">Pilih Program</option>
                                            
                                            @foreach($program as $data2)
                                            <option class="responsive"   value="{{$data2->program_no}}">{{$data2->program_nama}}</option>
                                            @endforeach
                                            
                                        </select>
                                        @if ($errors->has('program_no'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('program_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="indikator_program" class="col-sm-2 control-label">{{ __('Indikator Program') }}</label>
                                    <div class="col-sm-8">
                                        <input id="indikator_program" type="text" class="form-control {{ $errors->has('indikator_program') ? ' is-invalid' : '' }}" name="indikator_program" value="{{ old('indikator_program') }}" required autofocus>

                                        @if ($errors->has('indikator_program'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('indikator_program') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    {{-- <div class="col-sm-2 jlkdfj1">
                                        <p class="help-block">Your help text!</p>
                                    </div> --}}
                                </div>
                                {{-- <div class="form-group">
                                    <label for="satuan_id" class="col-sm-2 control-label">{{ __('Satuan') }}</label>
                                    <div class="col-sm-8">
                                        <select name="satuan_id" id="satuan_id" class="form-control">
                                            <option value="">Pilih Satuan</option>
                                            
                                            @foreach($satuan as $data3)
                                            <option class="responsive"   value="{{$data3->satuan_id}}">{{$data3->satuan_nama}}</option>
                                            @endforeach
                                            
                                        </select>
                                        @if ($errors->has('satuan_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('satuan_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}
                                <br>
                                    <div class="row" align="right">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                                            <a href="{{ route('rpjmd-program.index') }}" class="btn-default btn">Batal</a>
                                            
                                        </div>
                                    </div>
                            </form>
                        </div>

                     
             
</div>
@stop

@push('scripts')
<script>
    $(document).ready(function() {
    $('#is_id').select2();
    $('#program_id').select2();
    $('#satuan_id').select2();
});
</script>
@endpush


