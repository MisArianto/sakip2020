@extends('public.template')

@section('content')

<div class="box box-default" style="padding: 10px;">

<div class="box-header">
    <h3 style="color: #007bff; font-weight: bold;">Cascading

        @foreach($opds as $opd)
        {{$opd->organisasi_nama}}
        @endforeach
    </h3>
</div>
        <div class="box-body" style="font-style: 12px;">
        <div class="row">
            <div class="table-responsive">
                    <div class="col-md-12">
                        <ul id="tree1">
                            @foreach($visi as $v)
                                <li>VISI : <br>
                                    <button class="btn btn-primary" data-toggle="tooltip" title="VISI" style="font-weight: bold;background-color: #007bff;color:white; padding: 10px;">{{ $v->nama }}</button> 
                                    @foreach(collect($misi)->where('visi_id', $v->id) as $m)
                                    <ul>
                                        <li>MISI : <br>
                                            <button class="btn btn-primary"data-toggle="tooltip" title="MISI" style="font-weight: bold;background-color: #00a65a;color:white;padding: 10px;">- {{$m->nama}}</button>
                                            @foreach(collect($tujuan)->where('misi_nomor', $m->nomor) as $t)
                                            <ul>
                                                <li>TUJUAN : <br>
                                                    <button class="btn btn-primary"data-toggle="tooltip" title="TUJUAN" style="font-weight: bold;background-color: #f39c12;color:white;padding: 10px;">- {{$t->tujuan_nama}}</button>
                                                    @foreach(collect($sasaran)->where('tujuan_nomor', $t->tujuan_nomor) as $s)
                                                    <ul>
                                                        <li>SASARAN : <br>
                                                            <button class="btn btn-primary"data-toggle="tooltip" title="SASARAN" style="font-weight: bold;background-color: #17a2b8;color:white;padding: 10px;">- {{$s->sasaran_nama}}</button>
                                                            @foreach(collect($indikator_sasaran)->where('sasaran_nomor', $s->sasaran_nomor) as $is)
                                                            <ul>
                                                                <li>INDIKATOR SASARAN : <br>
                                                                <button class="btn btn-primary"data-toggle="tooltip" title="INDIKATOR SASARAN" style="font-weight: bold;background-color: salmon;color:white;padding: 10px;">- {{$is->indikator_sasaran_nama}}</button>
                                                                @foreach(collect($program)->where('indikator_sasaran_id', $is->id) as $p)
                                                                <ul>
                                                                    <li>PROGRAM : <br>
                                                                    <button class="btn btn-primary"data-toggle="tooltip" title="PROGRAM" style="font-weight: bold;background-color: #605ca8;color:white;padding: 10px;">- {{$p->program_nama}}</button>
                                                                    @foreach(collect($kegiatans)->where('program_no', $p->program_no) as $k)
                                                                    <ul>
                                                                        <li>KEGIATAN : <br>
                                                                        <button class="btn btn-primary"data-toggle="tooltip" title="KEGIATAN" style="font-weight: bold;background-color: #dc3545;color:white;padding: 10px;">- {{$k->kegiatan_nama}}</button>
                                                                            <ul>
                                                                                <li>INDIKATOR KEGIATAN : <br>
                                                                                    <button class="btn btn-primary"data-toggle="tooltip" title="INDIKATOR KEGIATAN" style="font-weight: bold;background-color: #3c763d;color:white;padding: 10px;">- {{$k->indikator_kegiatan}}</button>
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
