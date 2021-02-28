@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Laporan Hasil Evaluasi</h4>
        </div>
        <div class="card-body">
            <form id="form-filter" url="{{ url('user/lhe/fetch')}}" class="mb-5">
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

              <!-- include table -->
              @include('app.user.lhe._table')
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->
    
<!-- inlcude modal -->
@include('app.user.lhe._modal')

@endsection        

@section('scripts')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetch_data()

        $('.select2').select2({
            theme: "bootstrap4"
        })


        $(document).on('change', '#tahun_filter', function(){

          let url = $('#form-filter').attr('url')
          let organisasi_no = $('#organisasi_no').val()
          let tahun = $('#tahun_filter').val()

            $('#loadingTable').removeClass('layar')
            $('#load').addClass('layar')

            $.ajax({
                type: 'POST',
                url: url,
                data: {organisasi_no: organisasi_no, tahun:tahun},
                success: function(res)
                {
                    $('#load').html(res);
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
            });
          
        })

        $(document).on('click', '#handleEditLhe', function(){
          let id = $(this).data('id')
          let nilai = $(this).data('nilai')

          $('#form #id').val(id)
          $('#form #nilai').val(nilai)

          $('#myModal').modal('show')
        })


        $(document).on('click', '#btn-update-lhe', function(e){
            e.preventDefault()
            let id = $('#form #id').val()
            let url = $('#form').attr('urlUpdate')

            let tahun_filter = $('#form-filter #tahun_filter').val()
            let nilai = $('#form #nilai').val()

            let obj = {
              'tahun_emit' : tahun_filter,
              'nilai' : nilai
            }

            let token = {
                    "_token": $('#token').val()
                };

            $.ajax({
                type: 'PUT',
                url: `${url}/${id}`,
                data: obj,
                headers: token,
                success: function(res){

                  $('#load').html(res);

                    reset()
                    reset_error()

                    $('#myModal').modal('hide')
                    
                    Toast.fire({
                        type: "success",
                        title: `Update Success`,
                    });

                },
                error: function(data)
                {

                    reset_error()
                    let errors = data.responseJSON

                    Toast.fire({
                        type: "error",
                        title: `${errors.message}`
                      });

                    $.each(errors.errors, function(k, v){
                        $('#'+k+'_error').html(v)
                    })
                }
            })

        })
        

    })
    

    function reset_error(){
        $('#nilai_error').html('')
    }

    function reset(){
        $('#nilai').val('')
    }

    function fetch_data(){
        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')
    }


</script>
@endsection
