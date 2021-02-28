@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        <div class="card-header">
            <h3>RKT</h3>
        </div>
        <div class="card-body">

        	<form id="form-filter" url="{{ url('user/rkt/fetch')}}" class="mb-5">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="border p-2">
                            <legend class="w-auto">Cari</legend>
                            <div class="row">
                                <input type="hidden" value="{{ Auth::user()->organisasi_no }}" name="organisasi_no" id="organisasi_no">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-sm-8">
                                    <select class="form-control select2" name="tahun_filter" id="tahun_filter">
                                        <option value="">Pilih Tahun</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
              
            <ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" id="sasaran-tab" data-toggle="tab" href="#sasaran" role="tab" aria-controls="sasaran" aria-selected="true">Target Sasaran</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="prokeg-tab" data-toggle="tab" href="#prokeg" role="tab" aria-controls="prokeg" aria-selected="false">Target Program & Kegiatan</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="sasaran" role="tabpanel" aria-labelledby="sasaran-tab">
			  	@include('app.user.rkt._target_sasaran')
			  </div>
			  <div class="tab-pane fade" id="prokeg" role="tabpanel" aria-labelledby="prokeg-tab">
			  	@include('app.user.rkt._target_prokeg')
			  </div>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
    
    function fetch_data(){
        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')
    }


    $(document).on('change', '#tahun_filter', function(){

          let url = $('#form-filter').attr('url')
          let organisasi_no = $('#organisasi_no').val()
          let tahun = $('#tahun_filter').val()

            // set state
            $('#loadingTableTargetSasaran').removeClass('layar')
            $('#load_target_sasaran').addClass('layar')

            $('#loadingTableTargetProkeg').removeClass('layar')
            $('#load_target_prokeg').addClass('layar')

            $.ajax({
                type: 'POST',
                url: url,
                data: {organisasi_no: organisasi_no, tahun:tahun},
                success: function(res)
                {

                    $('#load_target_sasaran').html(res.target_sasarans);
                    $('#loadingTableTargetSasaran').addClass('layar')
                    $('#load_target_sasaran').removeClass('layar')

                    $('#load_target_prokeg').html(res.target_prokegs);
                    $('#loadingTableTargetProkeg').addClass('layar')
                    $('#load_target_prokeg').removeClass('layar')

                },
                error: function(data)
                {
                    let errors = data.responseJSON

                    Toast.fire({
                        type: "error",
                        title: `${errors.message}`
                      });

                }
            });
          
        })


</script>
@endsection
