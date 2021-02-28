
	<div
	  class="modal fade"
	  id="myModal"
	  tabindex="-1"
	  role="dialog"
	  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
	>
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="title-tambah">Tambah Indikator Kinerja Utama</h5>
	        <h5 class="modal-title display" id="title-edit">Edit Indikator Kinerja Utama</h5>
	        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	        <div class="modal-body">
				<!-- <div class="text-center" id="modal-loading-on">
				    @include('layouts._spinner')
				</div>

				<div id="modal-loading-off" class="layar"> -->
		          <form id="form" url="{{ url('admin/iku/store') }}" urlUpdate="{{ url('admin/iku/update') }}">
		            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		            <input type="hidden" class="display" name="id" id="id">
		            <input type="hidden" name="tahun_emit" id="tahun_emit">
		            <input type="hidden" name="organisasi_no_emit" id="organisasi_no_emit">
		            <div class="modal-body">

		            	<div class="form-group">
			                   <label for="organisasi_no" class="control-label">Organisasi</label>
			                   <select class="form-control form-control-sm select2" name="organisasi_no" id="organisasi_no">
			                      <option value="">Pilih</option>
			                    </select>
			                    <span class="text-danger">
			                        <strong id="organisasi_no_error"></strong>
			                    </span>
			            </div>

		            	<div class="form-group">
			                   <label for="indikator_sasaran_id" class="control-label">Indikator Sasaran</label>
			                   <select class="form-control form-control-sm select2" name="indikator_sasaran_id" id="indikator_sasaran_id">
			                      <option value="">Pilih</option>
			                    </select>
			                    <span class="text-danger">
			                        <strong id="indikator_sasaran_id_error"></strong>
			                    </span>
			            </div>

			            <div class="form-group">
			                   <label for="tahun" class="control-label">Tahun</label>
			                   <select class="form-control form-control-sm select2" name="tahun" id="tahun">
			                      <option value="">Pilih</option>
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


			            <div class="form-group">
			            	<label for="alasan" class="control-label">Alasan</label>
			            	<textarea name="alasan" id="alasan" class="form-control" cols="10" rows="5"></textarea>

		                  <span class="text-danger">
		                      <strong id="alasan_error"></strong>
		                  </span>
			            </div>

			            <div class="form-group">
			            	<label for="formulasi" class="control-label">Formulasi</label>
			            	<textarea name="formulasi" id="formulasi" class="form-control" cols="10" rows="5"></textarea>

		                  <span class="text-danger">
		                      <strong id="formulasi_error"></strong>
		                  </span>
			            </div>

			            <div class="form-group">
			            	<label for="sumber_data" class="control-label">Sumber Data</label>
			            	<textarea name="sumber_data" id="sumber_data" class="form-control" cols="10" rows="5"></textarea>

		                  <span class="text-danger">
		                      <strong id="sumber_data_error"></strong>
		                  </span>
			            </div>


			            <div class="form-group">
			            	<label for="keterangan" class="control-label">Keterangan</label>
			            	<textarea name="keterangan" id="keterangan" class="form-control" cols="10" rows="5"></textarea>

		                  <span class="text-danger">
		                      <strong id="keterangan_error"></strong>
		                  </span>
			            </div>

		            </div>
		            <!-- end modal body -->

		            <div class="modal-footer">
		              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
		              <button
		                type="submit"
		                id="btn-simpan-iku"
		                class="btn btn-primary"
		              ><i class="fa fa-save"></i> Save</button>
		              <button
		                type="submit"
		                id="btn-update-iku"
		                class="btn btn-info display"
		              >Update</button>
		            </div>
		          </form>
	        <!-- </div> -->
	    </div>
	  </div>
	</div>
	</div>
