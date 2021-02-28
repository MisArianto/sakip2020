
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
	        <h5 class="modal-title" id="title-tambah">Tambah Indikator Kinerja Individu</h5>
	        <h5 class="modal-title display" id="title-edit">Edit Indikator Kinerja Individu</h5>
	        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	        <div class="modal-body">
				<div class="text-center" id="modal-loading-on">
				    @include('layouts._spinner')
				</div>

				<div id="modal-loading-off" class="layar">
		          <form id="form" url="{{ url('user/iki/store') }}" urlUpdate="{{ url('user/iki/update') }}">
		            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		            <input type="hidden" class="display" name="id" id="id">
		            <input type="hidden" class="display" name="index" id="index">
		            <input type="hidden" name="tahun_emit" id="tahun_emit">
		            <div class="modal-body">

		              <div class="row">

		                <div class="col-md-4">
		                	<div class="form-group">
		                    <select class="form-control form-control-sm select2" name="pegawai_id" id="pegawai_id">
		                      <option value="">Pilih Pegawai</option>
		                    </select>
		                    <span class="text-danger">
		                        <strong id="pegawai_id_error"></strong>
		                    </span>
		                  </div>
		                </div>

		                <div class="col-md-4">
		                  <div class="form-group">
		                    <select class="form-control form-control-sm select2" name="pimpinan_id" id="pimpinan_id">
		                      <option value="">Pilih Pimpinan Penilai</option>
		                    </select>
		                    <span class="text-danger">
		                        <strong id="pimpinan_id_error"></strong>
		                    </span>
		                  </div>
		                </div>

		                <div class="col-md-4">
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

		                  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" class="form-control" name="sasaran_strategis" id="sasaran_strategis" placeholder="Sasaran Strategis">

		                    <span class="text-danger">
		                        <strong id="sasaran_strategis_error"></strong>
		                    </span>

		                  </div>

		                  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" class="form-control" name="indikator_sasaran" id="indikator_sasaran" placeholder="Indikator Sasaran">

		                    <span class="text-danger">
		                        <strong id="indikator_sasaran_error"></strong>
		                    </span>

		                  </div>

		                  <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-3">
		                    <select id="satuan_id" class="form-control select2" name="satuan_id">
	                        <option value="">Pilih Satuan</option>
	                        </select>

		                    <span class="text-danger">
		                        <strong id="satuan_id_error"></strong>
		                    </span>
		                  </div>

		                  <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 mb-3">
		                    <input type="text" name="target" id="target" placeholder="Target" class="form-control">

		                    <span class="text-danger">
		                        <strong id="target_error"></strong>
		                    </span>
		                  </div>

		                  <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12">
		                    <button class="btn btn-primary btn-block-xs-only" id="addIki"><i class='fa fa-plus'></i></button>
		                    <button class="btn btn-primary btn-block-xs-only layar" id="updateIki"><i class='fa fa-save'></i></button>
		                  </div>

		              </div>

		              <!-- row table -->
		              <div class="row">
		                <div class="col-md-12">
		                  <div class="table-responsive">
		                    <table class="table table-striped">
		                      <thead>
		                        <tr>
									<th>#</th>
		                          	<th>Sasaran Strategis</th>
		                          	<th>Indikator Sasaran</th>
									<th>Satuan</th>
									<th>Target</th>
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

		            	<div class="alert alert-warning alert-dismissible fade show layar" role="alert">
						  <strong>Anda Melakukan Perubahan Data!</strong> Click Tombol <strong>Update</strong> Sebelum Close.
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>

		              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
		              <button
		                type="submit"
		                id="btn-simpan-iki"
		                class="btn btn-primary"
		              ><i class="fa fa-save"></i> Save</button>
		              <button
		                type="submit"
		                id="btn-update-iki"
		                class="btn btn-info display"
		              >Update</button>
		            </div>
		          </form>
	        </div>
	    </div>
	  </div>
	</div>
	</div>
