@extends('public.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    

        <div class="box-body">
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Capaian Indikator</h4>
            <h5 style="text-align: center; font-weight: bold;">@foreach($opds as $opd)
            {{$opd->organisasi_nama}}
            @endforeach</h5>
            <h5 style="text-align: center; color: #007bff;">Tahun 2019</h5>
            
            <hr>
    <h5 style="text-align: center; font-weight: bold;  color: #007bff;">Sasaran</h5>
            
    {{-- <div class="table table-responsive">
    <table class="table table-responsive table-bordered" style="font-size: 11px;">
      <thead>
      <tr style=" background-color: #007bff;">
                    <th rowspan="2" style="vertical-align: middle;">No</th>
                    <th rowspan="2" style="vertical-align: middle;">Indikator Sasaran</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th>
                    <th rowspan="2" style="text-align: center;">Target</th>
                    <th colspan="2" style="text-align: center;">Tw I</th>
                    <th colspan="2" style="text-align: center;">Tw II</th>
                    <th colspan="2" style="text-align: center;">Tw III</th>
                    <th colspan="2" style="text-align: center;">Tw IV</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Capaian</th>
          </tr>
          <tr style=" background-color: #007bff;">
            <th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>
                    <th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>
                    <th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>
                    <th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>

      
          </tr>
      </thead>
      <tbody>
        
        @foreach($indikator_sasaran as $is)
          <tr style="font-size: 11px;">
            <td style="text-align: center;">{{$no++}}</td>
            <td>{{$is->indikator_sasaran_nama}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->satuan_nama}}</td>
            
            <td style="font-size: 10px; text-align: center;">{{$is->target_t3}}</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-%</td>
    
            
          </tr>
        @endforeach
      </tbody>
    </table>
    </div> --}}

<div class="tavle table-responsive">
  <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
    <tr style=" background-color: #007bff;">
        {{-- <th rowspan="2" style="vertical-align: middle;">No</th> --}}
        <th rowspan="4" style="vertical-align: middle;">Indikator Sasaran</th>
        <th rowspan="4" style="vertical-align: middle;">Formulasi</th>
        <th rowspan="4" style="vertical-align: middle;">Program</th>
        <th rowspan="4" style="text-align: center;vertical-align: middle;"N>Pagu</th>
        {{-- <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th> --}}
        <th colspan="4" style="text-align: center;vertical-align: middle;">Target</th>
        <th colspan="12" style="text-align: center;vertical-align: middle;">Capaian Kinerja</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW I</th>
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW II</th>
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW III</th>
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW IV</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th colspan="3" style="text-align: center;">Realisasi TW I</th>
        <th colspan="3" style="text-align: center;">Realisasi TW II</th>
        <th colspan="3" style="text-align: center;">Realisasi TW III</th>
        <th colspan="3" style="text-align: center;">Realisasi TW IV</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>

        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>

        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>

        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>
    </tr>
     
    <tbody>
    
        
    @foreach(collect($indikator_sasaran)->unique('indikator_sasaran_id') as $cs)
    <tr >
        {{-- <td style="text-align: center;">{{$no++}}</td> --}}
        <td title="Indikator Sasaran" >{{$cs->indikator_sasaran}}</td>
        <td title="Indikator Sasaran" >{{$cs->formulasi}}</td>
    {{-- </tr> --}}
    {{-- <tr> --}}
       
        <td title="program">
    @foreach(collect($indikator_sasaran)->unique('program_no')->where('indikator_sasaran_id', $cs->indikator_sasaran_id) as $cs2)
            - {{$cs2->program_nama}} <br>
    @endforeach
        <td title="pagu" style="text-align: center;">{{$cs2->pagu}}</td>
        </td>
        {{-- <td title="Satuan" style="text-align: center;">{{$cs->satuan_nama}}</td> --}}
        <td title="Target" style="text-align: center;">{{$cs2->target_tw1}}</td>
        <td title="Target" style="text-align: center;">{{$cs2->target_tw2}}</td>
        <td title="Target" style="text-align: center;"> {{$cs2->target_tw3}}</td>
         <td title="Target" style="text-align: center;">{{$cs2->target_tw4}}</td>
        {{-- <td title="TW I" style="text-align: center;">{{$cs2->tw_1}}</td> --}}
        <td title="Rekomendasi I" style="text-align: center;">{{$cs2->rkmn_1}}</td>
        <td title="Anggaran I" style="text-align: center;">{{$cs2->a_1}}</td>
        <td title="Realisasi  I" style="text-align: center;">{{$cs2->real_1}}</td>

        {{-- <td title="TW II" style="text-align: center;">{{$cs2->tw_2}}</td> --}}
        <td title="Rekomendasi  II" style="text-align: center;">{{$cs2->rkmn_2}}</td>
        <td title="Anggaran  II" style="text-align: center;">{{$cs2->a_2}}</td>
        <td title="Realisasi  II" style="text-align: center;">{{$cs2->real_2}}</td>

        {{-- <td title="TW III" style="text-align: center;">{{$cs2->tw_3}}</td> --}}
        <td title="Rekomendasi III" style="text-align: center;">{{$cs2->rkmn_3}}</td>
        <td title="Anggaran III" style="text-align: center;">{{$cs2->a_3}}</td>
        <td title="Realisasi  III" style="text-align: center;">{{$cs2->real_3}}</td>

        {{-- <td title="Realisasi TW IV" style="text-align: center;">{{$cs2->tw_4}}</td> --}}
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->rkmn_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->a_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->real_4}}</td>
    </tr>
    
    @endforeach
    </tbody>
  </table>
</div>
    
    <h5 style="text-align: center; font-weight: bold;  color: #007bff;">Program dan Kegiatan</h5>
    <div class="table table-responsive">

    
    <table class="table table-responsive table-bordered" style="font-size: 11px;">
      <thead>
      <tr style="background-color: #007bff; vertical-align: middle;">
        
        {{-- <th rowspan="2">Indikator Sasaran</th> --}}
        <th rowspan="2" colspan="2">Program</th>
        <th rowspan="2">Kegiatan</th>
        <th rowspan="2">Indikator</th>
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
            
     
      </thead>
      <tbody>
        
        
        
        
        {{-- @foreach($indikator_sasaran as $is)
          <tr style="font-weight: bold; background-color: #00a6c6; font-size: 13px;">
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
            <td style="text-align: center;">{{$k->satuan_nama}}</td>
            <td style="text-align: center;">{{$k->target_t3}}</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-</td>
            <td style="text-align: center;">-%</td>
          </tr>
          {{-- @endif --}}
        @endforeach
        @endforeach
        {{-- @endforeach --}}
      </tbody>
    </table>
        </div>
   
        </div>
</div>
        
@stop        

