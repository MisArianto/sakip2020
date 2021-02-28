@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        <div class="card-header">
            <h3>Tujuan Renstra</h3>
        </div>
        <div class="card-body">
              
            <div class="table-responsive">
               <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                       <tr>
                            <th style="text-align: center;">Misi</th>
                            <th style="text-align: center;">Tujuan</th>
                            <th style="text-align: center;">Indikator</th>
                            <th style="text-align: center;">Satuan</th>
                            <th style="text-align: center;">Kondisi Akhir</th>
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

@endsection        

@section('scripts')
<script>
    $(document).ready(function(){
        fetch_data()
    })
    
    function fetch_data(){
        $('#loading-on').removeClass('layar')
        $('#loading-off').addClass('layar')

        $.ajax({
            type: 'GET',
            url: '{{ url("user/perencanaan/renstra/tujuan-renstra/fetch") }}',
            success: function(res)
            {
                // console.log(res.api_tujuan_renstra.original)
                // console.log(res.api_indikator_tujuan_renstra.original)
                // console.log(res.api_satuan.original)
                $('#load').html(res.tujuan_renstras)

                $('#loading-on').addClass('layar')
                $('#loading-off').removeClass('layar')
            }
        })
    }


</script>
@endsection
