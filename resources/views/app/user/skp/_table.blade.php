<div class="table-responsive">
   <table class="table table-hover table-striped">
        <thead>
            <tr>
                <td>No</td>
                <td>Aksi</td>
                <td>Nama</td>
                <td>Jabatan</td>
            </tr>
        </thead>
        <tbody id="load">
            <!-- load ajax -->
        </tbody>
        <tbody class="layar" id="loadingTable">
            <tr>
                <td colspan="4" align="center">
                    @include('layouts._spinner')
                </td>
            </tr>
        </tbody>
    </table>
</div>