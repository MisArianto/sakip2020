<html>
	<head>
	<title>Hi</title>
</head>
<body>
	

<div class="box-body">
           {{-- <table class="table table-responsive table-striped table-bordered" id="users-table"> --}}
           <table class="table table-responsive table-bordered table-hover" id="userTable">
                    <thead>
                    <tr style="background-color: #007bff;">
                        <th style="height: 10px; width: 3%;">No</th>
                        <th style="height: 10px;">Username</th>
                        <th style="height: 10px;">Nama</th>
                        <th style="height: 10px;">Status</th>
                        <th style="height: 10px;">Nama OPD</th>
                        
                        
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="text-align: center;">{{$no++}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->nama}}</td>
                            <td>
                            @if($user->level == 1)
                            <span class="label label-danger">Admin</span>
                            @elseif($user->level == 2)
                            <span class="label label-primary">User</span>
                            @elseif($user->level == 3)
                            <span class="label label-success">Pengawas</span>
                            @endif
                            </td>
                            @if(App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->first() == null)
                            <td>Admin Kabupaten</td>
                            @elseif(App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->first() != null)
                            <td>{{App\Models\Organisasi::where('organisasi_no', $user->organisasi_no)->first()->organisasi_nama}}</td>
                            @endif
                            
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
        </body>
        </html>