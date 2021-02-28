@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 10px;">
   <div class="box-header">
    
    <h4> Program Prioritas RPJMD &nbsp 
      @if(Auth::user()->level == 1)
      <a href="{{ url ('perencanaan/rpjmd-program/create')}}" data-toggle="tooltip" title="Tambah Program"><button class="btn btn-primary btn-sm">Tambah</button></a>
      <a href="{{ url ('perencanaan/rpjmd-program/create')}}" data-toggle="tooltip" title="Tambah Target Kinerja Program"><button class="btn btn-primary btn-sm"><i class="fa fa-plus">&nbsp; </i> Target</button></a>
    @endif
    </h4>
    @foreach($periode as $p)
    <h4>Periode {{$p->periode}}</h4>
    @endforeach
  </div>
    
	
<div class="box-body">
<br>
	<div class="table-responsive">
		<table class="table table-responsive table-hover table-bordered" style="font-size: 11px;">
			<thead>
				
			
			<tr style="vertical-align: middle; background-color:  #007bff; ">
        <th rowspan="2" colspan="2">Indikator Sasaran / Program</th>
        {{-- <th rowspan="2">Kode Program</th> --}}
        {{-- <th rowspan="2">Program</th> --}}
        <th rowspan="2">Indikator Program</th>
        @if(Auth::user()->level == 1)
        <th rowspan="2"></th>
        @endif
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
      @foreach($indikator_sasaran as $is)
              <tr>
                <td colspan="18" style="font-weight: bold; background-color: #7abaff; font-size: 11px;" title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
              </tr>
              @foreach(collect($program)->where('indikator_sasaran_id', $is->indikator_sasaran_id) as $p)
			
							<tr>
                <td></td>
                 {{-- <td style="background-color: #6fd8ff;">{{$p->program_no}}</td> --}}
                 <td  style="font-weight: bold; font-size: 11px;" title="Program">{{-- {{$p->program_no}}  --}}{{$p->program_nama}}</td>
                 <td  style="font-weight: bold; font-size: 11px;" title="Indikator Program">{{-- {{$p->program_no}}  --}}{{$p->indikator_program}}</td>
                 {{-- @if(Auth::user()->level == 1)
                 <td>
                    <a href="#" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Program / Indikator"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus Program / Indikator"><i class="fa fa-trash"></i></a>
                 </td>
                 @endif --}}
                  @foreach(collect($target_program)->where('program_no', $p->program_no) as $tp)
                  <td style="text-align: center; font-size: 11px;">{{$tp->satuan_nama}}</td>
                  <td style="text-align: center; font-size: 11px;">{{$tp->perencanaan_awal}}</td>
                  <td style="text-align: center; font-size: 11px;">{{$tp->target_t1}}</td>
                  <td style="text-align: right; font-size: 10px;">{{number_format($tp->pagu_t1)}}</td>
                  <td style="text-align: center; font-size: 11px;">{{$tp->target_t2}}</td>
                  <td style="text-align: right; font-size: 10px;">{{number_format($tp->pagu_t2)}}</td>
                  <td style="text-align: center; font-size: 11px;">{{$tp->target_t3}}</td>
                  <td style="text-align: right; font-size: 10px;">{{number_format($tp->pagu_t3)}}</td>
                  <td style="text-align: center; font-size: 11px;">{{$tp->target_t4}}</td>
                  <td style="text-align: right; font-size: 10px;">{{number_format($tp->pagu_t4)}}</td>
                  <td style="text-align: center; font-size: 11px;">{{$tp->target_t5}}</td>
                  <td style="text-align: right; font-size: 10px;">{{number_format($tp->pagu_t5)}}</td>
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
@endsection
