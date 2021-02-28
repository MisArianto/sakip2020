<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use PDF;
use App\Lkjip;
use App\Models\CapaianSasaranOpd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonitoringController extends Controller
{
    public function lkjip()
    {
    	$lkjip = Lkjip::leftJoin('organisasi as o', 'o.organisasi_no', 'dok_lkjip.organisasi_no')
    			->select(
    				'o.organisasi_no',
    				'o.organisasi_nama',
    				DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2018') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2018"),
    				DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2019') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
    				DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2020') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
    				DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2021') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2021")
    			)
    			->where('o.organisasi_jenis', 'ORG')
    			->orderBy('o.organisasi_no')
    			->get();




    	return view('app.monitoring.lkjip', compact('lkjip'))->with('no', 1);
    }

    public function capaian()
    {

        $capaian = DB::table('capaian_sasaran_opd as cso')->leftJoin('indikator_sasaran_renstra as isr', 'isr.id', '=','cso.indikator_sasaran_id')
                    ->leftJoin('organisasi as o', 'o.organisasi_no', 'isr.organisasi_no')
                    ->select(
                        'o.organisasi_no',
                        'o.organisasi_nama',
                        'cso.a_1',
                        'cso.a_2',
                        'cso.a_3',
                        'cso.a_4',
                        'cso.tahun'

                    )
                    ->where('o.organisasi_jenis', 'ORG')
                    ->orderBy('o.organisasi_no');
                    

                    $tahun_2017 = $capaian->where('cso.tahun', '2017')
                                    ->get();
                    return  DB::table('indikator_sasaran_renstra as isr')->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', '=','isr.id')
                    ->leftJoin('organisasi as o', 'o.organisasi_no', 'isr.organisasi_no')
                    ->select(
                        'o.organisasi_no',
                        'o.organisasi_nama',
                        DB::raw("(select cd.a_1 from capaian_sasaran_opd as cd where ((cd.tahun = '2017') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_1_2017"),
                        DB::raw("(select cd.a_2 from capaian_sasaran_opd as cd where ((cd.tahun = '2017') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_2_2017"),
                        DB::raw("(select cd.a_3 from capaian_sasaran_opd as cd where ((cd.tahun = '2017') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_3_2017"),
                        DB::raw("(select cd.a_4 from capaian_sasaran_opd as cd where ((cd.tahun = '2017') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_4_2017"),
                        DB::raw("(select cd.a_1 from capaian_sasaran_opd as cd where ((cd.tahun = '2018') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_1_2018"),
                        DB::raw("(select cd.a_2 from capaian_sasaran_opd as cd where ((cd.tahun = '2018') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_2_2018"),
                        DB::raw("(select cd.a_3 from capaian_sasaran_opd as cd where ((cd.tahun = '2018') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_3_2018"),
                        DB::raw("(select cd.a_4 from capaian_sasaran_opd as cd where ((cd.tahun = '2018') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_4_2018"),
                        DB::raw("(select cd.a_1 from capaian_sasaran_opd as cd where ((cd.tahun = '2019') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_1_2019"),
                        DB::raw("(select cd.a_2 from capaian_sasaran_opd as cd where ((cd.tahun = '2019') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_2_2019"),
                        DB::raw("(select cd.a_3 from capaian_sasaran_opd as cd where ((cd.tahun = '2019') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_3_2019"),
                        DB::raw("(select cd.a_4 from capaian_sasaran_opd as cd where ((cd.tahun = '2019') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_4_2019"),
                        DB::raw("(select cd.a_1 from capaian_sasaran_opd as cd where ((cd.tahun = '2020') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_1_2020"),
                        DB::raw("(select cd.a_2 from capaian_sasaran_opd as cd where ((cd.tahun = '2020') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_2_2020"),
                        DB::raw("(select cd.a_3 from capaian_sasaran_opd as cd where ((cd.tahun = '2020') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_3_2020"),
                        DB::raw("(select cd.a_4 from capaian_sasaran_opd as cd where ((cd.tahun = '2020') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_4_2020"),
                        DB::raw("(select cd.a_1 from capaian_sasaran_opd as cd where ((cd.tahun = '2021') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_1_2021"),
                        DB::raw("(select cd.a_2 from capaian_sasaran_opd as cd where ((cd.tahun = '2021') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_2_2021"),
                        DB::raw("(select cd.a_3 from capaian_sasaran_opd as cd where ((cd.tahun = '2021') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_3_2021"),
                        DB::raw("(select cd.a_4 from capaian_sasaran_opd as cd where ((cd.tahun = '2021') and (isr.organisasi_no = o.organisasi_no)) limit 1) as a_4_2021"),
                    )
                    ->where('o.organisasi_jenis', 'ORG')
                    ->orderBy('o.organisasi_no')->groupBy('o.organisasi_no')->get();
                    return $tahun_2017;


        return view('app.monitoring.capaian', compact('capaian'))->with('no', 1);
    }

    public function pk()
    {
        $pk = DB::table('pk_eselon_2 as pk2')
                ->leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'pk2.indikator_sasaran_id')
                ->leftJoin('organisasi as o', 'o.organisasi_no', 'isr.organisasi_no')
                ->select(
                    'o.organisasi_no',
                    'o.organisasi_nama',
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2018') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2018"),
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2019') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2019"),
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2020') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2020"),
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2021') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2021"),

                     DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2018') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2018"),
                    DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2019') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2019"),
                    DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2020') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2020"),
                    DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2021') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2021"),

                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2018') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2018"),
                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2019') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2019"),
                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2020') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2020"),
                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2021') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2021")
                )
                ->where('o.organisasi_jenis', 'ORG')
                ->orderBy('o.organisasi_no')
                ->groupBy('o.organisasi_no')
                ->get();

                $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();

        return view('app.monitoring.pk', compact('pk', 'orgs'))->with('no', 1);

    }

    public function iki()
    {
        $ikis = DB::table('iki as i')->leftJoin('pegawai as p', 'p.id', 'i.pegawai_id')
                ->leftJoin('organisasi as o', 'o.organisasi_no', 'i.organisasi_no')
                ->select(
                    'o.organisasi_no',
                    'o.organisasi_nama',
                    'i.pegawai_id',
                    'i.tahun',
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2018') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2018"),
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2019') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2020') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2021') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2021"),
                )
                ->where('o.organisasi_jenis', 'ORG')
                ->orderBy('o.organisasi_no')
                ->get();


        $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();



        return view('app.monitoring.iki', compact('ikis', 'orgs'))->with('no', 1);
    }

    public function skp()
    {
        return view('app.admin.monitoring.skp.index');
    }

    public function fetch_skp()
    {
        $skps = DB::table('skp as i')->leftJoin('pegawai as p', 'p.id', 'i.pegawai_id')
                ->leftJoin('organisasi as o', 'o.organisasi_no', 'i.organisasi_no')
                ->select(
                    'o.organisasi_no',
                    'o.organisasi_nama',
                    'i.pegawai_id',
                    'i.tahun',
                    DB::raw("(select skp.tahun from skp where ((skp.tahun = '2019') and (skp.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                    DB::raw("(select skp.tahun from skp where ((skp.tahun = '2020') and (skp.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                )
                ->where('o.organisasi_jenis', 'ORG')
                ->orderBy('o.organisasi_no')
                ->get();


        $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();


        $no = 1;
        $output = '';


            foreach(collect($orgs)->unique('organisasi_nama') as $value){
        $output .= '
            <tr>
                <td>'.$no++.'</td>
                <td>'.$value->organisasi_nama.'</td>';

            foreach(collect($skps)->where('organisasi_nama', $value->organisasi_nama)->unique('organisasi_nama') as $data){

            
            $jumlah_pegawai_2018 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2018')->unique('pegawai_id')->count();
            $jumlah_pegawai_2019 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2019')->unique('pegawai_id')->count();
            $jumlah_pegawai_2020 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2020')->unique('pegawai_id')->count();
            $jumlah_pegawai_2021 = collect($skps)->where('organisasi_no', $data->organisasi_no)->where('tahun', '2021')->unique('pegawai_id')->count();

            $cekOrg = collect($skps)->where('organisasi_no', $data->organisasi_no)->first();

            if($data->organisasi_no == '2.01.06.01.')
            {
                $total_pegawai = DB::table('pegawai')->where('organisasi_nama', 'like', '%' . 'PERINDUSTRIAN' . '%')->count();

            }elseif($data->organisasi_no == '3.01.03.02.')
            {
                $total_pegawai = DB::table('pegawai')->where('organisasi_nama', 'like', '%' . 'PAJAK' . '%')->count();

            }else{

                $total_pegawai = DB::table('pegawai')->where('organisasi_nama', $data->organisasi_nama)->count();
            }

            // $output .= '<tr> 
            //     <td>'.$no++.'</td>
            //     <td>'.$data->organisasi_nama.'</td>';

                if($total_pegawai == 0){
                $output .= '<td class="text-center">
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0 % Complete (danger)</span>
                        0%
                      </div>
                    </div>
                </td>
                <td class="text-center">
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0 % Complete (danger)</span>
                        0%
                      </div>
                    </div>
                </td>
                <td class="text-center">
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0 % Complete (danger)</span>
                        0%
                      </div>
                    </div>
                </td>';
                }else{

                if($jumlah_pegawai_2018 == 0){
                $output .= '<td class="text-center" title="2018 - '.$data->organisasi_nama.'">
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="'.round($jumlah_pegawai_2018/$total_pegawai * 100).'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2018/$total_pegawai * 100,2).'%">
                        <span class="sr-only">'.round($jumlah_pegawai_2018/$total_pegawai * 100,2) .'% Complete (danger)</span>
                        '.round($jumlah_pegawai_2018/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }else{
                $output .= '<td class="text-center" title="2018 - '.$data->organisasi_nama.'">
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="'. round($jumlah_pegawai_2018/$total_pegawai * 100) .'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2018/$total_pegawai * 100,2).'%;color:red;">
                        <span class="sr-only">'. round($jumlah_pegawai_2018/$total_pegawai * 100,2) .'% Complete (success)</span>
                        '. round($jumlah_pegawai_2018/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }

                if($jumlah_pegawai_2019 == 0){
                $output .= '<td class="text-center" title="2019 - '. $data->organisasi_nama .'">
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="'. round($jumlah_pegawai_2019/$total_pegawai * 100) .'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2019/$total_pegawai * 100,2).'%">
                        <span class="sr-only">'. round($jumlah_pegawai_2019/$total_pegawai * 100,2) .'% Complete (danger)</span>
                        '. round($jumlah_pegawai_2019/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }else{
                $output .= '<td class="text-center" title="2019 - '. $data->organisasi_nama .'">
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="'. round($jumlah_pegawai_2019/$total_pegawai * 100) .'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2019/$total_pegawai * 100,2).'%;color:red;">
                        <span class="sr-only">'. round($jumlah_pegawai_2019/$total_pegawai * 100,2) .'% Complete (success)</span>
                        '. round($jumlah_pegawai_2019/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }

                if($jumlah_pegawai_2020 == 0){
                $output .= '<td class="text-center" title="2020 - '. $data->organisasi_nama .'">
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="'. round($jumlah_pegawai_2020/$total_pegawai * 100) .'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2020/$total_pegawai * 100,2).'%">
                        <span class="sr-only">'. round($jumlah_pegawai_2020/$total_pegawai * 100,2) .'% Complete (danger)</span>
                        '. round($jumlah_pegawai_2020/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }else{
                $output .= '<td class="text-center" title="2020 - '. $data->organisasi_nama .'">
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="'. round($jumlah_pegawai_2020/$total_pegawai * 100) .'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2020/$total_pegawai * 100,2).'%;color:red;">
                        <span class="sr-only">'. round($jumlah_pegawai_2020/$total_pegawai * 100,2) .'% Complete (success)</span>
                        '. round($jumlah_pegawai_2020/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }

                if($jumlah_pegawai_2021 == 0){
                $output .= '<td class="text-center" title="2021 - '. $data->organisasi_nama .'">
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="'. round($jumlah_pegawai_2021/$total_pegawai * 100) .'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2021/$total_pegawai * 100,2).'%">
                        <span class="sr-only">'. round($jumlah_pegawai_2021/$total_pegawai * 100,2) .'% Complete (danger)</span>
                        '. round($jumlah_pegawai_2021/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }else{
                $output .= '<td class="text-center" title="2021 - '. $data->organisasi_nama .'">
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="'. round($jumlah_pegawai_2021/$total_pegawai * 100) .'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($jumlah_pegawai_2021/$total_pegawai * 100,2).'%;color:red;">
                        <span class="sr-only">'. round($jumlah_pegawai_2021/$total_pegawai * 100,2) .'% Complete (success)</span>
                        '. round($jumlah_pegawai_2021/$total_pegawai * 100,2) .'%
                      </div>
                    </div>
                </td>';
                }

                }

            }
            $output .= '</tr>';
            }
        


        return response()->json([
            'output' => $output
        ],200);


        // return view('app.monitoring.skp', compact('skps','orgs'))->with('no', 1);
    }

    public function cetak_pk_pdf()
    {
        $pk = DB::table('pk_eselon_2 as pk2')
                ->leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'pk2.indikator_sasaran_id')
                ->leftJoin('organisasi as o', 'o.organisasi_no', 'isr.organisasi_no')
                ->select(
                    'o.organisasi_no',
                    'o.organisasi_nama',
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2018') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2018"),
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2019') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2019"),
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2020') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2020"),
                    DB::raw("(select pk_eselon_2.tahun from pk_eselon_2 where ((pk_eselon_2.tahun = '2021') and (pk_eselon_2.organisasi_no = o.organisasi_no)) limit 1) as pk2_tahun_2021"),

                     DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2018') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2018"),
                    DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2019') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2019"),
                    DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2020') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2020"),
                    DB::raw("(select pk_eselon_3.tahun from pk_eselon_3 where ((pk_eselon_3.tahun = '2021') and (pk_eselon_3.organisasi_no = o.organisasi_no)) limit 1) as pk3_tahun_2021"),

                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2018') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2018"),
                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2019') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2019"),
                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2020') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2020"),
                    DB::raw("(select pk_eselon_4.tahun from pk_eselon_4 where ((pk_eselon_4.tahun = '2021') and (pk_eselon_4.organisasi_no = o.organisasi_no)) limit 1) as pk4_tahun_2021")
                )
                ->where('o.organisasi_jenis', 'ORG')
                ->orderBy('o.organisasi_no')
                ->groupBy('o.organisasi_no')
                ->get();
        $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();

        return $output = view('app.monitoring._pk', compact('pk', 'orgs'))->with('no', 1)->render();

        // $pdf = PDF::loadHTML($output)->setPaper('legal', 'landscape');

        // return $pdf->stream('Cetakan-Monitoring-Perjanjian-Kinerja.pdf');
    }

    public function cetak_iki_pdf()
    {
        $ikis = DB::table('iki as i')->leftJoin('pegawai as p', 'p.id', 'i.pegawai_id')
                ->leftJoin('organisasi as o', 'o.organisasi_no', 'i.organisasi_no')
                ->select(
                    'o.organisasi_no',
                    'o.organisasi_nama',
                    'i.pegawai_id',
                    'i.tahun',
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2018') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2018"),
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2019') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2020') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                    DB::raw("(select iki.tahun from iki where ((iki.tahun = '2021') and (iki.organisasi_no = o.organisasi_no)) limit 1) as tahun_2021"),
                )
                ->where('o.organisasi_jenis', 'ORG')
                ->orderBy('o.organisasi_no')
                ->get();
        $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();

        return view('app.monitoring._iki', compact('ikis', 'orgs'))->with('no', 1)->render();
    }

    public function cetak_lkjip_pdf()
    {
        
        $lkjips = Lkjip::leftJoin('organisasi as o', 'o.organisasi_no', 'dok_lkjip.organisasi_no')
                ->select(
                    'o.organisasi_no',
                    'o.organisasi_nama',
                    DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2018') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2018"),
                    DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2019') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                    DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2020') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                    DB::raw("(select dok_lkjip.tahun from dok_lkjip where ((dok_lkjip.tahun = '2021') and (dok_lkjip.organisasi_no = o.organisasi_no)) limit 1) as tahun_2021")
                )
                ->where('o.organisasi_jenis', 'ORG')
                ->orderBy('o.organisasi_no')
                ->get();

        return view('app.monitoring._lkjip', compact('lkjips'))->with('no', 1)->render();
    }

    public function cetak_skp_pdf()
    {
        
        $skps = DB::table('skp as i')->leftJoin('pegawai as p', 'p.id', 'i.pegawai_id')
                ->leftJoin('organisasi as o', 'o.organisasi_no', 'i.organisasi_no')
                ->select(
                    'o.organisasi_no',
                    'o.organisasi_nama',
                    'i.pegawai_id',
                    'i.tahun',
                    DB::raw("(select skp.tahun from skp where ((skp.tahun = '2019') and (skp.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                    DB::raw("(select skp.tahun from skp where ((skp.tahun = '2020') and (skp.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                )
                ->where('o.organisasi_jenis', 'ORG')
                ->orderBy('o.organisasi_no')
                ->get();

        $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();

        return view('app.admin.monitoring.skp.cetak', compact('skps','orgs'))->with('no', 1)->render();
    }

    public function cetak_iku_pdf()
    {
            $ikus = DB::table('iku')
                            ->join('organisasi as o', 'o.organisasi_no', 'iku.organisasi_no')
                            ->select(
                                'o.organisasi_no',
                                'o.organisasi_nama',
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2017') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2017"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2018') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2018"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2019') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2020') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2021') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2021"),
                                'iku.tahun'
                            )
                            ->where('o.organisasi_jenis', 'ORG')
                            ->get();
                 $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();


            return view('app.monitoring._iku', compact('ikus','orgs'))->with('no', 1)->render();
    }

    public function cetak_cascading_pdf()
    {
            $data = DB::table('upload_cascading_rpjmd as ucr')
                        ->join('organisasi as o', 'o.organisasi_no', 'ucr.organisasi_nama')
                        ->select(
                            'o.organisasi_no',
                            'o.organisasi_nama',
                            'ucr.keterangan'
                        )
                        ->where('o.organisasi_jenis', 'ORG')
                        ->get();

            $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();


            return view('app.monitoring._cascading_cross_cutting', compact('data','orgs'))->with('no', 1)->render();
    }

    public function cascading_cross_cutting()
    {
        if(Auth::user()->level == 1)
        {
            $data = DB::table('upload_cascading_rpjmd as ucr')
                        ->join('organisasi as o', 'o.organisasi_no', 'ucr.organisasi_nama')
                        ->select(
                            'o.organisasi_no',
                            'o.organisasi_nama',
                            'ucr.keterangan'
                        )
                        ->where('o.organisasi_jenis', 'ORG')
                        ->get();

            $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();

        }else{
            $data = DB::table('upload_cascading_rpjmd as ucr')
                        ->join('organisasi as o', 'o.organisasi_no', 'ucr.organisasi_nama')
                        ->select(
                            'o.organisasi_no',
                            'o.organisasi_nama',
                            'ucr.keterangan'
                        )
                        ->where('o.organisasi_jenis', 'ORG')
                        ->where('o.organisasi_no', Auth::user()->organisasi_no)
                        ->get();

            $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->where('organisasi_no', Auth::user()->organisasi_no)->get();
        }

        return view('app.monitoring.cascading_cross_cutting', compact('data', 'orgs'))->with('no', 1)->render();
    }

    public function iku()
    {
        if(Auth::user()->level == 1)
        {
            $ikus = DB::table('iku')
                            ->join('organisasi as o', 'o.organisasi_no', 'iku.organisasi_no')
                            ->select(
                                'o.organisasi_no',
                                'o.organisasi_nama',
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2017') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2017"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2018') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2018"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2019') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2020') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2021') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2021"),
                                'iku.tahun'
                            )
                            ->where('o.organisasi_jenis', 'ORG')
                            ->get();
                 $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->get();

        }else{
            $ikus = DB::table('iku')
                            ->join('organisasi as o', 'o.organisasi_no', 'iku.organisasi_no')
                            ->select(
                                'o.organisasi_no',
                                'o.organisasi_nama',
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2017') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2017"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2018') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2018"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2019') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2019"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2020') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2020"),
                                DB::raw("(select i.tahun from iku as i where ((i.tahun = '2021') and (i.organisasi_no = o.organisasi_no)) limit 1) as tahun_2021"),
                                'iku.tahun'
                            )
                            ->where('o.organisasi_jenis', 'ORG')
                            ->where('o.organisasi_no', Auth::user()->organisasi_no)
                            ->get();
            $orgs = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->where('organisasi_no', Auth::user()->organisasi_no)->get();
        }


        return view('app.monitoring.iku', compact('ikus', 'orgs'))->with('no', 1)->render();
    }

}
