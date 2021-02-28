@extends('public.template2')

@section('content')

  
  <div class="card">
    <div class="card-body">
      <form id="form" url="{{ url('survei-skm/store') }}">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td colspan="2">
                <h5 class="text-center">KUESIONER SURVEI KEPUASAN MASYARAKAT (SKM) <br> PADA KANTOR BAPPEDA KABUPATEN KEPULAUAN MERANTI</h5>
              </td>
            </tr>
            <tr>
              <td>
                Tanggal Survei : {{ date('d-F-Y') }}
              </td>
              <td>
                <label class="label-control">Email: <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span></label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email Anda">
                <span class="text-danger">
                    <strong id="email_error"></strong>
                </span>
                <!-- Jam Survei : 
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jam_survei" id="jam_survei1" value="08.00 - 12.00">
                  <label class="form-check-label" for="jam_survei1">08.00 - 12.00</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jam_survei" id="jam_survei2" value="13.00 - 16.00">
                  <label class="form-check-label" for="jam_survei2">13.00 - 16.00</label>
                </div> -->
              </td>
            </tr>
            <tr>
              <td colspan="2"><h5 class="text-center">PROFILE</h5></td>
            </tr>
            <tr>
              <td>
                Jenis kelamin : <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jk" id="jk1" value="L">
                  <label class="form-check-label" for="jk1">L</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jk" id="jk2" value="P">
                  <label class="form-check-label" for="jk2">P</label>
                </div>
                <span class="text-danger">
                    <strong id="jk_error"></strong>
                </span>
              </td>
              <td>
                <div class="form-group row ml-1">
                Usia: <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <input type="number" name="usia" class="form-control form-control-sm mr-1 ml-1" style="width:100px;"> Tahun
                <span class="text-danger">
                    <strong id="usia_error"></strong>
                </span>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                Pendidikan : <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan1" value="SD">
                  <label class="form-check-label" for="pendidikan1">SD</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan2" value="SMP">
                  <label class="form-check-label" for="pendidikan2">SMP</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan3" value="SMA">
                  <label class="form-check-label" for="pendidikan3">SMA</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan4" value="D3">
                  <label class="form-check-label" for="pendidikan4">D3</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan5" value="S1">
                  <label class="form-check-label" for="pendidikan5">S1</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan6" value="S2">
                  <label class="form-check-label" for="pendidikan6">S2</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan7" value="PNS">
                  <label class="form-check-label" for="pendidikan7">PNS</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan8" value="TNI">
                  <label class="form-check-label" for="pendidikan8">TNI</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan9" value="TNI">
                  <label class="form-check-label" for="pendidikan9">TNI</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan10" value="POLRI">
                  <label class="form-check-label" for="pendidikan10">POLRI</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan11" value="Swasta">
                  <label class="form-check-label" for="pendidikan11">Swasta</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan12" value="Wirausaha">
                  <label class="form-check-label" for="pendidikan12">Wirausaha</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pendidikan" id="pendidikan13" value="Lainnya">
                  <label class="form-check-label" for="pendidikan13">Lainnya</label>
                </div>
                <span class="text-danger">
                    <strong id="pendidikan_error"></strong>
                </span>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                Jenis Layanan yang di terima : Pelayanan Kantor BAPPEDA
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <h5 class="text-center">
                  PENDAPAT RESPONDEN TENTANG PELAYANAN <br>
                  <i>( Lingkari kode huruf sesuai jawaban responden )</i>
                </h5>
              </td>
            </tr>
          </table>
          <table class="table table-bordered">
            <tr>
              <td>
                1. Bagaimana pemahaman Saudara kemudahan tentang kemudahan prosedur pelayanan di unit ini. 
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u1" id="u1" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Mudah</option>
                  <option value="2">Kurang Mudah</option>
                  <option value="3">Mudah</option>
                  <option value="3">Sangat Mudah</option>
                </select>
                <span class="text-danger">
                    <strong id="u1_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
              <td></td>
              <td>
                7. Bagaimana Pendapat Saudara tentang keadilan untuk mendapatkan pelayanan di unit ini
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u7" id="u7" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Adil</option>
                  <option value="2">Kurang Adil</option>
                  <option value="3">Adil</option>
                  <option value="3">Sangat Adil</option>
                </select>
                <span class="text-danger">
                    <strong id="u2_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
            </tr>
            <tr>
              <td>
                2. Bagaimana Pendapat Saudara tentang ke sesuaian persyaratan pelayanan dengan jenis pelayanannya 
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u2" id="u2" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Sesuai</option>
                  <option value="2">Kurang Sesuai</option>
                  <option value="3">Sesuai</option>
                  <option value="3">Sangat Sesuai</option>
                </select>
                <span class="text-danger">
                    <strong id="u3_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
              <td></td>
              <td>
                8. Bagaimana Pendapat Saudara tentang Kedisiplinan Petugas dalam Memberikan Pelayanan
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u8" id="u8" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Disiplin</option>
                  <option value="2">Kurang Disiplin</option>
                  <option value="3">Disiplin</option>
                  <option value="3">Sangat Disiplin</option>
                </select>
                <span class="text-danger">
                    <strong id="u4_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
            </tr>
            <tr>
              <td>
                3. Bagaimana Pendapat Saudara tentang keamanan pelayanan di unit ini 
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u3" id="u3" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Aman</option>
                  <option value="2">Kurang Aman</option>
                  <option value="3">Aman</option>
                  <option value="3">Sangat Aman</option>
                </select>
                <span class="text-danger">
                    <strong id="u5_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
              <td></td>
              <td>
                9. Bagaimana Pendapat Saudara tentang Kecepatan pelayanan unit ini
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u9" id="u9" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Cepat</option>
                  <option value="2">Kurang Cepat</option>
                  <option value="3">Cepat</option>
                  <option value="3">Sangat Cepat</option>
                </select>
                <span class="text-danger">
                    <strong id="u6_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
            </tr>
            <tr>
              <td>
                4. Bagaimana Pendapat Saudara tentang kejelasan dan kepastian petugas yang melayani 
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u4" id="u4" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Jelas</option>
                  <option value="2">Kurang Jelas</option>
                  <option value="3">Jelas</option>
                  <option value="3">Sangat Jelas</option>
                </select>
                <span class="text-danger">
                    <strong id="u7_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
              <td></td>
              <td>
                10. Bagaimana Pendapat Saudara tentang Kesopanan dan keramahan petugas dalam memberikan pelayanan
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u10" id="u10" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak sopan dan ramah</option>
                  <option value="2">Kurang sopan dan ramah</option>
                  <option value="3">sopan dan ramah</option>
                  <option value="3">Sangat sopan dan ramah</option>
                </select>
                <span class="text-danger">
                    <strong id="u8_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
            </tr>
            <tr>
              <td>
                5. Bagaimana Pendapat Saudara tentang Kesopanan dan keramahan petugas dalam memberikan pelayanan
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u5" id="u5" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak Bertanggung jawab</option>
                  <option value="2">Kurang Bertanggung jawab</option>
                  <option value="3">Bertanggung jawab</option>
                  <option value="3">Sangat Bertanggung jawab</option>
                </select>
                <span class="text-danger">
                    <strong id="u9_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
              <td></td>
              <td>
                11. Bagaimana Pendapat Saudara tentang ketetapan pelaksanaan terhadap jadwal waktu pelayanan
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u11" id="u11" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak tidak tepat</option>
                  <option value="2">Kurang tidak tepat</option>
                  <option value="3">Tidak tepat</option>
                  <option value="3">Sangat tidak tepat</option>
                </select>
                <span class="text-danger">
                    <strong id="u10_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
            </tr>
            <tr>
              <td>
                6. Bagaimana Pendapat Saudara tentang Kemampuan petugas dalam memberikan pelayanan
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u6" id="u6" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak mampu</option>
                  <option value="2">Kurang mampu</option>
                  <option value="3">Mampu</option>
                  <option value="3">Sangat mampu</option>
                </select>
                <span class="text-danger">
                    <strong id="u11_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
              <td></td>
              <td>
                12. Bagaimana Pendapat Saudara tentang kenyamanan di lingkungan unit pelayanan 
                <span class="text-danger" style="font-size: 12px;">* ) Wajib di isi</span>
                <br>
                <select name="u12" id="u12" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Tidak nyaman</option>
                  <option value="2">Kurang nyaman</option>
                  <option value="3">nyaman</option>
                  <option value="3">Sangat nyaman</option>
                </select>
                <span class="text-danger">
                    <strong id="u12_error"></strong>
                </span>
              </td>
              <td><strong>P*)</strong> <br> 1 <br> 2 <br> 3 <br> 4</td>
            </tr>
          </table>
        </div>
        <br>
        <div class="btn-group text-center">
          <button class="btn btn-primary" id="submit-survey">Submit Survey</button>
        </div>
      </form>
    </div>
  </div>

						
