@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Edit Sasaran Renstra</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ url('perencanaan/rencana-strategis/sasaran/update',$model->id) }}" class="form-horizontal" method="POST">
            @csrf
            
            <input type="hidden" name="_method" value="PUT">

            @if(Auth::user()->level == 1)

            <div class="form-group">
                <label for="org" class="col-sm-2 control-label">Nama Dinas</label>
                <div class="col-sm-8">
                    <select id="org" class="form-control{{ $errors->has('org') ? ' is-invalid' : '' }} select2" name="organisasi_no">
                    <option value="">--Pilih OPD--</option>
                    @foreach($orgs as $data)
                    <option @if($data->organisasi_no == $model->organisasi_no) selected @endif org_no="{{ $data->organisasi_no }}" value="{{ $data->id }}">{{ $data->organisasi_nama }}</option>
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
                <label for="tujuan_id" class="col-sm-2 control-label">Tujuan</label>
                <div class="col-sm-8">
                    <select id="tujuan_id" class="form-control{{ $errors->has('tujuan_id') ? ' is-invalid' : '' }}" name="tujuan_id">
                    </select>

                    @if ($errors->has('tujuan_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('tujuan_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            @elseif(Auth::user()->level == 2)

            <input type="hidden" name="organisasi_no" value="{{ $model->organisasi_no }}">

                <div class="form-group">
                <label for="tujuan_id" class="col-sm-2 control-label">Tujuan</label>
                <div class="col-sm-8">
                    <select id="tujuan_id" class="select2 form-control{{ $errors->has('tujuan_id') ? ' is-invalid' : '' }}" name="tujuan_id">
                    <option value="">--Pilih Tujuan--</option>
                    @foreach($tujuans as $tujuan)
                    <option  @if($tujuan->id == $model->tujuan_id) selected @endif value="{{ $tujuan->id }}">{{ $tujuan->tujuan_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('tujuan_id'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('tujuan_id') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>

            @endif

            <div class="form-group">
                <label for="sasaran_nama" class="col-sm-2 control-label">{{ __('Sasaran') }}</label>
                <div class="col-sm-8">
                    <input id="sasaran_nama" type="text" class="form-control {{ $errors->has('sasaran_nama') ? ' is-invalid' : '' }}" placeholder="Nama Sasaran" name="sasaran_nama" value="{{ $model->sasaran_nama }}">

                    @if ($errors->has('sasaran_nama'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('sasaran_nama') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>
            
            
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


$('#org').on('change', function(){

    let org_no = $('#org option:selected').attr('org_no');

    $.ajax({
        url: "{{ url('perencanaan/renstra-sasaran/ajax') }}"+'/'+org_no,
        dataType: 'json',
        success: function(res){
        console.log(res);
        var option = '<option value="0">--Pilih Tujuan--</option>';
            $.each(res, function(i, item){
            option += '<option value="'+item.id+'">'+item.tujuan_nama+'</option>';
            });
        $('#tujuan_nomor').html(option);
        }
    });
});


});
</script>
@endpush


