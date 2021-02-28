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
        <h5 class="modal-title">Upload Cascading</h5>
        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
	          <form id="form" url="{{ url('user/cascading/store') }}" enctype="multipart/form-data">
	            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	            <input type="hidden" class="display" name="tahun_emit" id="tahun_emit">
	            <div class="modal-body">

	            	<div class="form-group">
		            	<label for="tahun" class="control-label">Tahun</label>
		            	<select name="tahun" id="tahun" class="form-control select2">
		            		<option value="">Pilih</option>
		            		<option value="2019">2019</option>
		            		<option value="2020">2020</option>
		            		<option value="2021">2021</option>
		            		<option value="2022">2022</option>
		            	</select>

	                  <span class="text-danger">
	                      <strong id="tahun_error"></strong>
	                  </span>
		            </div>

		            <div class="form-group">
		            	<label for="tahun" class="control-label">Keterangan</label>
		            	<select name="keterangan" id="keterangan" class="form-control">
                            <option value="">Pilih</option>
                            <option value="pohon kinerja rpjmd">Pohon Kinerja RPJMD</option>
                            <option value="cross cutting">Cross Cutting</option>
                        </select>

	                  <span class="text-danger">
	                      <strong id="keterangan_error"></strong>
	                  </span>
		            </div>


		            <div class="form-group" id="form-group">
		                <label>Upload File</label>
		                <div class="uploader">

		                  <div id="caption">
		                    <i id="icon" class="mdi mdi-cloud-upload"></i>
		                    <p>Pilih File Anda di Sini</p>
		                    <div class="file-input">
		                      <label for="file" class="label">Pilih File</label>
		                      <input type="file" id="file" name="file" class="input" onchange="onInputChange(event)">
		                    </div>
		                  </div>

		                  <div class="layar" id="images-preview">
		                    <div class="images-preview">
		                      <div class="img-wrapper">
		                        <div class="close" id="close">x</div>
		                        <img src="{{ asset('img/gambar_pdf.png') }}" height="200px" width="200px" alt="Image Uploader">
		                        <input type="hidden" id="img_file" name="img_file">
		                        <div class="details">
		                          <span class="name" id="name_img"></span>
		                          <span class="size" id="size_img"></span>
		                        </div>
		                      </div>
		                    </div>
		                  </div>
		                </div>
		                <span class="text-danger">
		                      <strong id="file_error"></strong>
		                  </span>
		              </div>


	            </div>
	            <!-- end modal body -->

	            <div class="modal-footer">
	              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
	              <button
	                type="submit"
	                id="btn-simpan-cascading"
	                class="btn btn-info display"
	              >Save</button>
	            </div>
	          </form>
    </div>
  </div>
</div>
</div>
