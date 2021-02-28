@extends('layouts.template')

@section('content')
<div class="card" style="padding: 10px;">
    <div class="card-header">
        <h4>Data Kegiatan</h4>
    </div>
        <div class="card-body">
            <div class="table-responsive">
               <table class="table table-hover table-bordered" style="font-size: 12px;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Kegiatan</th>
                            <th>Nama Kegiatan</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($kegiatans as $k)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$k->kegiatan_no}}</td>
                                <td>{{$k->kegiatan_nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                {!! $kegiatans->links() !!}
            </div>
        </div>
</div>
@endsection