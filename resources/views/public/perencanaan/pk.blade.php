@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
    
{{-- <div class="box-header">
    <div class="pull-right"><a href="{{url('perencanaan')}}"><button class="btn btn-warning">Kembali</button></a></div>
</div> --}}
        <div class="card-body">
            <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Perjanjian Kinerja</h4>
            <h5 style="text-align: center; font-weight: bold;">Kabupaten Kepulauan Meranti</h5>
            {{-- <h5 style="text-align: center; color: #007bff; font-weight: bold;">Tahun 2019</h5> --}}
            <hr>

            <form action="{{ url ('perencanaan-kinerja/pk/data')}}" method="POST">
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
        <div class="table-responsive">
            
           
            
              <table class="table table-bordered table-hover  tablepretty" style="font-size: 12px;">
              <thead>
              <tr style="vertical-align: middle; color: #fff; background-color: #007bff ;">
                <th rowspan="2">Sasaran</th>
                <th rowspan="2">Indikator Sasaran</th>
                <th rowspan="2" style="text-align: center;">Satuan</th>
                <th style="text-align: center;">Target</th>
                
              </tr>
                
              </thead>
              <tbody>
              @foreach($sasaran as $s)
                      <tr>
                        <td colspan="16" style="font-weight: bold; background-color: #7abaff; ;" title="Sasaran">{{$s->sasaran_nama}}</td>
                      </tr>
                      @foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
                      <tr>
                        <td></td>
                        <td  style="font-weight: bold; " title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
                        @foreach(collect($target_pk)->where('indikator_sasaran_id', $is->id) as $t)
                        <td style="text-align: center;">{{$t->satuan_nama}}</td>
                        <td style="text-align: center;">{{$t->target_t}}</td>
                      </tr>
                
              @endforeach
              @endforeach 
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

