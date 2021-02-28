@extends('public.template2')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
<div class="box-header">
    <h3 style="color: #007bff; font-weight: bold;">Perencanaan Kinerja</h3>
    {{-- <div class="pull-right"><a href="{{url('/')}}"><button class="btn btn-warning">Kembali</button></a></div> --}}
</div>
        <br>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr><th colspan="5" style="text-align: center; color: #00a6c6; background-color: #e8e8e8;">Dokumen Perencanaan Kabupaten</th></tr>
            <tr style="text-align: center;">
                <td><a href="{{url('perencanaan-kinerja/rpjmd')}}" data-toggle="tooltip" title="Lihat RPJMD" class="btn btn-sm btn-primary">RPJMD</a></td>
                <td><a href="{{url('perencanaan-kinerja/rkt')}}" data-toggle="tooltip" title="Lihat RKT Kabupaten" class="btn btn-sm btn-success">RKT</a></td>
                <td><a href="{{url('perencanaan-kinerja/iku')}}" data-toggle="tooltip" title="Lihat IKU Kabupaten" class="btn btn-sm btn-warning">IKU</a></td>
                <td><a href="{{url('perencanaan-kinerja/pk')}}"><button class="btn btn-sm btn-info" data-toggle="tooltip" title="Lihat PK Kabupaten">PK</button></a></td>
                <td height="100">
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pohon Kinerja <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('perencanaan-kinerja/pohon-kinerja')}}">Cascading OPD</a></li>
                        <li><a href="{{url('cascading/pohon-kinerja-rpjmd')}}">Cascading RPJMD</a></li>
                    </ul>
                </div>
                </td>
            </tr>
            </table>
        </div>

       

        <br>
        <div class="table table-responsive table-bordered">
           <table class="table table-responsive table-bordered table-hover" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th colspan="6" style="text-align: center; color: #00a6c6; background-color: #e8e8e8;">Dokumen Perencanaan Perangkat Daerah</th>
                    </tr>
                    <tr style="background-color: #007bff;">
                    	<th style="vertical-align: middle; width: 12%;" rowspan="2">Kode Organisasi</th>
                        <th style="vertical-align: middle; width: 60%;" rowspan="2">Nama Organisasi</th>
                    	<th colspan="4" style="text-align: center;">Dokumen Perencanaan</th>
                    </tr>
                    <tr style="background-color: #007bff; ">
                        <th style="text-align: center; width: 7%;">Renstra</th>
                        <th style="text-align: center; width: 7%;">RKT</th>
                        <th style="text-align: center; width: 7%;">IKU</th>
                        <th style="text-align: center; width: 7%;">PK</th>
                    </tr>
                   
                </thead>
                <tbody>
                   
                    @foreach($org as $orgs)
                    <tr >
                        <td style="font-size: 12px;">{{$orgs->organisasi_no}}</td>
                        <td style="font-size: 12px;">{{$orgs->organisasi_nama}}</td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('perencanaan-kinerja/renstra',$orgs->organisasi_no)}}" data-toggle="tooltip" title="Renstra {{$orgs->organisasi_nama}}"><button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button></a></td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('perencanaan-kinerja/rkt-opd',$orgs->organisasi_no)}}" data-toggle="tooltip" title="RKT {{$orgs->organisasi_nama}}"><button class="btn btn-sm btn-success"><i class="fa fa-search"></i></button></a></td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('perencanaan-kinerja/iku-opd',$orgs->organisasi_no)}}" data-toggle="tooltip" title="IKU {{$orgs->organisasi_nama}}"><button class="btn btn-sm btn-primary"><i class="fa fa-search" ></i></button></a></td>
                        <td style="font-size: 12px; text-align: center;"><a href="{{url('perencanaan-kinerja/pk-opd',$orgs->organisasi_no)}}" data-toggle="tooltip" title="PK {{$orgs->organisasi_nama}}"><button class="btn btn-sm btn-info"><i class="fa fa-search" ></i></button></a></td>
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
