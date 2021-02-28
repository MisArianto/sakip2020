<div class="tavle table-responsive">
  <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
    <tr style=" background-color: #007bff;">
        {{-- <th rowspan="2" style="vertical-align: middle;">No</th> --}}
        <th rowspan="4" style="vertical-align: middle;">Indikator Sasaran</th>
        <th rowspan="4" style="vertical-align: middle;">Formulasi</th>
        <th rowspan="4" style="vertical-align: middle;">Program</th>
        {{-- <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th> --}}
        <th rowspan="4" style="text-align: center;vertical-align: middle;">Target</th>
        <th rowspan="4" style="text-align: center;vertical-align: middle;">Pagu</th>
        <th colspan="12" style="text-align: center;vertical-align: middle;">Capaian Kinerja Sasaran</th>
        <th rowspan="4" style="vertical-align: middle; text-align: center;">Aksi</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th colspan="3" style="text-align: center;">TW I</th>
        <th colspan="3" style="text-align: center;">TW II</th>
        <th colspan="3" style="text-align: center;">TW III</th>
        <th colspan="3" style="text-align: center;">TW IV</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th style="text-align: center;">A I</th>
        <th style="text-align: center;">Rkmn I</th>
        <th style="text-align: center;">Real I</th>

        <th style="text-align: center;">A II</th>
        <th style="text-align: center;">Rkmn II</th>
        <th style="text-align: center;">Real II</th>

        <th style="text-align: center;">A III</th>
        <th style="text-align: center;">Rkmn III</th>
        <th style="text-align: center;">Real III</th>

        <th style="text-align: center;">A IV</th>
        <th style="text-align: center;">Rkmn IV</th>
        <th style="text-align: center;">Real IV</th>
    </tr>
     
    <tbody>
    
        
    @foreach(collect($capaian_sasaran)->unique('indikator_sasaran_id') as $cs)
    <tr >
        {{-- <td style="text-align: center;">{{$no++}}</td> --}}
        <td title="Indikator Sasaran" >{{$cs->indikator_sasaran}}</td>
        <td title="Indikator Sasaran" >{{$cs->formulasi}}</td>
    {{-- </tr> --}}
    {{-- <tr> --}}
       
        <td title="program">
    @foreach(collect($capaian_sasaran)->unique('program_no')->where('indikator_sasaran_id', $cs->indikator_sasaran_id) as $cs2)
            - {{$cs2->program_nama}} <br>
    @endforeach
        </td>
        {{-- <td title="Satuan" style="text-align: center;">{{$cs->satuan_nama}}</td> --}}
        <td title="Target" style="text-align: center;">
            tw I: {{$cs2->target_tw1}} <br>
            tw II: {{$cs2->target_tw2}} <br>
            tw III: {{$cs2->target_tw3}} <br>
            tw IV: {{$cs2->target_tw4}} <br>
        </td>
        <td title="pagu" style="text-align: center;">{{$cs2->pagu}}</td>
        {{-- <td title="TW I" style="text-align: center;">{{$cs2->tw_1}}</td> --}}
        <td title="Anggaran I" style="text-align: center;">{{$cs2->a_1}}</td>
        <td title="Rekomendasi I" style="text-align: center;">{{$cs2->rkmn_1}}</td>
        <td title="Realisasi  I" style="text-align: center;">{{$cs2->real_1}}</td>

        {{-- <td title="TW II" style="text-align: center;">{{$cs2->tw_2}}</td> --}}
        <td title="Anggaran  II" style="text-align: center;">{{$cs2->a_2}}</td>
        <td title="Rekomendasi  II" style="text-align: center;">{{$cs2->rkmn_2}}</td>
        <td title="Realisasi  II" style="text-align: center;">{{$cs2->real_2}}</td>

        {{-- <td title="TW III" style="text-align: center;">{{$cs2->tw_3}}</td> --}}
        <td title="Anggaran III" style="text-align: center;">{{$cs2->a_3}}</td>
        <td title="Rekomendasi III" style="text-align: center;">{{$cs2->rkmn_3}}</td>
        <td title="Realisasi  III" style="text-align: center;">{{$cs2->real_3}}</td>

        {{-- <td title="Realisasi TW IV" style="text-align: center;">{{$cs2->tw_4}}</td> --}}
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->a_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->rkmn_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->real_4}}</td>
       {{--  <td title="Capaian" style="text-align: center;">@php 

            // if(is_numeric($cs->target_t) || is_float($cs->target_t)){
                // $arr = array($cs->tw_1, $cs->tw_2, $cs->tw_3, $cs->tw_4);

            //     echo round((int)max($arr)/(int)$cs->target_t * 100, 2);
            // }
            

    @endphp %</td> --}}
    <td style="text-align: center;">
        <a href="{{ url('capaian/sasaran/edit', $cs->id) }}" class="btn btn-info btn-xs"> edit</a>
    </td>
    </tr>
    
    @endforeach
    </tbody>
  </table>
</div>

