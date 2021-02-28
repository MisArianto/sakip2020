@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
    	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Upload Cascading</h4>
            <!-- <button class="btn btn-primary btn-sm float-right" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button> -->
        </div>
        <div class="card-body">
            <form id="form-filter" url="{{ url('user/cascading/fetch')}}" class="mb-5">
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
              <div class="col-md-4">
                  <fieldset class="border p-2">
                    <legend class="w-auto">Upload File</legend>
                      <form id="form" action="{{ url('user/cascading/store') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                            <div class="form-group">
                              <label for="tahun" class="control-label">Tahun</label>
                              <select name="tahun" id="tahun" class="form-control form-control-sm {{ $errors->has('tahun') ? ' is-invalid' : '' }}">
                                <option value="">Pilih</option>
                                <option value="2021">2021</option>
                              </select>
                              @if($errors->has('tahun'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('tahun') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                              <label for="tahun" class="control-label">Keterangan</label>
                              <select name="keterangan" id="keterangan" class="form-control form-control-sm {{ $errors->has('keterangan') ? ' is-invalid' : '' }}">
                                  <option value="">Pilih</option>
                                  <option value="pohon kinerja rpjmd">Pohon Kinerja RPJMD</option>
                                  <option value="cross cutting">Cross Cutting</option>
                              </select>
                              @if($errors->has('keterangan'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('keterangan') }}</strong>
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

<!-- 
                            <div class="form-group" id="form-group">
                                <label>Upload File</label>
                                <div class="uploader">

                                  <div id="caption">
                                    <i id="icon" class="mdi mdi-cloud-upload"></i>
                                    <p>Pilih File Anda di Sini</p>
                                    <div class="file-input">
                                      <label for="file" class="label">Pilih File</label>
                                      <input type="file" id="file" name="file" class="input" onchange="onInputChange(event)">
                                    </div>
                                  </div>

                                  <div class="layar" id="images-preview">
                                    <div class="images-preview">
                                      <div class="img-wrapper">
                                        <div class="close" id="close">x</div>
                                        <img src="{{ asset('img/gambar_pdf.png') }}" height="200px" width="200px" alt="Image Uploader">
                                        <input type="hidden" id="img_file" name="img_file">
                                        <div class="details">
                                          <span class="name" id="name_img"></span>
                                          <span class="size" id="size_img"></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <span class="text-danger">
                                      <strong id="file_error"></strong>
                                  </span>
                              </div> -->

                            <button
                              type="submit"
                              class="btn btn-info"
                            >Save</button>

                        </form>
                  </fieldset>
              </div>
              <div class="col-md-8">
                  <fieldset class="border p-2">
                    <legend class="w-auto">List Data</legend>
                      @include('app.user.cascading._table')
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
<!-- @include('app.user.cascading._modal') -->

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

                  $.each(res.cascadings, function(i, item){
                      output += `
                        <tr>
                          <td>${item.nama_file}</td>
                          <td>${item.tahun}</td>
                          <td>${item.keterangan}</td>
                          <td>
                              <div class="btn-group">
                                  <button class="btn btn-danger btn-sm" id="handleDelete" data-id="${item.id}" data-url="{{ url('user/cascading/destroy') }}">
                                      <i class="fa fa-trash"></i>
                                  </button>
                                  <a href="{{ url('user/cascading/download/${item.id}') }}" class="btn btn-info btn-sm">
                                      <i class="fa fa-download"></i>
                                  </a>
                              </div>  
                          </td>
                      </tr>
                      `
                    })

                $('#load').html(output)
                    // console.log(res)
                    // $('#load').html(res);
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

                              $.each(res.cascadings, function(i, item){
                                  output += `
                                    <tr>
                                      <td>${item.nama_file}</td>
                                      <td>${item.tahun}</td>
                                      <td>${item.keterangan}</td>
                                      <td>
                                          <div class="btn-group">
                                              <button class="btn btn-danger btn-sm" id="handleDelete" data-id="${item.id}" data-url="{{ url('user/cascading/destroy') }}">
                                                  <i class="fa fa-trash"></i>
                                              </button>
                                              <a href="{{ url('user/cascading/download/${item.id}') }}" class="btn btn-info btn-sm">
                                                  <i class="fa fa-download"></i>
                                              </a>
                                          </div>  
                                      </td>
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


        $(document).on('click', '#btn-simpan-cascading', function(e){
            e.preventDefault()
            let url = $('#form').attr('url')

            let tahun_filter = $('#form-filter #tahun_filter').val()
            let tahun = $('#form #tahun').val()
            let file = $('#form #img_file').val()
            let keterangan = $('#form #keterangan').val()

            let obj = {
            	'tahun_filter' : tahun_filter,
            	'tahun' : tahun,
            	'file' : file,
              'keterangan' : file,
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
        $('#keterangan_error').html('')
    }

    function reset(){
        $('#file').val('')
        $('#tahun').val('')
        $('#keterangan').val('')
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
