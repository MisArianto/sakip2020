@extends('public.template')

@section('content')
<div class="box box-default" style="padding: 10px;">

        <div class="box-body">
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Capaian Indikator Program RPJMD</h4>
            <h5 style="text-align: center; font-weight: bold;">Kabupaten Kepulauan Meranti</h5>
            <h5 style="text-align: center; color: #007bff; font-weight: bold;">Tahun 2019</h5>
            <hr>
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
        <div class="table table-responsive">
            
           
            
              <table class="table table-responsive table-bordered" style="font-size: 12px;">
              <thead>
              <tr style="vertical-align: middle; background-color: #007bff ;">
                <th rowspan="2" style="vertical-align: middle;">No</th>
                <th rowspan="2" style="vertical-align: middle;">Indikator Program</th>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">Target</th>
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
            
              @foreach($indikator_program as $ip)
              <tr>
                <td style="text-align: center;">{{$no++}}</td>
                  <td title="Indikator Program" style="">{{$ip->indikator_program}}</td>
                  @foreach($target_program as $tp)
                  @if($ip->program_no==$tp->program_no)
                  <td style="text-align: center; font-size: 11px;">{{$tp->satuan_nama}}</td>
                  
                  <td style="text-align: center; font-size: 11px;">{{$tp->target_t3}}</td>
                  <td style="text-align: center; font-size: 11px;">-</td>
                  <td style="text-align: center; font-size: 11px;">-</td>
                  <td style="text-align: center; font-size: 11px;">-</td>
                  <td style="text-align: center; font-size: 11px;">-</td>
                  <td style="text-align: center; font-size: 11px;">-%</td>
                  
                @endif
                @endforeach 
                </tr>
              @endforeach 
              </tbody>
              </table>
        </div>
        {{-- <div class="pull-right">
            {!! $org->links()!!}
        </div> --}}
        </div>
</div>
        
@stop        

