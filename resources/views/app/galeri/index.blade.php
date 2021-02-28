@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    {{-- <div class="box-header with-border"> --}}
        
        <div class="box-header">
            <h4>List Galeri &nbsp;&nbsp;
            @if(Auth::user()->level == 1)
            <a href="{{ url('master/galeri/add') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah User">Tambah</a>
            @endif
            </h4>
            {{-- <div class="pull-right"><a href="{{ url('master/user/print') }}" target="_blank"><i class="fa fa-print"></i></a></div><br> --}}
        </div>
        
</div>

<div class="row">
    @foreach($galeris as $galeri)
    <div class="col-md-4">
        <div class="box box-default" style="padding: 10px;">
                <div class="box-header">
                    <h1>{{ $galeri->judul }}</h1>
                </div>
                
                <div class="box-body">
                   <p>{{ substr($galeri->title, 0, 50) . '...' }}</p>
                </div>
                <div class="box-footer">
                    <a href="{{ url('master/galeri/edit',$galeri->id) }}" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>

                    <a href="{{ url('master/galeri/destroy',$galeri->id) }}" onclick="return ConfirmDelete();" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                </div>
        </div>
    </div>
    @endforeach

    {!! $galeris->links() !!}
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
