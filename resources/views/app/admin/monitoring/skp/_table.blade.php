<div class="table-responsive">
    <table class="table table-bordered" style="font-size:12px;">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-center">OPD</th>
                <th class="text-center">tahun 2018</th> 
                <th class="text-center">tahun 2019</th>
                <th class="text-center">tahun 2020</th>
                <th class="text-center">tahun 2021</th>
            </tr>
        </thead>
        <tbody id="load">
        </tbody>
        <tbody class="layar" id="loadingTable">
            <tr>
                <td colspan="6" align="center">
                    @include('layouts._spinner')
                    <br>
                    <p>Tunggu Sebentar, Sedang Load Data...</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>