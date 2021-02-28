<div>
   <div class="card card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4>Data Kegiatan</h4>
    </div>

        <div class="card-body">

        <div class="row">
            <div class="col-md-3">
                <input type="text" wire:model="search" class="form-control" placeholder="Cari...">
            </div>
        </div>
        <br>
        <br>
        <div class="table-responsive">

        @if(Auth::user()->level == 1)
        <div>{{json_encode($api->original['message'])}}</div>
        @endif
           <table class="table table-hover table-bordered" id="keg-table">
                    <thead>
                    <tr style="background-color: #007bff;">
                        <th style="height: 10px; width: 12%;">Kode Kegiatan</th>
                        <th style="height: 10px;">Nama Kegiatan</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        @foreach($kegiatans as $kegiatan)
                        <tr>
                            <td>{{$kegiatan->kegiatan_no}}</td>
                            <td>{{$kegiatan->kegiatan_nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
             {{$kegiatans->links()}}
            </div>
        </div>
    </div>
</div>
