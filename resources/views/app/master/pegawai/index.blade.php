@extends('layouts.template')

@section('content')
<div class="card card shadow mb-4">
    {{-- <div class="box-header with-border"> --}}
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4>Data Pegawai &nbsp&nbsp 
            
            <a href="{{url('pegawai/create')}}" data-toggle="tooltip" title="Tambah Pegawai"> <button class="btn btn-sm btn-primary">Tambah</button></a>
            
        </h4>
    </div>

    <div class="card-body">

    @if(Auth::user()->level == 1)
    <form action="{{ url ('pegawai/dataPegawai')}}" method="POST">
        {{ csrf_field() }}

        <div class="row">
              {{-- <div class="col-md-12"> --}}

                <div class="col-md-6">
                <select class="form-control select2" name="organisasi_no" id="organisasi_no">
                <option value="">-- Pilih OPD --</option>
                @foreach($opd as $data)
                <option value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>

              </div>
              {{-- </div> --}}
        </div>
    </form>
    @endif

    <br>
    
    <div class="table-responsive">
        
        @foreach($opds as $o)
        <h4 style="font-weight: bold; color: salmon;">{{$o->organisasi_nama}}</h4>
        @endforeach
           <table class="table table-responsive table-hover table-bordered" id="pegawai-table">
                    <thead>
                    <tr>
                        <th style="width: 1%;">No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Pangkat</th>
                        <th>Jabatan</th>
                        {{-- @if(Auth::user()->level == 1 )
                        <th style="height: 10px;">Instansi</th>
                        @endif --}}
                        @if(Auth::user()->level != 3 )
                        <th style="height: 10px; width: 10%; text-align: center;">Aksi</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $data2)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$data2->nama}}</td>
                            <td>{{$data2->nip}}</td>
                            <td>{{$data2->golongan}}</td>
                            <td>{{$data2->jabatan}}</td>
                            {{-- @if(Auth::user()->level == 1 )
                            <td>{{$data2->organisasi_nama}}</td>
                            @endif --}}
                            @if(Auth::user()->level != 3 )
                                <td display="inline" style="text-align: center;">
                                    <div class="btn-group">
                                    <a href="{{route('pegawai.edit',Hashids::encode($data2->id))}}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Pegawai"><i class="fa fa-edit" ></i></a> &nbsp;
                                    <form action="{{ route('pegawai.destroy',Hashids::encode($data2->id)) }}" method='POST' style="display: inline;">
                                        {{csrf_field()}}

                                        <input type="hidden" name="_method" value="DELETE">
                                        <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Pegawai"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
            </table>

                    {{-- <div class="pull-right">
                     {{ $dataser->links() }} 
                 </div> --}}
        </div>
</div>
@stop        

@push('scripts')
<script>
	
function ConfirmDelete() {
    var x = confirm("Yakin akan menghapus data?");
    if (x) return true; else return false;
}

$(function() {
	$('#pegawai-table').DataTable();



    // $('#pegawai-table').DataTable({
    //     responsive: true,
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{route('data.peg')}}",
    //     columns: [
    //         { data: 'DT_RowIndex', name: 'pegawai_id', orderable: false, searchable: false },
    //         { data: 'nama', name: 'nama' },
    //         { data: 'nip', name: 'nip' },
    //         { data: 'golongan', name: 'golongan' },
    //         { data: 'organisasi_nama', name: 'organisasi_nama' ,  searchable: false },
    //     ]
    // });
});
</script>
@endpush
