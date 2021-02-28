@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Edit Target Indikator Sasaran RKT</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/renstra-indikator-sasaran/updateIndikatorSasaran', $model->id) }}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
            
            <input type="hidden" name="_method" value="PUT">


                <div class="form-group">
                <label for="sasaran_nama" class="col-sm-2 control-label">Sasaran</label>
                <div class="col-sm-8">
                    <select id="sasaran_nama" class="select2 form-control{{ $errors->has('sasaran_nama') ? ' is-invalid' : '' }} select2" name="sasaran_nama" readonly>
                    <option value="">--Pilih Sasaran--</option>
                    @foreach($sasarans as $sasaran)
                    <option @if($sasaran->sasaran_id == $model->sasaran_id) selected @endif value="{{ $sasaran->sasaran_id }}">{{ $sasaran->sasaran_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('sasaran_nama'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('sasaran_nama') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="indikator_sasaran_nomor" class="col-sm-2 control-label">{{ __('Nomor Indikator Sasaran') }}</label>
                <div class="col-sm-8">
                    <input id="indikator_sasaran_nomor" type="text" class="form-control {{ $errors->has('indikator_sasaran_nomor') ? ' is-invalid' : '' }}" placeholder="Nomor Urut Sasaran" name="indikator_sasaran_nomor" value="{{ $model->indikator_sasaran_nomor }}" readonly>
                    @if ($errors->has('indikator_sasaran_nomor'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_sasaran_nomor') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="indikator_sasaran_nama" class="col-sm-2 control-label">{{ __('Indiaktor Sasaran') }}</label>
                <div class="col-sm-8">
                    <input id="indikator_sasaran_nama" type="text" class="form-control {{ $errors->has('indikator_sasaran_nama') ? ' is-invalid' : '' }}" placeholder="Nama Sasaran" name="indikator_sasaran_nama" value="{{ $model->indikator_sasaran_nama) }}">

                    @if ($errors->has('indikator_sasaran_nama'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('indikator_sasaran_nama') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="satuan" class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-8">
                    <select id="satuan" class="select2 form-control{{ $errors->has('satuan') ? ' is-invalid' : '' }}" name="satuan">
                    <option value="">--Pilih Satuan--</option>
                    @foreach($satuans as $satuan)
                    <option @if($satuan->id == $model->satuan_id) selected @endif value="{{ $satuan->id }}">{{ $satuan->satuan_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('satuan'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('satuan') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            <div class="form-group">
                <label for="perencanaan_awal" class="col-sm-2 control-label">{{ __('Data Capaian Awal') }}</label>
                <div class="col-sm-8">
                    <input id="perencanaan_awal" type="text" class="form-control {{ $errors->has('perencanaan_awal') ? ' is-invalid' : '' }}" placeholder="Data Capaian Awal.." name="perencanaan_awal" value="{{ $model->perencanaan_awal }}">

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
                        <a href="{{ route('renstra-sasaran.index') }}" class="btn-default btn">Batal</a>
                        
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


