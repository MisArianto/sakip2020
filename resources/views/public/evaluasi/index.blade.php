@extends('public.template')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">

<div class="box-header">
    <h3 style="color: #007bff; font-weight: bold;">Laporan Hasil Evaluasi Internal Tahun {{ date('Y') - 1 }}</h3>
</div>
    

        <div class="card-body">

        <div class="table-responsive">
            <table class="table  table-bordered table-hover" >
                <thead>
                    <tr style="background-color: rgb(102, 184, 255); font-weight: bold; font-size: 1.2rem;">
                        <th rowspan="2" style="text-align: center; vertical-align: middle; ">No</th>
                        <th rowspan="2" style=" vertical-align: middle;">Nama Perangkat Daerah</th>
                        <th style="text-align: center; " >Kategori</th>
                        <th style="text-align: center; " >Nilai</th>
                        <th style="text-align: center; " >Tahun</th>
                        <th style="text-align: center; " >Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lhes as $data)
                        <tr class="odd gradeX">
                            <td style="text-align: center; ">{{$no++}}</td> 
                            <td style="font-weight: bold;">{{$data->organisasi_nama}}</td>
                            
                            <td style="text-align: center; "> <form method="post" action="laporan_kinerja">
                                @if (substr($data->nilai, 0,2)>=90)
                                    AA
                                
                                @elseif (substr($data->nilai, 0,2)>=80 and substr($data->nilai, 0,2)<90) 
                                    A
                                
                                @elseif (substr($data->nilai, 0,2)>=70 and substr($data->nilai, 0,2)<80) 
                                    BB
                                
                                @elseif (substr($data->nilai, 0,2)>=60 and substr($data->nilai, 0,2)<70) 
                                    B
                                
                                @elseif (substr($data->nilai, 0,2)>=50 and substr($data->nilai, 0,2)<60) 
                                    CC
                                
                                @elseif (substr($data->nilai, 0,2)>=40 and substr($data->nilai, 0,2)<50) 
                                    C
                                
                                @elseif (substr($data->nilai, 0,2)>=00 and substr($data->nilai, 0,2)<40) 
                                    D
                                @endif
                            </td>
                            <td style="text-align: center; "> <form method="post" action="laporan_kinerja">{{$data->nilai}}</td>
                            <td style="text-align: center; "> <form method="post" action="laporan_kinerja">{{$data->tahun}}</td>
                            <td style="text-align: center; "> <form method="post" action="laporan_kinerja">

                                @if (substr($data->nilai, 0,2)>=90)
                                    Sangat Memuaskan
                                
                                @elseif (substr($data->nilai, 0,2)>=80 and substr($data->nilai, 0,2)<90) 
                                    Memuaskan
                                
                                @elseif (substr($data->nilai, 0,2)>=70 and substr($data->nilai, 0,2)<80) 
                                    Sangat Baik
                                
                                @elseif (substr($data->nilai, 0,2)>=60 and substr($data->nilai, 0,2)<70) 
                                    Baik
                                
                                @elseif (substr($data->nilai, 0,2)>=50 and substr($data->nilai, 0,2)<60) 
                                    Cukup
                                
                                @elseif (substr($data->nilai, 0,2)>=40 and substr($data->nilai, 0,2)<50) 
                                    Kurang
                                
                                @elseif (substr($data->nilai, 0,2)>=00 and substr($data->nilai, 0,2)<40) 
                                    Sangat Kurang
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        </div>
        </div>
</div>

        
@stop        
