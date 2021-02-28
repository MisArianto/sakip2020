@extends('public.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    
<div class="box-header"> <h3 style="color:#007bff; font-weight: bold; ">Capaian Kinerja</h3></div>

        <div class="box-body">
        {{-- <div class="table table-responsive table-bordered">
            <table class="table table-responsive">
                <tr><th colspan="4" style="text-align: center; color: #00a6c6; background-color: #e8e8e8;">Capaian Kinerja Kabupaten</th></tr>
            <tr style="text-align: center;">
                <td style="width: 25%;"><a href="{{url('capaian-kinerja/indikator-sasaran')}}" data-toggle="tooltip" title="Capaian Indikator Sasaran RPJMD" class="btn btn-sm btn-primary">Indikator Sasaran</a></td>
                
                <td style="width: 25%;"><a href="{{url('capaian-kinerja/indikator-program')}}"  ><button class="btn btn-sm btn-success" data-toggle="tooltip" title="Capaian Indikator Program RPJMD">Indikator Program</button></a></td>
            </tr>
            </table>
        </div> --}}

       

        <br>
        <div class="table table-responsive table-bordered">
           <table class="table table-responsive table-bordered table-hover">
                <thead>
                    {{-- <tr>
                        <th colspan="6" style="text-align: center; color: #00a6c6; background-color: #e8e8e8;">Capaian Kinerja Perangkat Daerah</th>
                    </tr> --}}
                    <tr style="background-color: #007bff;">
                    	<th style="vertical-align: middle; width: 12%;" rowspan="2">Kode Organisasi</th>
                        <th style="vertical-align: middle; " rowspan="2">Nama Organisasi</th>
                    	<th style="text-align: center;">Capaian Target</th>
                    </tr>
                    {{-- <tr style="background-color: #007bff; ">
                        <th style="text-align: center; width: 7%;">Indikator Sasaran</th>
                        <th style="text-align: center; width: 7%;">Indikator Program</th>
                        <th style="text-align: center; width: 7%;">ndikator Kegiatan</th>
                    </tr> --}}
                   
                </thead>
                <tbody>
                    <tr>
                        <td>14.10.</td>
                        <td>Kabupaten Kepulauan Meranti</td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('capaian-kinerja/indikator-sasaran')}}" data-toggle="tooltip" title="Capaian Indikator Sasaran RPJMD" class="btn btn-xs btn-primary"><i class="fa fa-search"></i></a></td>
                    </tr>
                    @foreach($orgs as $org)
                    <tr >
                        <td style="font-size: 12px;">{{$org->organisasi_no}}</td>
                        <td style="font-size: 12px;">{{$org->organisasi_nama}}</td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('capaian-kinerja/indikator-opd',$org->organisasi_no)}}" data-toggle="tooltip" title="Lihat Capaian Kinerja {{$org->organisasi_nama}}"><button class="btn btn-xs btn-primary"><i class="fa fa-search"></i></button></a></td>
                        {{-- <td style="font-size: 12px; text-align: center;"><a href="{{url('capaian/indikator-program-opd',$org->organisasi_no)}}" data-toggle="tooltip" title="Capaian Indikator Program {{$org->organisasi_nama}}"><button class="btn btn-xs"><i class="fa fa-search"></i></button></a></td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('capaian/indikator-kegiatan-opd',$org->organisasi_no)}}" data-toggle="tooltip" title="Capaian Indikator Kegiatan {{$org->organisasi_nama}}"><button class="btn btn-xs"><i class="fa fa-search" ></i></button></a></td> --}}
                        
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
        </div>
        {{-- <div class="pull-right">
            {{$org->links()}}
        </div> --}}
        
        </div>
        </div>
</div>

        
@stop        
