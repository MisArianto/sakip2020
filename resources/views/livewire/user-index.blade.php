<div>
   <div class="card card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4>Data Users</h4>
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
           <table class="table table-bordered table-hover" id="userTable">
                    <thead>
                    <tr style="background-color: #007bff; color: #fff;">
                        <td style="height: 10px; width: 3%;">No</td>
                        <td style="height: 10px;">Username</td>
                        <td style="height: 10px;">Nama</td>
                        <td style="height: 10px;">Nama OPD</td>
                        <td style="height: 10px;">Status</td>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        @foreach($users as $user)
                        <tr>
                            <td style="text-align: center;">{{$no++}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->nama}}</td>
                            @if(App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->first() == null)
                            <td>Admin Pusat</td>
                            @elseif(App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->first() != null)
                            <td>{{App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->orderBy('organisasi_no')->first()->organisasi_nama}}</td>
                            @endif
                            <td style="text-align: center;">
                            @if($user->level == 1)
                            <span class="label label-danger">Admin</span>
                            @elseif($user->level == 2)
                            <span class="label label-primary">User</span>
                            @elseif($user->level == 3)
                            <span class="label label-success">Pengawas</span>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
            {{$users->links()}}
            </div>
        </div>
    </div>
</div>
