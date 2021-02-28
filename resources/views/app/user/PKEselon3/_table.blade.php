<div class="table-responsive">
   <table class="table table-hover table-bordered" id="table-pk" style="font-size:12px;">
        <thead>
            <tr>
                <th style="text-align: center;" >Aksi</th>      
                <th>Sasaran Strategis</th>
                <th>Indikator Sasaran</th>
                <th>Program</th>
                <th style="text-align: center;">Jabatan</th>
                <th style="text-align: center;">Satuan</th>
                <th style="text-align: center;">Target</th>
                <th style="text-align: center;">Pagu</th>
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