@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
    
        <div class="card-body">
            <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Indikator Kinerja Utama</h4>
            <h5 style="text-align: center; font-weight: bold;">Kabupaten Kepulauan Meranti</h5>
            <h5 style="text-align: center; color: #007bff; font-weight: bold;">@foreach($periode as $p)
        Periode {{$p->periode}}
        @endforeach</h5>
            {{-- <form action="{{url('perencanaan/rkt/dataRKT')}}" method="post">
              {{csrf_field()}}
            <select name="tahun" id="">
              <option value="">Pilih Tahun</option>
              <option value="target_t1">Tahun2017</option>
              <option value="target_t2">Tahun2018</option>
              <option value="target_t3">Tahun2019</option>
              <option value="target_t4">Tahun2020</option>
              <option value="target_t5">Tahun2021</option>
            
            </select>
            <button class="btn btn-primary">Cari</button>
            </form> --}}
            <hr>
    <div class="table-responsive table-bordered">
    <table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
        <thead>
          <tr  style="font-size: 13px;">      
            <th style=" text-align: center; vertical-align: center; " rowspan="2">Sasaran Strategis</th>
            <th style=" text-align: center; vertical-align: center; " rowspan="2">Indikator Kinerja Utama</th>
            <th style=" text-align: center; vertical-align: center; " rowspan="2">Satuan</th>
            <th style=" text-align: center; vertical-align: center; " colspan="4"> Penjelasan</th>
          </tr>
          <tr style="font-size: 13px;">
            <th style=" text-align: center; vertical-align: center; ">Alasan</th>
            <th style=" text-align: center; vertical-align: center; ">Formulasi/Cara Pengukuran</th>
            <th style=" text-align: center; vertical-align: center; width: 10%;">Sumber Data</th>
            <th style=" text-align: center; vertical-align: center;  ">Keterangan</th>
          </tr>
        </thead>
      <tbody>
        @foreach($sasaran as $s)
        <tr style="background-color: #7abaff; font-weight: bold;">
          <td colspan="8">{{$s->sasaran_nama}}</td>
        </tr>
        @foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
        {{-- @if($s->id==$is->sasaran_id) --}}
        <tr style="font-size:  12px;">
          <td></td>
          <td>{{$is->indikator_sasaran}}</td>
          <td style="text-align: center;">{{$is->satuan_nama}}</td>
       
          <td>{{$is->alasan}}</td>
          <td>{{$is->formulasi}}</td>
          <td>{{$is->sumber_data}}</td>
          <td>{{$is->keterangan}}</td>
      
        </tr>
        {{-- @endif --}}
          @endforeach
          @endforeach
      </tbody>
      </table>
                    
  </div>
        </div>
</div>
        
@stop        

