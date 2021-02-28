<div class="table-responsive mt-3">
   <table class="table table-bordered" style="font-size:12px;">
        <thead>
           <tr>
                <th rowspan="2" colspan="2">Program</th>
                <th rowspan="2">Kegiatan</th>
                <th rowspan="2">Indikator Kegiatan</th>
                <th rowspan="2" class="text-center">Satuan</th>
                <th colspan="2" class="text-center">Target RKT</th>
            </tr>
            <tr>
                <th class="text-center">Target</th>
                <th class="text-center">Pagu</th>
            </tr>
        </thead>
        <tbody id="load_target_prokeg">
            <!-- load ajax -->
            
        </tbody>
        <tbody class="layar" id="loadingTableTargetProkeg">
            <tr>
                <td colspan="12" align="center">
                    @include('layouts._spinner')
                </td>
            </tr>
        </tbody>
    </table>
</div>