@endsection      


@push('scripts')
  
  <script type="text/javascript">
    $(document).ready(function(){

      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $(this).html('submit Survey')
      $(this).prop('disabled', false)


      $(document).on('click', '#submit-survey', function(e){
        e.preventDefault()

        $(this).html('submit...')
        $(this).prop('disabled', true)

        let url = $('#form').attr('url')
        let form = $('#form').serialize()

        let token = {
            "_token": $('#token').val()
        };


        $(this).html('submit...')
        $(this).prop('disabled', true)

        $.ajax({
          type: 'POST',
          url: url,
          data: form,
          headers: token,
          success: function(res){

            reset()
            // Toast.fire({
            //   type: "success",
            //   title: 'Submit Success!!'
            // });

            $(this).html('submit Survey')
            $(this).prop('disabled', false)


          },
          error: function(data)
          {
              reset_error()
              let errors = data.responseJSON

              $(this).html('submit Survey')
              $(this).prop('disabled', false)

              $.each(errors.errors, function(k, v){
                  $('#'+k+'_error').html(v)
              })


              Toast.fire({
                  type: "error",
                  title: `${errors.message}`
                });
          }
        })

      })

    })

    function reset()
    {
      $('#form #email').val('')
      $('#form #usia').val('')
      $('#form #jk').val('')
      $('#form #pendidikan').val('')
      $('#form #u1').val('')
      $('#form #u2').val('')
      $('#form #u3').val('')
      $('#form #u4').val('')
      $('#form #u5').val('')
      $('#form #u6').val('')
      $('#form #u7').val('')
      $('#form #u8').val('')
      $('#form #u9').val('')
      $('#form #u10').val('')
      $('#form #u11').val('')
      $('#form #u12').val('')
    }


    function reset_error()
    {
      $('#email_error').html('')
      $('#pendidikan_error').html('')
      $('#usia_error').html('')
      $('#jk_error').html('')
      $('#u1_error').html('')
      $('#u2_error').html('')
      $('#u3_error').html('')
      $('#u4_error').html('')
      $('#u5_error').html('')
      $('#u6_error').html('')
      $('#u7_error').html('')
      $('#u8_error').html('')
      $('#u9_error').html('')
      $('#u10_error').html('')
      $('#u11_error').html('')
      $('#u12_error').html('')
    }
  </script>

@endpush
