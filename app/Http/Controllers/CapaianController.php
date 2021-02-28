<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Organisasi;
use App\Models\visi_misi;
use App\Models\Misi;
use App\Models\TujuanRpjmd as Tujuan;
use App\Models\SasaranRpjmd as Sasaran;
use App\Models\IkuRpjmd as iku;
use App\Models\TujuanRenstra;
use App\Models\SasaranRenstra;
use App\Models\IndikatorTujuanRenstra;
use App\Models\IndikatorSasaranRenstra;
use App\Models\CapaianSasaranOpd;
use App\Models\Satuan;
use App\Models\ProgKegRenstra;
use App\Models\IkuRenstra;
use Illuminate\Http\Request;

class CapaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $capaians = DB::table('indikator_sasaran_renstra as isr')->leftJoin('organisasi as org', 'org.organisasi_no','isr.organisasi_no')
                    ->leftJoin('sasaran_renstra as sr', 'sr.id', 'isr.sasaran_id')
                    ->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
                    ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'isr.id')
                    ->select(
                        // 'prokeg_renstra.renstra_id',
                        'org.organisasi_no',
                        'org.organisasi_nama',
                        // 'sr.id as sasaran_id',
                        // 'sr.sasaran_nama',
                        'isr.id as indikator_sasaran_id',
                        // 's.id as satuan_id',
                        // 's.satuan_nama',
                        'isr.indikator_sasaran as indikator_sasaran_nama',
                        // 'cso.kinerja_1',
                        // 'cso.kinerja_2',
                        // 'cso.kinerja_3',
                        // 'cso.kinerja_4',
                        'cso.target1',
                        'cso.target2',
                        'cso.target3',
                        'cso.target4',
                        'cso.tahun',
                        // 'cso.tw_1',
                        // 'cso.tw_2',
                        // 'cso.tw_3',
                        // 'cso.tw_4',
                        \DB::raw('ROUND((cso.kinerja_1/cso.target1)*100,2) as calc1'),
                        \DB::raw('ROUND((cso.kinerja_2/cso.target2)*100,2) as calc2'),
                        \DB::raw('ROUND((cso.kinerja_3/cso.target3)*100,2) as calc3'),
                        \DB::raw('ROUND((cso.kinerja_4/cso.target4)*100,2) as calc4')
                    )
                    ->where('org.organisasi_no','!=', null)
                    ->where('cso.tahun', '2019')
                    ->orderBy('org.organisasi_no')
                    ->groupBy('cso.indikator_sasaran_id')
                    ->get();


        // $capaians = DB::table('v_capaian')->where('organisasi_no','!=', null)
        //             ->where('tahun', '2019')
        //             ->orderBy('organisasi_no')
        //             ->groupBy('indikator_sasaran_id')
        //             ->get();

        $tahun = '';

        return view('public.capaian.index', compact('capaians', 'tahun'))->render();
    }

    public function data(Request $request)
    {
        // $capaians = ProgKegRenstra::leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'prokeg_renstra.indikator_sasaran_id')
        //             ->leftJoin('organisasi as org', 'org.organisasi_no','prokeg_renstra.organisasi_no')
        //             ->leftJoin('sasaran_renstra as sr', 'sr.id', 'isr.sasaran_id')
        //             ->leftJoin('satuan as s', 's.id', 'prokeg_renstra.satuan_id')
        //             ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'isr.id')
        //             ->select(
        //                 'prokeg_renstra.renstra_id',
        //                 'org.organisasi_no',
        //                 'org.organisasi_nama',
        //                 'sr.id as sasaran_id',
        //                 'sr.sasaran_nama',
        //                 'isr.id as indikator_sasaran_id',
        //                 's.id as satuan_id',
        //                 's.satuan_nama',
        //                 'isr.indikator_sasaran as indikator_sasaran_nama',
        //                 'cso.kinerja_1',
        //                 'cso.kinerja_2',
        //                 'cso.kinerja_3',
        //                 'cso.kinerja_4',
        //                 'cso.target1',
        //                 'cso.target2',
        //                 'cso.target3',
        //                 'cso.target4',
        //                 'cso.tahun',
        //                 'cso.tw_1',
        //                 'cso.tw_2',
        //                 'cso.tw_3',
        //                 'cso.tw_4',
        //                 \DB::raw('ROUND((cso.kinerja_1/cso.target1)*100,2) as calc1'),
        //                 \DB::raw('ROUND((cso.kinerja_2/cso.target2)*100,2) as calc2'),
        //                 \DB::raw('ROUND((cso.kinerja_3/cso.target3)*100,2) as calc3'),
        //                 \DB::raw('ROUND((cso.kinerja_4/cso.target4)*100,2) as calc4')
        //             )
        //             ->where('org.organisasi_no','!=', null)
        //             ->where('cso.tahun', $request->tahun)
        //             ->orderBy('org.organisasi_no')
        //             ->groupBy('cso.indikator_sasaran_id')
        //             ->get();

        $capaians = DB::table('indikator_sasaran_renstra as isr')->leftJoin('organisasi as org', 'org.organisasi_no','isr.organisasi_no')
                    ->leftJoin('sasaran_renstra as sr', 'sr.id', 'isr.sasaran_id')
                    ->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
                    ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'isr.id')
                    ->select(
                        // 'prokeg_renstra.renstra_id',
                        'org.organisasi_no',
                        'org.organisasi_nama',
                        // 'sr.id as sasaran_id',
                        // 'sr.sasaran_nama',
                        'isr.id as indikator_sasaran_id',
                        // 's.id as satuan_id',
                        // 's.satuan_nama',
                        'isr.indikator_sasaran as indikator_sasaran_nama',
                        // 'cso.kinerja_1',
                        // 'cso.kinerja_2',
                        // 'cso.kinerja_3',
                        // 'cso.kinerja_4',
                        'cso.target1',
                        'cso.target2',
                        'cso.target3',
                        'cso.target4',
                        'cso.tahun',
                        // 'cso.tw_1',
                        // 'cso.tw_2',
                        // 'cso.tw_3',
                        // 'cso.tw_4',
                        \DB::raw('ROUND((cso.kinerja_1/cso.target1)*100,2) as calc1'),
                        \DB::raw('ROUND((cso.kinerja_2/cso.target2)*100,2) as calc2'),
                        \DB::raw('ROUND((cso.kinerja_3/cso.target3)*100,2) as calc3'),
                        \DB::raw('ROUND((cso.kinerja_4/cso.target4)*100,2) as calc4')
                    )
                    ->where('org.organisasi_no','!=', null)
                    ->where('cso.tahun', '2019')
                    ->orderBy('org.organisasi_no')
                    ->groupBy('cso.indikator_sasaran_id')
                    ->get();

        $tahun = $request->tahun;

        return view('public.capaian.index', compact('capaians', 'tahun'));
    }


     public function getModal($indikator_sasaran_id, $getTriwulan, $tahun)
    {
       
        $isid = substr($indikator_sasaran_id, 0, 3);

        $org = ProgKegRenstra::join('indikator_sasaran_renstra as isr', 'isr.id', 'prokeg_renstra.indikator_sasaran_id')
                    ->join('organisasi as org', 'org.organisasi_no','prokeg_renstra.organisasi_no')
                    ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'isr.id')
                    ->select(
                        'org.organisasi_no',
                        'org.organisasi_nama',
                        'cso.tahun'
                    )
                    ->where('cso.tahun', $tahun)
                    ->where('isr.id', $isid)
                    ->where('org.organisasi_no','!=', null)
                    ->orderBy('org.organisasi_no')
                    ->groupBy('cso.indikator_sasaran_id')
                    ->first();



        $collect = ProgKegRenstra::join('indikator_sasaran_renstra as isr', 'isr.id', 'prokeg_renstra.indikator_sasaran_id')
                    ->join('organisasi as org', 'org.organisasi_no','prokeg_renstra.organisasi_no')
                    ->join('kegiatan', 'kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                    ->join('sasaran_renstra as sr', 'sr.id', 'isr.sasaran_id')
                    ->join('satuan as s', 's.id', 'prokeg_renstra.satuan_id')
                    ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'isr.id')
                    ->select(
                        'prokeg_renstra.renstra_id',
                        'prokeg_renstra.pagu_t3',
                        'prokeg_renstra.pagu_t4',
                        'kegiatan.kegiatan_nama',
                        'org.organisasi_no',
                        'org.organisasi_nama',
                        'sr.id as sasaran_id',
                        'sr.sasaran_nama',
                        'isr.id as indikator_sasaran_id',
                        's.id as satuan_id',
                        's.satuan_nama',
                        'isr.indikator_sasaran as indikator_sasaran_nama',
                        'cso.kinerja_1',
                        'cso.kinerja_2',
                        'cso.kinerja_3',
                        'cso.kinerja_4',
                        'cso.target1',
                        'cso.target2',
                        'cso.target3',
                        'cso.target4',
                        'cso.tw_1',
                        'cso.tahun',
                        \DB::raw('ROUND((cso.kinerja_1/cso.target1)*100,2) as calc1'),
                        \DB::raw('ROUND((cso.kinerja_2/cso.target2)*100,2) as calc2'),
                        \DB::raw('ROUND((cso.kinerja_3/cso.target3)*100,2) as calc3'),
                        \DB::raw('ROUND((cso.kinerja_4/cso.target4)*100,2) as calc4'),
                        \DB::raw('ROUND((prokeg_renstra.pagu_t3/prokeg_renstra.pagu_t3)*100,2) as persen_t3'),
                        \DB::raw('ROUND((prokeg_renstra.pagu_t4/prokeg_renstra.pagu_t4)*100,2) as persen_t4')
                    )
                    ->where('cso.tahun', $tahun)
                    ->where('org.organisasi_no','!=', null)
                    // ->where('org.organisasi_no', $org->organisasi_no)
                    ->groupBy('cso.indikator_sasaran_id')
                    ->groupBy('sr.id')
                    ->get();

        // $collect = DB::table('v_capaian')
        //                 ->select(
        //                     'pagu_t3',
        //                     'pagu_t4',
        //                     'kegiatan_nama',
        //                     'organisasi_no',
        //                     'organisasi_nama',
        //                     'sasaran_id',
        //                     'sasaran_nama',
        //                     'indikator_sasaran_id',
        //                     'satuan_id',
        //                     'satuan_nama',
        //                     'indikator_sasaran_nama',
        //                     'kinerja_1',
        //                     'kinerja_2',
        //                     'kinerja_3',
        //                     'kinerja_4',
        //                     'target1',
        //                     'target2',
        //                     'target3',
        //                     'target4',
        //                     'tahun',
        //                     \DB::raw('ROUND((kinerja_1/target1)*100,2) as calc1'),
        //                     \DB::raw('ROUND((kinerja_2/target2)*100,2) as calc2'),
        //                     \DB::raw('ROUND((kinerja_3/target3)*100,2) as calc3'),
        //                     \DB::raw('ROUND((kinerja_4/target4)*100,2) as calc4'),
        //                     \DB::raw('ROUND((pagu_t3/pagu_t3)*100,2) as persen_t3'),
        //                     \DB::raw('ROUND((pagu_t4/pagu_t4)*100,2) as persen_t4')
        //                 )
        //                 ->where('tahun', $tahun)
        //                 ->where('organisasi_no','!=', null)
        //                 // ->where('org.organisasi_no', $org->organisasi_no)
        //                 ->groupBy('indikator_sasaran_id')
        //                 ->groupBy('sasaran_id')
        //                 ->get();



        // total indikator
        if($getTriwulan == 't_bm_tw1')
        {
                $capaian = $collect->groupBy('indikator_sasaran_id')
                    ->where('organisasi_no', $org->organisasi_no)
                    ->whereNotIn('target1',['0', '', 'n/a'])
                    ->groupBy('sasaran_id')
                    ->get();
                // $capaian = collect($collect)>where('calc1', '>','100');

        }elseif($getTriwulan == 't_bm_tw2')
        {
            $capaian = $collect->groupBy('indikator_sasaran_id')
                    ->where('organisasi_no', $org->organisasi_no)
                    ->whereNotIn('target2',['0', '', 'n/a'])
                    ->groupBy('sasaran_id')
                    ->get();
        }elseif($getTriwulan == 't_bm_tw3')
        {
            $capaian = $collect->groupBy('indikator_sasaran_id')
                    ->where('organisasi_no', $org->organisasi_no)
                    ->whereNotIn('target3',['0', '', 'n/a'])
                    ->groupBy('sasaran_id')
                    ->get();
        }elseif($getTriwulan == 't_bm_tw4')
        {
            $capaian = $collect->groupBy('indikator_sasaran_id')
                    ->where('organisasi_no', $org->organisasi_no)
                    ->whereNotIn('target4',['0', '', 'n/a'])
                    ->groupBy('sasaran_id')
                    ->get();
        }
        

        $output = '';
        $warna = '';
        $header = 'Capaian Kinerja Utama <strong>'.$org->organisasi_nama.'</strong> Tahun '.$tahun.' Triwulan';
        $kondisi = ['0', '', 'n/a', null, 'NA', 'Na'];
        $kondisi1 = ['00.00', '49.99'];
        $kondisi2 = ['50.00', '64.99'];
        $kondisi3 = ['65.00', '74.99'];
        $kondisi4 = ['75.00', '89.99'];
        $kondisi5 = ['90.00', '99.99'];


    

                            if(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 'tw_1')
                            {
                                $header .= ' 1 Kategori <strong>Tidak Ada Target (n/a)</strong>';
                                $warna = 'style="background-color:#95a5a6;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereIn('target1', $kondisi);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 'tw_2')
                            {
                                $header .= ' 2 Kategori <strong>Tidak Ada Target (n/a)</strong>';
                                $warna = 'style="background-color:#95a5a6;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereIn('target2', $kondisi);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 'tw_3')
                            {
                                $header .= ' 3 Kategori <strong>Tidak Ada Target (n/a)</strong>';
                                $warna = 'style="background-color:#95a5a6;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereIn('target3', $kondisi);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 'tw_4')
                            {
                                $header .= ' 4 Kategori <strong>Tidak Ada Target (n/a)</strong>';
                                $warna = 'style="background-color:#95a5a6;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereIn('target4', $kondisi);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_m1_tw1')
                            {
                                $header .= ' 1 Kategori <strong>00.00 s/d 49.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc1', $kondisi1);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_m1_tw2')
                            {
                                $header .= ' 2 Kategori <strong>00.00 s/d 49.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc2', $kondisi1);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_m1_tw3')
                            {
                                $header .= ' 3 Kategori <strong>00.00 s/d 49.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc3', $kondisi1);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_m1_tw4')
                            {
                                $header .= ' 4 Kategori <strong>00.00 s/d 49.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc4', $kondisi1);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_m2_tw1')
                            {
                                $header .= ' 1 Kategori <strong>50.00 s/d 64.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc1', $kondisi2);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_m2_tw2')
                            {
                                $header .= ' 2 Kategori <strong>50.00 s/d 64.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc2', $kondisi2);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_m2_tw3')
                            {
                                $header .= ' 3 Kategori <strong>50.00 s/d 64.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc3', $kondisi2);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_m2_tw4')
                            {
                                $header .= ' 4 Kategori <strong>50.00 s/d 64.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc4', $kondisi2);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_m3_tw1')
                            {
                                $header .= ' 1 Kategori <strong>65.00 s/d 74.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc1', $kondisi3);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_m3_tw2')
                            {
                                $header .= ' 2 Kategori <strong>65.00 s/d 74.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc2', $kondisi3);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_m3_tw3')
                            {
                                $header .= ' 3 Kategori <strong>65.00 s/d 74.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc3', $kondisi3);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_m3_tw4')
                            {
                                $header .= ' 4 Kategori <strong>65.00 s/d 74.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc4', $kondisi3);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_m4_tw1')
                            {
                                $header .= ' 1 Kategori <strong>75.00 s/d 89.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc1', $kondisi4);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_m4_tw2')
                            {
                                $header .= ' 2 Kategori <strong>75.00 s/d 89.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc2', $kondisi4);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_m4_tw3')
                            {
                                $header .= ' 3 Kategori <strong>75.00 s/d 89.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc3', $kondisi4);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_m4_tw4')
                            {
                                $header .= ' 4 Kategori <strong>75.00 s/d 89.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc4', $kondisi4);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_m5_tw1')
                            {
                                $header .= ' 1 Kategori <strong>90.00 s/d 99.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc1', $kondisi5);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_m5_tw2')
                            {
                                $header .= ' 2 Kategori <strong>90.00 s/d 99.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc2', $kondisi5);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_m5_tw3')
                            {
                                $header .= ' 3 Kategori <strong>90.00 s/d 99.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc3', $kondisi5);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_m5_tw4')
                            {
                                $header .= ' 4 Kategori <strong>90.00 s/d 99.99</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->whereBetween('calc4', $kondisi5);

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_h_tw1')
                            {
                                $header .= ' 1 Kategori <strong>Tercapai (100%)</strong>';
                                $warna = 'style="background-color:#ff0404;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc1', '100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_h_tw2')
                            {
                                $header .= ' 2 Kategori <strong>Tercapai (100%)</strong>';
                                $warna = 'style="background-color:#006600;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc2', '100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_h_tw3')
                            {
                                $header .= ' 3 Kategori <strong>Tercapai (100%)</strong>';
                                $warna = 'style="background-color:#006600;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc3', '100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_h_tw4')
                            {
                                $header .= ' 4 Kategori <strong>Tercapai (100%)</strong>';
                                $warna = 'style="background-color:#006600;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc4', '100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_b_tw1')
                            {
                                $header .= ' 1 Kategori <strong>Melebihi Target (>100%)</strong>';
                                $warna = 'style="background-color:#006600;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc1', '>','100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_b_tw2')
                            {
                                $header .= ' 2 Kategori <strong>Melebihi Target (>100%)</strong>';
                                $warna = 'style="background-color:#000266;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc2', '>','100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_b_tw3')
                            {
                                $header .= ' 3 Kategori <strong>Melebihi Target (>100%)</strong>';
                                $warna = 'style="background-color:#000266;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc3', '>','100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_b_tw4')
                            {
                                $header .= ' 4 Kategori <strong>Melebihi Target (>100%)</strong>';
                                $warna = 'style="background-color:#000266;color:white;"';
                                $capaian = collect($collect)->where('organisasi_no', $org->organisasi_no)->where('calc4', '>','100');

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_1' && $getTriwulan == 't_bm_tw1')
                            {
                                $header .= ' 1 Kategori <strong>Semua</strong>';
                                $warna = 'style="background-color:#2980b9;color:white;"';

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_2' && $getTriwulan == 't_bm_tw2')
                            {
                                $header .= ' 2 Kategori <strong>Semua</strong>';
                                $warna = 'style="background-color:#2980b9;color:white;"';

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_3' && $getTriwulan == 't_bm_tw3')
                            {
                                $header .= ' 3 Kategori <strong>Semua</strong>';
                                $warna = 'style="background-color:#2980b9;color:white;"';

                            }elseif(substr($indikator_sasaran_id, -4) == 'tw_4' && $getTriwulan == 't_bm_tw4')
                            {
                                $header .= ' 4 Kategori <strong>Semua</strong>';
                                $warna = 'style="background-color:#2980b9;color:white;"';

                            }
                    //     $output .= '</div>
                    // <div class="modal-body">';
                        
                        // if tw 4
                        if($getTriwulan == 'tw_4' 
                            || $getTriwulan == 't_m1_tw4' 
                            || $getTriwulan == 't_m2_tw4' 
                            || $getTriwulan == 't_m3_tw4' 
                            || $getTriwulan == 't_m4_tw4' 
                            || $getTriwulan == 't_m5_tw4' 
                            || $getTriwulan == 't_h_tw4' 
                            || $getTriwulan == 't_b_tw4' 
                            || $getTriwulan == 't_bm_tw4'){

                        $output .= '<h5>Tingkat Efektifitas dan Efisiensi Kinerja Sasaran Tersusunnya Dokumen Perencanaan yang Aspiratif
                                        <strong>'.$org->organisasi_nama.'</strong> Kabupaten Kepulauan Meranti </h5>';

                        $output .= '
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" style=" background-color: #2980b9;color:white;">No</th>
                                    <th rowspan="2" style=" background-color: #2980b9;color:white;">Sasaran</th>
                                    <th rowspan="2" style=" background-color: #2980b9;color:white;">Indikator</th>
                                    <th rowspan="2" style=" background-color: #2980b9;color:white;">Satuan</th>
                                    <th colspan="3" style=" background-color: #006600;color:white;" align="center">Kinerja</th>
                                    <th colspan="4" style=" background-color: #006600;color:white;" align="center">Keuangan</th>
                                </tr>
                                <tr style=" background-color: #006600;color:white;">
                                    <th>Target</th>
                                    <th>Realisasi</th>
                                    <th>(%)</th>
                                    <th>Program Kegiatan</th>
                                    <th>Pagu DPA</th>
                                    <th>Realisasi</th>
                                    <th>(%)</th>
                                </tr>
                            </thead>
                            <tbody>';
                                $no = 1;
                                $rata2 = [];
                                $dpa = [];
                                $real = [];
                                $persen = [];

                                foreach (collect($capaian)->unique('sasaran_id') as $data) {

                                $rows = collect($capaian)->where('sasaran_id', $data->sasaran_id)->count();

                                $i = 1;

                                // foreach(collect($capaian)->unique('sasaran_id')->where('sasaran_id', $data->sasaran_id) as $data2){
                                foreach(collect($capaian)->unique('indikator_sasaran_id')->where('sasaran_id', $data->sasaran_id) as $data2){
                                  if($i == 1){
                                $output .= '<tr>
                                    <td rowspan="'.$rows.'">'.$no++.'</td>
                                    <td rowspan="'.$rows.'">'.$data->sasaran_nama.'</td>';
                                $output .= '<td>'.$data2->indikator_sasaran_nama.'</td>
                                        <td rowspan="'.$rows.'">'.$data2->satuan_nama.'</td>';
                                    if($getTriwulan == 'tw_1' ||
                                        $getTriwulan == 't_m1_tw1' || 
                                        $getTriwulan == 't_m2_tw1' || 
                                        $getTriwulan == 't_m3_tw1' || 
                                        $getTriwulan == 't_m4_tw1' || 
                                        $getTriwulan == 't_m5_tw1' || 
                                        $getTriwulan == 't_h_tw1' || 
                                        $getTriwulan == 't_b_tw1' || 
                                        $getTriwulan == 't_bm_tw1'){

                                        $rata2[] .= $data2->calc1;

                                        $output .= '<td rowspan="'.$rows.'">'.$data2->target1.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_1.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc1.'</td>';

                                    }elseif($getTriwulan == 'tw_2' 
                                        || $getTriwulan == 't_m1_tw2' 
                                        || $getTriwulan == 't_m2_tw2' 
                                        || $getTriwulan == 't_m3_tw2' 
                                        || $getTriwulan == 't_m4_tw2' 
                                        || $getTriwulan == 't_m5_tw2' 
                                        || $getTriwulan == 't_h_tw2' 
                                        || $getTriwulan == 't_b_tw2' 
                                        || $getTriwulan == 't_bm_tw2'){

                                        $rata2[] .= $data2->calc2;

                                        $output .= '<td rowspan="'.$rows.'">'.$data2->target2.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_2.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc2.'</td>';

                                    }elseif($getTriwulan == 'tw_3' 
                                        || $getTriwulan == 't_m1_tw3' 
                                        || $getTriwulan == 't_m2_tw3' 
                                        || $getTriwulan == 't_m3_tw3' 
                                        || $getTriwulan == 't_m4_tw3' 
                                        || $getTriwulan == 't_m5_tw3' 
                                        || $getTriwulan == 't_h_tw3' 
                                        || $getTriwulan == 't_b_tw3' 
                                        || $getTriwulan == 't_bm_tw3'){


                                        $rata2[] .= $data2->calc3;

                                        $output .= '<td rowspan="'.$rows.'">'.$data2->target3.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_3.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc3.'</td>';

                                    }elseif($getTriwulan == 'tw_4' 
                                        || $getTriwulan == 't_m1_tw4' 
                                        || $getTriwulan == 't_m2_tw4' 
                                        || $getTriwulan == 't_m3_tw4' 
                                        || $getTriwulan == 't_m4_tw4' 
                                        || $getTriwulan == 't_m5_tw4' 
                                        || $getTriwulan == 't_h_tw4' 
                                        || $getTriwulan == 't_b_tw4' 
                                        || $getTriwulan == 't_bm_tw4'){

                                        $rata2[] .= $data2->calc4;

                                        $output .= '<td rowspan="'.$rows.'">'.$data2->target4.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_4.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc4.'</td>';
                                    }

                                    $dpa[] .= $data2->pagu_t3;
                                    $real[] .= $data2->pagu_t3;
                                    $persen[] .= $data2->persen_t3;


                                    $output .= '<td rowspan="'.$rows.'">'.$data2->kegiatan_nama.'</td>';
                                       if($tahun == '2019'){
                                            $output .= '<td rowspan="'.$rows.'">'.$data2->pagu_t3.'</td>';
                                            $output .= '<td rowspan="'.$rows.'">'.$data2->pagu_t3.'</td>';
                                            $output .= '<td rowspan="'.$rows.'">'.$data2->persen_t3.'</td>';
                                        }else{
                                            $output .= '<td rowspan="'.$rows.'">'.$data2->pagu_t4.'</td>';
                                            $output .= '<td rowspan="'.$rows.'">'.$data2->pagu_t4.'</td>';
                                            $output .= '<td rowspan="'.$rows.'">'.$data2->persen_t4.'</td>';
                                        }
                                        $output .= '</tr>';
                                    
                                  }else{
                                    $output .= '<tr><td>'.$data2->indikator_sasaran_nama.'</td></tr>';
                                  }

                                  $i++;

                                }


                              

                                }

                                 $min = collect($rata2)->sum() - collect($persen)->sum();
                                 $bagi = (collect($rata2)->sum() + collect($persen)->sum()) / 100;


                            $output .= '<tr><td></td><td></td><td colspan="4" align="center"><strong>RATA-RATA CAPAIAN DARI INDIKATOR</strong></td><td align="center"><strong>'.collect($rata2)->sum().'</strong></td><td><strong>TOTAL PER SASARAN</strong></td><td><strong>'.number_format(collect($dpa)->sum()).'</strong></td><td><strong>'.number_format(collect($real)->sum()).'</strong></td><td><strong>'.collect($persen)->sum().'</strong></td></tr><tr><td></td><td></td><td colspan="10" align="center"><strong>TINGKAT EFISIENSI '.$min.'
%</strong></td></tr><tr><td></td><td></td><td colspan="10" align="center"><strong>TINGKAT EFEKTIFITAS '.$bagi.'
%</strong></td></tr></tbody>
                        </table>';

                            }// end if tw 4
                            else{
                                $output .= '<div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style=" background-color: #2980b9;color:white;">No</th>
                                                        <th rowspan="2" style=" background-color: #2980b9;color:white;">Sasaran</th>
                                                        <th rowspan="2" style=" background-color: #2980b9;color:white;">Indikator</th>
                                                        <th rowspan="2" style=" background-color: #2980b9;color:white;">Satuan</th>
                                                        <th colspan="4" style=" background-color: #006600;color:white;" align="center">Kinerja</th>
                                                    </tr>
                                                    <tr style=" background-color: #006600;color:white;">
                                                        <th>Target</th>
                                                        <th>Realisasi</th>
                                                        <th>(%)</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    $no = 1;
                                                    foreach (collect($capaian)->unique('sasaran_id') as $data) {

                                                    $rows = collect($capaian)->where('sasaran_id', $data->sasaran_id)->count();

                                                    $i = 1;

                                                    // foreach(collect($capaian)->unique('sasaran_id')->where('sasaran_id', $data->sasaran_id) as $data2){
                                                    foreach(collect($capaian)->unique('indikator_sasaran_id')->where('sasaran_id', $data->sasaran_id) as $data2){
                                                      if($i == 1){
                                                    $output .= '<tr>
                                                        <td rowspan="'.$rows.'">'.$no++.'</td>
                                                        <td rowspan="'.$rows.'">'.$data->sasaran_nama.'</td>';
                                                    $output .= '<td>'.$data2->indikator_sasaran_nama.'</td>
                                                            <td rowspan="'.$rows.'">'.$data2->satuan_nama.'</td>';
                                                        if($getTriwulan == 'tw_1' ||
                                                            $getTriwulan == 't_m1_tw1' || 
                                                            $getTriwulan == 't_m2_tw1' || 
                                                            $getTriwulan == 't_m3_tw1' || 
                                                            $getTriwulan == 't_m4_tw1' || 
                                                            $getTriwulan == 't_m5_tw1' || 
                                                            $getTriwulan == 't_h_tw1' || 
                                                            $getTriwulan == 't_b_tw1' || 
                                                            $getTriwulan == 't_bm_tw1'){

                                                            $output .= '<td rowspan="'.$rows.'">'.$data2->target1.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_1.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc1.'</td>';

                                                        }elseif($getTriwulan == 'tw_2' 
                                                            || $getTriwulan == 't_m1_tw2' 
                                                            || $getTriwulan == 't_m2_tw2' 
                                                            || $getTriwulan == 't_m3_tw2' 
                                                            || $getTriwulan == 't_m4_tw2' 
                                                            || $getTriwulan == 't_m5_tw2' 
                                                            || $getTriwulan == 't_h_tw2' 
                                                            || $getTriwulan == 't_b_tw2' 
                                                            || $getTriwulan == 't_bm_tw2'){

                                                            $output .= '<td rowspan="'.$rows.'">'.$data2->target2.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_2.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc2.'</td>';

                                                        }elseif($getTriwulan == 'tw_3' 
                                                            || $getTriwulan == 't_m1_tw3' 
                                                            || $getTriwulan == 't_m2_tw3' 
                                                            || $getTriwulan == 't_m3_tw3' 
                                                            || $getTriwulan == 't_m4_tw3' 
                                                            || $getTriwulan == 't_m5_tw3' 
                                                            || $getTriwulan == 't_h_tw3' 
                                                            || $getTriwulan == 't_b_tw3' 
                                                            || $getTriwulan == 't_bm_tw3'){

                                                            $output .= '<td rowspan="'.$rows.'">'.$data2->target3.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_3.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc3.'</td>';

                                                        }elseif($getTriwulan == 'tw_4' 
                                                            || $getTriwulan == 't_m1_tw4' 
                                                            || $getTriwulan == 't_m2_tw4' 
                                                            || $getTriwulan == 't_m3_tw4' 
                                                            || $getTriwulan == 't_m4_tw4' 
                                                            || $getTriwulan == 't_m5_tw4' 
                                                            || $getTriwulan == 't_h_tw4' 
                                                            || $getTriwulan == 't_b_tw4' 
                                                            || $getTriwulan == 't_bm_tw4'){

                                                            $output .= '<td rowspan="'.$rows.'">'.$data2->target4.'</td><td rowspan="'.$rows.'">'.$data2->kinerja_4.'</td><td rowspan="'.$rows.'" '.$warna.'>'.$data2->calc4.'</td>';
                                                        }


                                                        $output .= '<td rowspan="'.$rows.'">-</td>
                                                    </tr>';
                                                      }else{
                                                        $output .= '<tr><td>'.$data2->indikator_sasaran_nama.'</td></tr>';
                                                      }

                                                      $i++;

                                                    }


                                                  

                                                    }

                                                $output .= '</tbody>
                                            </table><br>';
                            }

                        $output .= '<h4>Keterangan</h4>
                        <Table width="30%" border="1" style="border-collapse: collapse;">
                            <tr align="center">
                                <td>Warna</td>
                                <td>Prosentase</td>
                                <td>Keterangan</td>
                            </tr>
                            <tr align="center">
                                <td style=" background-color: #95a5a6;"></td>
                                <td>n/a</td>
                                <td>Tidak Ada Target</td>
                            </tr>
                            <tr align="center">
                                <td style=" background-color: #ff0404;"></td>
                                <td>< 100%</td>
                                <td>Tidak Tercapai</td>
                            </tr>
                            <tr align="center">
                                <td style=" background-color: #006600;"></td>
                                <td>= 100%</td>
                                <td>Tercapai</td>
                            </tr>
                             <tr align="center">
                                <td style=" background-color: #000266;"></td>
                                <td>> 100%</td>
                                <td>Melebihi Target</td>
                            </tr>
                        </table>';

        return response()->json(['output'=> $output, 'indikator_sasaran_id' => $indikator_sasaran_id, 'getTriwulan' => $getTriwulan, 'data'=>$capaian, 'organisasi_nama' => $org->organisasi_nama, 'tahun' => $tahun, 'header' => $header]);




    }

    public function isRpjmd()
    {
        $visi=visi_misi::where('tipe','visi')->get();
        $misi=visi_misi::where('tipe','misi')->get();
        // $tujuan=Tujuan::join('visi_misi as vm','vm.nomor','=','tujuan_rpjmd.misi_no')->get();
        $periode = Tujuan::join('misi','misi.id','=','tujuan_rpjmd.misi_id')
                ->groupBy('misi.periode')->get();


        $tujuan = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                ->groupBy('sasaran_rpjmd.tujuan_id')
                ->select('tujuan_rpjmd.id','tujuan_rpjmd.tujuan_no','tujuan_rpjmd.tujuan_nama')
                ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $tujuan;

        $sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                ->groupBy('sasaran_rpjmd.id')
                ->select('sasaran_rpjmd.id','sasaran_rpjmd.tujuan_id','sasaran_rpjmd.sasaran_nama')
                // ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $sasaran;

        $indikator_sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                // ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                // ->groupBy('sasaran_rpjmd.id')
                ->select('indikator_sasaran_rpjmd.id','indikator_sasaran_rpjmd.sasaran_id','indikator_sasaran_rpjmd.indikator_sasaran')
                // ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $indikator_sasaran;
        
        $target_sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                ->get();
        // return $target_sasaran;
        $cari_program = DB::table('tp_program_rpjmd')->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                        ->where('program.program_nama', 'LIKE', '%cari%')->get();
                        // return $cari_program;
        $indikator_sasaran_rpjmd = DB::table('tp_program_rpjmd')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
                            ->select('indikator_sasaran_rpjmd.id as is_id','indikator_sasaran_rpjmd.indikator_sasaran')
                            ->groupBy('is_id')
                            ->get();
                            // return $indikator_sasaran;
        //                     
        //                     
        $program = DB::table('tp_program_rpjmd')
                            ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
                            ->select('indikator_sasaran_rpjmd.id as is_id','program.program_no','program.program_nama')
                            ->groupBy('program_no')
                            ->orderBy('program.program_no')
                            ->get();
                            // return $program;


        $indikator_program = DB::table('tp_program_rpjmd')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->select('tp_program_rpjmd.tp_program_id as tp_id','tp_program_rpjmd.program_no','program_rpjmd.indikator_program')
                            // ->orderBy('program_id')
                            ->groupBy('program_no')
                            ->get();
                            // return $indikator_program;
        $target_program =   DB::table('tp_program_rpjmd')
                            // ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('satuan','satuan.id','=','tp_program_rpjmd.satuan_id')
                            ->groupBy('tp_program_rpjmd.program_no')
                            ->get();
                            // return $target_program;
        return view('public.capaian.indikator_sasaran',compact('visi','misi','tujuan','sasaran','periode','indikator_sasaran','target_sasaran','indikator_sasaran_rpjmd','program','indikator_program','target_program'))->with('no',1);
    }

     public function ipRpjmd()
    {
        
        $program = DB::table('tp_program_rpjmd')
                            ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
                            ->select('indikator_sasaran_rpjmd.id as is_id','program.program_no','program.program_nama')
                            ->groupBy('program_no')
                            ->orderBy('program.program_no')
                            ->get();
                            // return $program;


        $indikator_program = DB::table('tp_program_rpjmd')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->select('tp_program_rpjmd.tp_program_id as tp_id','tp_program_rpjmd.program_no','program_rpjmd.indikator_program')
                            // ->orderBy('program_id')
                            ->groupBy('program_no')
                            ->get();
                            // return $indikator_program;
        $target_program =   DB::table('tp_program_rpjmd')
                            // ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('satuan','satuan.id','=','tp_program_rpjmd.satuan_id')
                            ->groupBy('tp_program_rpjmd.program_no')
                            ->get();
                            // return $target_program;

        return view('public.capaian.indikator_program',compact('indikator_program','target_program'))->with('no',1);
    }

    public function pkKab()
    {
       $cari_program = DB::table('tp_program_rpjmd')->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                        ->where('program.program_nama', 'LIKE', '%cari%')->get();
                        // return $cari_program;
        $indikator_sasaran_rpjmd = DB::table('tp_program_rpjmd')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
                            ->select('indikator_sasaran_rpjmd.id as is_id','indikator_sasaran_rpjmd.indikator_sasaran')
                            ->groupBy('is_id')
                            ->get();
                            // return $indikator_sasaran_rpjmd;
        //                     
        //                     
        $program = DB::table('tp_program_rpjmd')
                            ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
                            ->select('indikator_sasaran_rpjmd.id as is_id','program.program_no','program.program_nama')
                            ->groupBy('program_no')
                            ->orderBy('program.program_no')
                            ->get();
                            // return $program; 

        $indikator_program = DB::table('tp_program_rpjmd')
                            ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
                            ->select('tp_program_rpjmd.tp_program_id as tp_id','tp_program_rpjmd.program_no','program_rpjmd.indikator_program')
                            // ->orderBy('program_id')
                            ->groupBy('program_no')
                            ->get();
                            // return $indikator_program;
        $target_program =   DB::table('tp_program_rpjmd')
                            // ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('satuan','satuan.id','=','tp_program_rpjmd.satuan_id')
                            ->groupBy('tp_program_rpjmd.program_no')
                            ->get();


        

         return view('public.capaian.indikator_program', compact('indikator_sasaran_rpjmd','program','periode','indikator_program','target_program'))->with('no',1);
    }

    public function rkt(){
        $tujuan = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                ->groupBy('sasaran_rpjmd.tujuan_id')
                ->select('tujuan_rpjmd.id','tujuan_rpjmd.tujuan_no','tujuan_rpjmd.tujuan_nama')
                ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $tujuan;

        $sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                ->groupBy('sasaran_rpjmd.id')
                ->select('sasaran_rpjmd.id','sasaran_rpjmd.tujuan_id','sasaran_rpjmd.sasaran_nama')
                // ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $sasaran;

        $indikator_sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                // ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                // ->groupBy('sasaran_rpjmd.id')
                ->select('indikator_sasaran_rpjmd.id','indikator_sasaran_rpjmd.sasaran_id','indikator_sasaran_rpjmd.indikator_sasaran')
                // ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $indikator_sasaran;
        
        $target_rkt = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                // ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t3 as target')
                ->get();
                $label='2019';
        // return $target_rkt;

        return view('public.capaian.rkt',compact('label','target_rkt','tujuan','sasaran','periode','indikator_sasaran'))->with('no',1);
    }

    public function dataRkt(Request $request)
    {
        

        if ($request->tahun=='target_t1'){
            $tahun = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                // ->where('tp_is_rpjmd.target_t1','=','target_t1')
                ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t1 as target')
                ->get();
                $label='2017';
                // return $tahun;

            }else if($request->tahun=='target_t2'){
            $tahun = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                // ->where('tp_is_rpjmd.target_t1','=','target_t1')
                ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t2 as target')
                ->get();
                $label='2018';
                // return $tahun;
            }else if($request->tahun=='target_t3'){
            $tahun = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                // ->where('tp_is_rpjmd.target_t1','=','target_t1')
                ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t3 as target')
                ->get();
                $label='2019';

            }else if($request->tahun=='target_t4'){
            $tahun = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                // ->where('tp_is_rpjmd.target_t1','=','target_t1')
                ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t4 as target')
                ->get();
                $label='2020';

            }else if($request->tahun=='target_t5'){
            $tahun = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                // ->where('tp_is_rpjmd.target_t1','=','target_t1')
                ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t5 as target')
                ->get();
                $label='2021';
            }
        
        $tujuan = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                ->groupBy('sasaran_rpjmd.tujuan_id')
                ->select('tujuan_rpjmd.id','tujuan_rpjmd.tujuan_no','tujuan_rpjmd.tujuan_nama')
                ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $tujuan;

        $sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                ->groupBy('sasaran_rpjmd.id')
                ->select('sasaran_rpjmd.id','sasaran_rpjmd.tujuan_id','sasaran_rpjmd.sasaran_nama')
                // ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $sasaran;

        $indikator_sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                // ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                // ->groupBy('sasaran_rpjmd.id')
                ->select('indikator_sasaran_rpjmd.id','indikator_sasaran_rpjmd.sasaran_id','indikator_sasaran_rpjmd.indikator_sasaran')
                // ->orderBy('tujuan_rpjmd.tujuan_no')
                ->get();
        // return $indikator_sasaran;
        
        $target_sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                ->get();
        // return $target_sasaran;

        return view('public.capaian.rkt',compact('label','tahun','tujuan','sasaran','periode','indikator_sasaran','target_sasaran'))->with('no',1);
    }

    public function ikuRpjmd ()
    {
        $periode = Tujuan::join('visi_misi','visi_misi.nomor','=','tujuan_rpjmd.misi_no')
                ->groupBy('visi_misi.periode')->get();

        $sasaran = Sasaran::get();
        // return $sasaran;

        $indikator_sasaran = iku::join('indikator_sasaran_rpjmd as iks','iks.id','=','iku_rpjmd.indikator_sasaran_id')
                ->join('tp_is_rpjmd as t','t.indikator_sasaran_id','=','iks.id')
                ->leftJoin('sasaran_rpjmd as sasaran','sasaran.id','=','iks.sasaran_id')
                ->leftJoin('satuan as s','s.id','=','t.satuan_id')
                // ->select('iks.id','iks.indikator_sasaran','s.satuan_nama')
                ->get();
        // return $indikator_sasaran;

        $iku = iku::get();
        // return $iku;

        return view('public.capaian.iku', compact('sasaran','indikator_sasaran','iku','periode'))->with('no',1);
    }

    public function isRenstra(Request $request)
    {
        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get();
                // return $opds;

        // $indikator_sasaran =  IndikatorSasaranRenstra::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
        //         ->where('organisasi_no','=',$request->organisasi_no)
        //         // ->where('tujuan')
        //         // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
        //         ->orderBy('indikator_sasaran_nomor')
        //         ->get();


        // $indikator_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
        //                         ->leftJoin('prokeg_renstra as renstra', 'renstra.indikator_sasaran_id', '=', 'is.id')
        //                         ->leftJoin('program as p', 'p.program_no', '=', 'renstra.program_no')
        //                         ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
        //                         ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
        //                         ->groupBy('is.indikator_sasaran_nama')
        //                         ->groupBy('p.program_nama')
        //                         ->orderBy('org.organisasi_no')
        //                         ->where('org.organisasi_no','=',$request->organisasi_no)
        //                         ->get([
        //                             'org.organisasi_no',
        //                             'org.organisasi_nama',
        //                             'is.indikator_sasaran_nama',
        //                             'satuan.satuan_nama',
        //                             'is.target_t5 as target_t' ,
        //                             'tw_1',
        //                             'a_1',
        //                             'rkmn_1',
        //                             'real_1',
        //                             'tw_2',
        //                             'a_2',
        //                             'rkmn_2',
        //                             'real_2',
        //                             'tw_3', 
        //                             'a_3',
        //                             'rkmn_3',
        //                             'real_3',
        //                             'tw_4', 
        //                             'a_4',
        //                             'rkmn_4',
        //                             'real_4',
        //                             'capaian_sasaran_opd.id',
        //                             'capaian_sasaran_opd.indikator_sasaran_id',
        //                             'capaian_sasaran_opd.pagu',
        //                             'p.program_nama', 
        //                             'renstra.pagu_t5 as pagu_t', 
        //                             'p.program_no'
        //                         ]);


        $indikator_sasaran = CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                // ->leftJoin('renstra_baru as rb', 'rb.indikator_sasaran_id', 'isr.id')
                ->leftJoin('prokeg_renstra as renstra', 'renstra.indikator_sasaran_id', '=', 'isr.id')
                ->leftJoin('program as p', 'p.program_no', '=', 'renstra.program_no')
                ->leftJoin('organisasi as org','org.organisasi_no','=','isr.organisasi_no')
                ->join('iku', 'iku.indikator_sasaran_id', 'isr.id')
                ->join('satuan', 'satuan.id', '=', 'isr.satuan_id')
                ->select(
                    'isr.indikator_sasaran',
                    'iku.formulasi',
                    'p.program_nama',
                    'satuan.satuan_nama',
                    'renstra.target_t3 as target_t' ,
                    'renstra.pagu_t3 as pagu_t', 
                    'tw_1',
                    'a_1',
                    'rkmn_1',
                    'real_1',
                    'tw_2',
                    'a_2',
                    'rkmn_2',
                    'real_2',
                    'tw_3', 
                    'a_3',
                    'rkmn_3',
                    'real_3',
                    'tw_4', 
                    'a_4',
                    'rkmn_4',
                    'real_4',
                    'renstra.target_t1 as target_tw1',
                    'renstra.target_t2 as target_tw2',
                    'renstra.target_t3 as target_tw3',
                    'renstra.target_t4 as target_tw4',
                    'renstra.target_t5 as target_tw5',
                    'capaian_sasaran_opd.id',
                    'capaian_sasaran_opd.indikator_sasaran_id',
                    'capaian_sasaran_opd.pagu',
                    'p.program_nama', 
                    'p.program_no'

                 )
                ->groupBy('isr.indikator_sasaran')
                ->groupBy('p.program_nama')
                ->orderBy('org.organisasi_no')
                ->where('isr.organisasi_no', $request->organisasi_no)
                ->get();
                // return $indikator_sasaran;
        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

                // return $program;

        $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();

        return view('public.capaian.indikator_opd', compact('opds','indikator_sasaran','program','kegiatan'))->with('no',1);
    }

    public function dataRenstra2(Request $request)
    {
        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get();

        $misi =  TujuanRenstra::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                ->where('organisasi_no','=',$request->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 
                // return $misi;

        $tujuan = TujuanRenstra::where('tujuan.organisasi_no', $request->organisasi_no)
                    // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                    ->orderBy('tujuan_nomor')
                    ->groupBy('tujuan_nomor')
                    ->get();
                // return $tujuan;

        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('tujuan_nomor','sasaran_nomor','sasaran_nama', 'sasaran_id')
                ->orderBy('tujuan_nomor')
                ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaranRenstra::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;

        $indikator_tujuan =  IndikatorTujuanRenstra::join('satuan','satuan.id','=','indikator_tujuan.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                ->select('tujuan_nomor','indikator_tujuan_nomor as it_nomor','indikator_tujuan_nama as it_nama','satuan_nama','kondisi_akhir', 'indikator_tujuan.id')
                ->orderBy('tujuan_nomor','it_nomor')
                ->get();

        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

                // return $program;

        $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();

                // return $kegiatan;

        return view('public.capaian.indikator_program', compact('opd','opds','misi','tujuan','indikator_tujuan','sasaran','indikator_sasaran','program','kegiatan'));
    }

    public function dataRenstra3(Request $request)
    {
        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get();

        $misi =  TujuanRenstra::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                ->where('organisasi_no','=',$request->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 
                // return $misi;

        $tujuan = TujuanRenstra::where('tujuan.organisasi_no', $request->organisasi_no)
                    // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                    ->orderBy('tujuan_nomor')
                    ->groupBy('tujuan_nomor')
                    ->get();
                // return $tujuan;

        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('tujuan_nomor','sasaran_nomor','sasaran_nama', 'sasaran_id')
                ->orderBy('tujuan_nomor')
                ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaranRenstra::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;

        $indikator_tujuan =  IndikatorTujuanRenstra::join('satuan','satuan.id','=','indikator_tujuan.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                ->select('tujuan_nomor','indikator_tujuan_nomor as it_nomor','indikator_tujuan_nama as it_nama','satuan_nama','kondisi_akhir', 'indikator_tujuan.id')
                ->orderBy('tujuan_nomor','it_nomor')
                ->get();

        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

                // return $program;

        $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();

                // return $kegiatan;

        return view('public.capaian.indikator_kegiatan', compact('opd','opds','misi','tujuan','indikator_tujuan','sasaran','indikator_sasaran','program','kegiatan'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
