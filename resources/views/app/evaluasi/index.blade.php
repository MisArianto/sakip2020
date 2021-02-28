@extends('layouts.template')

@section('content')


<div class="box box-default" style="padding: 15px;">
	<div class="box-header">
	<h4> Laporan Hasil Evaluasi Tahun {{ $tahun }}</h4>
	</div>

<div class="box-body">

        <form action="{{ url ('evaluasi/requestLhe')}}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                       {{--  @if(Auth::user()->level != 2)
                        <div class="col-md-6">
                        <select class="form-control select2" name="organisasi_no" id="organisasi_no">
                            <option value="">-- Pilih OPD --</option>
                            @foreach($orgs as $data)
                            <option @if($data->organisasi_no == $req_opd) selected @endif value="{{$data->organisasi_no}}">{{$data->organisasi_nama}}</option>
                            @endforeach
                        </select>
                        </div>
                        @endif --}}
        
        
                    <div class="col-md-2">
                        <select class="form-control select2" name="tahun" id="tahun">
                            <option value="">--Tahun--</option>
                            @for($i=2017;$i<2022;$i++)
                            <option @if($i == $tahun_int) selected @endif value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
        
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-warning" title="Cari"><i class="fa fa-search"></i></button>
                        </div>
                </div>
            </div>
        </form>

        {{-- <h4 style="font-weight: bold; color: salmon;">{{$opd ? $opd->organisasi_nama : ''}}</h4> --}}
{{-- 
        <br>    

        <a href="{{ url('evaluasi-kinerja/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>

        <br> --}}

        <br>

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
                        <th style="text-align: center; " >#</th>
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
                            <td>
                                <a href="{{ route('lhe.edit', $data->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        </div>
</div>
@endsection

@push('scripts')
<script>

function ConfirmDelete() {
    var x = confirm("Yakin akan menghapus data?");
    if (x) return true; else return false;
}


</script>
@endpush

