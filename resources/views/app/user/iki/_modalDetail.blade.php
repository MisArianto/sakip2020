<div
  class="modal fade bd-example-modal-xl"
  id="myModalDetail"
  tabindex="-1"
  role="dialog"
  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
>
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Indikator Kinerja Individu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	    <div class="modal-body">
	      <div class="text-center layar" id="modal-loading-on">
			    @include('layouts._spinner')
			</div>

			<div id="modal-loading-off">
		      <div class="table-responsive">
					<table class="table table-striped table-hover mb-2" id="load_pegawai_pimpinan">
						
					</table>

					<h4>URAIAN</h4>

					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<td align="center">No</td>
								<td>Sasaran Strategis</td>
								<td>Indikator Sasaran</td>
								<td>Satuan</td>
								<td>Target</td>
							</tr>
						</thead>
						<tbody id="load_iki">
							
						</tbody>
					</table>
				</div>
			</div>
	    </div>
    </div>
  </div>
</div>

