@extends('public.template')

@section('content')
<div class="box box-default" style="padding: 10px;">

<div class="box-header">
    <h3 style="color: #007bff; font-weight: bold;">Cascading</h3>
</div>
        <div class="box-body">
            {{-- <a href="{{ url('cascading/pohon_kinerja') }}" class="btn btn-danger" data-toggle="tooltip" title="Lihat Pohon Kinerja">Lihat Pohon Kinerja</a> --}}
            <hr>
            <div class="table table-responsive table-bordered">
               <table class="table table-responsive table-bordered">
                    <thead>
                        
                        <tr style="background-color: #007bff;;">
                            <th style="vertical-align: middle; width: 12%;" rowspan="2">Kode Organisasi</th>
                            <th style="vertical-align: middle; " rowspan="2">Nama Organisasi</th>
                            <th style="text-align: center;">#</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                           <td>14.10.</td>
                           <td>Kabupaten Kepulauan Meranti</td>
                           <td style="text-align: center;">
                            <a href="{{url('cascading/kabupaten')}}" data-toggle="tooltip" title="Lihat Cascading Kabupaten" class="btn btn-xs btn-primary">
                               <i class="fa fa-search"></i>
                        </a>
                        </td>
                       </tr>
                        @foreach($orgs as $org)
                        <tr >
                            <td style="font-size: 12px;">{{$org->organisasi_no}}</td>
                            <td style="font-size: 12px;">{{$org->organisasi_nama}}</td>
                            <td style="font-size: 12px; text-align: center;">
                                <a href="{{url('cascading/opd/data',$org->organisasi_no)}}" data-toggle="tooltip" title="Lihat Cascading {{$org->organisasi_nama}}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
            <br>
        </div>
</div>

        
@stop        
