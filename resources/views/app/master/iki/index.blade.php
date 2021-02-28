@extends('layouts.template')

@section('content')
<div class="card card shadow mb-4">
    {{-- <div class="box-header with-border"> --}}
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4>Indikator Kinerja Individu

            &nbsp;
            <a href="{{ url('iki/create') }}" data-toggle="tooltip" title="Tambah IKI"> <button class="btn btn-sm btn-primary">Tambah</button></a>
            
        </h4>
    </div>
    
    <div class="card-body">

    
    <form action="{{ url ('iki/dataPegawai')}}" method="POST">
        {{ csrf_field() }}

        <div class="row">
              {{-- <div class="col-md-12"> --}}
                @if(Auth::user()->level != 2)
                <div class="col-md-4">
                <select class="form-control select2" name="organisasi_no" id="organisasi_no">
                <option value="">-- Pilih OPD --</option>
                @foreach($opd as $data)
                <option @if($get_opd == $data->organisasi_no) selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                @endforeach
                </select>
                </div>
                @endif
                <div class="col-md-2">
                    <select class="form-control select2" name="tahun" id="tahun">
                        <option value="">--pilih Tahun--</option>
                        <option @if($tahun == '2017') selected @endif value="2017">2017</option>
                        <option @if($tahun == '2018') selected @endif value="2018">2018</option>
                        <option @if($tahun == '2019') selected @endif value="2019">2019</option>
                        <option @if($tahun == '2020') selected @endif value="2020">2020</option>
                        <option @if($tahun == '2021') selected @endif value="2021">2021</option>
                    </select>
                </div>
                <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>
              </div>
              {{-- </div> --}}
        </div>
    </form>
    
<br>

    <div class="table-responsive">
        
        @foreach($opds as $o)
        <h4 style="font-weight: bold; color: salmon;">{{$o->organisasi_nama}}</h4>
        @endforeach
           <table class="table table-responsive table-hover table-bordered" id="pegawai-table">
                    <thead>
                    <tr style="background-color: #007bff; color: #fff;">
                        <td style="width: 1%; text-align: center;">No</td>
                        <td >Nama</td>
                        <td >Jabatan</td>
                        @if(Auth::user()->level != 3 )
                        <td style=" width: 10%; text-align: center;">Aksi</td>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                        @foreach(collect($pegawai)->unique('pegawai_id') as $data2)
                        <tr>
                            <td style="text-align: center;">{{$no++}}</td>
                            <td><a href="{{url('iki/dataIki',  Hashids::encode($data2->id))}}" data-toggle="tooltip" title="Lihat IKI">{{$data2->nama}}</a></td>
                            <td>{{$data2->jabatan}}</td>
                            @if(Auth::user()->level != 3 )
                                <td display="inline" style="text-align: center;">
                                    <div class="btn-group">
                                    {{-- <a href="{{route('iki.edit', Hashids::encode($data2->id))}}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit iki"><i class="fa fa-edit" ></i></a> &nbsp; --}}
                                    <form action="{{ route('iki.destroy', Hashids::encode($data2->id)) }}" method='POST' style="display: inline;">
                                        {{csrf_field()}}

                                        <input type="hidden" name="_method" value="DELETE">
                                        <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Iki"><i class="fa fa-trash-o"></i></button>
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
