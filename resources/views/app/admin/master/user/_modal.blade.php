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
        <h5 class="modal-title" id="title-tambah">Tambah User</h5>
        <h5 class="modal-title" id="title-edit">Edit User</h5>
        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
	          <form id="form" url="{{ url('admin/master/user/store') }}" urlUpdate="{{ url('admin/master/user/update') }}">
	            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	            <input type="hidden" class="display" name="id" id="id">
	            <div class="modal-body">

	            	<div class="form-group">
	                  <label for="nama" class="control-label">Nama</label>

	                    <input id="nama" type="text" class="form-control" name="nama" autofocus>
	                   	<span class="text-danger">
	                        <strong id="nama_error"></strong>
	                    </span>
	                </div>

	            	<div class="form-group">
	                  <label for="username" class="control-label">Username</label>
	                  
	                    <input id="username" type="text" class="form-control" name="username" autofocus>
	                   	<span class="text-danger">
	                        <strong id="username_error"></strong>
	                    </span>
	                </div>
	                <div class="form-group">
	                  <label for="password" class="control-label">Password</label>
	                  
	                    <input id="password" type="password" minlength="6" class="form-control" name="password">
	                    <span class="text-danger">
	                        <strong id="password_error"></strong>
	                    </span>
	                </div>
	                <div class="form-group">
	                  <label for="level" class="control-label">Level</label>
	                  
	                      <select name="level" id="level" class="form-control select2">
	                          <option value="">Pilih</option>
	                          <option value="1">Admin</option>
	                          <option value="2">User</option>
	                          <option value="3">Pengurus</option>
	                      </select>
	                      <span class="text-danger">
	                        <strong id="level_error"></strong>
	                    </span>
	                  </div>
	                <div class="form-group">
	                    <label for="opd" class="control-label">OPD</label>
	                    
	                        <select name="opd" id="opd" class="form-control select2">
	                            <option value="">Pilih</option>
	                        </select>
	                       <span class="text-danger">
		                    </span>
	                    </div>
	                </div>

	            </div>
	            <!-- end modal body -->

	            <div class="modal-footer">
	              <button type="button" class="btn btn-secondary btn-tutup" data-dismiss="modal">Close</button>
	              <button
	                type="submit"
	                id="btn-simpan"
	                class="btn btn-info display"
	              >Save</button>
	              <button
	                type="submit"
	                id="btn-update"
	                class="btn btn-primary display"
	              >Update</button>
	            </div>
	          </form>
    </div>
  </div>
</div>
</div>
