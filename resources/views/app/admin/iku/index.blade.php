@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Indikator Kinerja Utama</h4>
            <button class="btn btn-primary btn-sm float-right" id="btn-tambah-iku"><i class="fa fa-plus"></i> Tambah</button>
        </div>

        <div class="card-body">
            <form id="form-filter" url="{{ url('admin/iku/fetch')}}" class="mb-5">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="border p-2">
                            <legend class="w-auto">Cari IKU</legend>
                            <div class="row">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-sm-8">
                                    <select class="form-control form-control-sm select2" name="organisasi_no" id="organisasi_no">
                                        <option value="">Pilih</option>
                                        @foreach($organisasis as $org)
                                        <option value="{{ $org->organisasi_no }}">{{ $org->organisasi_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
              @include('app.admin.iku._table')
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->
    
<!-- inlcude modal -->
@include('app.admin.iku._modal')

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

        $(document).on('change', '#form #organisasi_no', function(){

            let organisasi_no = $(this).val() 

            fetch_indikator_sasaran(organisasi_no)
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


        $(document).on('click', '#btn-tambah-iku', function(){
            $('#title-tambah').removeClass('layar')
            $('#title-edit').addClass('layar')
            $('#btn-simpan-iku').removeClass('layar')
            $('#btn-update-iku').addClass('layar')
            $('#id').addClass('layar')

            let tahun = $('#form-filter #tahun_filter').val()
            let organisasi_no = $('#form-filter #organisasi_no').val()
            $('#form #tahun_emit').val(tahun)
            $('#form #organisasi_no_emit').val(organisasi_no)

            reset()

            $('#myModal').modal('show')

            // melempar id tahun yang sudah di pilih keuntuk parameter yang di edit
            let tahun_filter = $('#form-filter #tahun_filter').val()
            $('#form #tahun_emit').val(tahun_filter)
        })

        $(document).on('click', '#btn-simpan-iku',function(e){
            e.preventDefault()

            let token = {
                    "_token": $('#token').val()
                };

            let url = $('#form').attr('url')


            $.ajax({
                type: 'POST',
                url: url,
                data: $('#form').serialize(),
                headers: token,
                success: function(res){

                    if(res == 'warning')
                    {
                        Toast.fire({
                            type: "warning",
                            title: `Data Sudah Ada`
                          });
                    }else{

                        $('#load').html(res);

                        Toast.fire({
                            type: "success",
                            title: `Tambah data success`
                          });

                        fetch_data()
                        reset()
                        reset_error()
                    }


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


        $(document).on('click', '#btn-update-iku', function(e){
            e.preventDefault()
            let id = $('#id').val()
            let url = $('#form').attr('urlUpdate')

            let token = {
                    "_token": $('#token').val()
                };

            $.ajax({
                type: 'PUT',
                url: `${url}/${id}`,
                data: $('#form').serialize(),
                headers: token,
                success: function(res){

                    if(res == 'warning')
                    {
                        Toast.fire({
                            type: "warning",
                            title: `Data Sudah Ada`
                          });
                        
                    }else{

                        $('#load').html(res);
                        reset()
                        reset_error()
                        $('#myModal').modal('hide')
                         Toast.fire({
                            type: "success",
                            title: `Update Success`,
                          });
                    }

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


        $(document).on('click', '#handleDeleteIku', function(){
            let id = $(this).data('id')
            let tahun = $('#form-filter #tahun_filter').val()
            let organisasi_no = $('#form-filter #organisasi_no').val()

            let obj = {
                'id': id,
                'tahun': tahun,
                'organisasi_no' : organisasi_no
            }

            let token = {
                    "_token": $('#token').val()
                };

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
                        type: 'POST',
                        url: '{{ url("user/iku/destroy") }}',
                        data: obj,
                        headers: token,
                        success: function(res){

                            $('#load').html(res)
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
    // end ready function


    function longValueEdit(value){

        // melempar id tahun yang sudah di pilih keuntuk parameter yang di edit
        let tahun_filter = $('#form-filter #tahun_filter').val()
        let organisasi_no_emit = $('#form-filter #organisasi_no').val()
        $('#form #tahun_emit').val(tahun_filter)
        $('#form #organisasi_no_emit').val(organisasi_no_emit)

        fetch_indikator_sasaran(organisasi_no_emit)

        let id = value.data('id')
        let organisasi_no = value.data('organisasi_no')

        let indikator_sasaran_id = value.data('indikator_sasaran_id')
        let tahun = value.data('tahun')
        let alasan = value.data('alasan')
        let formulasi = value.data('formulasi')
        let sumber_data = value.data('sumber_data')
        let keterangan = value.data('keterangan')

        $('#id').val(id)
        $('#form #organisasi_no').val(organisasi_no).change()
        $('#form #indikator_sasaran_id').val(indikator_sasaran_id).change()
        $('#tahun').val(tahun).change()
        $('#alasan').val(alasan)
        $('#formulasi').val(formulasi)
        $('#sumber_data').val(sumber_data)
        $('#keterangan').val(keterangan)


    }

    function reset_error(){
        $('#organisasi_no_error').html('')
        $('#indikator_sasaran_id_error').html('')
        $('#tahun_error').html('')
        $('#alasan_error').html('')
        $('#formulasi_error').html('')
        $('#sumber_data_error').html('')
        $('#tahun_filter_error').html('')
        $('#keterangan_error').html('')
    }

    function reset(){
        $('#form #organisasi_no').val('').change();
        $('#indikator_sasaran_id').val('').change();
        $('#form #tahun').val('').change();
        $('#alasan').val('');
        $('#formulasi').val('');
        $('#sumber_data').val('');
        $('#keterangan').val('');
    }

    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')

        fetch_organisasis()

    }

    function fetch_indikator_sasaran(organisasi_no){

        $.ajax({
            url: `{{ url('admin/iku/fetch-indikator_sasaran') }}`+'/'+organisasi_no,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih</option>';
                     $.each(res.isr, function(i, item){
                            output += '<option value="'+item.id+'">'+item.indikator_sasaran+'</option>';
                     });

                    $('#myModal #indikator_sasaran_id').html(output)
            }
        });
    }

    function fetch_organisasis(){

        $.ajax({
            url: `{{ url('admin/iku/fetch-organisasis') }}`,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih</option>';
                     $.each(res.organisasis, function(i, item){
                            output += '<option value="'+item.organisasi_no+'">'+item.organisasi_nama+'</option>';
                     });

                    $('#myModal #form #organisasi_no').html(output)
            }
        });
    }


</script>
@endsection
