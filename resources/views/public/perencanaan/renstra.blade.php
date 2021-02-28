@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
    
{{-- <div class="box-header">
    <div class="pull-right"><a href="{{url('perencanaan')}}"><button class="btn btn-warning">Kembali</button></a></div>
</div> --}}
        <div class="card-body">
            <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Rencana Strategis <br></h4>
            <h5 style="text-align: center; font-weight: bold;">@foreach($opds as $opd)
            {{$opd->organisasi_nama}}
            @endforeach</h5>
            <h5 style="text-align: center; color: #007bff;">Periode 2016-2021</h5>
            
            <hr>
    <h5 style="text-align: center;">Tujuan dan Sasaran</h5>
    <div class="table-responsive">
    <table class="table table-bordered table-hover  tablepretty" style="font-size: 11px;">
      <thead>
      <tr style="background-color: #007bff; vertical-align: middle;">
        <th>Tujuan</th>
        <th>Sasaran</th>
        <th>Indikator Sasaran</th>
        <th style="text-align: center;">Satuan</th>
        <th style="text-align: center;">Capaian Awal</th>
        <th  style="text-align: center;">Target 2017</th>
        <th  style="text-align: center;">Target 2018</th>
        <th  style="text-align: center;">Target 2019</th>
        <th  style="text-align: center;">Target 2020</th>
        <th  style="text-align: center;">Target 2021</th>
        <th  style="text-align: center;">Kondisi Akhir</th>
      </tr>
      
      </thead>
      <tbody>
        
        
        @foreach($tujuan as $t)
        
        <tr >
          <td colspan="18" style="background-color: #7abaff; font-weight: bolder;">{{$t->tujuan_nama}}</td>
        </tr>
        @foreach(collect($sasaran)->where('tujuan_nomor', $t->tujuan_nomor) as $s)
        {{-- @if($t->tujuan_nomor == $s->tujuan_nomor) --}}
        <tr style="font-size: 11px; font-weight: bold;">
          {{-- <td>{{$s->sasaran_nomor}}</td> --}}
          <td></td>
          <td colspan="16">{{$s->sasaran_nama}}</td>
        </tr>
        {{-- @endif --}}

        {{-- @foreach($indikator_sasaran as $is) --}}
        @foreach(collect($indikator_sasaran)->unique('indikator_sasaran_nama')->where('sasaran_id', $s->id) as $is)
        {{-- @if($s->sasaran_nomor==$is->sasaran_nomor) --}}
          <tr style="font-size: 11px;">
            <td></td>
            <td></td>
            <td>{{$is->indikator_sasaran_nama}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->satuan_nama}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->kondisi_awal}}</td>
            <td style="font-size: 10px; text-align: center;">{{collect($indikator_sasaran)->where('tahun', '2017')->first()->target}}</td>
            {{-- <td style="font-size: 10px; text-align: right;">{{($is->pagu_t1)}}</td> --}}
            <td style="font-size: 10px; text-align: center;">{{collect($indikator_sasaran)->where('tahun', '2018')->first()->target}}</td>
            {{-- <td style="font-size: 10px; text-align: right;">{{($is->pagu_t2)}}</td> --}}
            <td style="font-size: 10px; text-align: center;">{{collect($indikator_sasaran)->where('tahun', '2019')->first()->target}}</td>
            {{-- <td style="font-size: 10px; text-align: right;">{{($is->pagu_t3)}}</td> --}}
            <td style="font-size: 10px; text-align: center;">{{collect($indikator_sasaran)->where('tahun', '2020')->first()->target}}</td>
            {{-- <td style="font-size: 10px; text-align: right;">{{($is->pagu_t4)}}</td> --}}
            <td style="font-size: 10px; text-align: center;">{{collect($indikator_sasaran)->where('tahun', '2021')->first()->target}}</td>
            {{-- <td style="font-size: 10px; text-align: right;">{{($is->pagu_t5)}}</td> --}}
            <td style="font-size: 10px; text-align: center;">{{$is->target_akhir}}</td>
            {{-- <td style="font-size: 10px; text-align: right;">{{$is->pagu_kondisi_akhir}}</td> --}}
            
          </tr>
        {{-- @endif --}}

        @endforeach
        @endforeach
        @endforeach
      </tbody>
    </table>
    </div>

    <br>
    <div class="table table-responsive">
    <h5 style="text-align: center;">Program dan Kegiatan</h5>

    
    <table class="table table-responsive table-bordered table-hover  tablepretty" style="font-size: 11px;">
      <thead>
      <tr style="background-color: #007bff; vertical-align: middle;">
        
        {{-- <th rowspan="2">Indikator Sasaran</th> --}}
        <th rowspan="2" colspan="2">Program</th>
        <th rowspan="2">Kegiatan</th>
        <th rowspan="2">Indikator</th>
        <th rowspan="2" style="text-align: center;">Satuan</th>
            <th rowspan="2" style="text-align: center;">Capaian Awal</th>
            <th colspan="2" style="text-align: center;">Tahun 2017</th>
            <th colspan="2" style="text-align: center;">Tahun 2018</th>
            <th colspan="2" style="text-align: center;">Tahun 2019</th>
            <th colspan="2" style="text-align: center;">Tahun 2020</th>
            <th colspan="2" style="text-align: center;">Tahun 2021</th>
            <th colspan="2" style="text-align: center;">Kondisi Akhir</th>
      </tr>
       <tr style="background-color: #007bff; font-size: 12px;">
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
            <th style="text-align: center;">Target</th>
            <th style="text-align: center;">Pagu</th>
          </tr>
      </thead>
      <tbody>
        
        
        
        
        {{-- @foreach($indikator_sasaran as $is)
          <tr style="font-weight: bold; background-color: #007bff; font-size: 13px;">
            <td colspan="19">{{$is->indikator_sasaran_nama}}</td>
            <td></td>
          </tr> --}}

          @foreach($program as $p)
          {{-- @if($is->id==$p->indikator_sasaran_id) --}}
          <tr style="font-size: 12px;font-weight: bold; background-color: #7abaff;">
            {{-- <td></td> --}}
            {{-- <td>{{$p->program_no}}</td> --}}
            <td colspan="18" >{{$p->program_no}} &nbsp; {{$p->program_nama}}</td>
            
           
            {{-- <td></td> --}}
            {{-- <td style="text-align: center;">{{$is->satuan_nama}}</td>
            <td style="text-align: center;">{{$is->perencanaan_awal}}</td>
            <td style="text-align: center;">{{$is->target_t1}}</td>
            <td style="text-align: right;">{{($is->pagu_t1)}}</td>
            <td style="text-align: center;">{{$is->target_t2}}</td>
            <td style="text-align: right;">{{($is->pagu_t2)}}</td>
            <td style="text-align: center;">{{$is->target_t3}}</td>
            <td style="text-align: right;">{{($is->pagu_t3)}}</td>
            <td style="text-align: center;">{{$is->target_t4}}</td>
            <td style="text-align: right;">{{($is->pagu_t4)}}</td>
            <td style="text-align: center;">{{$is->target_t5}}</td>
            <td style="text-align: right;">{{($is->pagu_t5)}}</td>
            <td style="text-align: center;">{{$is->target_kondisi_akhir}}</td>
            <td style="text-align: right;">{{$is->pagu_kondisi_akhir}}</td>
            <td></td> --}}
          </tr>
          {{-- @endif --}}
          {{-- @foreach($kegiatan as $k) --}}
          @foreach(collect($kegiatan)->where('program_no', $p->program_no) as $k)
          {{-- @if($p->program_no==$k->program_no) --}}
          <tr style="font-size: 11px;">
            <td colspan="2"></td>
            <td>{{-- {{$k->kegiatan_no}}  --}}{{$k->kegiatan_nama}}</td>
            <td>{{$k->indikator_kegiatan}}</td>
            <td>{{$k->satuan_nama}}</td>
            <td style="text-align: center;">{{$k->perencanaan_awal}}</td>
            <td style="text-align: center;">{{$k->target_t1}}</td>
            <td style="text-align: right; font-size: 9px;">{{($k->pagu_t1)}}</td>
            <td style="text-align: center;">{{$k->target_t2}}</td>
            <td style="text-align: right; font-size: 9px;">{{($k->pagu_t2)}}</td>
            <td style="text-align: center;">{{$k->target_t3}}</td>
            <td style="text-align: right; font-size: 9px;">{{($k->pagu_t3)}}</td>
            <td style="text-align: center;">{{$k->target_t4}}</td>
            <td style="text-align: right; font-size: 9px;">{{($k->pagu_t4)}}</td>
            <td style="text-align: center;">{{$k->target_t5}}</td>
            <td style="text-align: right; font-size: 9px;">{{($k->pagu_t5)}}</td>
            <td style="text-align: center;">{{$k->target_kondisi_akhir}}</td>
            <td style="text-align: right; font-size: 9px;">{{$k->pagu_kondisi_akhir}}</td>
            
          </tr>
          {{-- @endif --}}
        @endforeach
        @endforeach
        {{-- @endforeach --}}
      </tbody>
    </table>
        </div>
        {{-- <div class="pull-right">
            {!! $org->links()!!}
        </div> --}}
        </div>
</div>
        
@stop        

