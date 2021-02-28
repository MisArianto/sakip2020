<div>
    <div class="card card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4>Data Program</h4>
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
        <div>{{json_encode($api->original['message'])}}</div>
        @endif
        <div class="table-responsive">
           <table class="table table-hover table-bordered" id="prgrm-table">
                    <thead>
                    <tr style="background-color: #007bff;">
                        <th style="height: 10px; width: 12%;">Kode Program</th>
                        <th style="height: 10px;">Nama Program</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $program)
                        <tr>
                            <td>{{$program->program_no}}</td>
                            <td>{{$program->program_nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
            {{$programs->links()}}
            </div>
        </div>
    </div>
</div>
