@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
        <div class="card-body">
            <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
            <h4 style="font-weight: bold;" class="text-center text-dark text-muted">Rencana Pembangunan Jangka Menengah Daerah </h4>
            <h5 style="font-weight: bold;" class="text-center text-dark text-muted">Kabupaten Kepulauan Meranti</h5>
            <h5 style="font-weight: bold;" class="text-center text-info">Periode {{$periode->periode}}</h5>
            
        <hr> 
        <div class="table-responsive">
            
   
            <table class="table table-striped">
              <thead class="text-muted text-center thead-light">
                <tr>
                  <th>Visi</th>
                </tr>
              </thead>
              <tbody class="text-muted text-center h5">
                @foreach($visi as $v)
                <tr>
                  <td>{{$v->nama}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-muted text-center thead-light">
                    <tr>
                        <th colspan="2"><h5>Misi</h5></th>
                    </tr>
                    </thead>
                    <tbody class="text-muted">
                    @foreach($misi as $m)
                      <tr style="font-size: 12px;">
                        <td>{{$m->nomor}}.</td>
                        <td>{{$m->nama}}</td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
            <br>
            <div class="tavle table-responsive">
            <h4 class="text-muted">Tujuan dan Sasaran RPJMD</h4>
              <table class="table table-responsive table-bordered table-hover " style="font-size: 11px;">
                <tr class="text-muted thead-light">
                    <th>Tujuan</th>
                    <th>Sasaran</th>
                    <th colspan="2">Indikator Sasaran</th>
                    <th style="text-align: center;">Satuan</th>
                    <th>Capaian Awal</th>
                    <th>Tahun 2017</th>
                    <th>Tahun 2018</th>
                    <th>Tahun 2019</th>
                    <th>Tahun 2020</th>
                    <th>Tahun 2021</th>
                    <th>Kondisi Akhir</th>
            			</tr>
                <tbody class="text-muted">
                  @foreach($tujuan as $t)
              <tr>
                <td colspan="12" style="font-weight: bold;" title="Tujuan">{{$t->tujuan_nama}}</td>
              </tr>
        			@foreach(collect($sasaran)->where('tujuan_id', $t->id) as $s)
        			      {{-- @if($t->id==$s->tujuan_id) --}}
        			<tr>
                <td></td>
                {{-- <td style="text-align: center; font-weight: bold;">{{$no++}}</td> --}}
                <td colspan="11" style=" font-weight: bold;" title="Sasaran">{{$s->sasaran_nama}}</td>
              </tr>
                @foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
                {{-- @if($s->id==$is->sasaran_id) --}}
                <tr >
                  <td colspan="2"></td>
                  <td>*</td>
                <td title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
                @foreach(collect($target_sasaran)->where('indikator_sasaran_id', $is->id) as $ts)
                {{-- @if($is->id==$ts->indikator_sasaran_id) --}}
                <td style="text-align: center;">{{$ts->satuan_nama}}</td>
                <td style="text-align: center;">{{$ts->perencanaan_awal}}</td>
                <td style="text-align: center;">{{$ts->target_t1}}</td>
                <td style="text-align: center;">{{$ts->target_t2}}</td>
                <td style="text-align: center;">{{$ts->target_t3}}</td>
                <td style="text-align: center;">{{$ts->target_t4}}</td>
                <td style="text-align: center;">{{$ts->target_t5}}</td>
                <td style="text-align: center;">{{$ts->kondisi_akhir}}</td>
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
<br>
<div class="tavle table-responsive">
<h4 class="text-muted">Program Prioritas RPJMD</h4>
              <table class="table table-bordered table-hover " style="font-size: 11px;">
              <thead class="text-muted thead-light">
              <tr>
                <th rowspan="2" colspan="2">Indikator Sasaran / Program</th>
                <th rowspan="2">Indikator Program</th>
                <th rowspan="2" style="text-align: center;">Satuan</th>
                <th rowspan="2" style="text-align: center;">Capaian Awal</th>
                <th colspan="2" style="text-align: center;">Tahun 2017</th>
                <th colspan="2" style="text-align: center;">Tahun 2018</th>
                <th colspan="2" style="text-align: center;">Tahun 2019</th>
                <th colspan="2" style="text-align: center;">Tahun 2020</th>
                <th colspan="2" style="text-align: center;">Tahun 2021</th>
                <th rowspan="2" style="text-align: center;">Kondisi Akhir</th>
              </tr>
              <tr style="background-color: #007bff ;">
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
              <tbody class="text-muted">
              @foreach($indikator_sasaran as $is)
                      <tr>
                        <td colspan="16" style="font-weight: bold;" title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
                      </tr>
                      @foreach(collect($program)->where('is_id', $is->id) as $p)
                      {{-- @if($is->id==$p->is_id) --}}
                      <tr>
                        <td></td>
                         {{-- <td style="background-color: #6fd8ff;">{{$p->program_no}}</td> --}}
                         <td  style="font-weight: bold; " title="Program">{{-- {{$p->program_no}}  --}}{{$p->program_nama}}</td>
                        @foreach(collect($indikator_program)->where('program_no', $p->program_no) as $ip)
                        {{-- @if($p->program_no==$ip->program_no) --}}
                          <td title="Indikator Program" style="font-size: 10px;">{{$ip->indikator_program_nama}}</td>
                          @foreach(collect($target_program)->where('program_no', $ip->program_no) as $tp)
                          {{-- @if($ip->program_no==$tp->program_no) --}}
                          <td style="text-align: center; font-size: 10px;">{{$tp->satuan_nama}}</td>
                          <td style="text-align: center; font-size: 10px;">{{$tp->perencanaan_awal}}</td>
                          <td style="text-align: center; font-size: 10px;">{{$tp->target_t1}}</td>
                          <td style="text-align: right; font-size: 9px;">{{number_format($tp->pagu_t1)}}</td>
                          <td style="text-align: center; font-size: 10px;">{{$tp->target_t2}}</td>
                          <td style="text-align: right; font-size: 9px;">{{number_format($tp->pagu_t2)}}</td>
                          <td style="text-align: center; font-size: 10px;">{{$tp->target_t3}}</td>
                          <td style="text-align: right; font-size: 9px;">{{number_format($tp->pagu_t3)}}</td>
                          <td style="text-align: center; font-size: 10px;">{{$tp->target_t4}}</td>
                          <td style="text-align: right; font-size: 9px;">{{number_format($tp->pagu_t4)}}</td>
                          <td style="text-align: center; font-size: 10px;">{{$tp->target_t5}}</td>
                          <td style="text-align: right; font-size: 9px;">{{number_format($tp->pagu_t5)}}</td>
                          <td style="text-align: center; font-size: 10px;">{{$tp->kondisi_akhir}}</td>
                        {{-- @endif --}}
                        @endforeach 
                        </tr>
                        {{-- @endif --}}
                        @endforeach 
                        {{-- @endif --}}
                        @endforeach 
              @endforeach 
              </tbody>
              </table>
        </div>
       
        </div>
</div>
        
@stop        

