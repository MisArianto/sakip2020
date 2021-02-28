<!-- eselon 3 -->
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
	        <h5 class="modal-title" id="title-tambah">Tambah Perjanjian Kinerja Eselon IV</h5>
	        <h5 class="modal-title display" id="title-edit">Edit Perjanjian Kinerja Eselon IV</h5>
	        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	        <div class="modal-body">
				<!-- <div class="text-center" id="modal-loading-on">
				    @include('layouts._spinner')
				</div>

				<div id="modal-loading-off" class="layar"> -->
		          <form id="form" url="{{ url('user/perjanjian-kinerja/eselon-4/store') }}" urlUpdate="{{ url('user/perjanjian-kinerja/eselon-4/update') }}">
		            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		            <input type="hidden" class="display" name="id" id="id">
		            <input type="hidden" class="display" name="tahun_emit" id="tahun_emit">
		            <div class="modal-body">

		            	<div class="form-group">
			            	<label for="sasaran" class="control-label">Sasaran</label>
			            	<input type="text" name="sasaran" id="sasaran" class="form-control">

		                  <span class="text-danger">
		                      <strong id="sasaran_error"></strong>
		                  </span>
			            </div>

			            <div class="form-group">
			            	<label for="indikator_sasaran" class="control-label">Indikator Sasaran</label>
			            	<input type="text" name="indikator_sasaran" id="indikator_sasaran" class="form-control">

		                  <span class="text-danger">
		                      <strong id="indikator_sasaran_error"></strong>
		                  </span>
			            </div>


			            <div class="form-group">
			                   <label for="kegiatan_no" class="control-label">Kegiatan</label>
			                   <select class="form-control form-control-sm select2" name="kegiatan_no" id="kegiatan_no">
			                      <option value="">Pilih</option>
			                    </select>
			                    <span class="text-danger">
			                        <strong id="kegiatan_no_error"></strong>
			                    </span>
			            </div>

			            <div class="form-group">
			                   <label for="jabatan_id" class="control-label">Jabatan</label>
			                   <select class="form-control form-control-sm select2" name="jabatan_id" id="jabatan_id">
			                      <option value="">Pilih</option>
			                    </select>
			                    <span class="text-danger">
			                        <strong id="jabatan_id_error"></strong>
			                    </span>
			            </div>

			            <div class="form-group">
			                   <label for="satuan_id" class="control-label">Satuan</label>
			                   <select class="form-control form-control-sm select2" name="satuan_id" id="satuan_id">
			                      <option value="">Pilih</option>
			                    </select>
			                    <span class="text-danger">
			                        <strong id="satuan_id_error"></strong>
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
			            	<label for="target" class="control-label">Target</label>
			            	<input type="text" name="target" id="target" class="form-control">

		                  <span class="text-danger">
		                      <strong id="target_error"></strong>
		                  </span>
			            </div>

						<div class="form-group">
			            	<label for="pagu" class="control-label">Pagu</label>
			            	<input type="text" name="pagu" id="pagu" class="form-control">

		                  <span class="text-danger">
		                      <strong id="pagu_error"></strong>
		                  </span>
			            </div>			            

		            </div>
		            <!-- end modal body -->

		            <div class="modal-footer">
		              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
		              <button
		                type="submit"
		                id="btn-simpan-pk"
		                class="btn btn-primary"
		              ><i class="fa fa-save"></i> Save</button>
		              <button
		                type="submit"
		                id="btn-update-pk"
		                class="btn btn-info display"
		              >Update</button>
		            </div>
		          </form>
	        <!-- </div> -->
	    </div>
	  </div>
	</div>
	</div>
