@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    <div class="box-header">
        <h4>Data Satuan</h4>
    </div>

        <div class="box-body">
        @if(Auth::user()->level == 1)
        <div>{{json_encode($api->original['message'])}}</div>
        @endif
           <table class="table table-responsive table-hover table-bordered" id="sats-table">
                    <thead>
                    <tr style="background-color: #007bff;">
                        <th style="height: 10px; width: 3%;">No</th>
                        <th style="height: 10px;">Nama Satuan</th>
                        {{-- @if(Auth::user()->level == 'Admin')
                        <th style="height: 10px;">Aksi</th>
                        @endif --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($satuan as $o)
                        <tr>
                            <td style="text-align: center;">{{$no++}}</td>
                            <td>{{$o->satuan_nama}}</td>
                            {{-- @if(Auth::user()->level == 'Admin')
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                    <a href="{{route('organisasi.edit',$o->id)}}" ><button ><i class="fa fa-edit" ></i></button></a>
                                    <form action="{{ route('organisasi.destroy',$o->id) }}" method='POST' style="display: inline;">
                                        @csrf

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
                    {{-- <div class="pull-right">
                     {{ $orgs->links() }} 
                 </div> --}}
        </div>
</div>
        
@stop        

@push('scripts')
<script>
    $('#sats-table').DataTable();
// $(function() {
//     $('#sats-table').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: '{!! route('data.sats') !!}',
//         columns: [
//             { data: 'DT_RowIndex', name: 'id' },
//             { data: 'satuan_nama', name: 'satuan_nama' },
//         ]
//     });
// });
</script>
@endpush