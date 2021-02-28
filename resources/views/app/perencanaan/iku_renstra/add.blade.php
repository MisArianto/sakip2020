@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h4>Tambah Indikator Kinerja Utama</h4>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ route('iku-renstra.store') }}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
            
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
                <label for="indikator_sasaran_id" class="col-sm-2 control-label">Indikator Sasaran</label>
                <div class="col-sm-8">
                    <select id="indikator_sasaran_id" class="form-control{{ $errors->has('indikator_sasaran_id') ? ' is-invalid' : '' }} select2" name="indikator_sasaran_id">
                    </select>

                    @if ($errors->has('indikator_sasaran_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_sasaran_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            @elseif(Auth::user()->level == 2)

                <input type="hidden" name="organisasi_no" value="{{ Auth::user()->organisasi_no }}">

                <div class="form-group">
                <label for="indikator_sasaran_id_user" class="col-sm-2 control-label">Indikator Sasaran</label>
                <div class="col-sm-8">
                    <select id="indikator_sasaran_id_user" class="select2 form-control{{ $errors->has('indikator_sasaran_id_user') ? ' is-invalid' : '' }} select2" name="indikator_sasaran_id_user">
                    <option value="">--Pilih Indikator Sasaran--</option>
                    @foreach($indikator_sasarans as $is)
                    <option {{ old('indikator_sasaran_id_user') ? 'selected' : '' }} value="{{ $is->id }}">{{ $is->indikator_sasaran }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('indikator_sasaran_id_user'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_sasaran_id_user') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            @endif

            <div class="form-group">
                <label for="tahun" class="col-sm-2 control-label">{{ __('Tahun') }}</label>
                <div class="col-sm-8">
                    <select id="tahun" class="form-control {{ $errors->has('tahun') ? ' is-invalid' : '' }} select2" name="tahun">
                    <option value="">--Pilih Tahun--</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    {{-- <option value="2020">2020</option> --}}
                    {{-- <option value="2021">2021</option> --}}
                    </select>
                    @if ($errors->has('tahun'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('tahun') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="alasan" class="col-sm-2 control-label">{{ __('Alasan') }}</label>
                <div class="col-sm-8">
                     <textarea id="alasan" class="form-control {{ $errors->has('alasan') ? ' is-invalid' : '' }}" name="alasan" placeholder="Alasan.."></textarea>
                    @if ($errors->has('alasan'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('alasan') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="formulasi" class="col-sm-2 control-label">{{ __('Formulasi') }}</label>
                <div class="col-sm-8">
                    <textarea id="formulasi" class="form-control {{ $errors->has('formulasi') ? ' is-invalid' : '' }}" name="formulasi" placeholder="Formulasi.."></textarea>
                    @if ($errors->has('formulasi'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('formulasi') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="sumber_data" class="col-sm-2 control-label">Sumber Data</label>
                <div class="col-sm-8">
                    <textarea id="sumber_data" class="form-control {{ $errors->has('sumber_data') ? ' is-invalid' : '' }}" name="sumber_data" placeholder="Sumber Data.."></textarea>
                    @if ($errors->has('sumber_data'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('sumber_data') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan" class="col-sm-2 control-label">{{ __('Keterangan') }}</label>
                <div class="col-sm-8">
                    <textarea id="keterangan" class="form-control {{ $errors->has('keterangan') ? ' is-invalid' : '' }}" name="keterangan" placeholder="Keterangan.."></textarea>

                    @if ($errors->has('keterangan'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('keterangan') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <br>
                <div class="row" align="right">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                        <a href="{{ url('perencanaan/iku-renstra') }}" class="btn-default btn">Batal</a>
                        
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
        url: "{{ url('perencanaan/renstra-program/ajaxIndikator') }}"+'/'+org_no,
        dataType: 'json',
        success: function(res){
        console.log(res);
        var option = '<option value="0">--Pilih Indikator Sasaran--</option>';
            $.each(res, function(i, item){
            option += '<option value="'+item.id+'">'+item.indikator_sasaran_nama+'</option>';
            });
        $('#indikator_sasaran_id').html(option);
        }
    });
});


});
</script>
@endpush


