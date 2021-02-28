@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3>Data Pegawai</h3>
            <button class="btn btn-primary btn-sm float-right" id="btn-tambah-pegawai"><i class="fa fa-plus"></i> Tambah</button>
        </div>
        <div class="card-body">
              
            <div class="table-responsive">
               <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                       <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Nama</th>
                            <th style="text-align: center;">NIP</th>
                            <th style="text-align: center;">Pangkat</th>
                            <th style="text-align: center;">Jabatan</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody id="load">
                        <!-- load ajax -->
                    </tbody>
                </table>
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->

<!-- inlcude modal -->
@include('app.user.pegawai._modal')

@endsection        

@section('scripts')
<script>
    $(document).ready(function(){
        fetch_data()

        $(document).on('click', '#btn-tambah-pegawai', function(){
            $('#myModal').modal('show')
        })

        $(document).on('click', '#cari', function(){
            let nip = $('#myModal #nip').val()

            let url = '{{ url("user/pegawai/search") }}'

            $('#loadingTable').removeClass('layar')
            $('#load').addClass('layar')

            $.ajax({
                type: 'GET',
                url: `${url}/${nip}`,
                dataType: 'json',
                async: false,
                success: function(res)
                {
                    $('#load_tambah_pegawai').html(res.output)

                    $('#loadingTable').addClass('layar')
                    $('#load').removeClass('layar')
                },
                error: function(data)
                {
                    let errors = data.responseJSON
                    Toast.fire({
                        type: "error",
                        title: `${errors.message}`
                    });
                }
            })
        })

        $(document).on('click', '#handleSimpan', function(){
            let id = $(this).data('id')
            let url = '{{ url("user/pegawai/simpan") }}'

            $.ajax({
                type: 'GET',
                url: `${url}/${id}`,
                async: false,
                success: function(res)
                {
                    Toast.fire({
                        type: "success",
                        title: 'Data Success di Tambahkan'
                    });

                    console.log(res)
                    fetch_data()
                },
                error: function(data)
                {
                    let errors = data.responseJSON
                    Toast.fire({
                        type: "error",
                        title: `${errors}`
                    });
                }
                
            })

        })

        $(document).on('click', '#delete', function(){
        	let url = $(this).data('url')
        	let id = $(this).data('id')

        	Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
              }).then(result => {
                if (result.value) {
                  $.ajax({
                        type: 'GET',
                        url: `${url}/${id}`,
                        async: true,
                        success: function(res){

							fetch_data()                        	

                             Toast.fire({
                                type: "success",
                                title: `Delete Success`
                              });

                        },
                        error: function(data)
                        {

                            let errors = data.responseJSON

                            Toast.fire({
                                type: "error",
                                title: `${errors.message}`
                              });

                        }
                    })
                }
              });


        })

        



    })
    
    function fetch_data(){

        $('#loading-on').removeClass('layar')
        $('#loading-off').addClass('layar')

        $.ajax({
            type: 'GET',
            url: '{{ url("user/pegawai/fetch") }}',
            dataType: 'json',
            success: function(res)
            {
                let pegawais = res.pegawais
                
                let output = ``

                $.each(pegawais, function(i, item){
                    output += `
                        <tr>
                            <td>${parseInt(i+1)}</td>
                            <td>${item.nama}</td>
                            <td>${item.nip}</td>
                            <td>${item.pangkat}</td>
                            <td>${item.jabatan}</td>
                            <td>    
                            	<div class="btn-group">
                                    <a href="{{ url('user/pegawai/cetak-pk-pdf/${item.id}') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
	                                <button class="btn btn-danger btn-sm" id="delete" title="Hapus Pegawai ${item.nama}" data-id="${item.id}" data-url="{{ url('user/pegawai/delete') }}">
	                                    <i class="fas fa-trash"></i>
	                                </button>
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


</script>
@endsection
