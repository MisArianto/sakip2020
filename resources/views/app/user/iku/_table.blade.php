<div class="table-responsive">
   <table class="table table-hover table-bordered" style="font-size: 12px;">
        <thead>
            <tr>           
                <th style=" text-align: center;width: 50px;" rowspan="2">Aksi</th>
                <th style=" text-align: center; " rowspan="2">Sasaran Strategis</th>
                <th style=" text-align: center; " rowspan="2">Indikator Kinerja Utama</th>
                <th style=" text-align: center; " rowspan="2">Satuan</th>
                <th style=" text-align: center; " colspan="4"> Penjelasan</th>
            </tr>
            <tr>
                <th style=" text-align: center;">Alasan</th>
                <th style=" text-align: center;">Formulasi/Cara Pengukuran</th>
                <th style=" text-align: center;width: 10%;">Sumber Data</th>
                <th style=" text-align: center; ">Keterangan</th>
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