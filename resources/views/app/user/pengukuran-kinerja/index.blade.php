@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Data Pengukuran Kinerja</h4>
            <form id="form-cetak" action="{{ url('user/pengukuran-kinerja/cetak') }}" method="POST">
                @csrf
                <input type="hidden" name="tahun" id="tahun-cetak">
                
                <button class="btn btn-danger layar" id="cetak" title="Cetak PDF">
                    <i class="fas fa-file-pdf"></i>
                </button>
                
            </form>
        </div>
        <div class="card-body">
            <form id="form-filter" url="{{ url('user/pengukuran-kinerja/fetch')}}" class="mb-5">
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
              @include('app.user.pengukuran-kinerja._table')
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->
    
<!-- inlcude modal -->
@include('app.user.pengukuran-kinerja._modal')
@include('app.user.pengukuran-kinerja._modalDetail')
@include('app.user.pengukuran-kinerja._modalDetailAll')

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

                    $('#cetak').removeClass('layar')
                    $('#tahun-cetak').val(tahun)

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


        $(document).on('click', '#btn-update-pk', function(e){
            e.preventDefault()
            let id = $('#id').val()
            let url = $('#form').attr('urlUpdate')

            console.log(`${url}/${id}`)

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


        $(document).on('click', '#handleEditCapaian', function() {
            let id = $(this).data('id_tw')
            let target = $(this).data('target')
            let kinerja = $(this).data('kinerja')
            let anggaran = $(this).data('anggaran')
            let rekomendasi = $(this).data('rekomendasi')
            let name = $(this).data('name')
            let name_detail = $(this).data('name_detail')

            let tahun_filter = $('#form-filter #tahun_filter').val()
            $('#form #tahun_emit').val(tahun_filter)

            $('#id').val(id)
            $('#target').val(target)
            $('#kinerja').val(kinerja)
            $('#anggaran').val(anggaran)
            $('#rekomendasi').val(rekomendasi)
            $('#name').val(name)
            $('#myModal #title').html(`Edit ${name_detail}`)

            $('#myModal').modal('show')
        })

        $(document).on('click', '#handleDetailCapaian', function() {
            let indikator_sasaran = $(this).data('indikator_sasaran')
            let target = $(this).data('target')
            let kinerja = $(this).data('kinerja')
            let anggaran = $(this).data('anggaran')
            let rekomendasi = $(this).data('rekomendasi')
            let name = $(this).data('name')
            let name_detail = $(this).data('name_detail')

            let output = ``


            output += `

                <tr>
                    <td>Indikator Sasaran</td>
                    <td>:</td>
                    <td>${indikator_sasaran}</td>
                </tr>
                <tr>
                    <td>Target</td>
                    <td>:</td>
                    <td>${target}</td>
                </tr>
                <tr>
                    <td>Kinerja</td>
                    <td>:</td>
                    <td>${kinerja}</td>
                </tr>
                <tr>
                    <td>Anggaran</td>
                    <td>:</td>
                    <td>${anggaran}</td>
                </tr>
                <tr>
                    <td>Rekomendasi</td>
                    <td>:</td>
                    <td>${rekomendasi}</td>
                </tr>

            `

            $('#myModalDetail #load_detail').html(output)
            $('#myModalDetail #title').html(`Detail ${name_detail}`)


            $('#myModalDetail').modal('show')
        })


        $(document).on('click', '#handleDetailCapaianAll', function(){
            let indikator_sasaran_id = $(this).data('indikator_sasaran_id')
            let organisasi_no = $('#form-filter #organisasi_no').val()
            let tahun = $('#form-filter #tahun_filter').val()

            let obj = {
                'indikator_sasaran_id' : indikator_sasaran_id,
                'organisasi_no' : organisasi_no,
                'tahun' : tahun
            }

            let token = {
                    "_token": $('#token').val()
                };

            $.ajax({
                type: 'POST',
                url: '{{ url("user/pengukuran-kinerja/detail") }}',
                data: obj,
                headers: token,
                success: function(res){

                        console.log(res.detail)
                        $('#myModalDetailAll #load_detail_all').html(res.detail)
                        $('#myModalDetailAll').modal('show')
                        
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
    

    // end ready function
    function longValueEdit(value){
        let id = value.data('id')
        let target = value.data('target')
        let kinerja = value.data('kinerja')
        let anggaran = value.data('anggaran')
        let rekomendasi = value.data('rekomendasi')

        $('#id').val(id)
        $('#target').val(target)
        $('#kinerja').val(kinerja)
        $('#anggaran').val(anggaran)
        $('#rekomendasi').val(rekomendasi)

        // melempar id tahun yang sudah di pilih keuntuk parameter yang di edit
        let tahun_filter = $('#form-filter #tahun_filter').val()
        $('#form #tahun_emit').val(tahun_filter)
    }

    function reset_error(){
        $('#target_error').html('')
        $('#kinerja_error').html('')
        $('#anggaran_error').html('')
        $('#rekomendasi_error').html('')
    }

    function reset(){
        $('#target').val('')
        $('#kinerja').val('')
        $('#anggaran').val('')
        $('#rekomendasi').val('')
    }

    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')
    }


</script>
@endsection
