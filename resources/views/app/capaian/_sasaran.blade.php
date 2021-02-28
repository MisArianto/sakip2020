
{{-- <div class="tavle table-responsive">
  <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
    <tr style=" background-color: #007bff;">
        <th rowspan="2" style="vertical-align: middle;">No</th>
        <th rowspan="2" style="vertical-align: middle;">Indikator Sasaran</th>
        <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th>
        <th rowspan="2" style="text-align: center;">Target</th>
        <th colspan="8" style="text-align: center;">Realisasi</th>
        <th rowspan="2" style="vertical-align: middle; text-align: center;">Capaian</th>
        <th rowspan="2" style="vertical-align: middle; text-align: center;">Aksi</th>
	</tr>
	<tr style=" background-color: #007bff;">
		<th style="text-align: center;">TW I</th>
        <th style="text-align: center;">R I</th>
		<th style="text-align: center;">TW II</th>
        <th style="text-align: center;">R II</th>
		<th style="text-align: center;">TW III</th>
        <th style="text-align: center;">R III</th>
		<th style="text-align: center;">TW IV</th>
        <th style="text-align: center;">R IV</th>
	</tr>
     
    <tbody>
    
		
    @foreach($capaian_sasaran as $cs)
    <tr >
        <td style="text-align: center;">{{$no++}}</td>
        <td title="Indikator Sasaran">{{$cs->indikator_sasaran_nama}}</td>
       
        <td title="Satuan" style="text-align: center;">{{$cs->satuan_nama}}</td>
        <td title="Target" style="text-align: center;">{{$cs->target_t}}</td>
        <td title="Realisasi TW I" style="text-align: center;">{{$cs->tw_1}}</td>
        <td title="Realisasi  I" style="text-align: center;">{{$cs->r_1}}</td>
        <td title="Realisasi TW II" style="text-align: center;">{{$cs->tw_2}}</td>
        <td title="Realisasi  II" style="text-align: center;">{{$cs->r_2}}</td>
        <td title="Realisasi TW III" style="text-align: center;">{{$cs->tw_3}}</td>
        <td title="Realisasi  III" style="text-align: center;">{{$cs->r_3}}</td>
        <td title="Realisasi TW IV" style="text-align: center;">{{$cs->tw_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs->r_4}}</td>
        <td title="Capaian" style="text-align: center;">@php 

            if(is_numeric($cs->target_t) || is_float($cs->target_t)){
                $arr = array($cs->tw_1, $cs->tw_2, $cs->tw_3, $cs->tw_4);

                echo round((int)max($arr)/(int)$cs->target_t * 100, 2);
            }
            

    @endphp %</td>
    <td style="text-align: center;">
    	<a href="{{ url('capaian/sasaran/edit', $cs->id) }}" class="btn btn-info btn-xs"> edit</a>
    </td>
    </tr>
    
    @endforeach
    </tbody>
  </table>
</div> --}}


{{-- contoh ke 2 --}}

