@extends('layouts.template')

@section('content')

<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 style="color: #0086a5; ">Edit Indikator Tujuan</h3>
            </div>

<br>
    <div class="tab-pane active" id="horizontal-form">
                            <form action="{{ url('perencanaan/renstra-tujuan-indikator/updateIndikatorRenstra', $model->id) }}" class="form-horizontal" method="POST">
                               {{ csrf_field() }}

                               <input type="hidden" name="_method" value="PUT">
                                
                                 {{-- @if(Auth::user()->level == 1)

                                <div class="form-group">
                                    <label for="organisasi_no" class="col-sm-2 control-label">{{ __('Nama OPD') }}</label>
                                    <div class="col-sm-8">
                                        <select name="organisasi_no" id="organisasi_no" class="form-control select2">
                                            <option value="">Pilih OPD</option>
                                            
                                            @foreach($opds as $opd)
                                            <option @if($opd->organisasi_no == $model->organisasi_no) selected @endif class="responsive" value="{{$opd->organisasi_no}}">{{$opd->organisasi_nama}}</option>
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
                                    <label for="tujuan_nomor" class="col-sm-2 control-label">{{ __('Tujuan') }}</label>
                                    <div class="col-sm-8">
                                        <select name="tujuan_nomor" id="tujuan_nomor" class="form-control select2">
                                        </select>
                                        @if ($errors->has('tujuan_nomor'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('tujuan_nomor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @elseif(Auth::user()->level != 1)


                                <div class="form-group">
                                    <label for="tujuan_nomor" class="col-sm-2 control-label">{{ __('Tujuan') }}</label>
                                    <div class="col-sm-8">
                                        <select name="tujuan_nomor" id="tujuan_nomor" class="form-control select2">
                                            <option value="">Pilih Tujuan</option>
                                            
                                            @foreach($tujuans as $tujuan)
                                            <option @if($tujuan->tujuan_nomor == $model->tujuan_nomor) selected @endif class="responsive"   value="{{$tujuan->tujuan_nomor}}">{{$tujuan->tujuan_nama}}</option>
                                            @endforeach
                                            
                                        </select>
                                        @if ($errors->has('tujuan_nomor'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('tujuan_nomor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @endif --}}

                                <div class="form-group">
                                    <label for="indikator_tujuan_nomor" class="col-sm-2 control-label">{{ __('Nomor Indikator Tujuan') }}</label>
                                    <div class="col-sm-8">
                                        <input id="indikator_tujuan_nomor" type="text" class="form-control {{ $errors->has('indikator_tujuan_nomor') ? ' is-invalid' : '' }}" placeholder="Nomor Urut Tujuan" name="indikator_tujuan_nomor" value="{{ $model->indikator_tujuan_nomor }}"  readonly>
                                        @if ($errors->has('indikator_tujuan_nomor'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('indikator_tujuan_nomor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="indikator_tujuan_nama" class="col-sm-2 control-label">{{ __('Indikator Tujuan') }}</label>
                                    <div class="col-sm-8">
                                        <input id="indikator_tujuan_nama" type="text" class="form-control {{ $errors->has('indikator_tujuan_nama') ? ' is-invalid' : '' }}" placeholder="Nama Tujuan" name="indikator_tujuan_nama" value="{{ $model->indikator_tujuan_nama }}" readonly>

                                        @if ($errors->has('indikator_tujuan_nama'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('indikator_tujuan_nama') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="satuan_id" class="col-sm-2 control-label">{{ __('Satuan') }}</label>
                                    <div class="col-sm-8">
                                        <select name="satuan_id" id="satuan_id" class="form-control select2">
                                            <option value="">Pilih Satuan</option>
                                            
                                            @foreach($satuans as $satuan)
                                            <option @if($satuan->id == $model->satuan_id) selected @endif class="responsive" value="{{$satuan->id}}">{{$satuan->satuan_nama}}</option>
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
                                    <label for="kondisi_akhir" class="col-sm-2 control-label">{{ __('Kondisi Akhir') }}</label>
                                    <div class="col-sm-8">
                                    <textarea id="kondisi_akhir" class="form-control {{ $errors->has('kondisi_akhir') ? ' is-invalid' : '' }}" placeholder="Kondisi Akhir" name="kondisi_akhir" value="{{ old('kondisi_akhir') }}">{{ $model->kondisi_akhir }}</textarea>

                                        @if ($errors->has('kondisi_akhir'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('kondisi_akhir') }}</strong>
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

    $('#organisasi_no').on('change', function(){

        let org_no = $('#organisasi_no option:selected').val();

        $.ajax({
            url: "{{ url('perencanaan/renstra-tujuan-indikator/ajax') }}"+'/'+org_no,
            dataType: 'json',
            success: function(res){
            console.log(res);
            var option = '<option value="0">--Pilih Tujuan--</option>';
                $.each(res, function(i, item){
                option += '<option value="'+item.tujuan_nomor+'">'+item.tujuan_nama+'</option>';
                });
            $('#tujuan_nomor').html(option);
            }
        });
    });


});
</script>
@endpush


