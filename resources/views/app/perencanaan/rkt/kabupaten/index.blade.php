@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
	<div class="box-header">
	<h4> RKT Kabupaten
      {{-- @if(Auth::user()->level == 1)
        <a href="{{url ('perencanaan/rkt-kegiatan/create')}}"><button class="btn btn-primary">Tambah</button></a>
      @endif --}}
    </h4>
	</div>

<form action="{{ url ('perencanaan/rkt-kab/dataRkt')}}" method="POST">
	{{ csrf_field() }}
	<div class="row">
          <div class="col-md-12">


	          <div class="col-md-2">
	          	<select class="form-control select2" name="tahun" id="tahun">
					<option value="">--Pilih Tahun--</option>
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
<div class="box-body">
	<div class="table table-responsive">
              <table class="table table-responsive table-bordered table-hover  tablepretty" style="font-size: 12px;">
                <tr style="height: 40px; vertical-align: middle; background-color: #007bff;">
                    <th>Tujuan</th>
                    <th colspan="2">Sasaran</th>
                    <th colspan="2">Indikator Sasaran</th>
                    <th style="text-align: center;">Satuan</th>
                    <th style="text-align: center;">Target</th>
          			</tr>
            <tbody>
                @foreach($tujuan as $t)
              <tr>
                <td colspan="12" style="font-weight: bold; background-color: #7abaff;" title="Tujuan">{{$t->tujuan_nama}}</td>
              </tr>
      			@foreach(collect($sasaran)->where('tujuan_id', $t->id) as $s)
			      {{-- @if($t->id==$s->tujuan_id) --}}
      			<tr>
      				<td></td>
               {{-- <td style="text-align: center;font-weight: bold;">{{$no++}}</td> --}}
                <td colspan="11" style="font-weight: bold;" title="Sasaran">{{$no++}}. {{$s->sasaran_nama}}</td>
            </tr>
                {{-- @foreach($indikator_sasaran as $is) --}}
                @foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
                {{-- @if($s->id==$is->sasaran_id) --}}
                <tr >
                  <td colspan="3"></td>
                  <td>-</td>
                <td title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
                {{-- @foreach($target_rkt as $t) --}}
                @foreach(collect($target_rkt)->where('indikator_sasaran_id', $is->id) as $t)
                {{-- @if($is->id==$t->indikator_sasaran_id) --}}
                <td style="text-align: center;">{{$t->satuan_nama}}</td>
                <td style="text-align: center;">{{$t->target_t3}}</td>
                </tr>
                
                {{-- @endif --}}
                @endforeach
                {{-- @endif --}}
                @endforeach
      {{-- @endif --}}
      
      
      @endforeach 
			@endforeach 
                </tbody>
              </table>
        </div>

</div>
@endsection

