@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Edit Sasaran Renstra</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
        <form action="{{ route('renstra-sasaran.update',$model->sasaran_id) }}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
            
            <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                <label for="tujuan_nomor" class="col-sm-2 control-label">Tujuan</label>
                <div class="col-sm-8">
                    <select id="tujuan_nomor" class="select2 form-control{{ $errors->has('tujuan_nomor') ? ' is-invalid' : '' }}" name="tujuan_nomor">
                    <option value="">--Pilih Tujuan--</option>
                    @foreach($tujuans as $tujuan)
                    <option @if($tujuan->tujuan_nomor == $model->tujuan_nomor) selected @endif value="{{ $tujuan->tujuan_nomor }}">{{ $tujuan->tujuan_nama }}</option>
                    @endforeach
                    </select>

                    @if ($errors->has('tujuan_nomor'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('tujuan_nomor') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>


            <div class="form-group">
                <label for="sasaran_nomor" class="col-sm-2 control-label">{{ __('Nomor Sasaran') }}</label>
                <div class="col-sm-8">
                    <input id="sasaran_nomor" type="text" class="form-control {{ $errors->has('sasaran_nomor') ? ' is-invalid' : '' }}" placeholder="Nomor Urut Sasaran" name="sasaran_nomor" value="{{ $model->sasaran_nomor }}">
                    @if ($errors->has('sasaran_nomor'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('sasaran_nomor') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
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


