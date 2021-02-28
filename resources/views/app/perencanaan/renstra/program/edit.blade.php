@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Edit data Kegiatan Renstra</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/renstra-program/update',$model->renstra_id) }}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
            
            <input type="hidden" name="_method" value="PUT">


                <div class="form-group">
                <label for="indikator_sasaran_id" class="col-sm-2 control-label">Indikator Sasaran</label>
                <div class="col-sm-8">
                    <select id="indikator_sasaran_id" class="select2 form-control{{ $errors->has('indikator_sasaran_id') ? ' is-invalid' : '' }} select2" name="indikator_sasaran_id">
                    <option value="">--Pilih Tujuan--</option>
                    @foreach($indikator_sasarans as $is)
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


            <div class="form-group">
                <label for="program_no" class="col-sm-2 control-label">{{ __('Program') }}</label>
                <div class="col-sm-8">
                    <select id="program_no" class="form-control {{ $errors->has('program_no') ? ' is-invalid' : '' }} select2" name="program_no">
                    <option value="">--Pilih Program--</option>
                    @foreach($programs as $program)
                    <option @if($program->program_no == $model->program_no) selected @endif value="{{ $program->program_no }}">{{ $program->program_nama }}</option>
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
                    <option value="">--Pilih Kegiatan--</option>
                    @foreach($kegiatans as $kegiatan)
                    <option @if($kegiatan->kegiatan_no == $model->kegiatan_no) selected @endif value="{{ $kegiatan->id }}">{{ $kegiatan->kegiatan_nama }}</option>
                    @endforeach
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
                    <textarea id="indikator_kegiatan" class="form-control {{ $errors->has('indikator_kegiatan') ? ' is-invalid' : '' }}" name="indikator_kegiatan" placeholder="Indikator Kegiatan..">{{$model->indikator_kegiatan}}</textarea>
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
                    <option @if($satuan->id == $model->satuan_id) selected @endif value="{{ $satuan->id }}">{{ $satuan->satuan_nama }}</option>
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
                    <input id="perencanaan_awal" type="text" class="form-control {{ $errors->has('perencanaan_awal') ? ' is-invalid' : '' }}" placeholder="Capaian Awal.." name="perencanaan_awal" value="{{ $model->perencanaan_awal }}">

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

            {{-- <div class="form-group">
                <div class="col-sm-8">
            <table align="center">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Target</th>
                        <th>Pagu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2017</td>
                        <td><input type="text" name="target2017" id="target2017" class="form-control"></td>
                        <td><input type="text" name="pagu2017" id="pagu2017" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>2018</td>
                        <td><input type="text" name="target2018" id="target2018" class="form-control"></td>
                        <td><input type="text" name="pagu2018" id="pagu2018" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>2019</td>
                        <td><input type="text" name="target2019" id="target2019" class="form-control"></td>
                        <td><input type="text" name="pagu2019" id="pagu2019" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>2020</td>
                        <td><input type="text" name="target2020" id="target2020" class="form-control"></td>
                        <td><input type="text" name="pagu2020" id="pagu2020" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>2021</td>
                        <td><input type="text" name="target2021" id="target2021" class="form-control"></td>
                        <td><input type="text" name="pagu2021" id="pagu2021" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Kondisi Akhir</td>
                        <td><input type="text" name="terget_kondisi_akhir" id="terget_kondisi_akhir" class="form-control"></td>
                        <td><input type="text" name="pagu_kondisi_akhir" id="pagu_kondisi_akhir" class="form-control"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div> --}}
            
            <br>
                <div class="row" align="right">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ url('perencanaan/rencana-strategis') }}" class="btn-default btn">Batal</a>
                        
                    </div>
                </div>
        </form>
    </div>
             
</div>
@stop

@push('scripts')
<script>
$(document).ready(function(){

function uang()
{
    for($u=2017;$u<2022;$u++){
        $('#pagu'+$u).maskNumber({
          integer: true,
        });
    }
}

uang();
    
$('#program_no').on('change', function(){

    let program_no = $(this).val();

    $.ajax({
        url: "{{ url('perencanaan/renstra-program/ajaxProgram') }}"+'/'+program_no,
        dataType: 'json',
        success: function(res){
        console.log(res);
        var option = '<option value="0">--Pilih Kegiatan--</option>';
            $.each(res, function(i, item){
            option += '<option value="'+item.id+'">'+item.kegiatan_nama+'</option>';
            });
        $('#kegiatan_no').html(option);
        }
    });
});



});
</script>
@endpush


