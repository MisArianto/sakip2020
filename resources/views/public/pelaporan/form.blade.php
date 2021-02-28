@extends('public.template')

@section('content')
<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">

<div class="box-header">
    <a href="{{url('/pelaporan-kinerja')}}" class="btn btn-default"><i class="fa fa-long-arrow-left"></i></a>
    <h3 style="color: #007bff; font-weight: bold;">Data LKJIP {{ $nama_opd }}</h3>
</div>
    

        <div class="card-body">
       

        <div class="table-responsive">
           <table class="table table-bordered">
                <thead>
                    
                    <tr style="background-color: #007bff;;">
                        <th style="text-align: center;">No</th>
                        <th>Nama File</th>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lkjips as $lkjip)
                    <tr >
                        <td>{{$no++}}</td>
                        <td>{{$lkjip->nama_file}}</td>
                        <td align="center">{{$lkjip->tahun}}</td>
                        <td align="center">
                            <form action="{{ url('pelaporan-kinerja/download-lkjip') }}" method="POST" style="display: inline;">
                                @csrf

                                <input type="hidden" name="organisasi_no" value="{{$lkjip->organisasi_no}}">
                                <input type="hidden" name="tahun" value="{{$lkjip->tahun}}">
                                
                                <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Download {{ $lkjip->nama_file }}"><i class="fa fa-download"></i></button>

                            </form>

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
