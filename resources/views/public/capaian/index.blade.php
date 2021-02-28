@extends('public.template')

@section('content')
<div id="preloader">

<div class="card" style="padding: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
    <div class="box-header"> <h3 style="color:#2980b9; font-weight: bold; ">Capaian Kinerja</h3></div>

    <div class="row">
        <div class="col-md-3">
            <form action="{{url('capaian-kinerja/data')}}" method="POST" width="10%">
                @csrf
                <select name="tahun" class="form-control" id="tahun">
                    <option @if($tahun == '2019') selected @endif value="2019">2019</option>
                    <option @if($tahun == '2020') selected @endif value="2020">2020</option>
                </select>
            </form>
        </div>
    </div>
        <div class="card-body">
        <br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="font-size: 12px;">
                    <thead>
                        <tr style=" background-color: #2980b9;color:white;">
                            <th rowspan="4" style="vertical-align: middle;">Organisas Nomor</th>
                            <th rowspan="4" style="vertical-align: middle;">SKPD</th>
                            <th rowspan="4" style="vertical-align: middle;">Capaian Kinerja 2019</th>
                            <th rowspan="4" style="text-align: center;vertical-align: middle;background-color:#95a5a6;">Tidak Ada Target (n/a)</th>
                            <th colspan="5" style="text-align: center;vertical-align: middle;background-color:#ff0404;">Tidak Tercapai (<100%)</th>
                            <th rowspan="4" style="text-align: center;vertical-align: middle;background-color:#006600;">Tercapai (100%)</th>
                            <th rowspan="4" style="text-align: center;vertical-align: middle;background-color:#000266;">Melebihi Target (>100%)</th>
                            <th rowspan="4" style="text-align: center;vertical-align: middle;background-color:#2980b9;">Jumlah Indikator</th>
                        </tr>
                        <tr style=" background-color: #2980b9;color:white;">
                            <th rowspan="3" style="text-align: center;vertical-align: middle;background-color:#ff0404;">00.00 s/d 49.99</th>
                            <th rowspan="3" style="text-align: center;vertical-align: middle;background-color:#ff0404;">50.00 s/d 64.99</th>
                            <th rowspan="3" style="text-align: center;vertical-align: middle;background-color:#ff0404;">65.00 s/d 74.99</th>
                            <th rowspan="3" style="text-align: center;vertical-align: middle;background-color:#ff0404;">75.00 s/d 89.99</th>
                            <th rowspan="3" style="text-align: center;vertical-align: middle;background-color:#ff0404;">90.00 s/d 99.99</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(collect($capaians)->unique('organisasi_no') as $capaian)

                        @php
                            $t_a = collect($capaians)->where('organisasi_no', $capaian->organisasi_no);

                            $t_a_tw1 = $t_a->whereIn('target1', ['0', '', 'NA', null, 'Na'])->count();
                            $t_a_tw2 = $t_a->whereIn('target2', ['0', '', 'NA', null, 'Na'])->count();
                            $t_a_tw3 = $t_a->whereIn('target3', ['0', '', 'NA', null, 'Na'])->count();
                            $t_a_tw4 = $t_a->whereIn('target4', ['0', '', 'NA', null, 'Na'])->count();

                            $t_m1_tw1 = $t_a->whereBetween('calc1', ['00.00', '49.99'])->count();
                            $t_m2_tw1 = $t_a->whereBetween('calc1', ['50.00', '64.99'])->count();
                            $t_m3_tw1 = $t_a->whereBetween('calc1', ['65.00', '74.99'])->count();
                            $t_m4_tw1 = $t_a->whereBetween('calc1', ['75.00', '89.99'])->count();
                            $t_m5_tw1 = $t_a->whereBetween('calc1', ['90.00', '99.99'])->count();

                            $t_m1_tw2 = $t_a->whereBetween('calc2', ['00.00', '49.99'])->count();
                            $t_m2_tw2 = $t_a->whereBetween('calc2', ['50.00', '64.99'])->count();
                            $t_m3_tw2 = $t_a->whereBetween('calc2', ['65.00', '74.99'])->count();
                            $t_m4_tw2 = $t_a->whereBetween('calc2', ['75.00', '89.99'])->count();
                            $t_m5_tw2 = $t_a->whereBetween('calc2', ['90.00', '99.99'])->count();

                            $t_m1_tw3 = $t_a->whereBetween('calc3', ['00.00', '49.99'])->count();
                            $t_m2_tw3 = $t_a->whereBetween('calc3', ['50.00', '64.99'])->count();
                            $t_m3_tw3 = $t_a->whereBetween('calc3', ['65.00', '74.99'])->count();
                            $t_m4_tw3 = $t_a->whereBetween('calc3', ['75.00', '89.99'])->count();
                            $t_m5_tw3 = $t_a->whereBetween('calc3', ['90.00', '99.99'])->count();

                            $t_m1_tw4 = $t_a->whereBetween('calc4', ['00.00', '49.99'])->count();
                            $t_m2_tw4 = $t_a->whereBetween('calc4', ['50.00', '64.99'])->count();
                            $t_m3_tw4 = $t_a->whereBetween('calc4', ['65.00', '74.99'])->count();
                            $t_m4_tw4 = $t_a->whereBetween('calc4', ['75.00', '89.99'])->count();
                            $t_m5_tw4 = $t_a->whereBetween('calc4', ['90.00', '99.99'])->count();

                            $t_h_tw1 = $t_a->where('calc1', '100')->count();
                            $t_h_tw2 = $t_a->where('calc2', '100')->count();
                            $t_h_tw3 = $t_a->where('calc3', '100')->count();
                            $t_h_tw4 = $t_a->where('calc4', '100')->count();

                            $t_b_tw1 = $t_a->where('calc1','>', '100')->count();
                            $t_b_tw2 = $t_a->where('calc2','>', '100')->count();
                            $t_b_tw3 = $t_a->where('calc3','>', '100')->count();
                            $t_b_tw4 = $t_a->where('calc4','>', '100')->count();


                            $t_bm_tw1 = $t_a_tw1 + $t_m1_tw1 + $t_m2_tw1 + $t_m3_tw1 + $t_m4_tw1 + $t_m5_tw1 + $t_h_tw1 + $t_b_tw1;
                            $t_bm_tw2 = $t_a_tw2 + $t_m1_tw2 + $t_m2_tw2 + $t_m3_tw2 + $t_m4_tw2 + $t_m5_tw2 + $t_h_tw2 + $t_b_tw2;
                            $t_bm_tw3 = $t_a_tw3 + $t_m1_tw3 + $t_m2_tw3 + $t_m3_tw3 + $t_m4_tw3 + $t_m5_tw3 + $t_h_tw3 + $t_b_tw3;
                            $t_bm_tw4 = $t_a_tw4 + $t_m1_tw4 + $t_m2_tw4 + $t_m3_tw4 + $t_m4_tw4 + $t_m5_tw4 + $t_h_tw4 + $t_b_tw4; 

                        @endphp

                            @if($capaian->organisasi_no != '')
                        <tr>
                            <td rowspan="6">{{ $capaian->organisasi_no }}</td>
                            <td rowspan="6">{{ $capaian->organisasi_nama }}</td>
                        </tr>
                        <tr id="myTarget">
                            

                            <td style="background-color:#2980b9;color:white;" align="center">tri 1</td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_a_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="tw_1">
                                    <span class="badge badge-secondary">{{ 
                                        $t_a_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" >
                                @if($t_m1_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m1_tw1">
                                    <span class="badge badge-danger">{{
                                        $t_m1_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m2_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m2_tw1">
                                    <span class="badge badge-danger">{{
                                        $t_m2_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m3_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m3_tw1">
                                    <span class="badge badge-danger">{{
                                        $t_m3_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m4_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m4_tw1">
                                    <span class="badge badge-danger">{{
                                        $t_m4_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m5_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m5_tw1">
                                    <span class="badge badge-danger">{{
                                        $t_m5_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_h_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}t_h_tw1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_h_tw1">
                                    <span class="badge badge-success">{{
                                        $t_h_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_b_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}t_b_tw1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_b_tw1">
                                    <span class="badge badge-primary">{{
                                        $t_b_tw1
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_bm_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}t_bm_tw1" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_bm_tw1">
                                    <span class="badge badge-info">{{ 
                                        $t_bm_tw1 
                                    }}</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                        <tr id="myTarget">
                            <td style="background-color:#2980b9;color:white;" align="center">tri 2</td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_a_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="tw_2">
                                    <span class="badge badge-secondary">{{ 
                                        $t_a_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m1_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m1_tw2">
                                    <span class="badge badge-danger">{{
                                        $t_m1_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m2_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m2_tw2">
                                    <span class="badge badge-danger">{{
                                        $t_m2_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m3_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m3_tw2">
                                    <span class="badge badge-danger">{{
                                        $t_m3_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m4_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m4_tw2">
                                    <span class="badge badge-danger">{{
                                        $t_m4_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m5_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m5_tw2">
                                    <span class="badge badge-danger">{{
                                        $t_m5_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_h_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_h_tw2">
                                    <span class="badge badge-success">{{
                                        $t_h_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_b_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_b_tw2">
                                    <span class="badge badge-primary">{{
                                        $t_b_tw2
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_bm_tw2 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_2" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_bm_tw2">
                                    <span class="badge badge-info">{{ 
                                        $t_bm_tw2 
                                    }}</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                        <tr id="myTarget">
                            <td style="background-color:#2980b9;color:white;" align="center">tri 3</td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_a_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="tw_3">
                                    <span class="badge badge-secondary">{{ 
                                        $t_a_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m1_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m1_tw3">
                                    <span class="badge badge-danger">{{
                                        $t_m1_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m2_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m2_tw3">
                                    <span class="badge badge-danger">{{
                                        $t_m2_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m3_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m3_tw3">
                                    <span class="badge badge-danger">{{
                                        $t_m3_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m4_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m4_tw3">
                                    <span class="badge badge-danger">{{
                                        $t_m4_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m5_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m5_tw3">
                                    <span class="badge badge-danger">{{
                                        $t_m5_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_h_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_h_tw3">
                                    <span class="badge badge-success">{{
                                        $t_h_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_b_tw3 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_b_tw3">
                                    <span class="badge badge-primary">{{
                                        $t_b_tw3
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_bm_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_3" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_bm_tw1">
                                    <span class="badge badge-info">{{ 
                                        $t_bm_tw1 
                                    }}</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                        <tr id="myTarget">
                            <td style="background-color:#2980b9;color:white;" align="center">tri 4</td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_a_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="tw_4">
                                    <span class="badge badge-secondary">{{ 
                                        $t_a_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m1_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m1_tw4">
                                    <span class="badge badge-danger">{{
                                        $t_m1_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m2_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m2_tw4">
                                    <span class="badge badge-danger">{{
                                        $t_m2_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m3_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m3_tw4">
                                    <span class="badge badge-danger">{{
                                        $t_m3_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m4_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m4_tw4">
                                    <span class="badge badge-danger">{{
                                        $t_m4_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_m5_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_m5_tw4">
                                    <span class="badge badge-danger">{{
                                        $t_m5_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_h_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_h_tw4">
                                    <span class="badge badge-success">{{
                                        $t_h_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_b_tw4 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_b_tw4">
                                    <span class="badge badge-primary">{{
                                        $t_b_tw4
                                    }}</span>
                                </a>
                                @endif
                            </td>
                            <td style="background-color:#efefef;color:white;" align="center">
                                @if($t_bm_tw1 > 0)
                                <a href="#" id="{{ $capaian->indikator_sasaran_id }}tw_4" url="{{ url('capaian-kinerja/get-modal') }}" data-t="t_bm_tw1">
                                    <span class="badge badge-info">{{ 
                                        $t_bm_tw1 
                                    }}</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#d35400;color:white;font-size:20px;" align="center"><i class="fa fa-flag"></i> F</td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                            <td style="background-color:#95a5a6;color:white;font-size:20px;" align="center"></td>
                        </tr>
                            @endif



                        @endforeach


                    </tbody>
                </table>

                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document" style="width:80%;">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    {{-- <h5 class="modal-title" id="exampleModalLabel">New message</h5> --}}
                                    <p class="modal-title" id="gridSystemModalLabel"></p>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body" id="load-modal">
                                    <div style="text-align: center;">
                                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>


            </div>
        </div>
    </div>
</div>
</div>
                        
@stop    


@push('scripts')
    
    <script type="text/javascript">
        $('#myTarget td a').on('click', function(){
            $('#myModal').modal('show');

            $('#load-modal').html('<div style="text-align: center;"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>');
            $('#gridSystemModalLabel').html('');

            // $('#load-modal').html('');
            // $('#gridSystemModalLabel').html('');

            let getTriwulan = $(this).data('t');
            let indikator_sasaran_id = this.id;
            let tahun = $('#tahun').val();
            console.log(tahun);
            // $("#preloader").loading();


            $.ajax({
              url: $(this).attr('url') + '/' + indikator_sasaran_id + '/triwulan/' + getTriwulan + '/tahun/' + tahun,
              dataType: 'json',
              success: function (res) {
                console.log(res.data);

                // $("#preloader").loading('stop');
                // console.log(res.indikator_sasaran_id);
                $('#load-modal').html(res.output);
                $('#gridSystemModalLabel').html(res.header);

                // $('#my'+res.indikator_sasaran_id).modal('show');
              }
            });
        });

        $('#tahun').on('change', function(){
            $(this).closest('form').submit();
        });
    </script>

@endpush



