@extends('public.template')

@section('content')
<div class="box box-default" style="padding: 10px;">

        <div class="box-body">
            <h4 style="text-align: center; color: #007bff; font-weight: bold;">Capaian Kinerja Sasaran</h4>
            <h5 style="text-align: center; font-weight: bold;">Kabupaten Kepulauan Meranti</h5>
            <h5 style="text-align: center; color: #007bff; font-weight: bold;">Tahun 2019</h5>
            
        <hr> 
            <div class="tavle table-responsive">
              <table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">
                <tr style=" background-color: #007bff;">
                    <th rowspan="2" style="vertical-align: middle;">No</th>
                    <th rowspan="2" style="vertical-align: middle;">Indikator Sasaran</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th>
                    <th rowspan="2" style="text-align: center;">Target</th>
                    <th colspan="2" style="text-align: center;">Tw I</th>
                    <th colspan="2" style="text-align: center;">Tw II</th>
                    <th colspan="2" style="text-align: center;">Tw III</th>
                    <th colspan="2" style="text-align: center;">Tw IV</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Capaian</th>
    			</tr>
    			<tr style=" background-color: #007bff;">
    				<th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>
                    <th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>
                    <th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>
                    <th style="text-align: center;">T</th>
                    <th style="text-align: center;">R</th>

    	
    			</tr>
                 
                <tbody>
                
        			
                @foreach($indikator_sasaran as $is)
                <tr >
                    <td style="text-align: center;">{{$no++}}</td>
                    <td title="Indikator Sasaran">{{$is->indikator_sasaran}}</td>
                    @foreach($target_sasaran as $ts)
                    @if($is->id==$ts->indikator_sasaran_id)
                    <td title="Satuan" style="text-align: center;">{{$ts->satuan_nama}}</td>
                    <td title="Target" style="text-align: center;">{{$ts->target_t3}}</td>
                    <td title="Target TW I" style="text-align: center;">-</td>
                    <td title="Realisasi TW I" style="text-align: center;">-</td>
                    <td title="Target TW II" style="text-align: center;">-</td>
                    <td title="Realisasi TW II" style="text-align: center;">-</td>
                    <td title="Target TW III" style="text-align: center;">-</td>
                    <td title="Realisasi TW III" style="text-align: center;">-</td>
                    <td title="Target TW IV" style="text-align: center;">-</td>
                    <td title="Realisasi TW IV" style="text-align: center;">-</td>
                    <td title="Capaian" style="text-align: center;">- %</td>
                </tr>
                @endif
                @endforeach
                @endforeach
                </tbody>
              </table>
            </div>
            
        </div>
</div>
        
@stop        

