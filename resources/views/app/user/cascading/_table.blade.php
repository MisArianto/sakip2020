<div class="table-responsive">
   <table class="table table-bordered" style="font-size:12px;">
        <thead>
           <tr>
                <td>File</td>
                <td>Tahun</td>
                <td>Date</td>
                <td>Aksi</td>
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