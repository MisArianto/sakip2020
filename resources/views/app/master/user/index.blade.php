@extends('layouts.template')

@section('content')
<div class="card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Data Users &nbsp;&nbsp;
            {{-- @if(Auth::user()->level == 1)
            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah User">Tambah</a>
            @endif --}}
            </h4>
        </div>
        
        <div class="card-body">
           <table class="table table-responsive table-bordered table-hover" id="userTable">
                    <thead>
                    <tr style="background-color: #007bff; color: #fff;">
                        <td style="height: 10px; width: 3%;">No</td>
                        <td style="height: 10px;">Username</td>
                        <td style="height: 10px;">Nama</td>
                        <td style="height: 10px;">Nama OPD</td>
                        <td style="height: 10px;">Status</td>
                        @if(Auth::user()->level == '1')
                        {{-- <td style="height: 10px; width: 7%; text-align: center;">Aksi</td> --}}
                        @endif
                        
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="text-align: center;">{{$no++}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->nama}}</td>
                            @if(App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->first() == null)
                            <td>Admin Pusat</td>
                            @elseif(App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->first() != null)
                            <td>{{App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->orderBy('organisasi_no')->first()->organisasi_nama}}</td>
                            @endif
                            <td style="text-align: center;">
                            @if($user->level == 1)
                            <span class="label label-danger">Admin</span>
                            @elseif($user->level == 2)
                            <span class="label label-primary">User</span>
                            @elseif($user->level == 3)
                            <span class="label label-success">Pengawas</span>
                            @endif
                            </td>
                            {{-- @if(Auth::user()->level == '1')
                                <td style="text-align: center;">
                                    <a href="{{route('user.edit',Hashids::encode($user->id))}}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit User"><i class="fa fa-edit" ></i></a>
                                    <form action="{{ route('user.destroy',$user->id) }}" method='POST' style="display: inline;">
                                      {{ csrf_field() }}

                                        <input type="hidden" name="_method" value="DELETE">
                                        <button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus User"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                </td>
                                @endif --}}
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
</div>
@stop        

@push('scripts')
<script>

$('#userTable').DataTable();

function ConfirmDelete() {
    var x = confirm("Yakin akan menghapus data?");
    if (x) return true; else return false;
}


 $('#create_record').click(function(){
  $('.modal-title').text("Tambah User");
     $('#action_button').val("Tambah");
     $('#action').val("Add");
     $('#formModal').modal('show');
 });

</script>
@endpush
