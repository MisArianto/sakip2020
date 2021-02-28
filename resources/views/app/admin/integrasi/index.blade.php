@extends('layouts.template')

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card card shadow mb-4">
            
            <div class="card-header">
                <h4>Integrasi Simpeg</h4>
            </div>
            
            <div class="card-body">
               <div class="row">
                   <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select id="simpeg" class="form-control form-control-sm">
                                   <option value="">Pilih Integrasi</option>
                                   <option value="pegawai" url="{{ url('admin/sistem/integrasi/get-api-simpeg') }}">Pegawai</option>
                                   <option value="jabatan" url="{{ url('admin/sistem/integrasi/get-jabatan-simpeg') }}">Jabatan</option>
                               </select>
                            <div class="input-group-prepend">
                              <input class="btn btn-primary btn-sm" id="integrasiSimpeg" type="submit" value="Integrasi">
                            </div>
                          </div>
                          

                   </div>
               </div>
            </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card shadow mb-4">
            
            <div class="card-header">
                <h4>Integrasi e-planning</h4>
            </div>
            
            <div class="card-body">
               <div class="row">
                   <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select id="planning" class="form-control form-control-sm">
                                   <option value="">Pilih Integrasi</option>
                                   <option value="kegiatan" url="{{ url('get_api/kegiatan/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK') }}">Kegiatan</option>
                                   <option value="program" url="{{ url('get_api/program/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK') }}">Program</option>
                                   <option value="satuan" url="{{ url('get_api/satuan/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK') }}">Satuan</option>
                                   <option value="users" url="{{ url('get_api/user/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK') }}">Users</option>
                               </select>
                            <div class="input-group-prepend">
                              <input class="btn btn-primary btn-sm" id="integrasiEplanning" type="submit" value="Integrasi">
                            </div>
                          </div>
                          
                   </div>
               </div>
            </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card card shadow mb-4">
      <div class="card-header">
          <h4>Response
      </div>
      <div class="card-body">
        <pre><div id="response"></div></pre>
      </div>
      <div class="layar card-body" id="loadingTable">
          <div class="row">
            <div class="col-md-12 text-center">
                @include('layouts._spinner')
                <br>
                <p>Mohon Tunggu Sedang Proses Integrasi...</p>
            </div>
          </div>
      </div>
    </div>
  </div>
</div> 

@stop        

@section('scripts')
<script>
  hljs.initHighlightingOnLoad();

    $(document).ready(function(){
        $(document).on('click', '#integrasiSimpeg', function(){

            $('#loadingTable').removeClass('layar')
            $('#load').addClass('layar')

            let url = $('#simpeg option:selected').attr('url');
             $.ajax({
                type: 'GET',
                url: url, 
                dataType:'json',
                async: true,
                success: function(res){

                    console.log(res)

                    $('#response').html(prettyPrintJson.toHtml(res))

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
        });

        $(document).on('click', '#integrasiEplanning', function(){
            $('#loadingTable').removeClass('layar')
            $('#load').addClass('layar')

            let url = $('#planning option:selected').attr('url');
             $.ajax({
                type: 'GET',
                url: url, 
                dataType:'json',
                async: true,
                success: function(res){

                  console.log(res)

                    $('#response').html(prettyPrintJson.toHtml(res))
                    
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
        });

    });
</script>
@endsection
