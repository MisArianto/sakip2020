@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Users</h4>
            <button class="btn btn-primary btn-sm float-right" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
        </div>
        <div class="card-body">
              
            @include('app.admin.master.user._table')

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->

@include('app.admin.master.user._modal')

@endsection        

@section('scripts')
<script>
    $(document).ready(function(){
        fetch_data()
        fetch_organisasi()

        $('.select2').select2({
            theme: "bootstrap4"
        })
    })
    
    function fetch_data(){
        $('#loading-on').removeClass('layar')
        $('#loading-off').addClass('layar')

        $.ajax({
            type: 'GET',
            url: '{{ url("admin/master/user/fetch") }}',
            success: function(res)
            {
                let output = ``
                $.each(res.users, function(i, item){
                    output +=  `
                        <tr>
                            <td>${parseInt(i+1)}</td>
                            <td>${item.username}</td>
                            <td>${item.nama}</td>
                            <td>${item.organisasi_nama ? item.organisasi_nama : 'Admin Pusat'}</td>
                            <td>${helper_level(item.level)}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" id="handleDelete" data-id="${item.id}" url="{{ url('admin/master/user/destroy') }}"><span class="fa fa-trash"></span></button>
                                    <button class="btn btn-info btn-sm" id="handleEdit" data-id="${item.id}" data-nama="${item.nama}" data-username="${item.username}" data-level="${item.level}" data-opd="${item.organisasi_no}"><span class="fa fa-edit"></span></button>
                                </div>
                            </td>
                        </tr>
                    `
                })

                $('#load').html(output)

                $('#loading-on').addClass('layar')
                $('#loading-off').removeClass('layar')
            }
        })
    }

    function fetch_organisasi()
    {
        $.ajax({
            type: 'GET',
            url: '{{ url("admin/master/user/fetch_organisasi") }}',
            dataType: 'json',
            success: function(res)
            {
                let output = ``
                output += `<option value="">Pilih</option>`
                $.each(res.opds, function(i, item){
                    output +=  `
                       <option value="${item.organisasi_no}">${item.organisasi_nama}</option>
                    `
                })

                $('#opd').html(output)
            }
        })
    }


    function helper_level(level)
    {
        if(level == 1)
        {
            return 'Admin'
        }else if(level == 2)
        {
            return 'User'
        }else{
            return 'Pengawas'
        }
    }

    function longValueEdit(value){
        let id = value.data('id')
        let username = value.data('username')
        let nama = value.data('nama')
        let level = value.data('level')
        let opd = value.data('opd')

        $('#id').val(id)
        $('#username').val(username)
        $('#nama').val(nama)
        $('#level').val(level).change()
        $('#opd').val(opd).change()
    }

    function reset_error(){
        $('#nama_error').html('')
        $('#usernama_error').html('')
        $('#level_error').html('')
        $('#opd_error').html('')
    }

    function reset(){
        $('#nama').val('');
        $('#username').val('');
        $('#level').val('');
        $('#opd').val('');
    }


</script>
@endsection
