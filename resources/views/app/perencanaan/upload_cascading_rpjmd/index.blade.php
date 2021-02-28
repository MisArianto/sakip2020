@extends('layouts.template')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="box box-default">
            <div class="box-header">
                <h3>Upload Cacading</h3>
            </div>
            <div class="box-body">
                <form action="{{ url('perencanaan/upload-cascading-rpjmd/store')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        
                        @if(Auth::user()->level == 1)
                        <div class="form-group">
                            <label for="org" class="col-sm-2 control-label">{{ __('OPD') }}</label>
                            <div class="col-sm-8">
                               <select name="org" class="form-control select2">
                                   <option value="">--Pilih OPD--</option>
                                   @foreach($orgs as $org)
                                    <option value="{{$org->organisasi_no}}">{{$org->organisasi_nama}}</option>
                                   @endforeach
                               </select>
                                @if ($errors->has('org'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('org') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @else
                        
                        <input type="hidden" name="org" value="{{Auth::user()->organisasi_no}}">


                        @endif

                        <div class="form-group">
                            <label for="file" class="col-sm-2 control-label">{{ __('File') }}</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" value="{{ old('file') }}" autofocus>
                                @if ($errors->has('file'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <!-- /.box-body -->
                    <div class="box-footer ">
                        <div class="col-sm-10">
                        <div class=" pull-right">
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                        </div>
                        
                    </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="box box-default">
            <div class="box-header">
                <h3>Cari Data Cacading</h3>
            </div>
            <div class="box-body">
                @if(Auth::user()->level == 1)
                <form action="{{ url('perencanaan/data-upload-cascading-rpjmd')}}" class="form-horizontal" method="POST" id="form_search">
                    {{ csrf_field() }}
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label for="org" class="col-sm-2 control-label">{{ __('OPD') }}</label>
                            <div class="col-sm-8">
                               <select name="org" id="search_org" class="form-control select2">
                                   <option value="">--Pilih OPD--</option>
                                   @foreach($orgs as $org)
                                    <option value="{{$org->organisasi_nama}}">{{$org->organisasi_nama}}</option>
                                   @endforeach
                               </select>
                                @if ($errors->has('org'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('org') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>
                        @endif

                <table class="table table-responsive table-bordered table-hover">
                        <thead>
                        <tr style="background-color: #007bff; color: #fff;">
                            <td style="height: 10px;">File</td>
                            <td style="height: 10px;">Date</td>
                            @if(Auth::user()->level == 1)
                            <td style="height: 10px;">Organisasi Nama</td>
                            @endif
                            <td style="height: 10px;">Aksi</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($cascading_rpjmd as $data)
                            <tr>
                                <td>{{$data->nama_file}}</td>
                                <td>{{$data->created_at}}</td>
                                @if(Auth::user()->level == 1)
                                <td>{{ str_replace('-', ' ', $data->organisasi_nama)}}</td>
                                @endif
                                <td>
                                     <form action="{{ url('perencanaan/upload-cascading-rpjmd/delete',$data->id) }}" method='POST' style="display: inline;">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="_method" value="DELETE">
                                        <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus User"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                    <form action="{{ url('perencanaan/download-cascading-rpjmd') }}" method="POST" style="display: inline;">
                                        @csrf

                                        <input type="hidden" name="org" value="{{ str_replace('-', ' ', $data->organisasi_nama)}}">
                                        
                                        <button class="btn btn-primary btn-xs" data-toggle="tooltip" title="Download {{$data->nama_file}}"><i class="fa fa-download"></i></button>

                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop     

@push('scripts')
<script>

$('#search_org').on('change', function(){
    console.log('test');
    $('#form_search').submit();
});

</script>
@endpush


