@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
<div class="box-header">
    <h4> Tujuan RPJMD</h4>
    @foreach($periode as $p)
    <h5>Periode {{$p->periode}}</h5>
    @endforeach
</div>
<div class="box-body">
<br>
	<div class="table-responsive">
		<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
			<thead>
				
			
			<tr style="background-color: #007bff;">
		        <th>Misi</th>
		        <th >No / Tujuan</th>
		        {{-- @if(Auth::user()->level == 1)
		        <th style="text-align: center;">Aksi</th>
		        @endif --}}
	        </tr>
      		</thead>
					<tbody>
					@foreach($misi as $m)
					<tr>
					<td colspan="3" style="font-weight: bold; ">Misi Ke : {{$m->nomor}}. {{$m->nama}}</td>
					</tr>
					@foreach($tujuan as $t)
					@if($m->id==$t->misi_id)
					<tr>
					<td></td>
					<td>{{$t->tujuan_no}} &nbsp;{{$t->tujuan_nama}}</td>
					{{-- @if(Auth::user()->level == 1)
					<td style="text-align: center;">
					<a href="#"><button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button></a>
					<a href="#"><button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></a>
					</td>
					@endif --}}
					</tr>
					@endif
					@endforeach 
			@endforeach 
		  </tbody>
      </table>
                    
	</div>
</div>


                     
             
</div>
@endsection
