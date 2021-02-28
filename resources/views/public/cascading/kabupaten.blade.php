@extends('public.template')

@section('content')

<div class="box box-default" style="padding: 10px;">

<div class="box-header">
    <h3 style="color: #007bff; font-weight: bold;">Cascading Kabupaten Kepulauan Meranti 
        {{-- Periode : 
        @foreach($periode as $periodes)
        {{$periodes->periode}}
        @endforeach --}}
    </h3>
</div>
        <div class="box-body" style="font-style: 12px;">
        <div class="row">
            <div class="table-responsive">
                    <div class="col-md-12">
                        <ul id="tree1">
                            @foreach($visi as $v)
                                <li>VISI :  <br>
                                    <button class="btn btn-primary" data-toggle="tooltip" title="VISI" style="font-weight: bold;background-color: #007bff;color:white; padding: 10px; border-color: black;">{{ $v->nama }}</button> 
                                    @foreach(collect($misi)->where('visi_id', $v->id) as $m)
                                    <ul>
                                        <li>MISI KE {{$m->nomor}} : <br>
                                            <button class="btn btn-primary"data-toggle="tooltip" title="MISI" style="font-weight: bold;background-color: #00a65a;color:white; padding: 10px;">{{$m->nama}}</button>
                                            @foreach(collect($tujuan_rpjmd)->where('misi_id', $m->id) as $t)
                                            <ul>
                                                <li>TUJUAN : <br>
                                                    <button class="btn btn-primary"data-toggle="tooltip" title="TUJUAN" style="font-weight: bold;background-color: #f39c12;color:white;padding: 10px;">- {{$t->tujuan_nama}}</button>
                                                    @foreach(collect($sasaran_rpjmd)->where('tujuan_id', $t->id) as $s)
                                                    <ul>
                                                        <li>SASARAN : <br>
                                                            <button class="btn btn-primary"data-toggle="tooltip" title="SASARAN" style="font-weight: bold;background-color: #17a2b8;color:white;padding: 10px;">- {{$s->sasaran_nama}}</button>
                                                            @foreach(collect($indikator_sasaran_rpjmd)->where('sasaran_id', $s->id) as $is)
                                                            <ul>
                                                                <li>INDIKATOR SASARAN : <br>
                                                                <button class="btn btn-primary"data-toggle="tooltip" title="INDIKATOR SASARAN" style="font-weight: bold;background-color: #605ca8;color:white;padding: 10px;">- {{$is->indikator_sasaran}}</button>
                                                                @foreach(collect($program_rpjmd)->where('indikator_sasaran_id', $is->id) as $p)
                                                                <ul>
                                                                    <li>PROGRAM : <br>
                                                                    <button class="btn btn-primary"data-toggle="tooltip" title="PROGRAM" style="font-weight: bold;background-color: #dc3545;color:white;padding: 10px;">- {{$p->program_nama}}</button>
                                                                    <ul>
                                                                        <li>INDIKATOR PROGRAM : <br>
                                                                        <button class="btn btn-primary"data-toggle="tooltip" title="INDIKATOR PROGRAM" style="font-weight: bold;background-color: #3c763d;color:white;padding: 10px;">- {{$p->indikator_program}}</button>
                                                                            
                                                                        </li>
                                                                    </ul>
                                                                        
                                                                    </li>
                                                                </ul>
                                                                @endforeach
                                                                </li>
                                                            </ul>
                                                            @endforeach
                                                        </li>
                                                    </ul>
                                                    @endforeach
                                                </li>
                                            </ul>
                                            @endforeach
                                        </li>

                                    </ul>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    </div>
        </div>
</div>
</div>

        
@stop
