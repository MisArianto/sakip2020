@extends('layouts.template')

@section('content')
<div class="card" style="padding: 10px;">
    <div class="card-header">
        <h4>Data Program</h4>
    </div>
        <div class="card-body">
            <div class="table-responsive">
               <table class="table table-hover table-bordered" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Kode Program</th>
                            <th>Nama Program</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $p)
                        <tr>
                            <td>{{$p->program_no}}</td>
                            <td>{{$p->program_nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $programs->links() !!}
            </div>
        </div>
</div>
@endsection