{{-- <div class="tavle table-responsive">
  <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
    <tr style=" background-color: #007bff;">
        <th rowspan="2" style="vertical-align: middle;">Indikator Sasaran</th>
        <th rowspan="2" style="vertical-align: middle;">Program</th>
        <th rowspan="2" style="text-align: center;vertical-align: middle;">Target</th>
        <th rowspan="2" style="text-align: center;vertical-align: middle;">Pagu</th>
        <th colspan="16" style="text-align: center;vertical-align: middle;">Capaian Kinerja Sasaran</th>
        <th rowspan="2" style="vertical-align: middle; text-align: center;">Aksi</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th style="text-align: center;">TW I</th>
        <th style="text-align: center;">A I</th>
        <th style="text-align: center;">Rkmn I</th>
        <th style="text-align: center;">Real I</th>

        <th style="text-align: center;">TW II</th>
        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Realisasi</th>

        <th style="text-align: center;">TW III</th>
        <th style="text-align: center;">A III</th>
        <th style="text-align: center;">Rkmn III</th>
        <th style="text-align: center;">Real III</th>

        <th style="text-align: center;">TW IV</th>
        <th style="text-align: center;">A IV</th>
        <th style="text-align: center;">Rkmn IV</th>
        <th style="text-align: center;">Real IV</th>
    </tr>
     
    <tbody>
    
        
    @foreach(collect($capaian_sasaran)->unique('indikator_sasaran_id') as $cs)
    <tr >
        <td title="Indikator Sasaran" >{{$cs->indikator_sasaran_nama}}</td>
       
        <td title="program">
    @foreach(collect($capaian_sasaran)->unique('program_no')->where('indikator_sasaran_id', $cs->indikator_sasaran_id) as $cs2)
            - {{$cs2->program_nama}} <br>
    @endforeach
        </td>
        <td title="Target" style="text-align: center;">{{$cs2->target_t}}</td>
        <td title="pagu" style="text-align: center;">{{$cs2->pagu}}</td>
        <td title="TW I" style="text-align: center;">{{$cs2->tw_1}}</td>
        <td title="Anggaran I" style="text-align: center;">{{$cs2->a_1}}</td>
        <td title="Rekomendasi I" style="text-align: center;">{{$cs2->rkmn_1}}</td>
        <td title="Realisasi  I" style="text-align: center;">{{$cs2->real_1}}</td>

        <td title="TW II" style="text-align: center;">{{$cs2->tw_2}}</td>
        <td title="Anggaran  II" style="text-align: center;">{{$cs2->a_2}}</td>
        <td title="Rekomendasi  II" style="text-align: center;">{{$cs2->rkmn_2}}</td>
        <td title="Realisasi  II" style="text-align: center;">{{$cs2->real_2}}</td>

        <td title="TW III" style="text-align: center;">{{$cs2->tw_3}}</td>
        <td title="Anggaran III" style="text-align: center;">{{$cs2->a_3}}</td>
        <td title="Rekomendasi III" style="text-align: center;">{{$cs2->rkmn_3}}</td>
        <td title="Realisasi  III" style="text-align: center;">{{$cs2->real_3}}</td>

        <td title="Realisasi TW IV" style="text-align: center;">{{$cs2->tw_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->a_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->rkmn_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->real_4}}</td> --}}
       {{--  <td title="Capaian" style="text-align: center;">@php 

            // if(is_numeric($cs->target_t) || is_float($cs->target_t)){
                // $arr = array($cs->tw_1, $cs->tw_2, $cs->tw_3, $cs->tw_4);

            //     echo round((int)max($arr)/(int)$cs->target_t * 100, 2);
            // }
            

    @endphp %</td> --}}
    {{-- <td style="text-align: center;">
        <a href="{{ url('capaian/sasaran/edit', $cs->id) }}" class="btn btn-info btn-xs"> edit</a>
    </td>
    </tr>
    
    @endforeach
    </tbody>
  </table>
</div> --}}


{{-- ke 3 --}}

