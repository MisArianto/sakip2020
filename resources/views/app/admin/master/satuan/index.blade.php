@extends('layouts.template')

@section('content')
<div class="box box-default" style="padding: 10px;">
    <div class="box-header">
        <h4>Data Satuan</h4>
    </div>

        <div class="box-body">
            <div class="table-responsive">
               <table class="table table-hover table-bordered" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($satuans as $s)
                            <tr>
                                <td style="width:10px;">{{$no++}}</td>
                                <td>{{$s->satuan_nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                {!! $satuans->links() !!}
            </div>
        </div>
</div>
        
@endsection