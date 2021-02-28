@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
<div class="box-header">
    <h4> RPJMD</h4>
    @foreach($periode as $p)
    <h5>Periode {{$p->periode}}</h5>
    @endforeach
</div>
<div class="box-body">
<ul class="nav nav-pills">
	<li class="active"><a data-toggle="tab" href="#visi-misi">Visi Misi</a></li>
	<li><a data-toggle="tab" href="#tujuan">Tujuan</a></li>
	<li><a data-toggle="tab" href="#sasaran">Sasaran</a></li>
	<li><a data-toggle="tab" href="#program">Program Prioritas</a></li>
</ul>
<div class="tab-content">
	<div id="visi-misi" class="tab-pane fade in active">
	@include('app.perencanaan.rpjmd._visi_misi')
	</div>

	<div id="tujuan" class="tab-pane fade">
	<div class="table-responsive">
		<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
			<thead>
				
			
			<tr style="background-color: #007bff;">
		        <th>Misi</th>
		        <th>No / Tujuan</th>
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
					@foreach(collect($tujuan)->where('misi_id', $m->id) as $t)
					
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
					
					@endforeach 
			@endforeach 
		  </tbody>
      </table>
	  </div>
	</div>

	<div id="sasaran" class="tab-pane fade">
		<div class="table-responsive">
		<table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
			<thead>
				
			
			<tr style="height: 40px; vertical-align: middle; background-color: #007bff;">
        {{-- <th>Tujuan</th> --}}
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
		     {{--  @foreach($tujuan as $t)
              <tr>
                <td colspan="12" style="font-weight: bold; background-color: #7abaff;" title="Tujuan">{{$t->tujuan_nama}}</td>
              </tr>
		      @foreach(collect($sasaran)->where('tujuan_id', $t->id) as $s) --}}
		      @foreach($sasaran as $s)
				<tr>
					{{-- <td>{{$s->tujuan_nama}}</td> --}}
	            <td colspan="11" title="Sasaran" style="font-weight: bold;">{{$no++}}. &nbsp;{{$s->sasaran_nama}}</td>
		        </tr>
		        @foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
	            
	            <tr >
	            	<td></td>
	              <td>-</td>
	            <td title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
	            @foreach(collect($target_sasaran)->where('indikator_sasaran_id', $is->id) as $ts)
	            
	            <td style="text-align: center;">{{$ts->satuan_nama}}</td>
	            <td style="text-align: center;">{{$ts->perencanaan_awal}}</td>
	            <td style="text-align: center;">{{$ts->target_t1}}</td>
	            <td style="text-align: center;">{{$ts->target_t2}}</td>
	            <td style="text-align: center;">{{$ts->target_t3}}</td>
	            <td style="text-align: center;">{{$ts->target_t4}}</td>
	            <td style="text-align: center;">{{$ts->target_t5}}</td>
	            <td style="text-align: center;">{{$ts->kondisi_akhir}}</td>
	            </tr>
	            @endforeach
	            @endforeach
		      @endforeach 
		      {{-- @endforeach  --}}
					{{-- @endforeach  --}}
				  </tbody>
		      </table>
		                    
			</div>
		</div>

		<div id="program" class="tab-pane fade">
			<div class="table-responsive">
				<table class="table table-responsive table-hover table-bordered" style="font-size: 11px;">
					<thead>
						
					
					<tr style="vertical-align: middle; background-color:  #007bff; ">
		        <th rowspan="2" colspan="2">Indikator Sasaran / Program</th>
		        {{-- <th rowspan="2">Kode Program</th> --}}
		        {{-- <th rowspan="2">Program</th> --}}
		        <th rowspan="2">Indikator Program</th>
		        {{-- @if(Auth::user()->level == 1)
		        <th rowspan="2"></th>
		        @endif --}}
		        <th rowspan="2" style="text-align: center;">Satuan</th>
		        <th rowspan="2" style="text-align: center;">Capaian Awal</th>
		        <th colspan="2" style="text-align: center;">Tahun 2017</th>
		        <th colspan="2" style="text-align: center;">Tahun 2018</th>
		        <th colspan="2" style="text-align: center;">Tahun 2019</th>
		        <th colspan="2" style="text-align: center;">Tahun 2020</th>
		        <th colspan="2" style="text-align: center;">Tahun 2021</th>
		        {{-- <th rowspan="2" style="text-align: center;">Kondisi Akhir</th> --}}
		        {{-- @if(Auth::user()->level == 1)
		        <th rowspan="2" style="text-align: center;">Aksi</th>
		        @endif --}}
		      </tr>
		      <tr style="background-color: #007bff; font-size: 11px;">
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		        <th style="text-align: center;">Target</th>
		        <th style="text-align: center;">Pagu</th>
		      </tr>
		        
		        
					</thead>
					<tbody>
		      	@foreach(collect($programs)->unique('indikator_program_id') as $is)
		              <tr>
		                <td colspan="18" style="font-weight: bold; background-color: #7abaff; font-size: 11px;" title="Indikator Program">{{$is->indikator_program_nama}}</td>
		              </tr>
		              @foreach(collect($programs)->unique('program_rpjmd_id')->where('indikator_program_id', $is->indikator_program_id) as $p)
					
									<tr>
		                <td></td>
		                 {{-- <td style="background-color: #6fd8ff;">{{$p->program_no}}</td> --}}
		                 <td  style="font-weight: bold; font-size: 11px;" title="Program">{{-- {{$p->program_no}}  --}}{{$p->program_nama}}</td>
		                 <td  style="font-weight: bold; font-size: 11px;" title="Indikator Program">{{-- {{$p->program_no}}  --}}{{$p->indikator_program_nama}}</td>
		                 {{-- @if(Auth::user()->level == 1)
		                 <td>
		                    <a href="#" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Program / Indikator"><i class="fa fa-edit"></i></a>
		                    <a href="#" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus Program / Indikator"><i class="fa fa-trash"></i></a>
		                 </td>
		                 @endif --}}
		                  @foreach(collect($programs)->where('program_rpjmd_id', $p->program_rpjmd_id) as $tp)
		                  <td style="text-align: center; font-size: 11px;">{{$tp->satuan_nama}}</td>
		                  <td style="text-align: center; font-size: 11px;">{{$tp->perencanaan_awal}}</td>
		                  <td style="text-align: center; font-size: 11px;">{{collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2017')->first()->target}}</td>
		                  <td style="text-align: right; font-size: 10px;">{{number_format(collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2017')->first()->pagu)}}</td>
		                  <td style="text-align: center; font-size: 11px;">{{collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2018')->first()->target}}</td>
		                  <td style="text-align: right; font-size: 10px;">{{number_format(collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2018')->first()->pagu)}}</td>
		                  <td style="text-align: center; font-size: 11px;">{{collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2019')->first()->target}}</td>
		                  <td style="text-align: right; font-size: 10px;">{{number_format(collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2019')->first()->pagu)}}</td>
		                  <td style="text-align: center; font-size: 11px;">{{collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2020')->first()->target}}</td>
		                  <td style="text-align: right; font-size: 10px;">{{number_format(collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2020')->first()->pagu)}}</td>
		                  <td style="text-align: center; font-size: 11px;">{{collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2021')->first()->target}}</td>
		                  <td style="text-align: right; font-size: 10px;">{{number_format(collect($targets)->where('indikator_program_id', $is->indikator_program_id)->where('tahun', '2020')->first()->pagu)}}</td>
		                  {{-- <td style="text-align: center; font-size: 11px;">{{$tp->kondisi_akhir}}</td> --}}
		                  {{-- @if(Auth::user()->level == 1)
		                  <td>
		                    <a href="#" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Target Indikator"><i class="fa fa-edit"></i></a>
		                    <a href="#" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus Target Indikator"><i class="fa fa-trash"></i></a>
		                  </td>
		                  @endif --}}
		                </tr>
		      
		      
		      @endforeach 
		      @endforeach 
					@endforeach 
				  </tbody>
		      </table>
		                    
			</div>
		</div>

</div>
</div>
</div>



                     
             
</div>
@endsection
