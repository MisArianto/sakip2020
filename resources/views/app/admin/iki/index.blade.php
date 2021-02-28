@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._loading')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Indikator Kinerja Individu</h4>
            <button class="btn btn-primary btn-sm float-right" id="btn-tambah-iki"><i class="fa fa-plus"></i> Tambah</button>
        </div>

        <div class="card-body">
            <form id="form-filter" url="{{ url('admin/iki/get-pegawai')}}" class="mb-5">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="border p-2">
                            <legend class="w-auto">Cari Pegawai</legend>
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
              @include('app.admin.iki._table')
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->
    
<!-- inlcude modal -->
@include('app.admin.iki._modal')


<!-- include modal detail -->
@include('app.admin.iki._modalDetail')

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

        $(document).on('change', '#tahun', () => {
            $('#btn-update-iki').prop('disabled', false)
        })

        $(document).on('change', '#form #organisasi_no', function(){

            let organisasi_no = $(this).val() 

            fetch_pegawais_pimpinans(organisasi_no)

        })


        $(document).on('click', '.btn-tutup', () => {
            $('#load_body').html('')
            reset()
            reset_error()
            $('#pegawai_id').val('').change()
            $('#pimpinan_id').val('').change()
            $('#tahun').val('').change()

            $('#modal-loading-on').removeClass('layar')
            $('#modal-loading-off').addClass('layar')
        })

        $(document).on('click', '#btn-tambah-iki', function(){
            $('#myModal #modal-loading-on').removeClass('layar')
            $('#myModal #modal-loading-off').addClass('layar')

            $('#title-tambah').removeClass('layar')
            $('#title-edit').addClass('layar')
            $('#btn-simpan-iki').removeClass('layar')
            $('#btn-update-iki').addClass('layar')
            $('#id').addClass('layar')

            let tahun = $('#form-filter #tahun_filter').val()
            let organisasi_no = $('#form-filter #organisasi_no').val()
            $('#form #tahun_emit').val(tahun)
            $('#form #organisasi_no_emit').val(organisasi_no)


            $('#myModal .modal-footer .alert').addClass('layar')

            reset()
            reset_error()

            $('#myModal').modal('show')
            // fetch_pegawais_pimpinans()
            $('#myModal #modal-loading-on').addClass('layar')
            $('#myModal #modal-loading-off').removeClass('layar')
        })


        $(document).on('click', '#btn-simpan-iki',function(e){
            e.preventDefault()

            let token = {
                    "_token": $('#token').val()
                };

            let url = $('#form').attr('url')

            let form = $('#form').serialize()

            $.ajax({
                type: 'POST',
                url: url,
                data: form,
                headers: token,
                success: function(res){

                  let pegawais = res.pegawais

                  let output = ''

                     $.each(pegawais, function(i, item){
                        output += '<tr>';
                        output += '<td>'+parseInt(i+1)+'</td>';
                        output += '<td>';

                        output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailIki" url="{{ url('admin/iki/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                        output += '<button class="btn btn-info btn-sm" id="handleEditIki" url="{{ url('admin/iki/filter-iki') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" data-organisasi_no="'+item.organisasi_no+'" data-pegawai_id="'+item.pegawai_id+'" data-pimpinan_id="'+item.pimpinan_id+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                        output += '<button class="btn btn-danger btn-sm" id="handleDelete" data-id="'+item.id+'" url="{{ url('admin/iki/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
                        output += '</td>';
                        output += '<td>'+item.nama+'</td>';
                        output += '<td>'+item.jabatan+'</td>';

                        output += '</tr>'
                     });

                    $('#load').html(output);
                    // $('#loadingTable').addClass('layar')
                    // $('#load').removeClass('layar')

                    Toast.fire({
                        type: "success",
                        title: `Tambah data success`
                      });

                    reset()
                    reset_error()
                    $('#load_body').html('')

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


        $(document).on('click', '#handleEditIki', function(){
            longValueEdit($(this))

            $('#myModal #modal-loading-on').removeClass('layar')
            $('#myModal #modal-loading-off').addClass('layar')

            $('#title-tambah').addClass('layar')
            $('#title-edit').removeClass('layar')
            $('#btn-simpan-iki').addClass('layar')
            $('#btn-update-iki').removeClass('layar')
            $('#id').removeClass('layar')

            let url = $(this).attr('url')
            let id = $(this).data('id')

            let tahun_filter = $('#form-filter #tahun_filter').val()
             let organisasi_no = $('#form-filter #organisasi_no').val()
            $('#myModal #tahun_emit').val(tahun_filter)
            $('#form #organisasi_no_emit').val(organisasi_no)

            $('#myModal').modal('show')

            $.ajax({
                url: `${url}/${id}`,
                success: function(res)
                {

                    let table = ``


                    $.each(res.ikis, (i, item) => {
                    table += `

                        <tr id='row${item.id}${i}'>
                        <td>
                          <div class="btn-group"> 
                          <button type='button' name='edit' class='btn btn-info btnEdit' data-id="${item.id}" data-index="${i}" data-pegawai_id="${item.pegawai_id}" data-pimpinan_id="${item.pimpinan_id}" data-indikator_sasaran="${item.indikator_sasaran}" data-sasaran_strategis="${item.sasaran_strategis}" data-satuan_id="${item.satuan_id}" data-target="${item.target}" data-tahun="${item.tahun}" data-row='row${parseInt(i+1)}'>
                            <i class='fa fa-edit'></i>
                          </button>
                          <button type='button' id="handleDeleteIki" data-id="${item.id}" data-index="${i}" url="{{ url('admin/iki/destroy') }}" class='btn btn-danger' data-row='row${item.id}'>
                            <i class='fa fa-trash'></i>
                          </button>
                          </div>
                        </td>
                        <td>
                          <input type='text' class='form-control sasaran_strategis${i}' name='sasaran_strategis_array[]' id='sasaran_strategis_array_${parseInt(i+1)}[]' value='${item.sasaran_strategis}' readonly>
                          <input type='hidden' name='id_array[]' id='id_array_${parseInt(i+1)}[]' value='${item.id}'>
                        </td>
                        <td>
                          <input type='text' class='form-control indikator_sasaran${i}' name='indikator_sasaran_array[]' id='indikator_sasaran_array_${parseInt(i+1)}[]' value='${item.indikator_sasaran}' readonly>
                        </td>
                        <td>
                            <input type='text' class='form-control satuan_nama${i}' name='satuan_array[]' id='satuan_array_${parseInt(i+1)}[]' value='${item.satuan_nama}' readonly>
                            <input type='hidden' class='form-control satuan_id${i}' name='satuan_id_array[]' id='satuan_id_array_${parseInt(i+1)}[]' value='${item.satuan_id}' readonly>
                        </td>
                        <td>
                        <input type='text' class='form-control target${i}' name='target_array[]' id='target_array_${parseInt(i+1)}[]' value='${item.target}' readonly>
                        </td>
                        </tr>

                      `
                    })

                    // console.log(table)
                    $('#load_body').html(table);
                    $('#btn-update-iki').prop('disabled', true);
                    $('#form #pegawai_id').val(`${res.iki.pegawai_id}`).change()
                    $('#form #pimpinan_id').val(`${res.iki.pimpinan_id}`).change()
                    $('#form #tahun').val(`${res.iki.tahun}`).change()
                    reset();
                    reset_error();

                    $('#myModal .modal-footer .alert').addClass('layar')

                    $('#myModal #modal-loading-on').addClass('layar')
                    $('#myModal #modal-loading-off').removeClass('layar')

                    // $('#myModal').modal('show')
                }
            });



        })


        $(document).on('click', '.btnEdit', function(){
          let id = $(this).data('id')
          let index = $(this).data('index')
          let pegawai_id = $(this).data('pegawai_id')
          let pimpinan_id = $(this).data('pimpinan_id')
          let tahun = $(this).data('tahun')

          let sasaran_strategis = $(`#row${id}${index} .sasaran_strategis${index}`).val()
          let indikator_sasaran = $(`#row${id}${index} .indikator_sasaran${index}`).val()
          let satuan_id = $(`#row${id}${index} .satuan_id${index}`).val()
          let target = $(`#row${id}${index} .target${index}`).val()

          $('#myModal #form #id').val(id)
          $('#myModal #form #index').val(index)
          $('#pegawai_id').val(pegawai_id).change()
          $('#pimpinan_id').val(pimpinan_id).change()
          $('#myModal #tahun').val(tahun).change()
          $('#sasaran_strategis').val(sasaran_strategis)
          $('#indikator_sasaran').val(indikator_sasaran)
          $('#satuan_id').val(satuan_id).change()
          $('#target').val(target)

          $('#addIki').addClass('layar')
          $('#updateIki').removeClass('layar')
        })


        $(document).on('click', '#updateIki', (e) => {
          e.preventDefault()

            let delete_row = $('#form #id').val();
            let index = $('#form #index').val();

            let pegawai_id = $('#pegawai_id').val();
            let pimpinan_id = $('#pimpinan_id').val();
            let tahun = $('#tahun').val();
            let sasaran_strategis = $('#sasaran_strategis').val();
            let indikator_sasaran = $('#indikator_sasaran').val();
            let satuan_id = $('#satuan_id').val();
            let satuan_nama = $('#satuan_id option:selected').attr('satuan_nama');
            let target = $('#target').val();

            $(`#form #row${delete_row}${index} .sasaran_strategis${index}`).val(sasaran_strategis)
            $(`#form #row${delete_row}${index} .indikator_sasaran${index}`).val(indikator_sasaran)
            $(`#form #row${delete_row}${index} .satuan_id${index}`).val(satuan_id)
            $(`#form #row${delete_row}${index} .satuan_nama${index}`).val(satuan_nama)
            $(`#form #row${delete_row}${index} .target${index}`).val(target)

           
            $('#addIki').removeClass('layar')
            $('#updateIki').addClass('layar')
            $('#btn-update-iki').prop('disabled', false);
            reset()

            $('#myModal .modal-footer .alert').removeClass('layar')
        })

        $(document).on('click', '#btn-update-iki', function(e){
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

                let pegawais = res.pegawais

                let output = ''

                 $.each(pegawais, function(i, item){
                    output += '<tr>';
                    output += '<td>'+parseInt(i+1)+'</td>';
                    output += '<td>';

                    output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailIki" url="{{ url('admin/iki/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                    output += '<button class="btn btn-info btn-sm" id="handleEditIki" url="{{ url('admin/iki/filter-iki') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" data-organisasi_no="'+item.organisasi_no+'" data-pegawai_id="'+item.pegawai_id+'" data-pimpinan_id="'+item.pimpinan_id+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                    output += '<button class="btn btn-danger btn-sm" id="handleDelete" data-id="'+item.id+'" url="{{ url('admin/iki/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
                    output += '</td>';
                    output += '<td>'+item.nama+'</td>';
                    output += '<td>'+item.jabatan+'</td>';

                    output += '</tr>'
                 });

                    $('#load').html(output);
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


        $(document).on('click', '#handleDeleteIki', function(){
        let id = $(this).data('id')
        let index = $(this).data('index')
        let url = $(this).attr('url')
        let delete_row = $(this).data("row");

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
                    type: 'GET',
                    url: `${url}/${id}`,
                    success: function(res){
                         $(`#row${id}${index}`).remove()

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


        $(document).on('click', '#handleDeleteUtama', function(){
            let id = $(this).data('id')
            let url = $(this).attr('url')

            let organisasi_no = $('#form-filter #organisasi_no').val()
            let tahun = $('#form-filter #tahun_filter').val()

            let obj = {
                'id': id,
                'organisasi_no': organisasi_no,
                'tahun': tahun
            }

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
                        success: function(res){

                            let pegawais = res.pegawais

                              let output = ''

                                 $.each(pegawais, function(i, item){
                                    output += '<tr>';
                                    output += '<td>'+parseInt(i+1)+'</td>';
                                    output += '<td>';

                                    output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailIki" url="{{ url('admin/iki/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                                    output += '<button class="btn btn-info btn-sm" id="handleEditIki" url="{{ url('admin/iki/filter-iki') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                                    output += '<button class="btn btn-danger btn-sm" id="handleDelete" data-id="'+item.id+'" url="{{ url('admin/iki/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
                                    output += '</td>';
                                    output += '<td>'+item.nama+'</td>';
                                    output += '<td>'+item.jabatan+'</td>';

                                    output += '</tr>'
                                 });

                                $('#load').html(output);


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


        $(document).on('click', '#handleDetailIki', function(){

          let id = $(this).data('id')
          let url = $(this).attr('url')

          // console.log(`${url}/${id}`)
            $('#myModalDetail #modal-loading-on').removeClass('layar')
            $('#myModalDetail #modal-loading-off').addClass('layar')
            $('#myModalDetail').modal('show')

          $.ajax({
                url: `${url}/${id}`,
                success: function(res)
                {

                    let pimpinan = res.pimpinan
                    let pegawai = res.pegawai
                    let ikis = res.ikis

                    let output = ``

                        output += `
                         <tr>
                            <td style="font-weight: bold;">Nama Pegawai</td>
                            <td style="font-weight: bold;">:</td>
                            <td>${pegawai ? pegawai.nama : ''}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Jabatan</td>
                            <td style="font-weight: bold;">:</td>
                            <td>${pegawai ? pegawai.jabatan : ''}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Nama Pimpinan</td>
                            <td style="font-weight: bold;">:</td>
                            <td>${pimpinan ? pimpinan.nama : ''}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Jabatan Pimpinan</td>
                            <td style="font-weight: bold;">:</td>
                            <td>${pimpinan ? pimpinan.jabatan : ''}</td>
                        </tr>
                        `

                    let output2 = ``

                        $.each(ikis, (i, item) => {
                        output2 += `
                          <tr>
                            <td style="text-align: center;">${parseInt(i+1)}</td>
                            <td>${ item.sasaran_strategis }</td>
                            <td>${item.indikator_sasaran}</td>
                            <td>${item.satuan_nama}</td>
                            <td>${item.target}</td>
                        </tr>
                        `
                      })

                    $('#load_pegawai_pimpinan').html(output);
                    $('#load_iki').html(output2);
                    $('#myModalDetail #modal-loading-on').addClass('layar')
                    $('#myModalDetail #modal-loading-off').removeClass('layar')

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


         $(document).on('click', '.remove' ,function(){
          var delete_row = $(this).data("row");
          $('#' + delete_row).remove();

          $('#btn-update-iki').prop('disabled', false);
        });

        $('#btn-simpan-iki').prop('disabled', true);


        var count=1;
        $(document).on('click', '#addIki',function(e){
          e.preventDefault();

          let sasaran_strategis = $('#sasaran_strategis').val();
          let indikator_sasaran = $('#indikator_sasaran').val();

          let satuan_id = $('#satuan_id').val();
          let satuan_nama = $('#satuan_id option:selected').attr('satuan_nama');

          let target = $('#target').val();

          if(sasaran_strategis === '')
          {
            $('#sasaran_strategis_error').html('Sasaran Strategi Wajib di isi')
          }else if(indikator_sasaran === '')
          {
            $('#indikator_sasaran_error').html('Indikator Sasaran Wajib di isi')
          }else if(satuan_id === '')
          {
            $('#satuan_id_error').html('Satuan Wajib di isi')
          }else if(target === '')
          {
            $('#target_error').html('Target Wajib di isi')

          }else if(sasaran_strategis != '' && indikator_sasaran != '' && satuan_id != '' && target != ''){

          count = count + 1;

          let table = "<tr id='row"+count+"'>";
              table += "<td><button type='button' name='remove' class='btn btn-danger remove' data-row='row"+count+"'><i class='fa fa-minus'></i></button></td>";
              table += "<td><input type='text' class='form-control' name='sasaran_strategis_array[]' id='sasaran_strategis_array[]' value='"+sasaran_strategis+"' readonly><input type='hidden' name='id_array[]' id='id_array[]' value='row"+count+"'></td>";
              table += "<td><input type='text' class='form-control' name='indikator_sasaran_array[]' id='indikator_sasaran_array[]' value='"+indikator_sasaran+"' readonly></td>";
              table += "<td><input type='hidden' class='form-control' name='satuan_id_array[]' id='satuan_id_array[]' value='"+satuan_id+"' readonly><input type='text' class='form-control' name='satuan_nama_array[]' id='satuan_nama_array[]' value='"+satuan_nama+"' readonly></td>";
              table += "<td><input type='text' class='form-control' name='target_array[]' id='target_array[]' value='"+target+"' readonly></td>";
              table += "</tr>";

                  $('#load_body').prepend(table);
                  $('#btn-simpan-iki').prop('disabled', false);
                  $('#btn-update-iki').prop('disabled', false);
                  reset_detail();
                  reset_error()
            }else{
              $('#sasaran_strategis_error').html('')
              $('#indikator_sasaran_error').html('')
              $('#satuan_id_error').html('')
              $('#target_error').html('')
            }
        });


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

                    let output = ''

                     $.each(res.pegawais, function(i, item){
                        output += '<tr>';
                        output += '<td>'+parseInt(i+1)+'</td>';
                        output += '<td>';

                        output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailIki" url="{{ url('admin/iki/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                        output += '<button class="btn btn-info btn-sm" id="handleEditIki" url="{{ url('admin/iki/filter-iki') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" data-organisasi_no="'+item.organisasi_no+'" data-pegawai_id="'+item.pegawai_id+'" data-pimpinan_id="'+item.pimpinan_id+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                        output += '<button class="btn btn-danger btn-sm" id="handleDeleteUtama" data-id="'+item.pegawai_id+'" url="{{ url('admin/iki/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
                        output += '</td>';
                        output += '<td>'+item.nama+'</td>';
                        output += '<td>'+item.jabatan+'</td>';

                        output += '</tr>'
                     });

                    $('#load').html(output);
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

    })
    // end ready function

    function longValueEdit(value){
        let id = value.data('id')
        let organisasi_no = value.data('organisasi_no')
        let pegawai_id = value.data('pegawai_id')
        let pimpinan_id = value.data('pimpinan_id')
        let tahun = value.data('tahun')

        $('#id').val(id)
        $('#form #organisasi_no').val(organisasi_no).change()
        $('#form #pegawai_id').val(pegawai_id).change()
        $('#form #pimpinan_id').val(pimpinan_id).change()
        $('#tahun').val(tahun)
    }

    function reset_error(){
        $('#organisasi_no_error').html('')
        $('#pegawai_id_error').html('')
        $('#pimpinan_id_error').html('')
        $('#tahun_error').html('')
        $('#nama_error').html('')
        $('#jabatan_error').html('')
        $('#tahun_filter_error').html('')
        $('#sasaran_strategis_error').html('');
        $('#indikator_sasaran_error').html('');
        $('#satuan_id_error').html('');
        $('#target_error').html('');
    }

    function reset(){
        $('#form #organisasi_no').val('').change()
        $('#pegawai_id').val('').change()
        $('#pimpinan_id').val('').change()
        $('#form #tahun').val('').change()
        $('#sasaran_strategis').val('');
        $('#indikator_sasaran').val('');
        $('#satuan_id').val('').change();
        $('#satuan_nama').val('');
        $('#target').val('');
    }

    function reset_detail(){
        $('#sasaran_strategis').val('');
        $('#indikator_sasaran').val('');
        $('#satuan_id').val('').change();
        $('#satuan_nama').val('');
        $('#target').val('');
    }

    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')

        fetch_satuans()
        fetch_organisasi()

    }

    function fetch_pegawais_pimpinans(organisasi_no){
        // $('#myModal #modal-loading-on').removeClass('layar')
        // $('#myModal #modal-loading-off').addClass('layar')

        $.ajax({
            type: 'GET',
            url: '{{ url("admin/iki/fetch-pegawai-pimpinan") }}'+'/'+organisasi_no,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih Pegawai</option>';
                     $.each(res.pegawais_pimpinans, function(i, item){
                            output += '<option value="'+item.id+'">'+item.nama+'</option>';
                     });

                let output2 = '';
                    output2 += '<option value="">Pilih Pimpinan</option>';
                     $.each(res.pegawais_pimpinans, function(i, item){
                            output2 += '<option value="'+item.id+'">'+item.nama+'</option>';
                     });

                    $('#pegawai_id').html(output)
                    $('#pimpinan_id').html(output2)
                    // $('#myModal #modal-loading-on').addClass('layar')
                    // $('#myModal #modal-loading-off').removeClass('layar')
            }
        });
    }


    function fetch_satuans(){
        $('#myModal #modal-loading-on').removeClass('layar')
        $('#myModal #modal-loading-off').addClass('layar')

        $.ajax({
            type: 'GET',
            url: `{{ url('admin/iki/fetch-satuan') }}`,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih Satuan</option>';
                     $.each(res.satuans, function(i, item){
                            output += '<option satuan_nama="'+item.satuan_nama+'" value="'+item.id+'">'+item.satuan_nama+'</option>';
                     });

                    $('#myModal #satuan_id').html(output)
                    $('#myModal #modal-loading-on').addClass('layar')
                    $('#myModal #modal-loading-off').removeClass('layar')
            }
        });
    }

    function fetch_organisasi(){
        $.ajax({
            url: `{{ url('admin/iki/fetch-organisasi') }}`,
            dataType: 'json',
            success: function(res)
            {

                let output = '';
                    output += '<option value="">Pilih Organisasi</option>';
                     $.each(res.organisasis, function(i, item){
                            output += '<option value="'+item.organisasi_no+'">'+item.organisasi_nama+'</option>';
                     });

                    $('#form #organisasi_no').html(output)
                    $('#modal-loading-on').addClass('layar')
                    $('#modal-loading-off').removeClass('layar')
            }
        });
    }



</script>
@endsection
