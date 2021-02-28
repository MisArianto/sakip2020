@extends('layouts.template')

@section('content')


<div class="card card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h4>Tambah Pegawai</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        
                       <form action="{{ route('pegawai.store') }}" class="form-horizontal" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="nama" class="col-sm-2 control-label">{{ __('Nama') }}</label>
                                    <div class="col-sm-8">
                                        <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" required autofocus>

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
                                        <input id="nip" type="text" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" value="{{ old('nip') }}" required placeholder="Contoh : 19800330 200012 2 001">

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
                                            <option value="IV.d">IV.d</option>
                                            <option value="IV.c">IV.c</option>
                                            <option value="IV.b">IV.b</option>
                                            <option value="IV.a">IV.a</option>
                                            <option value="III.d">III.d</option>
                                            <option value="III.c">III.c</option>
                                            <option value="III.b">III.b</option>
                                            <option value="III.a">III.a</option>
                                            <option value="II.d">II.d</option>
                                            <option value="II.c">II.c</option>
                                            <option value="II.b">II.b</option>
                                            <option value="II.a">II.a</option>
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
                                            <option value="Sekretaris Daerah">Sekretaris Daerah</option>
                                            <option value="Kepala">Kepala</option>
                                            <option value="Sekretaris DPRD">Sekretaris DPRD</option>
                                            <option value="Inspektur">Inspektur</option>
                                            <option value="Camat">Camat</option>
                                            <option value="Sekretaris">Sekretaris</option>
                                            <option value="Kepala Bagian">Kepala Bagian</option>
                                            <option value="Sekretaris Camat">Sekretaris Camat</option>
                                            <option value="Kepala Bidang">Kepala Bidang</option>
                                            <option value="Kepala Sub Bidang">Kepala Sub Bidang</option>
                                            <option value="Kepala Seksi">Kepala Seksi</option>
                                            <option value="Kepala Sub Bagian">Kepala Sub Bagian</option>
                                            <option value="Staff">Staff</option>
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
                                        <input id="uraian" type="text" class="form-control{{ $errors->has('uraian') ? ' is-invalid' : '' }}" name="uraian" placeholder="Contoh : Pemasaran">

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
                                @endif
                                <br>
                                    <div class="row" align="right">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                                            <a href="#" onclick="history.back();"><button class="btn-default btn">Batal</button></a>
                                            
                                        </div>
                                    </div>
                            </form>
                         </div>
                </div>
                        


                        </div>



                     
             
</div>
@endsection
