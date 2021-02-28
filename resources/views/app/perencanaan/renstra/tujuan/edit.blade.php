@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Tambah Tujuan Renstra</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
                            <form action="{{ route('renstra-tujuan.update') }}" class="form-horizontal" method="POST">
                               {{ csrf_field() }}
                                
                                <div class="form-group">
                                    <label for="opd" class="col-sm-2 control-label">{{ __('Nama OPD') }}</label>
                                    <div class="col-sm-8">
                                        <select name="opd" id="opd" class="form-control select2">
                                            <option value="">Pilih OPD</option>
                                            
                                            @foreach($opd as $data)
                                            <option class="responsive"   value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                                            @endforeach
                                            
                                        </select>
                                        @if ($errors->has('opd'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('opd') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="misi_nomor" class="col-sm-2 control-label">{{ __('Misi') }}</label>
                                    <div class="col-sm-8">
                                        <select name="misi_nomor" id="misi_nomor" class="form-control select2">
                                            <option value="">Pilih Misi</option>
                                            
                                            @foreach($misi as $data2)
                                            <option class="responsive"   value="{{$data2->nomor}}">{{$data2->nama}}</option>
                                            @endforeach
                                            
                                        </select>
                                        @if ($errors->has('misi_nomor'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('misi_nomor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tujuan_nomor" class="col-sm-2 control-label">{{ __('Nomor Tujuan') }}</label>
                                    <div class="col-sm-8">
                                        <input id="tujuan_nomor" type="text" class="form-control {{ $errors->has('tujuan_nomor') ? ' is-invalid' : '' }}" placeholder="Nomor Urut Tujuan" name="tujuan_nomor" value="{{ old('tujuan_nomor') }}" required autofocus>
                                        @if ($errors->has('tujuan_nomor'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tujuan_nomor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tujuan_nama" class="col-sm-2 control-label">{{ __('Tujuan') }}</label>
                                    <div class="col-sm-8">
                                        <input id="tujuan_nama" type="text" class="form-control {{ $errors->has('tujuan_nama') ? ' is-invalid' : '' }}" placeholder="Nama Tujuan" name="tujuan_nama" value="{{ old('tujuan_nama') }}" required autofocus>

                                        @if ($errors->has('tujuan_nama'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tujuan_nama') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                </div>
                                
                                <br>
                                    <div class="row" align="right">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                                            <a href="{{ route('renstra-tujuan.index') }}" class="btn-default btn">Batal</a>
                                            
                                        </div>
                                    </div>
                            </form>
                        </div>

                     
             
</div>
@stop

@push('scripts')
<script>
    $(document).ready(function() {
    $('#is_id').select2();
    $('#program_id').select2();
    $('#satuan_id').select2();
});
</script>
@endpush


