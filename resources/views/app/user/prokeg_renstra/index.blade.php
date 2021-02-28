@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        <div class="card-header">
            <h3>Program & Kegiatan Renstra</h3>
        </div>
        <div class="card-body">
              
            <div class="table-responsive">
               <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                       <tr>
                            <th rowspan="2" colspan="2">Program</th>
                            <th rowspan="2">Kegiatan</th>
                            <th rowspan="2">Indikator</th>
                            <th rowspan="2" style="text-align: center;">Satuan</th>
                            <th rowspan="2" style="text-align: center;">Capaian Awal</th>
                            <th colspan="2" style="text-align: center;">Tahun 2017</th>
                            <th colspan="2" style="text-align: center;">Tahun 2018</th>
                            <th colspan="2" style="text-align: center;">Tahun 2019</th>
                            <th colspan="2" style="text-align: center;">Tahun 2020</th>
                            <th colspan="2" style="text-align: center;">Tahun 2021</th>
                            <th colspan="2" style="text-align: center;">Kondisi Akhir</th>
                        </tr>
                         <tr>
                            <th style="text-align: center;">Target</th>
                            <th style="text-align: center;">Pagu</th>
                            <th style="text-align: center;">Target</th>
                            <th style="text-align: center;">Pagu</th>
                            <th style="text-align: center;">Target</th>
                            <th style="text-align: center;">Pagu</th>
                            <th style="text-align: center;">Target</th>
                            <th style="text-align: center;">Pagu</th>
                            <th style="text-align: center;">Target</th>
                            <th style="text-align: center;">Pagu</th>
                            <th style="text-align: center;">Target</th>
                            <th style="text-align: center;">Pagu</th>
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
            url: '{{ url("user/perencanaan/renstra/program-kegiatan-renstra/fetch") }}',
            success: function(res)
            {
                console.log(res)
                $('#load').html(res)

                $('#loading-on').addClass('layar')
                $('#loading-off').removeClass('layar')
            }
        })
    }


</script>
@endsection
