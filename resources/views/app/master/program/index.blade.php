@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    <div class="box-header">
        <h4>Data Program</h4>
    </div>
        <div class="box-body">
         @if(Auth::user()->level == 1)
        <div>{{json_encode($api->original['message'])}}</div>
        @endif
           <table class="table table-responsive table-hover table-bordered" id="prgrm-table">
                    <thead>
                    <tr style="background-color: #007bff;">
                        <th style="height: 10px; width: 12%;">Kode Program</th>
                        <th style="height: 10px;">Nama Program</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($program as $u)
                        <tr>
                            <td>{{$u->program_no}}</td>
                            <td>{{$u->program_nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>

                    {{-- <div class="pull-right">
                     {{ $user->links() }} 
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

    $('#prgrm-table').DataTable();

    // $('#prgrm-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: '{!! route('data.prgrms') !!}',
    //     columns: [
    //         { data: 'program_no', name: 'program_no' },
    //         { data: 'program_nama', name: 'program_nama' },
    //     ]
    // });
});
</script>
@endpush
