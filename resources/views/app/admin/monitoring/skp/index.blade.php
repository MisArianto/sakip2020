@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Monitoring Sistem SKP</h4>
            <a href="{{url('admin/monitoring/cetak-skp')}}" class="float-right" target="_blank" title="Cetak Monitoring SKP"><i style="font-size:25px;color: #f04a5d;" class="fas fa-file-pdf"></i></a>
        </div>

        <div class="card-body">
              <!-- include table -->
              @include('app.admin.monitoring.skp._table')
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

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')

        $('#loadingTable').removeClass('layar')
        $('#load').addClass('layar')

        $.ajax({
            type: 'GET',
            url: '{{ url("admin/monitoring/fetch-skp") }}',
            dataType: 'json',
            async: true,
            success: function(res){
                $('#load').html(res.output)

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
    }

</script>
@endsection
