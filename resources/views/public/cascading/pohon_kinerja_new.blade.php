<html>
<head>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>e-sakip</title>
  	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{ asset ('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset ('bower_components/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{ asset ('orgchart/css/jquery.orgchart.css')}}">
	<link rel="stylesheet" href="{{ asset ('dist/css/AdminLTE.css')}}">
	<link rel="stylesheet" href="{{ asset ('css/font.css')}}">
	<link rel="stylesheet" href="{{ asset ('orgchart/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset ('css/select2.min.css')}}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style>
	.select2 {
		width:100%!important;
		}
		
	</style>
</head>
<body style="font-family: Philosopher;">
	

<div class="box box-default" style="padding: 10px;">
	<div class="box-header">
    <h4 style="color: #007bff; font-weight: bold;" >Pohon Kinerja 
    	@foreach($org as $o)
    		{{$o->organisasi_nama}}
    	@endforeach
    </h4>
</div>

 <div class="box-body">


<form action="{{ url ('cascading/pohon-kinerja/data')}}" method="POST" id="form-pohon-kinerja">
        {{ csrf_field() }}

        <div class="row">
              <div class="col-md-12">

                <div class="col-md-4">
                <select class="form-control select2" name="organisasi_no" id="organisasi_no">
                <option value="">-- Pilih OPD --</option>
                @foreach($opd as $data)
                <option @if($opds=="$data->organisasi_no") selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                @endforeach
                </select>
                </div>
                <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary" title="Cari"><i class="fa fa-search"></i></button>

              </div>
              </div>
        </div>
    </form>
    <div class="box-body">
        <div class="row">
            <div class="table-responsive">
                    <div class="col-md-12">
                    	<ul id="ul-data">
					    <li>VISI
					      <ul>
					        <li>MISI
					        	<ul>
					            <li>TUJUAN
					            	<ul>
					                <li>SASARAN
					                	<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul>
					                </li>
					                <li>SASARAN<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul></li>
					              </ul>
					          </li>
					            <li>TUJUAN
					              <ul>
					                <li>SASARAN<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul></li>
					                <li>SASARAN<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul></li>
					              </ul>
					            </li>
					          </ul>
					        </li>
					        <li>MISI
					          <ul>
					            <li>TUJUAN
					            	<ul>
					                <li>SASARAN
					                	<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul>
					                </li>
					                <li>SASARAN<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul></li>
					              </ul>
					          </li>
					            <li>TUJUAN
					              <ul>
					                <li>SASARAN<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul></li>
					                <li>SASARAN<ul>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						                <li>INDIKATOR SASARAN
						                <ul>
						                <li>PROGRAM</li>
						                <li>PROGRAM</li>
						              </ul></li>
						              </ul></li>
					              </ul>
					            </li>
					          </ul>
					        </li>
					      </ul>
					    </li>
					  </ul>
					  <div id="chart-container"></div>
                        {{-- <ul id="ul-data">
                            @foreach($visi as $v)
                                <li>{{ $v->nama }}
                                    @foreach(collect($misi)->where('visi_id', $v->id) as $m)
                                    <ul>
                                        <li>MISI : <br>
                                            <button class="btn btn-primary"data-toggle="tooltip" title="MISI" style="font-weight: bold;background-color: #00a65a;color:white;padding: 10px;">- {{$m->nama}}</button>
                                            @foreach(collect($tujuan)->where('misi_nomor', $m->nomor) as $t)
                                            <ul>
                                                <li>TUJUAN : <br>
                                                    <button class="btn btn-primary"data-toggle="tooltip" title="TUJUAN" style="font-weight: bold;background-color: #f39c12;color:white;padding: 10px;">- {{$t->tujuan_nama}}</button>
                                                    @foreach(collect($sasaran)->where('tujuan_nomor', $t->tujuan_nomor) as $s)
                                                    <ul>
                                                        <li>SASARAN : <br>
                                                            <button class="btn btn-primary"data-toggle="tooltip" title="SASARAN" style="font-weight: bold;background-color: #17a2b8;color:white;padding: 10px;">- {{$s->sasaran_nama}}</button>
                                                            @foreach(collect($indikator_sasaran)->where('sasaran_nomor', $s->sasaran_nomor) as $is)
                                                            <ul>
                                                                <li>INDIKATOR SASARAN : <br>
                                                                <button class="btn btn-primary"data-toggle="tooltip" title="INDIKATOR SASARAN" style="font-weight: bold;background-color: salmon;color:white;padding: 10px;">- {{$is->indikator_sasaran_nama}}</button>
                                                                @foreach(collect($program)->where('indikator_sasaran_id', $is->id) as $p)
                                                                <ul>
                                                                    <li>PROGRAM : <br>
                                                                    <button class="btn btn-primary"data-toggle="tooltip" title="PROGRAM" style="font-weight: bold;background-color: #605ca8;color:white;padding: 10px;">- {{$p->program_nama}}</button>
                                                                    @foreach(collect($kegiatans)->where('program_no', $p->program_no) as $k)
                                                                    <ul>
                                                                        <li>KEGIATAN : <br>
                                                                        <button class="btn btn-primary"data-toggle="tooltip" title="KEGIATAN" style="font-weight: bold;background-color: #dc3545;color:white;padding: 10px;">- {{$k->kegiatan_nama}}</button>
                                                                            <ul>
                                                                                <li>INDIKATOR KEGIATAN : <br>
                                                                                    <button class="btn btn-primary"data-toggle="tooltip" title="INDIKATOR KEGIATAN" style="font-weight: bold;background-color: #3c763d;color:white;padding: 10px;">- {{$k->indikator_kegiatan}}</button>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                    @endforeach
                                                                    </li>
                                                                </ul>
                                                                @endforeach
                                                                </li>
                                                            </ul>
                                                            @endforeach
                                                        </li>
                                                    </ul>
                                                    @endforeach
                                                </li>
                                            </ul>
                                            @endforeach
                                        </li>

                                    </ul>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
 --}}                    </div>
                    </div>
        </div>
    	{{-- <div id="load-data"></div> --}}
    </div>

	{{-- <div class="card-body">
		<center>
			<div id="tree-view"></div>
		</center>	
	</div>
	<div class="card-footer text-muted">

	</div>

	<ul id="tree-data" style="display:none">
		@foreach($visi as $v)
		<li id="root" style="background-color: grey;">
			{{$v->nama}}
			<ul>
				@foreach(collect($misi)->where('visi_id', $v->id) as $m)
				<li id="node1">{{$m->nama}}
					<ul>
						@foreach(collect($tujuan)->where('misi_nomor', $m->nomor) as $t)
						<li id="node2">
							{{$t->tujuan_nama}}
							<ul>
								@foreach(collect($sasaran)->where('tujuan_nomor', $t->tujuan_nomor) as $s)
								<li id="node2">
									{{$s->sasaran_nama}}
									@foreach(collect($indikator_sasaran)->where('sasaran_nomor', $s->sasaran_nomor) as $is)
                                        <ul>
                                            <li id="node2">
                                            - {{$is->indikator_sasaran_nama}}
                                            @foreach(collect($program)->where('indikator_sasaran_id', $is->id) as $p)
                                            <ul>
                                                <li id="node2">
                                                - {{$p->program_nama}}
                                                @foreach(collect($kegiatans)->where('program_no', $p->program_no) as $k)
                                                <ul>
                                                    <li id="node2">
                                                    - {{$k->kegiatan_nama}}
                                                        <ul>
                                                            <li id="node2">
                                                                - {{$k->indikator_kegiatan}}
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                @endforeach
                                                </li>
                                            </ul>
                                            @endforeach
                                            </li>
                                        </ul>
                                        @endforeach
								</li> 
								@endforeach
							</ul>
						</li>
						@endforeach
					</ul>
				</li>
				@endforeach
			</ul>
		</li>
		@endforeach
	</ul> --}}
</div>
</div>



<script src="{{ asset ('js/jquery.min.js')}}"></script>
<script src="{{ asset ('orgchart/js/jquery.orgchart.js') }}"></script>
<script src="{{ asset ('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset ('js/select2.min.js') }}"></script>
<script src="{{ asset ('dist/js/adminlte.min.js')}}"></script>

{{-- <script src="{{ asset ('js/jquery-1.7.2.min.js') }}"></script> --}}
<script>
  $(document).ready(function() {

  	$.ajaxSetup({
  		headers: {
  			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
  	});


    $('.select2').select2();
	});

  	 $(function() {

      $('#chart-container').orgchart({
        'data' : $('#ul-data')
      });

    });

 

</script>
{{-- <script type="text/javascript">
    $(document).ready(function () {
		$("#tree-data").jOrgChart({
			chartElement: $("#tree-view"), 
			nodeClicked: nodeClicked
		});
		// lighting a node in the selection
		function nodeClicked(node, type) {
			node = node || $(this);
			$('.jOrgChart .selected').removeClass('selected');
			node.addClass('selected');
		}
	});

</script> --}}
<script type="text/javascript">
    var str1 = "</bo";
    var str2 = "dy>";
    var str3 = "</html>";
    document.write(str1.concat(str2, str3));
</script>