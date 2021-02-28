<br>
<div class="table-responsive">
		<div class="table-responsive">
		    <table class="table table-responsive table-hover">
		      <thead>
		        <tr>
		          <th style=" font-weight: bold; background-color: #007bff;"><h4>Visi :</h4></th>
		        </tr>
		      </thead>
		      <tbody>
		        @foreach($visi as $v)
		        <tr>
		          <td style=" font-weight: bold;">- {{$v->nama}}</td>
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
						<th style="font-weight: bold; background-color: #007bff;" colspan="2"><h4>Misi :</h4></th>
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