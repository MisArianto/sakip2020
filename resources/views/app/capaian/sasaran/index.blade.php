@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<h3> Target Indikator Sasaran RKT Perangkat Daerah
     {{--  @if(Auth::user()->level == 1)
        <a href="{{url ('perencanaan/rkt-sasaran/create')}}"><button class="btn btn-primary">Tambah</button></a>
      @endif --}}
    </h3>


<form action="{{ url ('capaian/dataSasaran')}}" method="POST">
	{{ csrf_field() }}
	<div class="row">
          <div class="col-md-12">
          		@if(Auth::user()->level != 2)
	            <div class="col-md-6">
	              <select class="form-control select2" name="organisasi_no" id="organisasi_no">
		            <option value="">-- Pilih OPD --</option>
		            @foreach($orgs as $data)
		            <option value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
		            @endforeach
	              </select>
	            </div>
	            @endif


	          <div class="col-md-2">
	          	<select class="form-control select2" name="tahun" id="tahun">
	          		<option value="">--Tahun--</option>
	          		@for($i=2017;$i<2022;$i++)
	          		<option value="{{$i}}">{{$i}}</option>
	          		@endfor
	          	</select>
	          </div>

				<div class="col-md-4">
	    			<button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>
	          	</div>
          </div>
    </div>
</form>

<br>
	{{-- <table class="table table-responsive ">
		@foreach($orgss as $o)
		<tr>
			<td style="width: 7%;">Nama Organisasi</td>
			<td style="width: 2%;">:</td>
			<td>{{$o->organisasi_nama}}</td>
		</tr>
		@endforeach
		<tr>
			<td>Periode</td>
			<td >:</td>
			<td>2016-2021</td>
		</tr>
	</table> --}}
    @foreach($opds as $o)
		<h4 style="font-weight: bold; color: salmon;">{{$o->organisasi_nama}}</h4>
		@endforeach
    {{-- <h5>Periode 2016-2021</h5> --}}
	<div class="tavle table-responsive">
              <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
                <tr style=" background-color: #007bff;">
                    <th rowspan="2" style="vertical-align: middle;">No</th>
                    <th rowspan="2" style="vertical-align: middle;">Indikator Sasaran</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th>
                    <th rowspan="2" style="text-align: center;">Target</th>
                    <th colspan="4" style="text-align: center;">Realisasi</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Capaian</th>
    			</tr>
    			<tr style=" background-color: #007bff;">
    				<th style="text-align: center;">TW I</th>
    				<th style="text-align: center;">TW II</th>
    				<th style="text-align: center;">TW III</th>
    				<th style="text-align: center;">TW IV</th>
    			</tr>
                 
                <tbody>
                
        			
                @foreach($capaian_sasaran as $cs)
                <tr >
                    <td style="text-align: center;">{{$no++}}</td>
                    <td title="Indikator Sasaran">{{$cs->indikator_sasaran_nama}}</td>
                    {{-- @foreach($target_sasaran as $ts)
                    @if($is->id==$ts->indikator_sasaran_id) --}}
                    <td title="Satuan" style="text-align: center;">{{$cs->satuan_nama}}</td>
                    <td title="Target" style="text-align: center;">{{$cs->target_t}}</td>
                    <td title="Realisasi TW I" style="text-align: center;">{{$cs->tw_1}}</td>
                    <td title="Realisasi TW II" style="text-align: center;">{{$cs->tw_2}}</td>
                    <td title="Realisasi TW III" style="text-align: center;">{{$cs->tw_3}}</td>
                    <td title="Realisasi TW IV" style="text-align: center;">{{$cs->tw_4}}</td>
                    <td title="Capaian" style="text-align: center;">@php 

                        // if(is_numeric($cs->target_t) || is_float($cs->target_t)){
                            $arr = array($cs->tw_1, $cs->tw_2, $cs->tw_3, $cs->tw_4);

                            echo round(max($arr)/$cs->target_t * 100, 2);
                        // }
                        

                @endphp %</td>
                </tr>
                {{-- @endif
                @endforeach --}}
                @endforeach
                </tbody>
              </table>
            </div>

</div>
@endsection

