@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Edit data Indikator Program Renstra</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/renstra-program-indikator/update',$model->indikator_program_id) }}" class="form-horizontal" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
                <label for="indikator_program_nama" class="col-sm-2 control-label">{{ __('Indikator Kinerja Program') }}</label>
                <div class="col-sm-8">
                    <textarea id="indikator_program_nama" class="form-control {{ $errors->has('indikator_program_nama') ? ' is-invalid' : '' }}" name="indikator_program_nama" placeholder="Indikator Program.."></textarea>
                    @if ($errors->has('indikator_program_nama'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_program_nama') }}</strong>
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
                            <td>
                                <input id="target2017" type="text" class="form-control {{ $errors->has('target2017') ? ' is-invalid' : '' }}" placeholder="Target 2017" name="target2017" value="{{ $model->target_t1 }}">

                                @if ($errors->has('target2017'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target2017') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="target2018" type="text" class="form-control {{ $errors->has('target2018') ? ' is-invalid' : '' }}" placeholder="Target 2017" name="target2018" value="{{ $model->target_t2 }}">

                                @if ($errors->has('target2018'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target2018') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="target2019" type="text" class="form-control {{ $errors->has('target2019') ? ' is-invalid' : '' }}" placeholder="Target 2017" name="target2019" value="{{ $model->target_t3 }}">

                                @if ($errors->has('target2019'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target2019') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="target2020" type="text" class="form-control {{ $errors->has('target2020') ? ' is-invalid' : '' }}" placeholder="Target 2017" name="target2020" value="{{ $model->target_t4 }}">

                                @if ($errors->has('target2020'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target2020') }}</strong>
                                    </span>
                                @endif
                            </td>


                            <td>
                                <input id="target2021" type="text" class="form-control {{ $errors->has('target2021') ? ' is-invalid' : '' }}" placeholder="Target 2017" name="target2021" value="{{ $model->target_t5 }}">

                                @if ($errors->has('target2021'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('target2021') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="target_akhir" type="text" class="form-control {{ $errors->has('target_akhir') ? ' is-invalid' : '' }}" placeholder="Target_akhir" name="target_akhir" value="{{ $model->target_kondisi_akhir }}">

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
                            <td>
                                <input id="pagu2017" type="text" class="form-control {{ $errors->has('pagu2017') ? ' is-invalid' : '' }}" placeholder="Pagu 2017" name="pagu2017" value="{{ $model->pagu_t1 }}">

                                @if ($errors->has('pagu2017'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu2017') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="pagu2018" type="text" class="form-control {{ $errors->has('pagu2018') ? ' is-invalid' : '' }}" placeholder="Pagu 2017" name="pagu2018" value="{{ $model->pagu_t2 }}">

                                @if ($errors->has('pagu2018'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu2018') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="pagu2019" type="text" class="form-control {{ $errors->has('pagu2019') ? ' is-invalid' : '' }}" placeholder="Pagu 2017" name="pagu2019" value="{{ $model->pagu_t3 }}">

                                @if ($errors->has('pagu2019'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu2019') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="pagu2020" type="text" class="form-control {{ $errors->has('pagu2020') ? ' is-invalid' : '' }}" placeholder="Pagu 2017" name="pagu2020" value="{{ $model->pagu_t4 }}">

                                @if ($errors->has('pagu2020'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu2020') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="pagu2021" type="text" class="form-control {{ $errors->has('pagu2021') ? ' is-invalid' : '' }}" placeholder="Pagu 2017" name="pagu2021" value="{{ $model->pagu_t5 }}">

                                @if ($errors->has('pagu2021'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('pagu2021') }}</strong>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <input id="pagu_akhir" type="text" class="form-control {{ $errors->has('pagu_akhir') ? ' is-invalid' : '' }}" placeholder="pagu_akhir" name="pagu_akhir" value="{{ $model->pagu_kondisi_akhir }}">

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

    let org_id = $('#organisasi_no option:selected').attr('org_id');

    console.log(org_id);

    $.ajax({
        url: "{{ url('perencanaan/renstra-program-indikator/ajaxIndikator') }}"+'/'+org_id,
        dataType: 'json',
        success: function(res){
        console.log(res);
        var option = '<option value="0">--Pilih Indikator Sasaran--</option>';
            $.each(res, function(i, item){
            option += '<option value="'+item.program_no+'">'+item.program_nama+'</option>';
            });
        $('#program_no').html(option);
        }
    });
});

// $('#program_no').on('change', function(){

//     let program_no = $(this).val();

//     $.ajax({
//         url: "{{ url('perencanaan/renstra-program/ajaxProgram') }}"+'/'+program_no,
//         dataType: 'json',
//         success: function(res){
//         console.log(res);
//         var option = '<option value="0">--Pilih Kegiatan--</option>';
//             $.each(res, function(i, item){
//             option += '<option value="'+item.id+'">'+item.kegiatan_nama+'</option>';
//             });
//         $('#kegiatan_no').html(option);
//         }
//     });
// });


});
</script>
@endpush


