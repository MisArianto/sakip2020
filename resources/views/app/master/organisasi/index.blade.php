@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    <div class="box-header">
        <h4>Data Organisasi</h4>
    </div>
        <div class="box-body">
        @if(Auth::user()->level == 1)
        <div>{{json_encode($api->original['message'])}}</div>
        @endif
           <table class="table table-responsive table-hover table-bordered" id="orgs-table">
                    <thead>
                    <tr style="background-color: #007bff;">
                        <th style="height: 10px; width: 12%;">Kode Organisasi</th>
                        <th style="height: 10px;">Nama Organisasi</th>
                        {{-- @if(Auth::user()->level == 1 || Auth::user()->level == 'Admin')
                        <th style="height: 10px;">Aksi</th>
                        @endif --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orgs as $o)
                        <tr>
                            <td>{{$o->organisasi_no}}</td>
                            <td>{{$o->organisasi_nama}}</td>
                           {{--  @if(Auth::user()->level == 1 || Auth::user()->level == 'Admin')
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                    <a href="{{route('organisasi.edit',$o->id)}}" ><button ><i class="fa fa-edit" ></i></button></a>
                                    <form action="{{ route('organisasi.destroy',$o->id) }}" method='POST' style="display: inline;">
                                        {{csrf_field()}}

                                        <input type="hidden" name="_method" value="DELETE">
                                        <button onclick="return ConfirmDelete();" ><i class="fa fa-trash-o" style="color: red;"></i></button>
                                    </form>
                                    </div>
                                </td>
                                @endif --}}
                        </tr>
                        @endforeach
                    </tbody>
            </table>
                   {{--  <div class="pull-right">
                     {{ $orgs->links() }} 
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

    $('#orgs-table').DataTable();


    // $('#orgs-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: '{!! route('data.orgs') !!}',
    //     columns: [
    //         // { data: 'DT_RowIndex', name: 'organisasi_id', orderable: false, searchable: false },
    //         { data: 'organisasi_no', name: 'organisasi_no' },
    //         { data: 'organisasi_nama', name: 'organisasi_nama' },
    //         // { data: 'unitkey', name: 'unitkey' },
    //     ]
    // });
});
</script>
@endpush