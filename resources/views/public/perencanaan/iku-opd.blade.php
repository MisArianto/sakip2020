@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
    
  <div class="card-body">
      <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
      <h4 style="text-align: center;font-weight: bold;" class="text-info">Indikator Kinerja Utama</h4>
      <h5 style="text-align: center;font-weight: bold;" class="text-muted">@foreach($opds as $opd)
      {{$opd->organisasi_nama}}
      @endforeach</h5>
      <hr>
    <div class="table-responsive">
    <table class="table table-bordered table-hover" style="font-size: 12px;">
        <thead class="thead-light text-muted">
          <tr  style="font-size: 13px;">      
            <th style=" text-align: center; vertical-align: center; " rowspan="2">Sasaran Strategis</th>
            <th style=" text-align: center; vertical-align: center; " rowspan="2">Indikator Kinerja Utama</th>
            <th style=" text-align: center; vertical-align: center; " rowspan="2">Satuan</th>
            <th style=" text-align: center; vertical-align: center; " colspan="4">Penjelasan</th>
          </tr>
          <tr style="font-size: 13px;">
            <th style=" text-align: center; vertical-align: center; ">Alasan</th>
            <th style=" text-align: center; vertical-align: center; ">Formulasi/Cara Pengukuran</th>
            <th style=" text-align: center; vertical-align: center; width: 10%;">Sumber Data</th>
            <th style=" text-align: center; vertical-align: center;  ">Keterangan</th>
          </tr>
        </thead>
      <tbody class="text-muted">
        @foreach(collect($sasaran)->unique('sasaran_id') as $s)
        <tr style="font-weight: bold;">
          <td colspan="8">{{$s->sasaran_nama}}</td>
        </tr>
        @foreach(collect($sasaran)->unique('indikator_sasaran_id')->where('sasaran_id', $s->sasaran_id) as $is)
        
        <tr style="font-size:  12px;">
          <td></td>
          <td>{{$is->indikator_sasaran}}</td>
          <td style="text-align: center;">{{$is->satuan_nama}}</td>
          <td>{{$is->alasan}}</td>
          <td>{{$is->formulasi}}</td>
          <td>{{$is->sumber_data}}</td>
          <td>{{$is->keterangan}}</td>
        </tr>
          @endforeach
          @endforeach
      </tbody>
      </table>
    </div>
  </div>
</div>
        
@stop        

