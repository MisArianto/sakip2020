
<div class="table-responsive">
   <table class="table table-bordered" id="table-pk" style="font-size:12px;">
        <thead>
           <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">Indikator Sasaran</th>
                <th style="text-align: center;">Capaian Kinerja</th>
                <th style="text-align: center;">Target</th>
                <th style="text-align: center;">Kinerja</th>
                <th style="text-align: center;">Anggaran</th>
                <th style="text-align: center;">Rekomendasi</th>
                <th style="text-align: center;">#</th>
            </tr>
        </thead>
        <tbody id="load">
            <!-- load ajax -->
            
        </tbody>
        <tbody class="layar" id="loadingTable">
            <tr>
                <td colspan="12" align="center">
                    @include('layouts._spinner')
                </td>
            </tr>
        </tbody>
    </table>
</div>