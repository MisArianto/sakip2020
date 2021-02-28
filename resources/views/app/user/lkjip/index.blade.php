@extends('layouts.template')


<!-- @section('style')

    <style rel="stylesheet">

        #form-group .uploader .file-input .label{
            background: #2196F3;
            color: #fff;
          }

      #form-group .uploader #icon {
          font-size: 85px;
        }

        #form-group .uploader #caption .file-input .input{
            opacity: 0;
            z-index: -2;
          }

          #form-group .uploader #caption .file-input .label, .input {
            background: #fff;
            color: #2196F3;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            padding: 10px;
            border-radius: 4px;
            margin-top: 7px;
            cursor: pointer;
          }

          #form-group .uploader .file-input {
          width:200px;
          margin:auto;
          height: 68px;
          position: relative;
        }

      #form-group .uploader{
        width:100%;
        background:#2196F3;
        color:#fff;
        padding:40px 15px;
        text-align:center;
        border-radius:10px;
        border:3px dashed #fff;
        font-size:20px;
        position: relative;
      }

      #form-group .images-preview .close{
          position: absolute;
          border-radius: 10px;
          background: white;
          cursor: pointer;
          padding-top: 0px;
          padding-bottom: 0px;
          padding-right: 5px;
          padding-left: 5px;
      }

      #form-group .images-preview .img-wrapper{
          width:  200px;
          display: flex;
          flex-direction: column;
          margin:10px;
          height: 200px;
          justify-content:space-between;
          background: #fff;
          box-shadow: 5px 5px 20px #3e3737;
        }

        #form-group .images-preview .details .name{
            overflow: hidden;
            height: 18px;
          }

        #form-group .images-preview .details{
          font-size: 12px;
          background: #fff;
          color: #000;
          display: flex;
          flex-direction: column;
          align-item: self-start;
          padding: 3px 6px;
        }

      #form-group .images-preview{
        display: flex;
        flex-wrap: wrap;
        /*margin-top: 20px;*/
      }

    </style>

@endsection -->

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
    	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Laporan Kinerja Instansi Pemerintah</h4>
            <!-- <button class="btn btn-primary btn-sm float-right" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button> -->
        </div>
        <div class="card-body">
            <form id="form-filter" url="{{ url('user/lkjip/fetch')}}" class="mb-5">
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

            @if ($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
              </div>
            @endif

            <div class="row">
              <div class="col-md-6">
                  <fieldset class="border p-2">
                    <legend class="w-auto">Upload File</legend>
                      <form id="form" action="{{ url('user/lkjip/store') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                            <div class="form-group">
                              <label for="tahun" class="control-label">Tahun</label>
                              <select name="tahun" class="form-control form-control-sm {{ $errors->has('tahun') ? ' is-invalid' : '' }}">
                                <option value="">Pilih</option>
                                <option value="2021">2021</option>
                              </select>
                               @if ($errors->has('tahun'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('tahun') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                              <label for="file" class="control-label">File</label>
                              <input type="file" name="file" class="form-control form-control-sm {{ $errors->has('file') ? ' is-invalid' : '' }}">
                              @if ($errors->has('file'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>  

                            <button
                              type="submit"
                              class="btn btn-info"
                            >Save</button>

                        </form>
                  </fieldset>
              </div>
              <div class="col-md-6">
                  <fieldset class="border p-2">
                    <legend class="w-auto">List Data</legend>
                    @include('app.user.lkjip._table')
                  </fieldset>
              </div>
            </div>

            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->
    
<!-- inlcude modal -->

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

        $(document).on('click', '#close', function(){

            $('#caption').removeClass('layar')
            $('#images-preview').addClass('layar')
        })


        $(document).on('click', '#handleDelete', function(){
            let id = $(this).data('id')
            let tahun = $('#form-filter #tahun_filter').val()
            let url = $(this).data('url')

            let obj = {
              'tahun' : tahun 
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
                        url: `${url}/${id}`,
                        data: obj,
                        headers: token,
                        success: function(res){
                             Toast.fire({
                                type: "success",
                                title: `Delete Success`
                              });

                             let output = ``

                              $.each(res.lkjips, function(i, item){
                                  output += `
                                    <tr>
                                      <td>
                                        <div class="btn-group">
                                          <button class="btn btn-danger btn-sm" id="handleDelete" data-id="${item.id}" data-url="{{ url('user/lkjip/destroy') }}">
                                            <i class="fa fa-trash"></i>
                                          </button>
                                           <a href="{{ url('user/lkjip/download/${item.id}') }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-download"></i>
                                          </a>
                                        </div>
                                      </td>
                                      <td>${item.nama_file}</td>
                                      <td>${item.tahun}</td>
                                    </tr>
                                  `
                                })

                            $('#load').html(output)

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

                    let output = ``

                      $.each(res.lkjips, function(i, item){
                          output += `
                            <tr>
                              <td>
                                <div class="btn-group">
                                  <button class="btn btn-danger btn-sm" id="handleDelete" data-id="${item.id}" data-url="{{ url('user/lkjip/destroy') }}">
                                    <i class="fa fa-trash"></i>
                                  </button>
                                   <a href="{{ url('user/lkjip/download/${item.id}') }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-download"></i>
                                  </a>
                                </div>
                              </td>
                              <td>${item.nama_file}</td>
                              <td>${item.tahun}</td>
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
            });
          
        })


        $(document).on('click', '#btn-simpan-lkjip', function(e){
            e.preventDefault()
            let url = $('#form').attr('url')

            let tahun_filter = $('#form-filter #tahun_filter').val()
            let tahun = $('#form #tahun').val()
            let file2 = $('#form #file').val()
            let file = $('#form #img_file').val()

            let obj = {
            	'tahun_filter' : tahun_filter,
            	'tahun' : tahun,
            	'file' : file,
              'file2' : file2
            }

            let token = {
                    "_token": $('#token').val()
                };

            $.ajax({
                type: 'POST',
                url: `${url}`,
                data: obj,
                headers: token,
                success: function(res){

                  console.log(res)

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
        $('#file_error').html('')
        $('#tahun_error').html('')
    }

    function reset(){
        $('#file').val('')
        $('#tahun').val('')
    }

    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')
    }

    function onInputChange(e)
    {
        let file = e.target.files[0]

        if(!file.type.match('application/pdf.*')){
            Toast.fire({
                  type: "error",
                  title: "Oopss...",
                  text: `${file.name} bukan File PDF`
                });
            return
          }

        let reader = new FileReader()
        reader.onload = () => {
        	$('#img_file').val(reader.result)
            $('#name_img').html(file.name)
            $('#size_img').html(file.size)

            $('#caption').addClass('layar')
            $('#images-preview').removeClass('layar')
        }
        reader.readAsDataURL(file);
    }


</script>
@endsection
