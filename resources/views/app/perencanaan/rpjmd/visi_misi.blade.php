@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
<div class="box-header">
    <h3> Visi dan Misi</h3>
    @foreach($periode as $p)
    <h4>Periode {{$p->periode}}</h4>
    @endforeach
</div>
<div class="box-body">
	<div class="table-responsive">
    <table class="table table-responsive table-hover">
      <thead>
        <tr>
          <th style=" font-weight: bold; background-color: #00a6c6;"><h4>Visi :</h4></th>
        </tr>
      </thead>
      <tbody>
        @foreach($visi as $v)
        <tr>
          <td style="text-align: center; font-weight: bold;">{{$v->nama}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    <br>
  <div class="table-responsive">
		<table class="table table-responsive table-hover">
			<thead>
			<tr>
				<th style="font-weight: bold; background-color: #6fd8ff;" colspan="2"><h4>Misi :</h4></th>
			</tr>
			</thead>
			<tbody>
			@foreach($misi as $m)
							<tr>
                <td>{{$m->nomor}}.</td>
								<td>{{$m->nama}}</td>
							</tr>
			@endforeach 
		  </tbody>
      </table>
                    
	</div>
</div>


                     
             
</div>
</div>
@endsection
