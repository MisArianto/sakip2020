@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
    
{{-- <div class="box-header">
    <div class="pull-right"><a href="{{url('perencanaan')}}"><button class="btn btn-warning">Kembali</button></a></div>
</div> --}}
        <div class="card-body">
            <a href="{{url('/perencanaan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Rencana Kinerja Tahunan</h4>
            <h5 style="text-align: center;font-weight: bold;">Kabupaten Kepulauan Meranti</h5>
            {{-- @foreach($tahun as $t)
            <h5 style="text-align: center; color: #007bff; font-weight: bold;">Tahun {{$t->tahun}}</h5>
            @endforeach --}}
    
            {{-- <form action="{{url('perencanaan/rkt/kabupaten')}}" method="post">
              {{csrf_field()}}
            <select name="tahun" id="" class="form-control select2">
              <option value="">Pilih Tahun</option>
              <option value="target_t1">Tahun2017</option>
              <option value="target_t2">Tahun2018</option>
              <option value="target_t3">Tahun2019</option>
              <option value="target_t4">Tahun2020</option>
              <option value="target_t5">Tahun2021</option>
            
            </select>
            <button type="submit" class="btn btn-sm btn-warning" title="Cari">Cari</button>
            </form> --}}
            {{-- <div class="pull-right"> --}}
            <form action="{{ url ('perencanaan-kinerja/rkt/dataRkt')}}" method="POST">
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

                      {{-- <select class="form-control" name="tahun" id="tahun">
                        <option @if($tahun=="target_t1") selected @endif value="target_t1">Tahun 2017</option>
                        <option @if($tahun=="target_t2") selected @endif value="target_t2">Tahun 2018</option>
                        <option @if($tahun=="target_t3") selected @endif value="target_t3">Tahun 2019</option>
                      </select>
                    </div> --}}

                   {{--  <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>
                    </div> --}}
                </div>
            </form>
        <hr>

        <div class="table-responsive">
              <table class="table table-bordered table-hover  tablepretty" style="font-size: 12px;">
                <tr style="height: 40px; color: #fff; background-color: #007bff;">
                    <th>Tujuan</th>
                    <th colspan="2">Sasaran</th>
                    <th colspan="2">Indikator Sasaran</th>
                    <th style="text-align: center;">Satuan</th>
                    <th style="text-align: center;">Target</th>
          			</tr>
            <tbody>
                @foreach($tujuan as $t)
              <tr>
                <td colspan="12" style="font-weight: bold; background-color: #7abaff;" title="Tujuan">{{$t->tujuan_nama}}</td>
              </tr>
      			@foreach(collect($sasaran)->where('tujuan_id', $t->id) as $s)
      			<tr>
      				<td></td>
                <td colspan="11" style="font-weight: bold;" title="Sasaran">{{$no++}}. {{$s->sasaran_nama}}</td>
            </tr>
                @foreach(collect($indikator_sasaran)->where('sasaran_id', $s->id) as $is)
                <tr >
                  <td colspan="3"></td>
                  <td>-</td>
                  <td title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>

                  @foreach(collect($target_rkt)->where('indikator_sasaran_id', $is->id) as $t)
                  <td style="text-align: center;">{{$t->satuan_nama}}</td>
                  <td style="text-align: center;">{{$t->target_t}}</td>
                </tr>
                
                @endforeach
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