<div class="tavle table-responsive">
  <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
    <tr style=" background-color: #007bff;">
        {{-- <th rowspan="2" style="vertical-align: middle;">No</th> --}}
        <th rowspan="4" style="vertical-align: middle;">Indikator Sasaran</th>
        <th rowspan="4" style="vertical-align: middle;">Formulasi</th>
        <th rowspan="4" style="vertical-align: middle;">Program</th>
        <th rowspan="4" style="text-align: center;vertical-align: middle;"N>Pagu</th>
        {{-- <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th> --}}
        <th colspan="4" style="text-align: center;vertical-align: middle;">Target</th>
        <th colspan="12" style="text-align: center;vertical-align: middle;">Capaian Kinerja</th>
        <th rowspan="4" style="vertical-align: middle; text-align: center;">Aksi</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW I</th>
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW II</th>
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW III</th>
        <th rowspan="3" style="text-align: center;vertical-align: middle;">TW IV</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th colspan="3" style="text-align: center;">Realisasi TW I</th>
        <th colspan="3" style="text-align: center;">Realisasi TW II</th>
        <th colspan="3" style="text-align: center;">Realisasi TW III</th>
        <th colspan="3" style="text-align: center;">Realisasi TW IV</th>
    </tr>
    <tr style=" background-color: #007bff;">
        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>

        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>

        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>

        <th style="text-align: center;">Kinerja</th>
        <th style="text-align: center;">Anggaran</th>
        <th style="text-align: center;">Rekomendasi</th>
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
        <td title="pagu" style="text-align: center;">{{$cs2->pagu}}</td>
        </td>
        {{-- <td title="Satuan" style="text-align: center;">{{$cs->satuan_nama}}</td> --}}
        {{-- @foreach(collect($target)->where('indikator_sasaran_id', $cs->indikator_sasaran_id)->where('tahun', '2017') as $t_2017)
        <td title="Target" style="text-align: center;">{{$t_2017->target}}</td>
        @endforeach

        @foreach(collect($target)->where('indikator_sasaran_id', $cs->indikator_sasaran_id)->where('tahun', '2018') as $t_2018)
        <td title="Target" style="text-align: center;">{{$t_2018->target}}</td>
        @endforeach

        @foreach(collect($target)->where('indikator_sasaran_id', $cs->indikator_sasaran_id)->where('tahun', '2019') as $t_2019)
        <td title="Target" style="text-align: center;">{{$t_2019->target}}</td>
        @endforeach

        @foreach(collect($target)->where('indikator_sasaran_id', $cs->indikator_sasaran_id)->where('tahun', '2020') as $t_2020)
        <td title="Target" style="text-align: center;">{{$t_2020->target}}</td>
        @endforeach

        @foreach(collect($target)->where('indikator_sasaran_id', $cs->indikator_sasaran_id)->where('tahun', '2021') as $t_2021)
        <td title="Target" style="text-align: center;">{{$t_2021->target}}</td>
        @endforeach
 --}}
        <td title="Target" style="text-align: center;">{{$cs2->target1}}</td>
        <td title="Target" style="text-align: center;">{{$cs2->target2}}</td>
        <td title="Target" style="text-align: center;"> {{$cs2->target3}}</td>
         <td title="Target" style="text-align: center;">{{$cs2->target4}}</td>
        {{-- <td title="TW I" style="text-align: center;">{{$cs2->tw_1}}</td> --}}
        <td title="Realisasi  I" style="text-align: center;">{{$cs2->kinerja_1}}</td>
        <td title="Anggaran I" style="text-align: center;">{{$cs2->a_1}}</td>
        <td title="Rekomendasi I" style="text-align: center;">{{$cs2->rkmn_1}}</td>

        {{-- <td title="TW II" style="text-align: center;">{{$cs2->tw_2}}</td> --}}
        <td title="Realisasi  II" style="text-align: center;">{{$cs2->kinerja_2}}</td>
        <td title="Anggaran  II" style="text-align: center;">{{$cs2->a_2}}</td>
        <td title="Rekomendasi  II" style="text-align: center;">{{$cs2->rkmn_2}}</td>

        {{-- <td title="TW III" style="text-align: center;">{{$cs2->tw_3}}</td> --}}
        <td title="Realisasi  III" style="text-align: center;">{{$cs2->kinerja_3}}</td>
        <td title="Anggaran III" style="text-align: center;">{{$cs2->a_3}}</td>
        <td title="Rekomendasi III" style="text-align: center;">{{$cs2->rkmn_3}}</td>

        {{-- <td title="Realisasi TW IV" style="text-align: center;">{{$cs2->tw_4}}</td> --}}
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->kinerja_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->a_4}}</td>
        <td title="Realisasi  IV" style="text-align: center;">{{$cs2->rkmn_4}}</td>
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



