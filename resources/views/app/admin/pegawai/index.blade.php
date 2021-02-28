@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        <div class="card-header">
            <h3>Data Pegawai</h3>
        </div>
        <div class="card-body">

            <form id="form-filter" url="{{ url('admin/pegawai/fetch')}}" class="mb-5">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="border p-2">
                            <legend class="w-auto">Cari Pegawai</legend>
                            <div class="row">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-sm-8">
                                    <select class="form-control select2" name="organisasi_no" id="organisasi_no">
                                        <option value="">Pilih</option>
                                        @foreach($organisasis as $org)
                                        <option value="{{ $org->organisasi_no }}">{{ $org->organisasi_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
              
            <div class="table-responsive">
               <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                       <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Nama</th>
                            <th style="text-align: center;">NIP</th>
                            <th style="text-align: center;">Pangkat</th>
                            <th style="text-align: center;">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody id="load">
                        <!-- load ajax -->
                    </tbody>
                    <tbody class="layar" id="loadingTable">
                        <tr>
                            <td colspan="12" align="center">
                                @include('layouts._spinner')
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->

@endsection        

@section('scripts')
<script>
    $(document).ready(function(){

        fetch_data()

        $('.select2').select2({
            theme: "bootstrap4"
        })

        $(document).on('change', '#organisasi_no', function(){

            let url = $('#form-filter').attr('url')
            let organisasi_no = $('#form-filter  #organisasi_no').val()

            $('#loadingTable').removeClass('layar')
            $('#load').addClass('layar')

            $.ajax({
                type: 'GET',
                url: `${url}/${organisasi_no}`,
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
                            </tr>
                        `
                    })

                    $('#load').html(output)

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


    })
    
    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')

        
    }


</script>
@endsection
