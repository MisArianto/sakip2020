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
    <h4 style="color: #007bff; font-weight: bold;" >Pohon Kinerja Rpjmd
    	@foreach($org as $o)
    		{{$o->organisasi_nama}}
    	@endforeach
		<a href="{{ url('perencanaan-kinerja') }}" class="btn btn-primary">Kembali</a>
    </h4>
</div>

 <div class="box-body">


<form action="{{ url ('cascading/pohon-kinerja-rpjmd/data')}}" method="POST" id="form-pohon-kinerja">
        {{ csrf_field() }}

        <div class="row">
              <div class="col-md-12">

                <div class="col-md-4">
                <select class="form-control select2" name="organisasi_no" id="organisasi_no">
                <option value="">-- Pilih OPD --</option>
                @foreach($opd as $data)
                <option @if($opd=="$data->organisasi_no") selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
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

        <br>

        <table class="table table-responsive table-bordered table-hover">
            <thead>
            <tr style="background-color: #007bff; color: #fff;">
                <td style="height: 10px;">File</td>
                <td style="height: 10px;">Date</td>
                <td style="height: 10px;">Aksi</td>
            </tr>
            </thead>
            <tbody>
                @foreach($cascading_rpjmd as $data)
                <tr>
                    <td>{{$data->nama_file}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>
                      <form action="{{ url('cascading/download-cascading-rpjmd') }}" method="POST" style="display: inline;">
                          @csrf

                          <input type="hidden" name="org" value="{{ str_replace('-', ' ', $data->organisasi_nama)}}">
                          
                          <button class="btn btn-primary btn-xs" data-toggle="tooltip" title="Download {{$data->nama_file}}"><i class="fa fa-download"></i></button>

                      </form>
                         {{-- <a href="{{ \Storage::path('public/cascading_rpjmd/'.$data->nama_file) }}" id="embedURL">Download file</a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
    	</table>
    </div>

</div>
</div>



<script src="{{ asset ('js/jquery.min.js')}}"></script>
<script src="{{ asset ('js/zohoviewer/jquery.zohoviewer.js')}}"></script>
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

  	$('#embedURL').zohoViewer();


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