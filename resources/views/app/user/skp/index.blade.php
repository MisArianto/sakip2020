@extends('layouts.template')

@section('content')

<div class="text-center" id="loading-on">
    @include('layouts._spinner')
</div>

<div class="layar" id="loading-off">
    <div class="card card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Sasaran Kerja Pegawai</h4>
            <button class="btn btn-primary btn-sm float-right" id="btn-tambah-skp"><i class="fa fa-plus"></i> Tambah</button>
        </div>

        <div class="card-body">
            <form id="form-filter" url="{{ url('user/skp/get-pegawai')}}" class="mb-5">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="border p-2">
                            <legend class="w-auto">Cari Pegawai</legend>
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
              @include('app.user.skp._table')
            </div>

        </div> 
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end loading -->
    
<!-- inlcude modal -->
@include('app.user.skp._modal')


<!-- include modal detail -->
@include('app.user.skp._modalDetail')

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
            $('#btn-update-skp').prop('disabled', false)
        })

        // $(document).on('change', '#pegawai_id', () => {
        //   $('#btn-update-skp').prop('disabled', false)
        // })

        // $(document).on('change', '#pejabat_id', () => {
        //   $('#btn-update-skp').prop('disabled', false)
        // })

        // $(document).on('change', '#tahun', () => {
        //   $('#btn-update-skp').prop('disabled', false)
        // })

        $(document).on('click', '.btn-tutup', () => {
            $('#load_body').html('')
            reset()
            reset_error()
            $('#pegawai_id').val('').change()
            $('#pejabat_id').val('').change()
            $('#tahun').val('').change()

            $('#modal-loading-on').removeClass('layar')
            $('#modal-loading-off').addClass('layar')
        })

        $(document).on('click', '#btn-tambah-skp', function(){
            $('#myModal #modal-loading-on').removeClass('layar')
            $('#myModal #modal-loading-off').addClass('layar')

            $('#title-tambah').removeClass('layar')
            $('#title-edit').addClass('layar')
            $('#btn-simpan-skp').removeClass('layar')
            $('#btn-update-skp').addClass('layar')
            $('#id').addClass('layar')


            $('#myModal .modal-footer .alert').addClass('layar')

            reset()
            reset_error()

            $('#myModal').modal('show')
            $('#myModal #modal-loading-on').addClass('layar')
            $('#myModal #modal-loading-off').removeClass('layar')
        })


        $(document).on('click', '#btn-simpan-skp',function(e){
            e.preventDefault()

            let token = {
                    "_token": $('#token').val()
                };

            let url = $('#form').attr('url')

            let formFilter = $('#form-filter').serialize()
            let form = $('#form').serialize()

            $.ajax({
                type: 'POST',
                url: url,
                data: {form:form, formFilter:formFilter},
                headers: token,
                success: function(res){

                  let pegawais = res.pegawais

                  let output = ''

                     $.each(pegawais, function(i, item){
                        output += '<tr>';
                        output += '<td>'+parseInt(i+1)+'</td>';
                        output += '<td>';

                        output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailSkp" url="{{ url('user/skp/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                        output += '<button class="btn btn-info btn-sm" id="handleEditSkp" url="{{ url('user/skp/filter-skp') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                        output += '<button class="btn btn-danger btn-sm" id="handleDeleteUtama" data-id="'+item.id+'" url="{{ url('user/skp/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
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


        $(document).on('click', '#handleEditSkp', function(){
            longValueEdit($(this))

            $('#myModal #modal-loading-on').removeClass('layar')
            $('#myModal #modal-loading-off').addClass('layar')

            $('#title-tambah').addClass('layar')
            $('#title-edit').removeClass('layar')
            $('#btn-simpan-skp').addClass('layar')
            $('#btn-update-skp').removeClass('layar')
            $('#id').removeClass('layar')

            let url = $(this).attr('url')
            let id = $(this).data('id')

            let tahun_filter = $('#form-filter #tahun_filter').val()
            $('#myModal #tahun_emit').val(tahun_filter)

            $('#myModal').modal('show')


            $.ajax({
                url: `${url}/${id}`,
                success: function(res)
                {

                    let table = ``


                    $.each(res.skps, (i, item) => {
                    table += `

                        <tr id='row${item.id}${i}'>
                        <td>
                          <div class="btn-group"> 
                          <button type='button' name='edit' class='btn btn-info btnEdit' data-id="${item.id}" data-index="${i}" data-pegawai_id="${item.pegawai_id}" data-pejabat_id="${item.pejabat_id}" data-kegiatan="${item.kegiatan}" data-ak="${item.ak}" data-output="${item.output}" data-mutu="${item.mutu}" data-waktu="${item.waktu}" data-biaya="${item.biaya}" data-tahun="${item.tahun}" data-row='row${parseInt(i+1)}'>
                            <i class='fa fa-edit'></i>
                          </button>
                          <button type='button' id="handleDeleteSkp" data-id="${item.id}" data-index="${i}" url="{{ url('skp/destroy') }}" class='btn btn-danger' data-row='row${item.id}'>
                            <i class='fa fa-trash'></i>
                          </button>
                          </div>
                        </td>
                        <td>
                          <input type='text' class='form-control kegiatan${i}' name='tugas_jabatan_array[]' id='tugas_jabatan_array_${parseInt(i+1)}[]' value='${item.kegiatan}' readonly>
                          <input type='hidden' name='id_array[]' id='id_array_${parseInt(i+1)}[]' value='${item.id}'>
                        </td>
                        <td>
                          <input type='text' class='form-control ak${i}' name='ak_array[]' id='ak_array_${parseInt(i+1)}[]' value='${item.ak}' readonly>
                        </td>
                        <td>
                        <input type='text' class='form-control output${i}' name='kuant_output_array[]' id='kuant_output_array_${parseInt(i+1)}[]' value='${item.output}' readonly>
                        </td>
                        <td>
                        <input type='text' class='form-control mutu${i}' name='kual_mutu_array[]' id='kual_mutu_array_${parseInt(i+1)}[]' value='${item.mutu}' readonly>
                        </td>
                        <td>
                        <input type='text' class='form-control waktu${i}' name='waktu_array[]' id='waktu_array_${parseInt(i+1)}[]' value='${item.waktu}' readonly>
                        </td>
                        <td>
                        <input type='text' class='form-control biaya${i}' name='biaya_array[]' id='biaya_array_${parseInt(i+1)}[]' value='${item.biaya}' readonly>
                        </td>
                        </tr>

                      `
                    })

                    // console.log(table)
                    $('#load_body').html(table);
                    $('#btn-update-skp').prop('disabled', true);
                    $('#form #pegawai_id').val(`${res.skp.pegawai_id}`).change()
                    $('#form #pejabat_id').val(`${res.skp.pejabat_id}`).change()
                    $('#form #tahun').val(`${res.skp.tahun}`).change()
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
          let pejabat_id = $(this).data('pejabat_id')
          let tahun = $(this).data('tahun')

          let kegiatan = $(`#row${id}${index} .kegiatan${index}`).val()
          let ak = $(`#row${id}${index} .ak${index}`).val()
          let output = $(`#row${id}${index} .output${index}`).val()
          let mutu = $(`#row${id}${index} .mutu${index}`).val()
          let waktu = $(`#row${id}${index} .waktu${index}`).val()
          let biaya = $(`#row${id}${index} .biaya${index}`).val()


          $('#myModal #form #id').val(id)
          $('#myModal #form #index').val(index)
          $('#pegawai_id').val(pegawai_id).change()
          $('#pejabat_id').val(pejabat_id).change()
          $('#myModal #tahun').val(tahun).change()
          $('#tugas_jabatan').val(kegiatan)
          $('#ak').val(ak)
          $('#kuant_output').val(output)
          $('#kual_mutu').val(mutu)
          $('#waktu').val(waktu)
          $('#biaya').val(biaya)

          $('#addSkp').addClass('layar')
          $('#updateSkp').removeClass('layar')
        })


        $(document).on('click', '#updateSkp', (e) => {
          e.preventDefault()

            let delete_row = $('#form #id').val();
            let index = $('#form #index').val();

            let pegawai_id = $('#pegawai_id').val();
            let pejabat_id = $('#pejabat_id').val();
            let tahun = $('#tahun').val();
            let tugas_jabatan = $('#tugas_jabatan').val();
            let ak = $('#ak').val();
            let kuant_output = $('#kuant_output').val();
            let kual_mutu = $('#kual_mutu').val();
            let waktu = $('#waktu').val();
            let biaya = $('#myModal #form #biaya').val();

            $(`#form #row${delete_row}${index} .kegiatan${index}`).val(tugas_jabatan)
            $(`#form #row${delete_row}${index} .ak${index}`).val(ak)
            $(`#form #row${delete_row}${index} .output${index}`).val(kuant_output)
            $(`#form #row${delete_row}${index} .mutu${index}`).val(kual_mutu)
            $(`#form #row${delete_row}${index} .waktu${index}`).val(waktu)
            $(`#form #row${delete_row}${index} .biaya${index}`).val(biaya)

           
            $('#addSkp').removeClass('layar')
            $('#updateSkp').addClass('layar')
            $('#btn-update-skp').prop('disabled', false);
            reset()

            $('#myModal .modal-footer .alert').removeClass('layar')
        })

        $(document).on('click', '#btn-update-skp', function(e){
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

                        output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailSkp" url="{{ url('user/skp/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                        output += '<button class="btn btn-info btn-sm" id="handleEditSkp" url="{{ url('user/skp/filter-skp') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                        output += '<button class="btn btn-danger btn-sm" id="handleDeleteUtama" data-id="'+item.id+'" url="{{ url('user/skp/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
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


        $(document).on('click', '#handleDeleteSkp', function(){
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
            let id = $(this).data('pegawai_id')
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

                                    output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailSkp" url="{{ url('user/skp/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                                    output += '<button class="btn btn-info btn-sm" id="handleEditSkp" url="{{ url('user/skp/filter-skp') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                                    output += '<button class="btn btn-danger btn-sm" id="handleDelete" data-id="'+item.id+'" url="{{ url('user/skp/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
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


        $(document).on('click', '#handleDetailSkp', function(){

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

                    let pejabat = res.pejabat
                    let pegawai = res.pegawai
                    let skps = res.skps

                    let output = ``

                        output += `
                         <tr>
                          <td style="text-align: center;" >1.</td>
                          <td>Nama</td>
                          <td style="width: 1%;">:</td>
                          <td>${pejabat ? pejabat.nama : ''}</td>
                          <td style="text-align: center;" >1.</td>
                          <td>Nama</td>
                          <td style="width: 1%;">:</td>
                          <td>${pegawai ? pegawai.nama : ''}</td>
                        </tr>
                        <tr>            
                          <td style="text-align: center;" >2.</td>
                          <td>Nip</td>
                          <td>:</td>
                          <td>${pejabat ? pejabat.nip : ''}</td>
                          <td style="text-align: center;" >2.</td>
                          <td>Nip</td>
                          <td>:</td>
                          <td>${pegawai ? pegawai.nip : ''}</td>
                        </tr>
                        <tr>
                          <td style="text-align: center;" >3.</td>
                          <td>Pangkat/Gol. Ruang</td>
                          <td>:</td>
                          <td>${pejabat ? pejabat.golongan : ''}</td>
                          <td style="text-align: center;" >3.</td>
                          <td>Pangkat/Gol. Ruang</td>
                          <td>:</td>
                          <td>${pegawai ? pegawai.golongan : ''}</td>
                        </tr>
                        <tr>
                          <td style="text-align: center;" >4.</td>
                          <td>Jabatan</td>
                          <td>:</td>
                          <td>${pejabat ? pejabat.jabatan : ''}</td>
                          <td style="text-align: center;" >4.</td>
                          <td>Jabatan</td>
                          <td>:</td>
                          <td>${pegawai ? pegawai.jabatan : ''}</td>
                        </tr>
                        <tr>
                          <td style="text-align: center;" >5.</td>
                          <td>Unit Kerja</td>
                          <td>:</td>
                          <td>${pejabat ? pejabat.organisasi_nama : ''}</td>
                          <td style="text-align: center;" >5.</td>
                          <td>Unit Kerja</td>
                          <td>:</td>
                          <td>${pegawai ? pegawai.organisasi_nama : ''}</td>
                        </tr>

                        `

                    let output2 = ``

                        $.each(skps, (i, item) => {
                        output2 += `
                          <tr>
                            <td style="text-align: center;">${parseInt(i+1)}</td>
                            <td>${item.kegiatan}</td>
                            <td>${item.ak}</td>
                            <td>${item.output}</td>
                            <td>${item.mutu}</td>
                            <td>${item.waktu}</td>
                            <td>${item.biaya}</td>
                          </tr>
                        `
                      })

                    $('#load_pegawai_pejabat').html(output);
                    $('#load_skp').html(output2);
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

          $('#btn-update-skp').prop('disabled', false);
        });

        $('#btn-simpan-skp').prop('disabled', true);


        var count=1;
        $(document).on('click', '#addSkp',function(e){
          e.preventDefault();

          let tugas_jabatan = $('#tugas_jabatan').val();
          let ak = $('#ak').val();

          let kuant_output = $('#kuant_output').val();
          let kual_mutu = $('#kual_mutu').val();
          let waktu = $('#waktu').val();
          let biaya = $('#biaya').val();

          if(tugas_jabatan === '')
          {
            $('#tugas_jabatan_error').html('Tugas Jabatan Wajib di isi')
          }else if(ak === '')
          {
            $('#ak_error').html('AK Wajib di isi')
          }else if(kuant_output === '')
          {
            $('#kuant_output_error').html('Kuant/output Wajib di isi')
          }else if(kual_mutu === '')
          {
            $('#kual_mutu_error').html('Mutu Wajib di isi')
          }else if(waktu === '')
          {
            $('#waktu_error').html('Waktu Wajib di isi')
          }else if(biaya === '')
          {
            $('#biaya_error').html('Biaya Wajib di isi')
          }else if(tugas_jabatan != '' && ak != '' && kuant_output != '' && kual_mutu != '' && waktu != '' && biaya != ''){

          count = count + 1;

          let table = "<tr id='row"+count+"'>";
              table += "<td><button type='button' name='remove' class='btn btn-danger remove' data-row='row"+count+"'><i class='fa fa-minus'></i></button></td>";
              table += "<td><input type='text' class='form-control' name='tugas_jabatan_array[]' id='tugas_jabatan_array[]' value='"+tugas_jabatan+"' readonly><input type='hidden' name='id_array[]' id='id_array[]' value='row"+count+"'></td>";
              table += "<td><input type='text' class='form-control' name='ak_array[]' id='ak_array[]' value='"+ak+"' readonly></td>";
              table += "<td><input type='text' class='form-control' name='kuant_output_array[]' id='kuant_output_array[]' value='"+kuant_output+"' readonly></td>";
              table += "<td><input type='text' class='form-control' name='kual_mutu_array[]' id='kual_mutu_array[]' value='"+kual_mutu+"' readonly></td>";
              table += "<td><input type='text' class='form-control' name='waktu_array[]' id='waktu_array[]' value='"+waktu+"' readonly></td>";
              table += "<td><input type='text' class='form-control' name='biaya_array[]' id='biaya_array[]' value='"+biaya+"' readonly></td>";
              table += "</tr>";

                  $('#load_body').prepend(table);
                  $('#btn-simpan-skp').prop('disabled', false);
                  $('#btn-update-skp').prop('disabled', false);
                  reset();
            }else{
              $('#tugas_jabatan_error').html('')
              $('#ak_error').html('')
              $('#kuant_output_error').html('')
              $('#kual_mutu_error').html('')
              $('#waktu_error').html('')
              $('#biaya_error').html('')
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

                  // console.log(res)
                    let output = ''

                     $.each(res.pegawais, function(i, item){
                        output += '<tr>';
                        output += '<td>'+parseInt(i+1)+'</td>';
                        output += '<td>';

                        output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailSkp" url="{{ url('user/skp/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                        output += '<button class="btn btn-info btn-sm" id="handleEditSkp" url="{{ url('user/skp/filter-skp') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                        output += '<button class="btn btn-danger btn-sm" id="handleDeleteUtama" data-pegawai_id="'+item.pegawai_id+'" url="{{ url('user/skp/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
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


        $(document).on('change', '#organisasi_no', function(){

         
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

                        output += '<div class="btn-group"><button class="btn btn-warning btn-sm" id="handleDetailSkp" url="{{ url('user/skp/detail') }}" data-id="'+item.id+'" title="detail '+ item.nama +'"><i class="fa fa-eye cursor"></i></button>';
                        output += '<button class="btn btn-info btn-sm" id="handleEditSkp" url="{{ url('user/skp/filter-skp') }}" data-id="'+item.id+'" data-nama="'+item.nama+'" data-jabatan="'+item.jabatan+'" title="edit '+ item.nama +'"><i class="fa fa-edit cursor"></i></button>';
                        output += '<button class="btn btn-danger btn-sm" id="handleDeleteUtama" data-pegawai_id="'+item.pegawai_id+'" url="{{ url('user/skp/destroy') }}" title="delete '+ item.nama +'"><i class="fa fa-trash cursor"></i></button></div>';
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
        let nama = value.data('nama')
        let jabatan = value.data('jabatan')
        let tahun = value.data('tahun')

        $('#id').val(id)
        $('#nama').val(nama)
        $('#jabatan').val(jabatan)
        $('#tahun').val(tahun)
    }

    function reset_error(){
        $('#nama_error').html('')
        $('#jabatan_error').html('')
        $('#tahun_error').html('')
    }

    function reset(){
        $('#tugas_jabatan').val('');
        $('#ak').val('');
        $('#kuant_output').val('');
        $('#kual_mutu').val('');
        $('#waktu').val('');
        $('#biaya').val('');
    }

    function fetch_data(){

        $('#loading-on').addClass('layar')
        $('#loading-off').removeClass('layar')

        fetch_pegawais()
       	fetch_pejabats()
    }

    function fetch_pegawais(){
        $('#myModal #modal-loading-on').removeClass('layar')
        $('#myModal #modal-loading-off').addClass('layar')

        $.ajax({
            url: `{{ url('user/skp/fetch-pegawai') }}`,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih Pegawai</option>';
                     $.each(res.pegawais, function(i, item){
                            output += '<option value="'+item.id+'">'+item.nama+'</option>';
                     });

                    $('#pegawai_id').html(output)
                    $('#myModal #modal-loading-on').addClass('layar')
                    $('#myModal #modal-loading-off').removeClass('layar')
            }
        });
    }


    function fetch_pejabats(){
        $('#myModal #modal-loading-on').removeClass('layar')
        $('#myModal #modal-loading-off').addClass('layar')

        $.ajax({
            url: `{{ url('user/skp/fetch-pegawai') }}`,
            dataType: 'json',
            success: function(res)
            {
                let output = '';
                    output += '<option value="">Pilih Pejabat Penilai</option>';
                     $.each(res.pegawais, function(i, item){
                            output += '<option value="'+item.id+'">'+item.nama+'</option>';
                     });

                    $('#pejabat_id').html(output)
                    $('#myModal #modal-loading-on').addClass('layar')
                    $('#myModal #modal-loading-off').removeClass('layar')
            }
        });
    }



</script>
@endsection
