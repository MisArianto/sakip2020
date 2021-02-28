@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
    <div class="box-header">
    <h4> Sasaran RPJMD</h4>
    @foreach($periode as $p)
    <h5>Periode {{$p->periode}}</h5>
    @endforeach
  </div>
   {{--  @if(Auth::user())
    
	@if(Auth::user()->level == 1)
	<a href="organisasi/create"><button class="btn btn-warning">Tambah</button></a>
	@endif --}}


	
<br>
<div class="box-body">
	<div class="table-responsive">
		<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
			<thead>
				
			
			<tr style="height: 40px; vertical-align: middle; background-color: #007bff;">
        <th>Tujuan</th>
        <th>Sasaran</th>
        <th  colspan="2">Indikator Sasaran</th>
        <th style="text-align: center;">Satuan</th>
        <th>Capaian Awal</th>
        <th>Tahun 2017</th>
        <th>Tahun 2018</th>
        <th>Tahun 2019</th>
        <th>Tahun 2020</th>
        <th>Tahun 2021</th>
        <th>Kondisi Akhir</th>
			</tr>
			</thead>
			<tbody>
      @foreach($tujuan as $t)
              <tr>
                <td colspan="12" style="font-weight: bold; background-color: #7abaff;" title="Tujuan">{{$t->tujuan_nama}}</td>
              </tr>
			@foreach($sasaran as $s)
      @if($t->id==$s->tujuan_id)
							<tr>
                <td></td>
                <td colspan="11" title="Sasaran" style="font-weight: bold;">{{$no++}}. &nbsp;{{$s->sasaran_nama}}</td>
              </tr>
                @foreach($indikator_sasaran as $is)
                @if($s->id==$is->sasaran_id)
                <tr >
                  <td colspan="2"></td>
                  <td>-</td>
                <td title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
                @foreach($target_sasaran as $ts)
                @if($is->id==$ts->indikator_sasaran_id)
                <td style="text-align: center;">{{$ts->satuan_nama}}</td>
                <td style="text-align: center;">{{$ts->perencanaan_awal}}</td>
                <td style="text-align: center;">{{$ts->target_t1}}</td>
                <td style="text-align: center;">{{$ts->target_t2}}</td>
                <td style="text-align: center;">{{$ts->target_t3}}</td>
                <td style="text-align: center;">{{$ts->target_t4}}</td>
                <td style="text-align: center;">{{$ts->target_t5}}</td>
                <td style="text-align: center;">{{$ts->kondisi_akhir}}</td>
                </tr>
                @endif
                @endforeach
                @endif
                @endforeach
      @endif
      
      
      @endforeach 
			@endforeach 
		  </tbody>
      </table>
                    
	</div>
</div>


                     
             
</div>
@endsection
