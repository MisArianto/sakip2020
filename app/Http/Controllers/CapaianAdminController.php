<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Alert;
use Illuminate\Http\Request;
use App\Models\CapaianSasaranOpd;
use App\Models\CapaianProgramOpd;
use App\Models\CapaianKegiatanOpd;

class CapaianAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $capaian_sasaran = [];
        $capaian_program = [];
        $capaian_kegiatan = [];
        $opds = [];
        $tahun = '';
        $tahun_int = '';
        $req_opd = '';

        if(Auth::user()->level != 1){

                $orgs = CapaianSasaranOpd::join('indikator_sasaran_renstra as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('is.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                // $orgs_program = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                //     ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->where('ip.organisasi_no', Auth::user()->organisasi_no)
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

                // $orgs_kegiatan = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                //     ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->where('pr.organisasi_no', Auth::user()->organisasi_no)
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

            }else{
                $orgs = CapaianSasaranOpd::join('indikator_sasaran_renstra as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                // $orgs_program = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                //     ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

                // $orgs_kegiatan = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                //     ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

            }


        return view('app.capaian.index', compact('orgs','opds', 'capaian_sasaran', 'capaian_program', 'capaian_kegiatan','tahun', 'tahun_int', 'req_opd'))->with('no',1);
    }



    public function dataRequest(Request $request)
    {
            if(Auth::user()->level == 3){
                $orgs = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('pr.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                // $orgs_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                //     ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->where('is.organisasi_no', Auth::user()->organisasi_no)
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

                // $opds_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                //     ->where('is.organisasi_no', Auth::user()->organisasi_no)
                //     ->groupBy('org.organisasi_no')
                //     ->get(['org.organisasi_nama']);

                // $opds_kegiatan = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                //     ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->where('pr.organisasi_no', Auth::user()->organisasi_no)
                //     ->get(['org.organisasi_nama']);

                // $orgs_program = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                //     ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->where('ip.organisasi_no', Auth::user()->organisasi_no)
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

                $opds = CapaianProgramOpd::join('indikator_program_renstra as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->where('ip.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_nama']);

                $tahun = $request->tahun;
                $organisasi_no = Auth::user()->organisasi_no;

                $target = DB::table('indikator_sasaran_renstra as isr')->join('capaian_sasaran_opd', 'capaian_sasaran_opd.indikator_sasaran_id', 'isr.id')
                    ->leftJoin('target_is_renstra', 'target_is_renstra.indikator_sasaran_id', 'isr.id')
                    ->where('isr.organisasi_no', Auth::user()->organisasi_no)
                    ->get();


                $capaian_sasaran = $this->percabangan_sasaran($tahun, $organisasi_no);
                $capaian_kegiatan = $this->percabangan_kegiatan($tahun, $organisasi_no);
                $capaian_program = $this->percabangan_program($tahun, $organisasi_no);

            }else{

                if ($request->organisasi_no == '') {
                    Alert::warning('Pilih OPD!!', 'Warning')->persistent('Close');

                    return redirect('capaian');
                }

                if ($request->tahun == '') {
                    Alert::warning('Pilih Tahun!!', 'Warning')->persistent('Close');

                    return redirect('capaian');
                }

                if ($request->organisasi_no == 'KAB') {
                    $orgs = 'KAB';
                    $req_opd = 'KAB';
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
                    $capaian_sasaran = [];
                    $organisasi_no = 'KAB';

                    // return $target_sasaran;
                    $tahun = $request->tahun;
                    $capaian_sasaran = $this->percabangan_sasaran_kab($tahun);
                    $capaian_kegiatan = [];
                    $capaian_program = [];
                    

                }

                $orgs = CapaianSasaranOpd::join('indikator_sasaran_renstra as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);
                // return $orgs;

                // $orgs_program = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                //     ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

                // $orgs_kegiatan = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                //     ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->orderBy('org.organisasi_no')
                //     ->get(['org.organisasi_no','org.organisasi_nama']);

                // $opds_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                //     ->where('is.organisasi_no', $request->organisasi_no)
                //     ->groupBy('org.organisasi_no')
                //     ->get(['org.organisasi_nama']);

                // $opds_program = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                //     ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                //     ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                //     ->groupBy('org.organisasi_no')
                //     ->where('ip.organisasi_no', $request->organisasi_no)
                //     ->get(['org.organisasi_nama']);

                $opds = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->where('pr.organisasi_no', $request->organisasi_no)
                    ->get();
                    // return $opds;

                $tahun = $request->tahun;
                $organisasi_no = $request->organisasi_no;

                $target = DB::table('indikator_sasaran_renstra as isr')->join('target_is_renstra', 'target_is_renstra.indikator_sasaran_id', 'isr.id')
                    ->where('isr.organisasi_no', $request->organisasi_no)
                    ->where('target_is_renstra.tahun', '2017')
                    ->first();


                $capaian_sasaran = $this->percabangan_sasaran($tahun, $organisasi_no);
                $capaian_kegiatan = $this->percabangan_kegiatan($tahun, $organisasi_no);
                $capaian_program = $this->percabangan_program($tahun, $organisasi_no);

            }

            $tahun = 'Tahun '.$request->tahun;
            $tahun_int = $request->tahun;
            $req_opd = $request->organisasi_no;


        return view('app.capaian.index', compact('orgs','opds', 'capaian_sasaran', 'capaian_program', 'capaian_kegiatan', 'tahun','tahun_int', 'req_opd', 'target'))->with('no',1);
    }



    function percabangan_kegiatan($tahun, $organisasi_no)
    {

        if($tahun == '2017')
            {
               return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t1 as target_t', 'tw_1','tw_2', 'tw_3', 'tw_4', 'pr.renstra_id']);

            }
            elseif($tahun == '2018')
            {
               return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t2 as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'pr.renstra_id']);
            }
            elseif($tahun == '2019') 
            {
                return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t3 as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'pr.renstra_id']);
            }
            elseif($tahun == '2020')
            {
                return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t4 as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'pr.renstra_id']);
            
            }
            elseif($tahun == '2021')
            {
                return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t5 as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'pr.renstra_id']);
            
            }
    }

    function percabangan_program($tahun, $organisasi_no)
    {

        if($tahun == '2017')
        {
           return CapaianProgramOpd::join('indikator_program_renstra as ip','ip.id','=','capaian_program_opd.indikator_program_id')
                                ->join('target_ip_renstra as tipr', 'tipr.indikator_program_id', '=', 'ip.id')
                                ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->where('ip.organisasi_no', $organisasi_no)
                                ->where('tipr.tahun', $tahun)
                                ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'tipr.target as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'ip.id']);

        }
        elseif($tahun == '2018')
        {
           return CapaianProgramOpd::join('indikator_program_renstra as ip','ip.id','=','capaian_program_opd.indikator_program_id')
                                ->join('target_ip_renstra as tipr', 'tipr.indikator_program_id', '=', 'ip.id')
                                ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->where('ip.organisasi_no', $organisasi_no)
                                ->where('tipr.tahun', $tahun)
                                ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'tipr.target as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'ip.id']);
        }
        elseif($tahun == '2019') 
        {
            return CapaianProgramOpd::join('indikator_program_renstra as ip','ip.id','=','capaian_program_opd.indikator_program_id')
                                ->join('target_ip_renstra as tipr', 'tipr.indikator_program_id', '=', 'ip.id')
                                ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->where('ip.organisasi_no', $organisasi_no)
                                ->where('tipr.tahun', $tahun)
                                ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'tipr.target as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'ip.id']);
        }
        elseif($tahun == '2020')
        {
            return CapaianProgramOpd::join('indikator_program_renstra as ip','ip.id','=','capaian_program_opd.indikator_program_id')
                                ->join('target_ip_renstra as tipr', 'tipr.indikator_program_id', '=', 'ip.id')
                                ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->where('ip.organisasi_no', $organisasi_no)
                                ->where('tipr.tahun', $tahun)
                                ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'tipr.target as target_t4 as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'ip.id']);
        
        }
        elseif($tahun == '2021')
        {
            return CapaianProgramOpd::join('indikator_program_renstra as ip','ip.id','=','capaian_program_opd.indikator_program_id')
                                ->join('target_ip_renstra as tipr', 'tipr.indikator_program_id', '=', 'ip.id')
                                ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->where('ip.organisasi_no', $organisasi_no)
                                ->where('tipr.tahun', $tahun)
                                ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'tipr.target as target_t5 as target_t','tw_1','tw_2', 'tw_3', 'tw_4', 'ip.id']);
        
        }
    }


     function percabangan_sasaran_test($tahun, $organisasi_no)
    {
        // dd($organisasi_no);
        if($tahun == '2017')
        {
            return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'renstra.target_t1 as target_t' ,
                    'renstra.pagu_t1 as pagu_t', 
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
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();


                               

        }
        elseif($tahun == '2018')
        {
            return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'renstra.target_t2 as target_t' ,
                    'renstra.pagu_t2 as pagu_t', 
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
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();
        }
        elseif($tahun == '2019') 
        {
            return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();
        }
        elseif($tahun == '2020')
        {
           return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'renstra.target_t4 as target_t' ,
                    'renstra.pagu_t4 as pagu_t', 
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
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();
        
        }
        elseif($tahun == '2021')
        {
            return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'renstra.target_t5 as target_t' ,
                    'renstra.pagu_t5 as pagu_t', 
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
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();
        
        }
    }


    function percabangan_sasaran($tahun, $organisasi_no)
    {
        // dd($organisasi_no);
        if($tahun == '2017')
        {
           

                return DB::table('indikator_sasaran_renstra as isr')->join('capaian_sasaran_opd', 'capaian_sasaran_opd.indikator_sasaran_id', 'isr.id')
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
                    'renstra.target_t1 as target_t' ,
                    'renstra.pagu_t1 as pagu_t', 
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
                    'capaian_sasaran_opd.target1',
                    'capaian_sasaran_opd.target2',
                    'capaian_sasaran_opd.target3',
                    'capaian_sasaran_opd.target4',
                    'capaian_sasaran_opd.kinerja_1',
                    'capaian_sasaran_opd.kinerja_2',
                    'capaian_sasaran_opd.kinerja_3',
                    'capaian_sasaran_opd.kinerja_4',
                    'p.program_nama', 
                    'p.program_no'

                 )
                ->groupBy('isr.indikator_sasaran')
                ->groupBy('p.program_nama')
                ->orderBy('org.organisasi_no')
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();




                               

        }
        elseif($tahun == '2018')
        {
            return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'renstra.target_t2 as target_t' ,
                    'renstra.pagu_t2 as pagu_t', 
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
                    'capaian_sasaran_opd.target1',
                    'capaian_sasaran_opd.target2',
                    'capaian_sasaran_opd.target3',
                    'capaian_sasaran_opd.target4',
                    'capaian_sasaran_opd.kinerja_1',
                    'capaian_sasaran_opd.kinerja_2',
                    'capaian_sasaran_opd.kinerja_3',
                    'capaian_sasaran_opd.kinerja_4',
                    'p.program_nama', 
                    'p.program_no'

                 )
                ->groupBy('isr.indikator_sasaran')
                ->groupBy('p.program_nama')
                ->orderBy('org.organisasi_no')
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();
        }
        elseif($tahun == '2019') 
        {
            return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'capaian_sasaran_opd.target1',
                    'capaian_sasaran_opd.target2',
                    'capaian_sasaran_opd.target3',
                    'capaian_sasaran_opd.target4',
                    'capaian_sasaran_opd.kinerja_1',
                    'capaian_sasaran_opd.kinerja_2',
                    'capaian_sasaran_opd.kinerja_3',
                    'capaian_sasaran_opd.kinerja_4',
                    'p.program_nama', 
                    'p.program_no'

                 )
                ->groupBy('isr.indikator_sasaran')
                ->groupBy('p.program_nama')
                ->orderBy('org.organisasi_no')
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();

        }
        elseif($tahun == '2020')
        {
           return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'renstra.target_t4 as target_t' ,
                    'renstra.pagu_t4 as pagu_t', 
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
                    'capaian_sasaran_opd.target1',
                    'capaian_sasaran_opd.target2',
                    'capaian_sasaran_opd.target3',
                    'capaian_sasaran_opd.target4',
                    'capaian_sasaran_opd.kinerja_1',
                    'capaian_sasaran_opd.kinerja_2',
                    'capaian_sasaran_opd.kinerja_3',
                    'capaian_sasaran_opd.kinerja_4',
                    'p.program_nama', 
                    'p.program_no'

                 )
                ->groupBy('isr.indikator_sasaran')
                ->groupBy('p.program_nama')
                ->orderBy('org.organisasi_no')
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();
        
        }
        elseif($tahun == '2021')
        {
            return CapaianSasaranOpd::join('indikator_sasaran_renstra as isr','isr.id','=','capaian_sasaran_opd.indikator_sasaran_id')
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
                    'renstra.target_t5 as target_t' ,
                    'renstra.pagu_t5 as pagu_t', 
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
                    'capaian_sasaran_opd.target1',
                    'capaian_sasaran_opd.target2',
                    'capaian_sasaran_opd.target3',
                    'capaian_sasaran_opd.target4',
                    'capaian_sasaran_opd.kinerja_1',
                    'capaian_sasaran_opd.kinerja_2',
                    'capaian_sasaran_opd.kinerja_3',
                    'capaian_sasaran_opd.kinerja_4',
                    'p.program_nama', 
                    'p.program_no'

                 )
                ->groupBy('isr.indikator_sasaran')
                ->groupBy('p.program_nama')
                ->orderBy('org.organisasi_no')
                ->where('isr.organisasi_no', $organisasi_no)
                ->get();
        
        }
    }

    function percabangan_sasaran_kab($tahun)
    {

        if($tahun == '2017')
        {
           return $capaian_sasaran = DB::table('capaian_sasaran_kab as csk')->join('indikator_sasaran_rpjmd as is','is.id','=','csk.indikator_sasaran_id')
                                ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran','satuan.satuan_nama', 'is.target_t1 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4', 'csk.id']);

        }
        elseif($tahun == '2018')
        {
            return $capaian_sasaran = DB::table('capaian_sasaran_kab as csk')->join('indikator_sasaran_rpjmd as is','is.id','=','csk.indikator_sasaran_id')
                                ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran','satuan.satuan_nama', 'is.target_t2 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4', 'csk.id']);
        }
        elseif($tahun == '2019') 
        {
            return $capaian_sasaran = DB::table('capaian_sasaran_kab as csk')->join('indikator_sasaran_rpjmd as is','is.id','=','csk.indikator_sasaran_id')
                                ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran','satuan.satuan_nama', 'is.target_t3 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4', 'csk.id']);
        }
        elseif($tahun == '2020')
        {
            return $capaian_sasaran = DB::table('capaian_sasaran_kab as csk')->join('indikator_sasaran_rpjmd as is','is.id','=','csk.indikator_sasaran_id')
                                ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran','satuan.satuan_nama', 'is.target_t4 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4', 'csk.id']);
        
        }
        elseif($tahun == '2021')
        {
            return $capaian_sasaran = DB::table('capaian_sasaran_kab as csk')->join('indikator_sasaran_rpjmd as is','is.id','=','csk.indikator_sasaran_id')
                                ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                ->orderBy('org.organisasi_no')
                                ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran','satuan.satuan_nama', 'is.target_t5 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4', 'csk.id']);
        
        }


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
    public function edit_sasaran($id)
    {
        $model = CapaianSasaranOpd::where('id', $id)->first();


        return view('app.capaian.sasaran_edit', compact('model'));
    }

    public function edit_program($id)
    {
        $model = CapaianProgramOpd::where('id', $id)->first();


        return view('app.capaian.program_edit', compact('model'));
    }

    public function edit_kegiatan($id)
    {
        $model = CapaianKegiatanOpd::where('id', $id)->first();


        return view('app.capaian.kegiatan_edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_sasaran(Request $request, $id)
    {
        $model = CapaianSasaranOpd::where('id', $id)->first();
        $model->target1 = $request->target1;
        $model->target2 = $request->target2;
        $model->target3 = $request->target3;
        $model->target4 = $request->target4;

        $model->kinerja_1 = $request->kinerja1;
        $model->kinerja_2 = $request->kinerja2;
        $model->kinerja_3 = $request->kinerja3;
        $model->kinerja_4 = $request->kinerja4;

        $model->tw_1 = $request->tw_1;
        $model->a_1 = $request->a_1;
        $model->rkmn_1 = $request->rkmn_1;
        $model->real_1 = $request->real_1;

        $model->tw_2 = $request->tw_2;
        $model->a_2 = $request->a_2;
        $model->rkmn_2 = $request->rkmn_2;
        $model->real_2 = $request->real_2;

        $model->tw_3 = $request->tw_3;
        $model->a_3 = $request->a_3;
        $model->rkmn_3 = $request->rkmn_3;
        $model->real_3 = $request->real_3;

        $model->tw_4 = $request->tw_4;
        $model->a_4 = $request->a_4;
        $model->rkmn_4 = $request->rkmn_4;
        $model->real_4 = $request->real_4;

        $model->pagu = $request->pagu;
        $model->save();

        Alert::success('Data Berhasil di update!!', 'Success')->persistent('Close');

        return redirect('capaian');
    }

    public function update_program(Request $request, $id)
    {
        $model = CapaianProgramOpd::where('indikator_program_id', $id)->first();
        $model->tw_1 = $request->tw_1;
        $model->tw_2 = $request->tw_2;
        $model->tw_3 = $request->tw_3;
        $model->tw_4 = $request->tw_4;
        $model->save();

        Alert::success('Data Berhasil di update!!', 'Success')->persistent('Close');

        return redirect('capaian');
    }

    public function update_kegiatan(Request $request, $id)
    {
        $model = CapaianKegiatanOpd::where('renstra_id', $id)->first();
        $model->tw_1 = $request->tw_1;
        $model->tw_2 = $request->tw_2;
        $model->tw_3 = $request->tw_3;
        $model->tw_4 = $request->tw_4;
        $model->save();

        Alert::success('Data Berhasil di update!!', 'Success')->persistent('Close');

        return redirect('capaian');
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
