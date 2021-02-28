<div class="tavle table-responsive">
        <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
          <tr style=" background-color: #007bff;">
              <th rowspan="2" style="vertical-align: middle;">No</th>
              <th rowspan="2" style="vertical-align: middle;">Indikator Kegaiatan</th>
              <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th>
              <th rowspan="2" style="text-align: center;">Target</th>
              <th colspan="4" style="text-align: center;">Realisasi</th>
              <th rowspan="2" style="vertical-align: middle; text-align: center;">Capaian</th>
              <th rowspan="2" style="vertical-align: middle; text-align: center;">Aksi</th>
          </tr>
          <tr style=" background-color: #007bff;">
              <th style="text-align: center;">TW I</th>
              <th style="text-align: center;">TW II</th>
              <th style="text-align: center;">TW III</th>
              <th style="text-align: center;">TW IV</th>
          </tr>
           
          <tbody>
          
              
          @foreach($capaian_kegiatan as $cs)
          <tr >
              <td style="text-align: center;">{{$no++}}</td>
              <td title="Indikator Sasaran">{{$cs->indikator_kegiatan}}</td>
              {{-- @foreach($target_sasaran as $ts)
              @if($is->id==$ts->indikator_sasaran_id) --}}
              <td title="Satuan" style="text-align: center;">{{$cs->satuan_nama}}</td>
              <td title="Target" style="text-align: center;">{{$cs->target_t}}</td>
              <td title="Realisasi TW I" style="text-align: center;">{{$cs->tw_1}}</td>
              <td title="Realisasi TW II" style="text-align: center;">{{$cs->tw_2}}</td>
              <td title="Realisasi TW III" style="text-align: center;">{{$cs->tw_3}}</td>
              <td title="Realisasi TW IV" style="text-align: center;">{{$cs->tw_4}}</td>
              <td title="Capaian" style="text-align: center;">@php 
                  // if(is_numeric($cs->target_t) || is_float($cs->target_t)){
                      // $arr = array($cs->tw_1, $cs->tw_2, $cs->tw_3, $cs->tw_4);

                      // echo round((int)max($arr)/(int)$cs->target_t * 100, 2);
                  // }

          @endphp %</td>
          <td style="text-align: center;">
              <a href="{{ url('capaian/kegiatan/edit', $cs->renstra_id) }}" class="btn btn-info btn-xs"> edit</a>
          </td>
          </tr>
          {{-- @endif
          @endforeach --}}
          @endforeach
          </tbody>
        </table>
      </div>