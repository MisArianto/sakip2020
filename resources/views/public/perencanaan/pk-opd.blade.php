@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">

{{-- <div class="card-header">
    <div class="pull-right"><a href="{{url('perencanaan')}}"><button class="btn btn-warning">Kembali</button></a></div>
</div> --}}
        <div class="card-body">
            <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Perjanjian Kinerja</h4>
            <h5 style="text-align: center; font-weight: bold;">@foreach($opds as $opd)
            {{$opd->organisasi_nama}}
            @endforeach</h5>
            <hr>
            <form action="{{ url ('perencanaan-kinerja/pk-opd/data')}}" method="POST">
              @csrf
              <div class="row">
                      <div class="col-md-4">
                        <div class="input-group mb-3">
                        <select class="form-control" name="tahun" id="tahun">
                          <option @if($tahun=="target_t1") selected @endif value="target_t1">Tahun 2017</option>
                          <option @if($tahun=="target_t2") selected @endif value="target_t2">Tahun 2018</option>
                          <option @if($tahun=="target_t3") selected @endif value="target_t3">Tahun 2019</option>
                          <option @if($tahun=="target_t4") selected @endif value="target_t4">Tahun 2020</option>
                          <option @if($tahun=="target_t5") selected @endif value="target_t5">Tahun 2021</option>
                        </select>
                        <div class="input-group-prepend">
                          <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                      </div>
                </div>
            </form>


            <hr>
    <h5 style="text-align: center;">Eselon II</h5>
    <div class="table-responsive">
    <table class="table table-bordered table-hover" style="font-size: 11px;">
      <thead>
      <tr style="background-color: #007bff; vertical-align: middle; color: #fff;">
            <th rowspan="2">Sasaran</th>
            <th rowspan="2">Indikator Sasaran</th>
            <th rowspan="2" style="text-align: center;">Satuan</th>
            <th style="text-align: center;">Target</th>
      </tr>
      </thead>
      <tbody>
        @foreach($sasaran as $s)
        <tr style="font-size: 11px; font-weight: bold;">
          <td colspan="16">{{$s->sasaran_nama}}</td>
        </tr>
        @foreach(collect($indikator_sasaran)->where('sasaran_nomor', $s->sasaran_nomor) as $is)
          <tr style="font-size: 11px;">
            <td></td>
            <td>{{$is->indikator_sasaran_nama}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->satuan_nama}}</td>
            <td style="font-size: 10px; text-align: center;">{{$is->target}}</td>
          </tr>
        @endforeach
        @endforeach
      </tbody>
    </table>
    </div>

    <br>
    <div class="table table-responsive">
    <h5 style="text-align: center;">Eselon III dan IV</h5>
          <table class="table table-responsive table-bordered table-hover" style="font-size: 11px;">
            <thead>
            <tr style="background-color: #007bff; vertical-align: middle; color: #fff;">
                  <th rowspan="2" colspan="2">Program</th>
                  <th rowspan="2">Kegiatan</th>
                  <th rowspan="2">Indikator</th>
                  <th rowspan="2" style="text-align: center;">Satuan</th>
                  <th style="text-align: center;">Target</th>
                  <th style="text-align: center;">Pagu</th>
                </tr>
            </thead>
            <tbody>

                @foreach($program as $p)
                <tr style="font-size: 12px;font-weight: bold; background-color: #7abaff;">
                  <td colspan="18" >{{$p->program_no}} &nbsp; {{$p->program_nama}}</td>

                </tr>
                @foreach(collect($kegiatan)->where('program_no', $p->program_no) as $k)
                <tr style="font-size: 11px;">
                  <td colspan="2"></td>
                  <td>{{$k->kegiatan_nama}}</td>
                  <td>{{$k->indikator_kegiatan}}</td>
                  <td>{{$k->satuan_nama}}</td>
                  <td style="text-align: center;">{{$k->target}}</td>
                  <td style="text-align: right; font-size: 9px;">{{($k->pagu)}}</td>
                </tr>
              @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
        </div>
</div>

@stop

