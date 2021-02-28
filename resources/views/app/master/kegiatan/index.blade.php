@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    <div class="box-header">
        <h4>Data Kegiatan</h4>
    </div>

        <div class="box-body">
        @if(Auth::user()->level == 1)
        <div>{{json_encode($api->original['message'])}}</div>
        @endif
           <table class="table table-responsive table-hover table-bordered" id="keg-table">
                    <thead>
                    <tr style="background-color: #007bff;">
                        {{-- <th style="height: 10px; width: 12%;">Kode Pogram</th> --}}
                        {{-- <th style="height: 10px;">Nama Progam</th> --}}
                        <th style="height: 10px; width: 12%;">Kode Kegiatan</th>
                        <th style="height: 10px;">Nama Kegiatan</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($program as $p)
                        <tr>
                            <td>{{$p->program_no}}</td>
                            <td>{{$p->program_nama}}</td>
                        </tr> --}}
                        @foreach($kegiatan as $u)
                        <tr>
                            <td>{{$u->kegiatan_no}}</td>
                            <td>{{$u->kegiatan_nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>

        </div>
</div>
@stop        

@push('scripts')
<script>

function ConfirmDelete() {
    var x = confirm("Yakin akan menghapus data?");
    if (x) return true; else return false;
}

$('#keg-table').DataTable();

$(function() {

    // $('#keg-table').DataTable();
    // $('#keg-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: '{!! route('data.keg') !!}',
    //     columns: [
    //         // { data: 'nuprgrm', name: 'nuprgrm' },
    //         // { data: 'nmprgrm', name: 'nmprgrm' },
    //         { data: 'kegiatan_no', name: 'kegiatan_no' },
    //         { data: 'kegiatan_nama', name: 'kegiatan_nama' },
    //     ]
    // });
});
</script>
@endpush
