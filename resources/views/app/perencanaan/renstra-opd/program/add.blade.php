@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #007bff; ">Tambah Program dan Kegiatan Renstra</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ route('renstra-program.store') }}" class="form-horizontal" method="POST">
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


                <div class="form-group">
                <label for="indikator_sasaran_id_user" class="col-sm-2 control-label">Indikator Sasaran</label>
                <div class="col-sm-8">
                    <select id="indikator_sasaran_id_user" class="select2 form-control{{ $errors->has('indikator_sasaran_id_user') ? ' is-invalid' : '' }} select2" name="indikator_sasaran_id_user">
                    <option value="">--Pilih Indikator Sasaran--</option>
                    @foreach($indikator_sasarans as $is)
                    <option {{ old('indikator_sasaran_id_user') ? 'selected' : '' }} value="{{ $is->id }}">{{ $is->indikator_sasaran_nama }}</option>
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
                <label for="program_no" class="col-sm-2 control-label">{{ __('Program') }}</label>
                <div class="col-sm-8">
                    <select id="program_no" class="form-control {{ $errors->has('program_no') ? ' is-invalid' : '' }} select2" name="program_no">
                    <option value="">--Pilih Program--</option>
                    @foreach($programs as $program)
                    <option {{ old('program_no') ? 'selected' : '' }} value="{{ $program->program_no }}">{{ $program->program_nama }}</option>
                    @endforeach
                    </select>
                    @if ($errors->has('program_no'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('program_no') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="kegiatan_no" class="col-sm-2 control-label">{{ __('Kegiatan') }}</label>
                <div class="col-sm-8">
                    <select id="kegiatan_no" class="form-control {{ $errors->has('kegiatan_no') ? ' is-invalid' : '' }} select2" name="kegiatan_no">
                    {{-- <option value="">--Pilih Kegiatan--</option>
                    @foreach($kegiatans as $kegiatan)
                    <option {{ old('kegiatan') ? 'selected' : '' }} value="{{ $kegiatan->id }}">{{ $kegiatan->kegitan_nama }}</option>
                    @endforeach --}}
                    </select>
                    @if ($errors->has('kegiatan_no'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('kegiatan_no') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="indikator_kegiatan" class="col-sm-2 control-label">{{ __('Indikator Kegiatan') }}</label>
                <div class="col-sm-8">
                    <textarea id="indikator_kegiatan" class="form-control {{ $errors->has('indikator_kegiatan') ? ' is-invalid' : '' }}" name="indikator_kegiatan" placeholder="Indikator Kegiatan.."></textarea>
                    @if ($errors->has('indikator_kegiatan'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_kegiatan') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="satuan_id" class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-8">
                    <select id="satuan_id" class="select2 form-control{{ $errors->has('satuan_id') ? ' is-invalid' : '' }} select2" name="satuan_id">
                    <option value="">--Pilih Satuan--</option>
                    @foreach($satuans as $satuan)
                    <option {{ old('satuan_id') ? 'selected' : '' }} value="{{ $satuan->id }}">{{ $satuan->satuan_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('satuan_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('satuan_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="perencanaan_awal" class="col-sm-2 control-label">{{ __('Data Capaian Awal') }}</label>
                <div class="col-sm-8">
                    <input id="perencanaan_awal" type="text" class="form-control {{ $errors->has('perencanaan_awal') ? ' is-invalid' : '' }}" placeholder="Capaian Awal.." name="perencanaan_awal" value="{{ old('perencanaan_awal') }}">

                    @if ($errors->has('perencanaan_awal'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('perencanaan_awal') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="target" class="col-sm-2 control-label">{{ __('Target') }}</label>

                <div class="col-xs-8">
                <table>
                    <tr>
                        @for($i=2017;$i<2022;$i++)
                            <td>
                                <input id="target{{$i}}" type="text" class="form-control {{ $errors->has('target'.$i) ? ' is-invalid' : '' }}" placeholder="Target {{$i}}" name="target{{$i}}" value="{{ old('target'.$i) }}">

                                @if ($errors->has('target'.$i))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target'.$i) }}</strong>
                                    </span>
                                @endif
                            </td>
                        @endfor

                            <td>
                                <input id="target_akhir" type="text" class="form-control {{ $errors->has('target_akhir') ? ' is-invalid' : '' }}" placeholder="Target_akhir" name="target_akhir" value="{{ old('target_akhir') }}">

                                @if ($errors->has('target_akhir'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target_akhir') }}</strong>
                                    </span>
                                @endif
                            </td>
                    </tr>
                </table>
                </div>

            </div>

            <div class="form-group">
                <label for="pagu" class="col-sm-2 control-label">{{ __('Pagu') }}</label>

                <div class="col-xs-8">
                <table>
                    <tr>
                        @for($i=2017;$i<2022;$i++)
                            <td>
                                <input id="pagu{{$i}}" type="text" class="form-control {{ $errors->has('pagu'.$i) ? ' is-invalid' : '' }}" placeholder="pagu {{$i}}" name="pagu{{$i}}" value="{{ old('pagu'.$i) }}">

                                @if ($errors->has('pagu'.$i))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu'.$i) }}</strong>
                                    </span>
                                @endif
                            </td>
                        @endfor

                            <td>
                                <input id="pagu_akhir" type="text" class="form-control {{ $errors->has('pagu_akhir') ? ' is-invalid' : '' }}" placeholder="pagu_akhir" name="pagu_akhir" value="{{ old('pagu_akhir') }}">

                                @if ($errors->has('pagu_akhir'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu_akhir') }}</strong>
                                    </span>
                                @endif
                            </td>
                    </tr>
                </table>
                </div>

            </div>

            
            <br>
                <div class="row" align="right">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                        <a href="{{ route('renstra-program.index') }}" class="btn-default btn">Batal</a>
                        
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

$('#program_no').on('change', function(){

    let program_no = $(this).val();

    $.ajax({
        url: "{{ url('perencanaan/renstra-program/ajaxProgram') }}"+'/'+program_no,
        dataType: 'json',
        success: function(res){
        console.log(res);
        var option = '<option value="0">--Pilih Kegiatan--</option>';
            $.each(res, function(i, item){
            option += '<option value="'+item.kegiatan_no+'">'+item.kegiatan_nama+'</option>';
            });
        $('#kegiatan_no').html(option);
        }
    });
});

function uang()
{
    for($u=2017;$u<2022;$u++){
        $('#pagu'+$u).maskNumber({
          integer: true,
        });
    }
}

uang();
    




});
</script>
@endpush


