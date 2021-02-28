
	<div
	  class="modal fade bd-example-modal-xl"
	  id="myModal"
	  tabindex="-1"
	  role="dialog"
	  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
	>
	  <div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="title-tambah">Tambah Sasaran Kerja Pegawai</h5>
	        <h5 class="modal-title display" id="title-edit">Edit Sasaran Kerja Pegawai</h5>
	        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	        <div class="modal-body">
				<div class="text-center" id="modal-loading-on">
				    @include('layouts._spinner')
				</div>

				<div id="modal-loading-off" class="layar">
		          <form id="form" url="{{ url('admin/skp/store') }}" urlUpdate="{{ url('admin/skp/update') }}">
		            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		            <input type="hidden" class="display" name="id" id="id">
		            <input type="hidden" class="display" name="tahun_emit" id="tahun_emit">
		            <input type="hidden" class="display" name="organisasi_no_emit" id="organisasi_no_emit">
		            <div class="modal-body">

		              <div class="row">

		                <div class="col-md-3">
		                	<div class="form-group">
		                    <select class="form-control form-control-sm select2" name="organisasi_no" id="organisasi_no">
		                      <option value="">--Pilih OPD--</option>
		                    </select>
		                    <span class="text-danger">
		                        <strong id="organisasi_no_error"></strong>
		                    </span>
		                  </div>
		                </div>

		                <div class="col-md-3">
		                	<div class="form-group">
		                    <select class="form-control form-control-sm select2" name="pegawai_id" id="pegawai_id">
		                      <option value="">--Pilih Pegawai--</option>
		                    </select>
		                    <span class="text-danger">
		                        <strong id="pegawai_id_error"></strong>
		                    </span>
		                  </div>
		                </div>


		                <div class="col-md-3">
		                  <div class="form-group">
		                    <select class="form-control form-control-sm select2" name="pejabat_id" id="pejabat_id">
		                      <option value="">Pilih Pejabat Penilai</option>
		                    </select>
		                    <span class="text-danger">
		                        <strong id="pejabat_id_error"></strong>
		                    </span>
		                  </div>
		                </div>

		                <div class="col-md-3">
		                  <select id="tahun" class="form-control form-control-sm select2" name="tahun">
		                    <option value="">Pilih Tahun</option>
		                    <option value="2017">2017</option>
		                    <option value="2018">2018</option>
		                    <option value="2019">2019</option>
		                    <option value="2020">2020</option>
		                    <option value="2021">2021</option>
		                  </select>

		                  <span class="text-danger">
		                      <strong id="tahun_error"></strong>
		                  </span>

		                </div>

		              </div>
		              <!-- end row -->

		              <hr>

		              <div class="row mb-3">

		                  <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 mb-3">
		                    <textarea class="form-control" name="tugas_jabatan" id="tugas_jabatan" placeholder="Kegiatan Tugas Jabatan"></textarea>

		                    <span class="text-danger">
		                        <strong id="tugas_jabatan_error"></strong>
		                    </span>

		                  </div>

		                  <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" name="ak" id="ak" placeholder="Ak" class="form-control">

		                    <span class="text-danger">
		                        <strong id="ak_error"></strong>
		                    </span>
		                  </div>

		                  <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" name="kuant_output" id="kuant_output" placeholder="Kuant/Output" class="form-control">

		                    <span class="text-danger">
		                        <strong id="kuant_output_error"></strong>
		                    </span>
		                  </div>

		                  <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" name="kual_mutu" id="kual_mutu" placeholder="Mutu" class="form-control">

		                    <span class="text-danger">
		                        <strong id="kual_mutu_error"></strong>
		                    </span>
		                  </div>

		                  <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" name="waktu" id="waktu" placeholder="Waktu" class="form-control">

		                    <span class="text-danger">
		                        <strong id="waktu_error"></strong>
		                    </span>
		                  </div>

		                  <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" name="biaya" id="biaya" placeholder="Biaya" class="form-control">
		                    
		                    <span class="text-danger">
		                        <strong id="biaya_error"></strong>
		                    </span>
		                  </div>

		                  <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12">
		                    <button class="btn btn-primary btn-block-xs-only" id="addSkp"><i class='fa fa-plus'></i></button>
		                    <button class="btn btn-primary btn-block-xs-only layar" id="updateSkp"><i class='fa fa-save'></i></button>
		                  </div>

		              </div>

		              <!-- row table -->
		              <div class="row">
		                <div class="col-md-12">
		                  <div class="table-responsive">
		                    <table class="table table-striped" style="font-size: 12px;">
		                      <thead>
		                        <tr>
		                          <th>#</th>
		                          <th>Kegiatan Tugas Jabatan</th>
		                          <th>AK</th>
		                          <th>Kuant/Output</th>
		                          <th>Kual/Mutu</th>
		                          <th>Waktu</th>
		                          <th>Biaya</th>
		                        </tr>
		                      </thead>
		                      <tbody id="load_body">

		                      </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>
		            </div>
		            <!-- end modal body -->

		            <div class="modal-footer">
		              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
		              <button
		                type="submit"
		                id="btn-simpan-skp"
		                class="btn btn-primary"
		              ><i class="fa fa-save"></i> Save</button>
		              <button
		                type="submit"
		                id="btn-update-skp"
		                class="btn btn-info display"
		              >Update</button>
		            </div>
		          </form>
	        </div>
	    </div>
	  </div>
	</div>
	</div>
