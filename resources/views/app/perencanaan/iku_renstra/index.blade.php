@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
                     
  
    <h4> Indikator Kinerja Utama
    	@if(Auth::user()->level == 3)
    	@foreach($opd as $data)
    	{{$data->organisasi_nama}}
    	@endforeach
    	@endif
   
   {{--  &nbsp;
	@if(Auth::user()->level != 3)
        <a href="{{route ('iku-renstra.create')}}"><button class="btn btn-sm btn-primary">Tambah</button></a>
      @endif --}}
    </h4>

@if(Auth::user()->level != 2)
<form action="{{ url ('perencanaan/iku-renstra/dataIku')}}" method="POST">
	@csrf
	<div class="row">
          <div class="col-md-12">

            <div class="col-md-4">
              <select class="form-control select2" name="organisasi_no" id="organisasi_no">
            <option value="">-- Pilih OPD --</option>
            @foreach($opd as $data)
            <option @if($opds==$data->organisasi_no) selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
            @endforeach
              </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" name="tahun" id="tahun">
                    <option value="">-- Pilih Tahun --</option>
                    <option @if('2017' == $tahun) selected @endif value="2017">2017</option>
                    <option @if('2018' == $tahun) selected @endif value="2018">2018</option>
                    <option @if('2019' == $tahun) selected @endif value="2019">2019</option>
                    <option @if('2020' == $tahun) selected @endif value="2020">2020</option>
                    <option @if('2021' == $tahun) selected @endif value="2021">2021</option>
                </select>
            </div>
			<div class="col-md-4">
    		<button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>

          </div>
          </div>
    </div>
</form>
@endif


<br>
@if(Auth::user()->level == 2)
<form action="{{ url ('perencanaan/iku-renstra/dataIku')}}" method="POST">
	@csrf
	<div class="col-md-12">
	<input type="hidden" value="{{Auth::user()->organisasi_no}}" name="organisasi_no" id="organisasi_no">
          
            <div class="col-md-2">
                <select class="form-control" name="tahun" id="tahun">
                    <option value="">-- Pilih Tahun --</option>
                    <option @if('2017' == $tahun) selected @endif value="2017">Tahun 2017</option>
                    <option @if('2018' == $tahun) selected @endif value="2018">Tahun 2018</option>
                    <option @if('2019' == $tahun) selected @endif value="2019">Tahun 2019</option>
                    <option @if('2020' == $tahun) selected @endif value="2020">Tahun 2020</option>
                    <option @if('2021' == $tahun) selected @endif value="2021">Tahun 2021</option>
                    {{-- <option @if('2020' == $tahun) selected @endif value="2020">2020</option> --}}
                </select>
            </div>
			<div class="col-md-4">
    		<button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>

          </div>
          </div>
</form>
@endif
<br>
<br>
<br>

	<div class="table-responsive table-bordered">
		<table class="table table-responsive table-bordered">
				<thead>
					<tr  style="font-size: 13px; background-color: salmon;">			
						<th style=" text-align: center; vertical-align: center; " rowspan="2">Sasaran Strategis</th>
						<th style=" text-align: center; vertical-align: center; " rowspan="2">Indikator Kinerja Utama</th>
						<th style=" text-align: center; vertical-align: center; " rowspan="2">Satuan</th>
						<th style=" text-align: center; vertical-align: center; " colspan="4"> Penjelasan</th>
						@if(Auth::user()->level != 3)
						<th style=" text-align: center; vertical-align: center;  width: 50px;" rowspan="2">Aksi</th>
						@endif
					</tr>
					<tr style="font-size: 13px; background-color: salmon;">
						<th style=" text-align: center; vertical-align: center; ">Alasan</th>
						<th style=" text-align: center; vertical-align: center; ">Formulasi/Cara Pengukuran</th>
						<th style=" text-align: center; vertical-align: center; width: 10%;">Sumber Data</th>
						<th style=" text-align: center; vertical-align: center;  ">Keterangan</th>
					</tr>
				</thead>
			<tbody>
				@foreach(collect($sasaran)->unique('sasaran_id') as $s)
				<tr style="background-color: #00a6c6; font-weight: bold;">
					<td colspan="8">{{$s->sasaran_nama}}</td>
				</tr>
				@foreach(collect($sasaran)->unique('indikator_sasaran_id')->where('sasaran_id', $s->sasaran_id) as $is)
				
				<tr style="font-size:  12px;">
					<td></td>
					<td>{{$is->indikator_sasaran}}</td>
					<td style="text-align: center;">{{$is->satuan_nama}}</td>
					<td>{{$is->alasan}}</td>
					<td>{{$is->formulasi}}</td>
					<td>{{$is->sumber_data}}</td>
					<td>{{$is->keterangan}}</td>
					{{-- @if(Auth::user()->level != 3)
					<td style="text-align: center;">
						
						<form action="{{ url('perencanaan/iku-renstra/destroy',$is->iku_id) }}" method='POST' style="display: inline;">
							{{ csrf_field() }}

							<input type="hidden" name="_method" value="DELETE">
							<button onclick="return ConfirmDelete();" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash-o" ></i></button>
						</form>
					</td>
					@endif --}}
				</tr>
     			@endforeach
     			@endforeach
		  </tbody>
      </table>
                    
	</div>


                     
             
</div>
@endsection
