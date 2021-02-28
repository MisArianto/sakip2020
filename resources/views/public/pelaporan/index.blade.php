@extends('public.template')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">

<div class="box-header">
    <h3 style="color: #007bff; font-weight: bold;">Pelaporan Kinerja</h3>
</div>
    

        <div class="card-body">
        

       

        <div class="table-responsive">
           <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="6" style="text-align: center; color: #007bff; background-color: #e8e8e8; font-size: 16px;">Laporan Kinerja Instansi Pemerintah</th>
                    </tr>
                    <tr style="background-color: #007bff;;">
                    	<th style="vertical-align: middle; width: 12%;" rowspan="2">Kode Organisasi</th>
                        <th style="vertical-align: middle; " rowspan="2">Nama Organisasi</th>
                    	<th style="text-align: center;">LKjIP</th>
                    </tr>
                    {{-- <tr style="background-color: salmon; ">
                        <th style="text-align: center; width: 7%;">Indikator Sasaran</th>
                        <th style="text-align: center; width: 7%;">Indikator Program</th>
                        <th style="text-align: center; width: 7%;">ndikator Kegiatan</th>
                    </tr> --}}
                   
                </thead>
                <tbody>
                   <tr>
                       <td>14.10.</td>
                       <td>Kabupaten Kepulauan Meranti</td>
                       <td style="text-align: center;">
                        <a href="#" data-toggle="tooltip" title="Lihat LKjIP Kabupaten" class="btn btn-sm btn-primary">
                        {{-- <a href="{{ url('pelaporan/lkjip') }}" data-toggle="tooltip" title="Laporan Kinerja Instansi Pemerintah Kabupaten Kepulauan Meranti"> --}}
                           <i class="fa fa-search"></i>
                        {{-- </a> --}}
                    </a>
                    </td>
                   </tr>
                    @foreach($orgs as $org)
                    <tr >
                        <td style="font-size: 12px;">{{$org->organisasi_no}}</td>
                        <td style="font-size: 12px;">{{$org->organisasi_nama}}</td>
                        <td style="font-size: 12px; text-align: center;">
                            <a href="{{ url('pelaporan-kinerja/form',$org->organisasi_no) }}" data-toggle="tooltip" title="Lihat LKjIP {{$org->organisasi_nama}}" class="btn btn-sm btn-primary">
                            {{-- <a href="{{url('pelaporan/lkjip-opd',$org->organisasi_no)}}" data-toggle="tooltip" title="Laporan Kinerja Instansi Pemerintah{{$org->organisasi_nama}}"> --}}
                                <i class="fa fa-search"></i>
                            {{-- </a> --}}
                            </a>
                        </td>
                        {{-- <td style="font-size: 12px; text-align: center;"><a href="{{url('pelaporan/indikator-program-opd',$org->organisasi_no)}}" data-toggle="tooltip" title="pelaporan Indikator Program {{$org->organisasi_nama}}"><button class="btn btn-xs"><i class="fa fa-search"></i></button></a></td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('pelaporan/indikator-kegiatan-opd',$org->organisasi_no)}}" data-toggle="tooltip" title="pelaporan Indikator Kegiatan {{$org->organisasi_nama}}"><button class="btn btn-xs"><i class="fa fa-search" ></i></button></a></td> --}}
                        
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
