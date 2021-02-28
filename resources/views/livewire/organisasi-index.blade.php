<div>
    <div class="card card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4>Data Organisasi</h4>
    </div>
        <div class="card-body">

         <div class="row">
            <div class="col-md-3">
                <input type="text" wire:model="search" class="form-control" placeholder="Cari...">
            </div>
        </div>
        <br>
        <br>

        @if(Auth::user()->level == 1)
        <div class="alert alert-warning">{{json_encode($api->original['message'])}}</div>
        @endif
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="orgs-table">
                        <thead>
                        <tr style="background-color: #007bff;">
                            <th style="height: 10px; width: 12%;">Kode Organisasi</th>
                            <th style="height: 10px;">Nama Organisasi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;?>
                            @foreach($orgs as $o)
                            <tr>
                                <td>{{$o->organisasi_no}}</td>
                                <td>{{$o->organisasi_nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                {{$orgs->links()}}
            </div>
        </div>
    </div>
</div>
