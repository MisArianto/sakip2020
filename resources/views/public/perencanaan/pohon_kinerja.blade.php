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
	

<div class="card" style="padding: 10px;">
	<div class="card-header">
    <h4 style="color: #007bff; font-weight: bold;" >Pohon Kinerja 
    	@foreach($org as $o)
    		{{$o->organisasi_nama}}
    	@endforeach
		<a href="{{ url('perencanaan-kinerja') }}" class="btn btn-primary">Kembali</a>
    </h4>
</div>

 <div class="card-body">


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
                    	
					  <div id="chart-container"></div>

						<ul id="ul-data" style="display:none;background: yellow">
							@foreach($visi as $v)
							<li>
								{{$v->nama}}
								<ul>
									@foreach(collect($misi)->where('visi_id', $v->id) as $m)
									<li>{{$m->nama}}
										<ul>
											@foreach(collect($tujuan)->where('misi_id', $m->id) as $t)
											<li>
												{{$t->tujuan_nama}}
												<ul>
													@foreach(collect($sasaran)->where('tujuan_id', $t->id) as $s)
													<li>
														{{$s->sasaran_nama}}
														@foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
					                                        <ul>
					                                            <li>
					                                             {{$is->indikator_sasaran_nama}}
					                                            @foreach(collect($program)->where('indikator_sasaran_id', $is->id) as $p)
					                                            <ul>
					                                                <li>
					                                                 {{$p->program_nama}}
					                                                @foreach(collect($kegiatans)->where('program_no', $p->program_no) as $k)
					                                                <ul>
					                                                    <li>
					                                                     {{$k->kegiatan_nama}}
					                                                        <ul>
					                                                            <li>
					                                                                 {{$k->indikator_kegiatan}}
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
						</ul>
                    </div>
                    </div>
        </div>
    </div>

</div>
</div>



<script src="{{ asset ('js/jquery.min.js')}}"></script>
<script src="{{ asset ('orgchart/js/jquery.orgchart.js') }}"></script>
<script src="{{ asset ('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset ('js/select2.min.js') }}"></script>
<script src="{{ asset ('dist/js/adminlte.min.js')}}"></script>

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
<script type="text/javascript">
    var str1 = "</bo";
    var str2 = "dy>";
    var str3 = "</html>";
    document.write(str1.concat(str2, str3));
</script>