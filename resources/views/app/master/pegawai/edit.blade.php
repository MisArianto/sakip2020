@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
            <div class="box-header with-border">
              <h4>Edit Pegawai</h4>
            </div>
                            <form action="{{ route('pegawai.update',$pegawai->id) }}" class="form-horizontal" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="nama" class="col-sm-2 control-label">{{ __('Nama') }}</label>
                                    <div class="col-sm-8">
                                        <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ $pegawai->nama }}" required autofocus>

                                        @if ($errors->has('nama'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nama') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="nip" class="col-sm-2 control-label">{{ __('NIP') }}</label>
                                    <div class="col-sm-8">
                                        <input id="nip" type="text" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" value="{{ $pegawai->nip }}" required placeholder="Contoh : 19800330 200012 2 001">

                                        @if ($errors->has('nip'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nip') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label for="golongan" class="col-sm-2 control-label">{{ __('Golongan') }}</label>
                                    <div class="col-sm-8">
                                        <select name="golongan" id="golongan" class="form-control select2" required>
                                            <option value="">Pilih Golongan</option>
                                            <option @if($pegawai->golongan == 'IV.d') selected @endif value="IV.d">IV.d</option>
                                            <option @if($pegawai->golongan == 'IV.c') selected @endif value="IV.c">IV.c</option>
                                            <option @if($pegawai->golongan == 'IV.b') selected @endif value="IV.b">IV.b</option>
                                            <option @if($pegawai->golongan == 'IV.a') selected @endif value="IV.a">IV.a</option>
                                            <option @if($pegawai->golongan == 'III.d') selected @endif value="III.d">III.d</option>
                                            <option @if($pegawai->golongan == 'III.c') selected @endif value="III.c">III.c</option>
                                            <option @if($pegawai->golongan == 'III.b') selected @endif value="III.b">III.b</option>
                                            <option @if($pegawai->golongan == 'III.a') selected @endif value="III.a">III.a</option>
                                            <option @if($pegawai->golongan == 'II.d') selected @endif value="II.d">II.d</option>
                                            <option @if($pegawai->golongan == 'II.c') selected @endif value="II.c">II.c</option>
                                            <option @if($pegawai->golongan == 'II.b') selected @endif value="II.b">II.b</option>
                                            <option @if($pegawai->golongan == 'II.a') selected @endif value="II.a">II.a</option>
                                        </select>

                                        @if ($errors->has('golongan'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('golongan') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jabatan" class="col-sm-2 control-label">{{ __('Jabatan') }}</label>
                                    <div class="col-sm-8">
                                        <select name="jabatan" id="jabatan" class="form-control select2" required>
                                            <option value="">Pilih Jabatan</option>
                                            <option @if($pegawai->jabatan == 'Kepala') selected @endif value="Kepala">Kepala</option>
                                            <option @if($pegawai->jabatan == 'Inspektur') selected @endif value="Inspektur">Inspektur</option>
                                            <option @if($pegawai->jabatan == 'Camat') selected @endif value="Camat">Camat</option>
                                            <option @if($pegawai->jabatan == 'Sekretaris') selected @endif value="Sekretaris">Sekretaris</option>
                                            <option @if($pegawai->jabatan == 'Sekretaris Camat') selected @endif value="Sekretaris Camat">Sekretaris Camat</option>
                                            <option @if($pegawai->jabatan == 'Kepala Bidang') selected @endif value="Kepala Bidang">Kepala Bidang</option>
                                            <option @if($pegawai->jabatan == 'Kepala Sub Bidang') selected @endif value="Kepala Sub Bidang">Kepala Sub Bidang</option>
                                            <option @if($pegawai->jabatan == 'Kepala Seksi') selected @endif value="Kepala Seksi">Kepala Seksi</option>
                                            <option @if($pegawai->jabatan == 'Staff') selected @endif value="Staff">Staff</option>
                                        </select>
                                        @if ($errors->has('jabatan'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('jabatan') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="uraian" class="col-sm-2 control-label">{{ __('Uraian Jabatan') }}</label>
                                    <div class="col-sm-8">
                                        <input id="uraian" type="text" class="form-control{{ $errors->has('uraian') ? ' is-invalid' : '' }}" name="uraian" value="{{ $pegawai->uraian }}" placeholder="Contoh : Pemasaran">

                                        @if ($errors->has('uraian'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('uraian') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if(Auth::user()->level != 2)
                                <div class="form-group">
                                    <label for="opd" class="col-sm-2 control-label">{{ __('Nama OPD') }}</label>
                                    <div class="col-sm-8">
                                        <select name="opd" id="opd" class="form-control select2" required>
                                            <option value="">Pilih OPD</option>
                                            @foreach($opd as $data)
                                            <option @if($pegawai->organisasi_no == $data->organisasi_no) selected @endif class="responsive"   value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('opd'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('opd') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <br>
                                    <div class="row" align="right">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                                            <a href="{{ route('pegawai.index') }}" class="btn-default btn">Kembali</a>
                                            
                                        </div>
                                    </div>
                            </form>
                        </div>



                     
             
</div>
@endsection
