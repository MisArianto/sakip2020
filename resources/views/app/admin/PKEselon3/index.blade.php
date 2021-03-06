@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Perjanjian Kinerja Eselon III</h4>
            <button class="btn btn-primary btn-sm float-right" id="btn-tambah-pk"><i class="fa fa-plus"></i> Tambah</button>
        </div>

        <div class="card-body">
            <form id="form-filter" url="{{ url('admin/perjanjian-kinerja/eselon-3/fetch')}}" class="mb-5">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="border p-2">
                            <legend class="w-auto">Cari PK</legend>
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
              @include('app.admin.PKEselon3._table')
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->
    
<!-- inlcude modal -->
@include('app.admin.PKEselon3._modal')

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

        $(document).on('click', '.btn-tutup', function(){
            reset_error()
        })

        $(document).on('click', '.close', function(){
            reset_error()
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

        $(document).on('click', '#btn-tambah-pk', function(){
	        $('#title-tambah').removeClass('layar')
	        $('#title-edit').addClass('layar')
	        $('#btn-simpan').removeClass('layar')
	        $('#btn-simpan-pk').removeClass('layar')
	        $('#btn-simpan-iku').removeClass('layar')
	        $('#btn-update').addClass('layar')
	        $('#btn-update-pk').addClass('layar')
	        $('#btn-update-iku').addClass('layar')
	        $('#id').addClass('layar')

	        reset()

	        $('#myModal').modal('show')

	        // melempar id tahun yang sudah di pilih keuntuk parameter yang di edit
	        let tahun_filter = $('#form-filter #tahun_filter').val()
	        $('#form #tahun_emit').val(tahun_filter)
	    })


        $(document).on('click', '#btn-simpan-pk',function(e){
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

                    if(res === 'warning')
                    {
                        Toast.fire({
                            type: "warning",
                            title: 'Data sudah ada!!'
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


        $(document).on('click', '#btn-update-pk', function(e){
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

                    if(res === 'warning')
                    {
                        Toast.fire({
                            type: "warning",
                            title: 'Data sudah ada!!'
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


        $(document).on('click', '#handleDeletePk', function(){
	        let id = $(this).data('id')
	        let url = $(this).attr('url')
	        let delete_row = $(this).data("row");

	        let form = $('#form-filter').serialize()

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
	                    url: '{{ url("admin/perjanjian-kinerja/eselon-3/destroy") }}'+'/'+id,
	                    data: form,
	                    headers: token,
	                    success: function(res){

	                         $('#load').html(res);

	                         Toast.fire({
	                            type: "success",
	                            title: `Delete Success`
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
	            }
	          });
	    })

    })
    // end ready function

    function longValueEdit(value){
        let id = value.data('id')
        let organisasi_no = value.data('organisasi_no')
        let sasaran = value.data('sasaran')
        let indikator_sasaran = value.data('indikator_sasaran')
        let program_no = value.data('program_no')
        let jabatan_id = value.data('jabatan_id')
        let satuan_id = value.data('satuan_id')
        let tahun = value.data('tahun')
        let target = value.data('target')
        let pagu = value.data('pagu')

        $('#id').val(id)
        $('#form #organisasi_no').val(organisasi_no).change()
        $('#sasaran').val(sasaran)
        $('#indikator_sasaran').val(indikator_sasaran)
        $('#program_no').val(program_no).change()
        $('#jabatan_id').val(jabatan_id).change()
        $('#satuan_id').val(satuan_id).change()
        $('#tahun').val(tahun).change()
        $('#target').val(target)
        $('#pagu').val(pagu)


        // melempar id tahun yang sudah di pilih keuntuk parameter yang di edit
        let tahun_filter = $('#form-filter #tahun_filter').val()
        let organisasi_no_emit = $('#form-filter #organisasi_no').val()
        $('#form #tahun_emit').val(tahun_filter)
        $('#form #organisasi_no_emit').val(organisasi_no_emit)
    }

    function reset_error(){
        $('#form #organisasi_no_error').html('')
        $('#sasaran_error').html('')
        $('#indikator_sasaran_error').html('')
        $('#program_no_error').html('')
        $('#jabatan_id_error').html('')
        $('#satuan_id_error').html('')
        $('#tahun_error').html('')
        $('#target_error').html('')
        $('#pagu_error').html('')
    }

    function reset(){
        $('#form #organisasi_no').val('').change();
        $('#sasaran').val('').change();
        $('#indikator_sasaran').val('').change();
        $('#program_no').val('').change();
        $('#jabatan_id').val('').change();
        $('#satuan_id').val('').change();
        $('#tahun').val('').change();
        $('#target').val('');
        $('#pagu').val('');
    }

    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')

        fetch_program()
        fetch_jabatan()
        fetch_satuan()
    }


    function fetch_program(){
        $('#myModal #modal-loading-on').removeClass('layar')
        $('#myModal #modal-loading-off').addClass('layar')

        $.ajax({
            url: `{{ url('admin/perjanjian-kinerja/eselon-3/fetch-program') }}`,
            dataType: 'json',
            success: function(res)
            {
                console.log(res)
                let output = '';
                    output += '<option value="">Pilih</option>';
                     $.each(res.programs, function(i, item){
                            output += '<option value="'+item.program_no+'">'+item.program_nama+'</option>';
                     });

                    $('#myModal #program_no').html(output)
                    $('#myModal #modal-loading-on').addClass('layar')
                    $('#myModal #modal-loading-off').removeClass('layar')
            }
        });
    }


    function fetch_jabatan(){
        $('#myModal #modal-loading-on').removeClass('layar')
        $('#myModal #modal-loading-off').addClass('layar')

        $.ajax({
            url: `{{ url('admin/perjanjian-kinerja/eselon-3/fetch-jabatan') }}`,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih</option>';
                     $.each(res.jabatans, function(i, item){
                            output += '<option value="'+item.id+'">'+item.jabatan_nama+'</option>';
                     });

                    $('#myModal #jabatan_id').html(output)
                    $('#myModal #modal-loading-on').addClass('layar')
                    $('#myModal #modal-loading-off').removeClass('layar')
            }
        });
    }

    function fetch_satuan(){
        $('#myModal #modal-loading-on').removeClass('layar')
        $('#myModal #modal-loading-off').addClass('layar')

        $.ajax({
            url: `{{ url('admin/perjanjian-kinerja/eselon-3/fetch-satuan') }}`,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih</option>';
                     $.each(res.satuans, function(i, item){
                            output += '<option value="'+item.id+'">'+item.satuan_nama+'</option>';
                     });

                    $('#myModal #satuan_id').html(output)
                    $('#myModal #modal-loading-on').addClass('layar')
                    $('#myModal #modal-loading-off').removeClass('layar')
            }
        });
    }


</script>
@endsection
