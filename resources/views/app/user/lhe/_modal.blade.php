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
        <h5 class="modal-title">Edit Laporan Hasil Evaluasi</h5>
        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
	          <form id="form" urlUpdate="{{ url('user/lhe/update') }}">
	            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	            <input type="hidden" class="display" name="id" id="id">
	            <input type="hidden" class="display" name="tahun_emit" id="tahun_emit">
	            <div class="modal-body">

	            	<div class="form-group">
		            	<label for="nilai" class="control-label">Nilai</label>
		            	<input type="text" name="nilai" id="nilai" class="form-control">

	                  <span class="text-danger">
	                      <strong id="nilai_error"></strong>
	                  </span>
		            </div>

	            </div>
	            <!-- end modal body -->

	            <div class="modal-footer">
	              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
	              <button
	                type="submit"
	                id="btn-update-lhe"
	                class="btn btn-info display"
	              >Update</button>
	            </div>
	          </form>
    </div>
  </div>
</div>
</div>
