@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">

        <div class="card-body">
            <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
            <h4 style="text-align: center; font-weight: bold;" class="text-info">Rencana Kinerja Tahunan <br></h4>
            <h5 style="text-align: center; font-weight: bold;" class="text-muted">{{ $opd }}</h5>
            
            <hr>

            <form action="{{ url ('perencanaan-kinerja/rkt-opd/data')}}" method="POST">
              @csrf
              <div class="row">
                    <div class="col-md-4">
                      <div class="input-group mb-3">
                        <select class="form-control" name="tahun" id="tahun">
                          <option @if($tahun=="target_t1") selected @endif value="target_t1">Tahun 2017</option>
                          <option @if($tahun=="target_t2") selected @endif value="target_t2">Tahun 2018</option>
                          <option @if($tahun=="target_t3") selected @endif value="target_t3">Tahun 2019</option>
                        </select>
                        <div class="input-group-prepend">
                          <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                  </div>
                </div>
            </form>
            <hr>
    <h5 style="text-align: center;">Sasaran</h5>
    <div class="table-responsive">
    <table class="table table-bordered table-hover  tablepretty" >
      <thead>
      <tr style="background-color: #007bff; color: #fff;">
        <th rowspan="2">Sasaran</th>
        <th rowspan="2">Indikator Sasaran</th>
        <th rowspan="2" style="text-align: center;">Satuan</th>
        <th style="text-align: center;">Target</th>
      </tr>
      </thead>
      <tbody>
        @foreach($sasaran as $s)
        {{-- @foreach(collect($sasaran)->where('tujuan_nomor', $t->tujuan_nomor) as $s) --}}
        <tr style="font-size: 11px; font-weight: bold;">
          <td colspan="16">{{$s->sasaran_nama}}</td>
          
        </tr>

        @foreach(collect($indikator_sasaran)->unique('indikator_sasaran_nama')->where('sasaran_id', $s->id) as $is)
          <tr style="font-size: 11px;">
            <td></td>
            <td>{{$is->indikator_sasaran_nama}}</td>
            <td style="text-align: center;">{{$is->satuan_nama}}</td>
            
            <td style="text-align: center;">{{$is->target}}</td>
          </tr>

        @endforeach
        @endforeach
      </tbody>
    </table>
    </div>

    <br>
    <div class="table table-responsive">
    <h5 style="text-align: center;">Program dan Kegiatan</h5>

    
    <table class="table table-responsive table-bordered table-hover  tablepretty" >
      <thead>
      <tr style="background-color: #007bff; color: #fff;">
        <th rowspan="2" colspan="2">Program</th>
        <th rowspan="2">Kegiatan</th>
        <th rowspan="2">Indikator</th>
        <th rowspan="2" style="text-align: center;">Satuan</th>
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
            <td style="text-align: center;">{{$k->satuan_nama}}</td>
            <td style="text-align: center;">{{$k->target}}</td>
            <td style="text-align: right; font-size: 9px;">{{($k->pagu)}}</td>
            
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

