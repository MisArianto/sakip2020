@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Edit data indikator sasaran</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/rencana-strategis/indikator-sasaran/update', $model->indikator_sasaran_id) }}" class="form-horizontal" method="POST">
            @csrf
            
            <input type="hidden" name="_method" value="PUT">


                @if(Auth::user()->level == 1)

            <div class="form-group">
                <label for="org" class="col-sm-2 control-label">Nama Dinas</label>
                <div class="col-sm-8">
                    <select id="org" class="form-control{{ $errors->has('org') ? ' is-invalid' : '' }} select2" name="org">
                    <option value="">--Pilih Dinas--</option>
                    @foreach($orgs as $data)
                    <option @if($data->organisasi_no == $model->organisasi_no) selected @endif org_no="{{ $data->organisasi_no }}" value="{{ $data->organisasi_no }}">{{ $data->organisasi_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('org'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('org') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>


            <div class="form-group">
                <label for="sasaran_id" class="col-sm-2 control-label">Sasaran</label>
                <div class="col-sm-8">
                    <select id="sasaran_id" class="form-control{{ $errors->has('sasaran_id') ? ' is-invalid' : '' }} select2" name="sasaran_id">
                    </select>

                    @if ($errors->has('sasaran_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('sasaran_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            @elseif(Auth::user()->level == 2)

             <input type="hidden" name="organisasi_no" value="{{ $model->organisasi_no }}">

                <div class="form-group">
                <label for="sasaran_id" class="col-sm-2 control-label">Sasaran</label>
                <div class="col-sm-8">
                    <select id="sasaran_id" class="select2 form-control{{ $errors->has('sasaran_id') ? ' is-invalid' : '' }} select2" name="sasaran_id">
                    <option value="">--Pilih Sasaran--</option>
                    @foreach($sasarans as $sasaran)
                    <option @if($sasaran->id == $model->sasaran_id) selected @endif value="{{ $sasaran->id }}">{{ $sasaran->sasaran_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('sasaran_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('sasaran_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            @endif

            <div class="form-group">
                <label for="indikator_sasaran" class="col-sm-2 control-label">Indiaktor Sasaran</label>
                <div class="col-sm-8">
                    <input id="indikator_sasaran" type="text" class="form-control" placeholder="Nama Sasaran" name="indikator_sasaran" value="{{ $model->indikator_sasaran }}">

                    @if ($errors->has('indikator_sasaran'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_sasaran') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="satuan_id" class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-8">
                    <select id="satuan_id" class="select2 form-control{{ $errors->has('satuan_id') ? ' is-invalid' : '' }}" name="satuan_id">
                    <option value="">--Pilih Satuan--</option>
                    @foreach($satuans as $satuan)
                    <option @if($satuan->satuan_id == $model->satuan_id) selected @endif value="{{ $satuan->id }}">{{ $satuan->satuan_nama }}</option>
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
                <label for="kondisi_awal" class="col-sm-2 control-label">{{ __('Data Capaian Awal') }}</label>
                <div class="col-sm-8">
                    <input id="kondisi_awal" type="text" class="form-control {{ $errors->has('kondisi_awal') ? ' is-invalid' : '' }}" placeholder="Data Capaian Awal.." name="kondisi_awal" value="{{ $model->kondisi_awal }}">

                    @if ($errors->has('kondisi_awal'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('kondisi_awal') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

           {{--  <div class="form-group">
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

            </div> --}}
            
            
            <br>
                <div class="row" align="right">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
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


$('#org').on('change', function(){

    let org_no = $('#org option:selected').attr('org_no');

    $.ajax({
        url: "{{ url('perencanaan/renstra-indikator-sasaran/ajaxIndikator') }}"+'/'+org_no,
        dataType: 'json',
        success: function(res){
        console.log(res);
        var option = '<option value="0">--Pilih Sasaran--</option>';
            $.each(res, function(i, item){
            option += '<option value="'+item.sasaran_id+'">'+item.sasaran_nama+'</option>';
            });
        $('#sasaran_nama').html(option);
        }
    });
});


});
</script>
@endpush


