<div
  class="modal fade"
  id="myModal"
  tabindex="-1"
  role="dialog"
  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pegawai</h5>
        <button type="button" class="close btn-tutup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">

        	<div class="input-group mb-3">
            	<input type="text" name="nip" id="nip" class="form-control" placeholder="Cari NIP disini">

              	<span class="text-danger">
                  <strong id="nip_error"></strong>
              	</span>	

              	<div class="input-group-prepend">
                  <input class="btn btn-primary" id="cari" type="submit" value="Cari">
                </div>
            </div>

            <div class="table-responsive">
	            <table class="table table-hover table-stripped">
	            	<thead>
	            		<th>NIP</th>
	            		<th>Nama</th>
	            		<th>Jabatan</th>
	            		<th>#</th>
	            	</thead>
	            	<tbody id="load_tambah_pegawai">
	            		
	            	</tbody>
	            	<tbody class="layar" id="loadingTable">
			            <tr>
			                <td colspan="4" align="center">
			                    @include('layouts._spinner')
			                    <br>
			                    Loading...
			                </td>
			            </tr>
			        </tbody>
	            </table>
            </div>
	    </div>
    </div>
  </div>
</div>
</div>
