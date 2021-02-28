@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Tambah Indikator Sasaran</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/rencana-strategis-opd/tambah-indikator-sasaran/store') }}" class="form-horizontal" method="POST">
            @csrf
            
            @if(Auth::user()->level == 1)

            <div class="form-group">
                <label for="org" class="col-sm-2 control-label">Nama Dinas</label>
                <div class="col-sm-8">
                    <select id="org" class="form-control{{ $errors->has('org') ? ' is-invalid' : '' }} select2" name="org">
                    <option value="">--Pilih Dinas--</option>
                    @foreach($orgs as $data)
                    <option {{ old('org') ? 'selected' : '' }} org_no="{{ $data->organisasi_no }}" value="{{ $data->organisasi_no }}">{{ $data->organisasi_nama }}</option>
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

                <div class="form-group">
                <label for="sasaran_id" class="col-sm-2 control-label">Sasaran</label>
                <div class="col-sm-8">
                    <select id="sasaran_id" class="select2 form-control{{ $errors->has('sasaran_id') ? ' is-invalid' : '' }} select2" name="sasaran_id">
                    <option value="">--Pilih Sasaran--</option>
                    @foreach($sasarans as $sasaran)
                    <option {{ old('sasaran_id') ? 'selected' : '' }} value="{{ $sasaran->id }}">{{ $sasaran->sasaran_nama }}</option>
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
                <label for="indikator_sasaran" class="col-sm-2 control-label">{{ __('Indiaktor Sasaran') }}</label>
                <div class="col-sm-8">
                    <input id="indikator_sasaran" type="text" class="form-control {{ $errors->has('indikator_sasaran') ? ' is-invalid' : '' }}" placeholder="Nama Sasaran" name="indikator_sasaran" value="{{ old('indikator_sasaran') }}">

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
                    <select id="satuan_id" class="select2 form-control{{ $errors->has('satuan') ? ' is-invalid' : '' }} select2" name="satuan_id">
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
                <label for="kondisi_awal" class="col-sm-2 control-label">{{ __('Data Capaian Awal') }}</label>
                <div class="col-sm-8">
                    <input id="kondisi_awal" type="text" class="form-control {{ $errors->has('kondisi_awal') ? ' is-invalid' : '' }}" placeholder="Data Capaian Awal.." name="kondisi_awal" value="{{ old('kondisi_awal') }}">

                    @if ($errors->has('kondisi_awal'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('kondisi_awal') }}</strong>
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
                                <input id=" {{$i}}" type="text" class="form-control {{ $errors->has('pagu'.$i) ? ' is-invalid' : '' }}" placeholder="pagu {{$i}}" name="pagu{{$i}}" value="{{ old('pagu'.$i) }}">

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
                        <a href="{{ url('perencanaan/rencana-strategis-opd') }}" class="btn-default btn">Batal</a>
                        
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


