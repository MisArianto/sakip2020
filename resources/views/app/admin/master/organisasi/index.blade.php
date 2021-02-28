@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Data Organisasi</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
           <table class="table table-hover table-bordered" style="font-size: 12px;">
                    <thead>
	                    <tr>
	                    	<th>#</th>
	                        <th>Kode Organisasi</th>
	                        <th>Nama Organisasi</th>
	                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orgs as $o)
                        <tr>
                        	<td>{{ $no++ }}</td>
                            <td>{{$o->organisasi_no}}</td>
                            <td>{{$o->organisasi_nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
         </div>
    </div>
</div>
        
@endsection