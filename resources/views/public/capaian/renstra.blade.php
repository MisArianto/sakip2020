@extends('public.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    
<h3 style="color: #00a6c6; font-weight: bold;">Perencanaan Kinerja</h3>
<div class="pull-right"><a href="{{ url('perencanaan') }}"><button class="btn btn-warning">Kembali</button> </a></div><br>
        <div class="box-body">
            <h4 style="text-align: center; color: #00a6c6; font-weight: bold;">Rencana Strategis <br></h4>
            <h5 style="text-align: center; font-weight: bold;">@foreach($opds as $opd)
            {{$opd->organisasi_nama}}
            @endforeach</h5>
            <h5 style="text-align: center; color: #00a6c6;">Periode 2016-2021</h5>
            
            <hr>
    <h5 style="text-align: center;">Tujuan dan Sasaran</h5>
    <div class="table table-responsive">
    <table class="table table-responsive table-bordered" style="font-size: 11px;">
      <thead>
      <tr style="background-color: salmon; vertical-align: middle;">
        <th rowspan="2">Tujuan</th>
        <th rowspan="2">Sasaran</th>
        <th rowspan="2">Indikator Sasaran</th>
        <th rowspan="2" style="text-align: center;">Satuan</th>
            <th rowspan="2" style="text-align: center;">Capaian Awal</th>
            <th colspan="2" style="text-align: center;">Tahun 2017</th>
            <th colspan="2" style="text-align: center;">Tahun 2018</th>
            <th colspan="2" style="text-align: center;">Tahun 2019</th>
            <th colspan="2" style="text-align: center;">Tahun 2020</th>
            <th colspan="2" style="text-align: center;">Tahun 2021</th>
            <th colspan="2" style="text-align: center;">Kondisi Akhir</th>
      </tr>
       <tr style="background-color: salmon; font-size: 12px;">
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
        
        
        @foreach($tujuan as $t)
        
        <tr >
          <td colspan="18" style="background-color: #00a6c6; font-weight: bolder;">{{$t->tujuan_nama}}</td>
        </tr>
        @foreach($sasaran as $s)
        @if($t->tujuan_nomor == $s->tujuan_nomor)
        <tr style="font-size: 11px; background-color:#6fd8ff;">
          <td></td>
          <td colspan="16">{{$s->sasaran_nama}}</td>
          
        </tr>
        @endif

        @foreach($indikator_sasaran as $is)
        @if($s->sasaran_nomor==$is->sasaran_nomor)
          <tr style="font-size: 11px;">
            <td></td>
            <td></td>
            <td>{{$is->indikator_sasaran_nama}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->satuan_nama}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->perencanaan_awal}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->target_t1}}</td>
            <td style="font-size: 10px; text-align: right;">{{($is->pagu_t1)}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->target_t2}}</td>
            <td style="font-size: 10px; text-align: right;">{{($is->pagu_t2)}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->target_t3}}</td>
            <td style="font-size: 10px; text-align: right;">{{($is->pagu_t3)}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->target_t4}}</td>
            <td style="font-size: 10px; text-align: right;">{{($is->pagu_t4)}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->target_t5}}</td>
            <td style="font-size: 10px; text-align: right;">{{($is->pagu_t5)}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->target_kondisi_akhir}}</td>
            <td style="font-size: 10px; text-align: right;">{{$is->pagu_kondisi_akhir}}</td>
            
          </tr>
        @endif

        @endforeach
        @endforeach
        @endforeach
      </tbody>
    </table>
    </div>

    <br>
    <div class="table table-responsive">
    <h5 style="text-align: center;">Program dan Kegiatan</h5>

    
    <table class="table table-responsive table-bordered" style="font-size: 11px;">
      <thead>
      <tr style="background-color: salmon; vertical-align: middle;">
        
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
       <tr style="background-color: salmon; font-size: 12px;">
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
          <tr style="font-weight: bold; background-color: #00a6c6; font-size: 13px;">
            <td colspan="19">{{$is->indikator_sasaran_nama}}</td>
            <td></td>
          </tr> --}}

          @foreach($program as $p)
          {{-- @if($is->id==$p->indikator_sasaran_id) --}}
          <tr style="font-size: 12px;font-weight: bold; background-color: #00a6c6;">
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
          @foreach($kegiatan as $k)
          @if($p->program_no==$k->program_no)
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
          @endif
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

