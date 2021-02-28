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
        <h5 class="modal-title" id="title"></h5>
        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
			<!-- <div class="text-center" id="modal-loading-on">
			    @include('layouts._spinner')
			</div>

			<div id="modal-loading-off" class="layar"> -->
	          <form id="form" urlUpdate="{{ url('user/pengukuran-kinerja/update') }}">
	            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	            <input type="hidden" class="display" name="id" id="id">
	            <input type="hidden" class="display" name="tahun_emit" id="tahun_emit">
	            <input type="hidden" class="display" name="name" id="name">
	            <div class="modal-body">

	            	<div class="form-group">
		            	<label for="target" class="control-label">Target</label>
		            	<input type="text" name="target" id="target" class="form-control">

	                  <span class="text-danger">
	                      <strong id="target_error"></strong>
	                  </span>
		            </div>	


		            <div class="form-group">
		            	<label for="kinerja" class="control-label">Kinerja</label>
		            	<input type="text" name="kinerja" id="kinerja" class="form-control">

	                  <span class="text-danger">
	                      <strong id="kinerja_error"></strong>
	                  </span>
		            </div>


		            <div class="form-group">
		            	<label for="anggaran" class="control-label">Anggaran</label>
		            	<input type="number" name="anggaran" id="anggaran" class="form-control">

	                  <span class="text-danger">
	                      <strong id="anggaran_error"></strong>
	                  </span>
		            </div>


		            <div class="form-group">
		            	<label for="rekomendasi" class="control-label">Rekomendasi</label>
		            	<!-- <input type="text" name="rekomendasi" id="rekomendasi" class="form-control"> -->

		            	<textarea name="rekomendasi" id="rekomendasi" class="form-control" cols="4" rows="4"></textarea>

	                  <span class="text-danger">
	                      <strong id="rekomendasi_error"></strong>
	                  </span>
		            </div>		            

	            </div>
	            <!-- end modal body -->

	            <div class="modal-footer">
	              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
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
