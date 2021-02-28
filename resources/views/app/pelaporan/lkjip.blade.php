@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
	<div class="box-header">
	<h4> Laporan Kinerja Instansi Pemerintah</h4>
	</div>
    <div class="alert alert-warning">
    <h3>PENTING!</h3>
    <p>Cara Upload Data :</p>
    <ul>
      <li>Konversi semua file menjadi 1 file PDF</li>
      <li>Pilih tahun terlebih dahulu</li>
      <li>Setelah data dipilih, upload dengan menekan tombol <b><i>Upload</i></b>.</li>
      <li>Apabila terjadi kesalahan upload, maka akan dihapus secara otomatis oleh admin</li>
      <li>Terima Kasih !!</li>
    </ul>
</div>
    

    @if(Auth::user()->level != 2)
    <div class="row">

         <div class="col-md-6">
                <form action="{{ url('laporan/dataRequest') }}" method="POST" id="formOrgAdmin">
                    @csrf
                    
                    <div class="col-md-5">
                        <select name="organisasi_no" id="" class="form-control select2">
                            <option value="">Pilih Opd</option>
                            @foreach($orgs as $org)
                            <option @if($org->organisasi_no == $organisasi_no) selected @endif value="{{$org->organisasi_no}}">{{$org->organisasi_nama}}</option>
                            @endforeach
                        </select>
                    </div>

                     {{-- <div class="col-md-1">
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
                    </div> --}}

                </form>
            </div>

        <div class="col-md-6">
            <form action="{{ url('laporan/upload-lkjip') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-4">
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">Pilih Tahun</option>
                        <option value="2016">Tahun 2016</option>
                        <option value="2017">Tahun 2017</option>
                        <option value="2018">Tahun 2018</option>
                        <option value="2019">Tahun 2019</option>
                        <option value="2020">Tahun 2020</option>
                        <option value="2021">Tahun 2021</option>
                    </select>
                    @if ($errors->has('tahun'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tahun') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="col-md-3">
                    <input type="file" name="file" class="form-control">
                    @if ($errors->has('file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('file') }}</strong>
                        </span>
                    @endif

                </div>

                 <div class="col-md-3">
                    <button type="submit" id="btnUpload" class="btn btn-primary">Upload</button>
                </div>

            </form>
        </div>

    </div>

    @else

        <div class="row">

            <div class="col-md-6">
                <form action="{{ url('laporan/upload-lkjip') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-4">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Pilih Tahun</option>
                            <option value="2016">Tahun 2016</option>
                            <option value="2017">Tahun 2017</option>
                            <option value="2018">Tahun 2018</option>
                            <option value="2019">Tahun 2019</option>
                            <option value="2020">Tahun 2020</option>
                            <option value="2021">Tahun 2021</option>
                        </select>
                        @if ($errors->has('tahun'))
                            <span class="help-block">
                                <strong>{{ $errors->first('tahun') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="col-md-3">
                        <input type="file" name="file" class="form-control">
                        @if ($errors->has('file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                    </div>

                     <div class="col-md-1">
                        <button type="submit" id="btnUpload" class="btn btn-primary">Upload</button>
                    </div>

                </form>
            </div>

        </div>

    @endif

    <br>

<div class="box-body">
        

        {{-- akses admin --}}
        @if(Auth::user()->level != 2)
        

           <div class="table table-responsive table-bordered">
           <table class="table table-responsive table-bordered">
                <thead>
                    
                    <tr style="background-color: #007bff;;">
                        <th style="text-align: center;">No</th>
                        <th>Nama File</th>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lkjips as $lkjip)
                    <tr >
                        <td>{{$no++}}</td>
                        <td>{{$lkjip->nama_file}}</td>
                        <td align="center">{{$lkjip->tahun}}</td>
                        <td align="center">
                            <form action="{{ url('laporan/download-lkjip') }}" method="POST" style="display: inline;">
                                @csrf

                                <input type="hidden" name="organisasi_no" value="{{$lkjip->organisasi_no}}">
                                <input type="hidden" name="tahun" value="{{$lkjip->tahun}}">
                                
                                <button class="btn btn-primary btn-xs" data-toggle="tooltip" title="Download {{ $lkjip->nama_file }}"><i class="fa fa-download"></i></button>

                            </form>

                            <form action="{{ route('lkjip.destroy',$lkjip->id) }}" method='POST' style="display: inline;">
                              @csrf

                                <input type="hidden" name="_method" value="DELETE">
                                <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus {{ $lkjip->nama_file }}"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
        </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div id="media"></div>
                </div>
            </div>

        @else <!-- akses user -->

        <div class="table table-responsive table-bordered">
           <table class="table table-responsive table-bordered">
                <thead>
                    
                    <tr style="background-color: #007bff;;">
                        <th style="text-align: center;">No</th>
                        <th>Nama File</th>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lkjips as $lkjip)
                    <tr >
                        <td align="center">{{$no++}}</td>
                        <td>{{$lkjip->nama_file}}</td>
                        <td align="center">{{$lkjip->tahun}}</td>
                        <td align="center">
                            <form action="{{ url('laporan/download-lkjip') }}" method="POST" style="display: inline;">
                                @csrf

                                <input type="hidden" name="organisasi_no" value="{{$lkjip->organisasi_no}}">
                                <input type="hidden" name="tahun" value="{{$lkjip->tahun}}">
                                
                                <button class="btn btn-primary btn-xs" data-toggle="tooltip" title="Download {{ $lkjip->nama_file }}"><i class="fa fa-download"></i></button>

                            </form>

                            <form action="{{ route('lkjip.destroy',$lkjip->id) }}" method='POST' style="display: inline;">
                              @csrf

                                <input type="hidden" name="_method" value="DELETE">
                                <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus {{ $lkjip->nama_file }}"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
        </div>

        @endif


         <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">View</h4>
                    </div>
                    <div class="modal-body">
                        <div id="media"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        
        </div>
</div>
@endsection

@push('scripts')
<script>

function ConfirmDelete() {
    var x = confirm("Yakin akan menghapus data?");
    if (x) return true; else return false;
}

$('#btnUpload').prop('disabled', true);

$(document).on('change', function(){

    $('#btnUpload').prop('disabled', false);
});

$(document).on('change', '#formOrgAdmin', function(){
    $(this).submit();
});

</script>
@endpush

