@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #007bff; ">Tambah PK</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/perjanjian-kinerja/store-eselon-III') }}" class="form-horizontal" method="POST">
            @csrf
            
            @if(Auth::user()->level == 1)

            <div class="form-group">
                <label for="organisasi_no" class="col-sm-2 control-label">Nama Dinas</label>
                <div class="col-sm-8">
                    <select id="organisasi_no" class="form-control{{ $errors->has('organisasi_no') ? ' is-invalid' : '' }} select2" name="organisasi_no">
                    <option value="">--Pilih Dinas--</option>
                    @foreach($orgs as $data)
                    <option {{ old('organisasi_no') ? 'selected' : '' }} org_no="{{ $data->organisasi_no }}" value="{{ $data->id }}">{{ $data->organisasi_nama }}</option>
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
                <label for="indikator_program_id" class="col-sm-2 control-label">Indikator Program</label>
                <div class="col-sm-8">
                    <select id="indikator_program_id" class="select2 form-control{{ $errors->has('indikator_program_id') ? ' is-invalid' : '' }} select2" name="indikator_program_id">
                    <option value="">--Pilih Indikator Program--</option>
                    @foreach($indikator_program as $is)
                    <option {{ old('indikator_program_id') ? 'selected' : '' }} value="{{ $is->id }}">{{ $is->indikator_program_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('indikator_program_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_program_id') }}</strong>
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
                    <option {{ old('jabatan_id') ? 'selected' : '' }} value="{{ $data->jabatan_id }}">{{ $data->jabatan_nama }}</option>
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
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
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
                                <input id="target" type="text" class="form-control {{ $errors->has('target') ? ' is-invalid' : '' }}" placeholder="Target" name="target">

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
                                <input id="pagu" type="text" class="form-control {{ $errors->has('pagu') ? ' is-invalid' : '' }}" placeholder="Pagu" name="pagu">

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
             
</div>
@stop

@push('scripts')
<script>
$(document).ready(function(){


$('#organisasi_no').on('change', function(){

    let org_no = $('#organisasi_no option:selected').attr('org_no');

    $.ajax({
        url: "{{ url('perencanaan/perjanjian-kinerja/eselon-III/ajaxIndikatorProgram') }}"+'/'+org_no,
        dataType: 'json',
        success: function(res){
        console.log(res);
        var option = '<option value="0">--Pilih Indikator Program--</option>';
            $.each(res, function(i, item){
            option += '<option value="'+item.id+'">'+item.indikator_program+'</option>';
            });
        $('#indikator_program_id').html(option);
        }
    });
});


});
</script>
@endpush


