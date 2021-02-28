<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Organisasi;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\visi_misi;
use App\Models\TujuanRpjmd as Tujuan;
use App\Models\SasaranRpjmd as Sasaran;
use App\Models\IkuRpjmd as iku;
use App\Models\TujuanRenstra;
use App\Models\SasaranRenstra;
use App\Models\IndikatorTujuanRenstra;
use App\Models\IndikatorSasaranRenstra;
use App\Models\Satuan;
use App\Models\ProgKegRenstra;
use App\Models\IkuRenstra;
use Illuminate\Http\Request;

class PerencanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $org = Organisasi::where('organisasi_jenis','ORG')
            ->orderBy('organisasi_no')
            // ->paginate(10);
            ->get();


        // return $org;

        return view('public.perencanaan.index', compact('org'));
    }


    public function pohon_kinerja()
    {
        $opd = Organisasi::where('organisasi_jenis','ORG')->get();
        $visi = [];
        $misi = [];
        $tujuan = [];
        $sasaran = [];
        $indikator_sasaran = [];
        $program = [];
        $kegiatans = [];
        $opds = [];
        $org = [];

        return view('public.cascading.pohon-kinerja', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));
        // return view('public.perencanaan.pohon_kinerja', compact('orgs'));
    }

    public function rpjmd()
    {
        $visi=Visi::get();
        $misi=Misi::get();
        
        $periode = Misi::leftJoin('visi', 'visi.id', 'misi.visi_id')->first();


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
                            ->leftJoin('indikator_program_rpjmd as ipr','ipr.program_rpjmd_id','=','program_rpjmd.id')
                            ->select('tp_program_rpjmd.tp_program_id as tp_id','tp_program_rpjmd.program_no','ipr.indikator_program_nama')
                            // ->orderBy('program_id')
                            ->groupBy('program_no')
                            ->get();
                        //     return $indikator_program;
        $target_program =   DB::table('tp_program_rpjmd')
                            // ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('satuan','satuan.id','=','tp_program_rpjmd.satuan_id')
                            ->groupBy('tp_program_rpjmd.program_no')
                            ->get();
                            // return $target_program;


        
// return $periode->periode;

        return view('public.perencanaan.rpjmd',compact('visi','misi','tujuan','sasaran','periode','indikator_sasaran','target_sasaran','indikator_sasaran_rpjmd','program','indikator_program','target_program'))->with('no',1);
    }

    public function pkKab()
    {
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
	    
	    $target_pk = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
	            ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
	            ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t3 as target_t')
	            ->get();

       
		$tahun = 'target_t3';


        // $indikator_sasaran_rpjmd = DB::table('tp_program_rpjmd')
        //                     ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
        //                     ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
        //                     ->select('indikator_sasaran_rpjmd.id as is_id','indikator_sasaran_rpjmd.indikator_sasaran')
        //                     ->groupBy('is_id')
        //                     ->get();
        //                     // return $indikator_sasaran_rpjmd;
        // //                     
        // //                     
        // $program = DB::table('tp_program_rpjmd')
        //                     ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
        //                     ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
        //                     ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
        //                     ->select('indikator_sasaran_rpjmd.id as is_id','program.program_no','program.program_nama')
        //                     ->groupBy('program_no')
        //                     ->orderBy('program.program_no')
        //                     ->get();
        //                     // return $program; 

        // $indikator_program = DB::table('tp_program_rpjmd')
        //                     ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
        //                     ->select('tp_program_rpjmd.tp_program_id as tp_id','tp_program_rpjmd.program_no','program_rpjmd.indikator_program')
        //                     // ->orderBy('program_id')
        //                     ->groupBy('program_no')
        //                     ->get();
        //                     // return $indikator_program;
        // $target_program =   DB::table('tp_program_rpjmd')
        //                     // ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
        //                     ->join('satuan','satuan.id','=','tp_program_rpjmd.satuan_id')
        //                     ->groupBy('tp_program_rpjmd.program_no')
        //                     ->get();


        

         return view('public.perencanaan.pk', compact('sasaran','indikator_sasaran','target_pk','tahun'))->with('no',1);
    }

    public function rkt(){
        // $tujuan = [];
        // // return $tujuan;
        // $sasaran = [];

        // $indikator_sasaran = [];
        
        // $target_rkt = [];

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
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t3 as target_t')
                        ->get();

        $tahun = 'target_t3';
 
        return view('public.perencanaan.rkt', compact('target_rkt','tujuan','sasaran','indikator_sasaran','tahun'))->with('no',1);
    }

    public function dataPkKab(Request $request){

        if($request->tahun == 'target_t1')
            {

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
                
                $target_pk = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                        ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t1 as target_t')
                        ->get();
                        // return $target_pk;

            }
            elseif($request->tahun == 'target_t2')
            {
               

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
                
                $target_pk = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                        ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t2 as target_t')
                        ->get();
            }
            elseif($request->tahun == 'target_t3') 
            {
               

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
                
                $target_pk = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                        ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t3 as target_t')
                        ->get();

            }elseif($request->tahun == 'target_t4') 
            {

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
                
                $target_pk = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                        ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t4 as target_t')
                        ->get();
            }
            elseif($request->tahun == 'target_t5') 
            {
                

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
                
                $target_pk = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                        ->join('satuan','satuan.id','=','tp_is_rpjmd.satuan_id')
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t5 as target_t')
                        ->get();
            }

            $tahun=$request->tahun;

			// return $sasaran;
            // return $indikator_sasaran;
            // return $target_pk;

            

        return view('public.perencanaan.pk',compact('tahun','target_pk','sasaran','indikator_sasaran'))->with('no',1);
    }

    public function dataRktKab(Request $request){
        if($request->tahun == 'target_t1')
            {
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
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t1 as target_t')
                        ->get();
                        // return $target_rkt;

            }
            elseif($request->tahun == 'target_t2')
            {
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
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t2 as target_t')
                        ->get();
            }
            elseif($request->tahun == 'target_t3') 
            {
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
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t3 as target_t')
                        ->get();

            }elseif($request->tahun == 'target_t4') 
            {
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
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t4 as target_t')
                        ->get();
            }
            elseif($request->tahun == 'target_t5') 
            {
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
                        ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t5 as target_t')
                        ->get();
            }

            $tahun=$request->tahun;

            // return $target_rkt;

            

        return view('public.perencanaan.rkt',compact('tahun','target_rkt','tujuan','sasaran','indikator_sasaran'))->with('no',1);
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

        return view('public.perencanaan.rkt',compact('label','tahun','tujuan','sasaran','periode','indikator_sasaran','target_sasaran'))->with('no',1);
    }

    public function ikuRpjmd ()
    {
        $periode = Tujuan::join('misi','misi.id','=','tujuan_rpjmd.misi_id')->get();

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

        return view('public.perencanaan.iku', compact('sasaran','indikator_sasaran','iku','periode'))->with('no',1);
    }

    

    public function dataRenstra(Request $request)
    {
        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get();

        $misi =  TujuanRenstra::leftJoin('misi','misi.id','=','tujuan_renstra.misi_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 

        $tujuan = TujuanRenstra::where('tujuan_renstra.organisasi_no', $request->organisasi_no)
                    // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                //     ->orderBy('tujuan_nomor')
                //     ->groupBy('tujuan_nomor')
                    ->get();
                // return $tujuan;

        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('sasaran_nama', 'id')
                // ->orderBy('tujuan_nomor')
                ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaranRenstra::join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
                ->leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                ->where('indikator_sasaran_renstra.organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                ->select(
                        'indikator_sasaran_renstra.id as id',
                        'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                        'indikator_sasaran_renstra.kondisi_awal',
                        'indikator_sasaran_renstra.target_akhir',
                        'indikator_sasaran_renstra.organisasi_no',
                        'indikator_sasaran_renstra.sasaran_id',
                        'satuan.id as satuan_id',
                        'satuan.satuan_nama',
                        'tisr.id as target_is_id',
                        'tisr.tahun',
                        'tisr.target'
                )
                ->orderBy('indikator_sasaran_renstra.id')
                ->get();
                // return $indikator_sasaran;

        $indikator_tujuan =  IndikatorTujuanRenstra::join('satuan','satuan.id','=','indikator_tujuan_renstra.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                ->select('indikator_tujuan_renstra.indikator_tujuan as it_nama','satuan.satuan_nama','kondisi_akhir', 'indikator_tujuan_renstra.id')
                // ->orderBy('tujuan_nomor')
                // ->orderBy('it_nomor')
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

        return view('public.perencanaan.renstra', compact('opds','misi','tujuan','indikator_tujuan','sasaran','indikator_sasaran','program','kegiatan'));
    }

    public function RktOpd(Request $request)
    {
    	Session::put('organisasi_no', $request->organisasi_no);
    	
    		$tahun = date('Y');

    		$opd  = get_name_opd($request->organisasi_no);


	        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
	                ->select('tujuan_id','sasaran_nama', 'id')
	                ->orderBy('tujuan_id')
	                ->get();

                $indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                    ->select(
                            'indikator_sasaran_renstra.id as indikator_sasaran_id',
                            'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                            'indikator_sasaran_renstra.sasaran_id',
                            'satuan.satuan_nama',
                            'tisr.target', 
                            'tisr.tahun'
                            )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',$request->organisasi_no)
	                ->where('tisr.tahun', $tahun)
	                ->get();

	        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
	                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
	                    ->groupBy('program.program_no')
	                    ->get();


	        $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t3 as target','pagu_t3 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
	                    ->get();

                        dd($kegiatan);
        

        return view('public.perencanaan.rkt-opd', compact('tahun','opd','sasaran','indikator_sasaran','program','kegiatan'));
    }
    public function dataRktOpd(Request $request)
    {

    	$opds  = Organisasi::where('organisasi_no','=',Session::get('organisasi_no'))->get(['organisasi_nama']);

                        
        $sasaran =  SasaranRenstra::where('organisasi_no','=',Session::get('organisasi_no'))
	                ->select('tujuan_id','sasaran_nama', 'id')
	                ->orderBy('tujuan_id')
	                ->get();
	                // return $sasaran;
	    $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
	                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
	                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    ->groupBy('program.program_no')
	                    ->get();
                        
        $indikator_sasaran = [];

	    if($request->tahun == date('Y')-3)
	        {
                        
                        $indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')-3)
                        ->get();
                        
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select(
                                    'prokeg_renstra.program_no',
                                    'kegiatan.kegiatan_nama',
                                    'prokeg_renstra.kegiatan_no',
                                    'prokeg_renstra.indikator_kegiatan',
                                    'satuan.satuan_nama',
                                    'target_t1 as target',
                                    'pagu_t1 as pagu' 
                                    )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun== date('Y')-2){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')-2)
	                ->get();
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t2 as target','pagu_t2 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun == date('Y')-1){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')-1)
                        ->get();
                        
                        // dd(date('Y'));
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t3 as target','pagu_t3 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun==date('Y')){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y'))
	                ->get();
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t4 as target','pagu_t4 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun==date('Y')+1){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')+1)
	                ->get();
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t5 as target','pagu_t5 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }

	        $tahun=$request->tahun;

	                // return $indikator_sasaran;

	                // return $request->tahun;
	        return view('public.perencanaan.rkt-opd', compact('tahun','opds','sasaran','indikator_sasaran','program','kegiatan'));
    }

    public function dataIkuRenstra (Request $request) 
    {

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                ->get(); 

        $sasaran =  SasaranRenstra::leftJoin('indikator_sasaran_renstra as is','is.sasaran_id','sasaran_renstra.id')
                        ->leftJoin('iku', 'iku.indikator_sasaran_id', 'is.id')
                        ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'is.id')
                        ->leftJoin('satuan', 'satuan.id', 'is.satuan_id')
                        ->select(
                            'sasaran_renstra.id as sasaran_id',
                            'sasaran_renstra.sasaran_nama',
                            'is.id as indikator_sasaran_id',
                            'is.indikator_sasaran',
                            'iku.id as iku_id',
                            'iku.alasan',
                            'iku.formulasi',
                            'iku.sumber_data',
                            'iku.keterangan',
                            'cso.tahun',
                            'satuan.id',
                            'satuan.satuan_nama'
                        )
                        ->where('sasaran_renstra.organisasi_no','=',$request->organisasi_no)
                        ->get();

        return view('public.perencanaan.iku-opd', compact('opds','sasaran'));
    }

    public function pkOpd(Request $request)
    {
    	Session::put('organisasi_no', $request->organisasi_no);
    	
    		$tahun = 'target_t3';

    		$opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                // ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(['organisasi_nama']);


	        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
	                ->select('tujuan_id','sasaran_nama', 'id')
	                ->orderBy('tujuan_id')
	                ->get();
	                // return $sasaran;

	        $indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                    ->leftJoin('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                        'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                        'satuan.satuan_nama',
                        'tisr.target'
                    )
	                ->where('indikator_sasaran_renstra.organisasi_no','=',$request->organisasi_no)
                    ->where('tisr.tahun','=', date('Y')-1)
	                ->orderBy('indikator_sasaran_renstra.indikator_sasaran')
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
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','prokeg_renstra.target_t3 as target','prokeg_renstra.pagu_t3 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
	                    // ->groupBy('program.program_no')
	                    ->get();
	                    // return $kegiatan;

        return view('public.perencanaan.pk-opd', compact('tahun','opds','sasaran','indikator_sasaran','program','kegiatan'));
    }

    public function dataPkOpd(Request $request)
    {

    	$opds  = Organisasi::where('organisasi_no','=',Session::get('organisasi_no'))->get(['organisasi_nama']);

    	$sasaran =  SasaranRenstra::where('organisasi_no','=',Session::get('organisasi_no'))
	                ->get();
	                // return $sasaran;
	    $program = ProgKegRenstra::leftJoin('program','program.program_no','prokeg_renstra.program_no')
	                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
	                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    ->groupBy('program.program_no')
	                    ->get();

                        // return $program;

	    if($request->tahun == 'target_t1')
	        {
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')-3)
	                ->get();



	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t1 as target','pagu_t1 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun=='target_t2'){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')-2)
	                ->get();
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t2 as target','pagu_t2 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun=='target_t3'){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')-1)
	                ->get();
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t3 as target','pagu_t3 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun=='target_t4'){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y'))
	                ->get();
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t4 as target','pagu_t4 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }else if($request->tahun=='target_t5'){
	        	$indikator_sasaran =  IndikatorSasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                        ->join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
	                // ->where('tujuan')
	                ->select(
                                'indikator_sasaran_renstra.id as indikator_sasaran_id',
                                'indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama',
                                'indikator_sasaran_renstra.sasaran_id',
                                'satuan.satuan_nama',
                                'tisr.target', 
                                'tisr.tahun'
                                )
                        ->orderBy('indikator_sasaran_renstra.id')
                        ->where('indikator_sasaran_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                ->where('tisr.tahun', date('Y')+1)
	                ->get();
	            

	            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
	                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
	                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
	                    ->select('prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.kegiatan_no','prokeg_renstra.indikator_kegiatan','satuan.satuan_nama','target_t5 as target','pagu_t5 as pagu' )
	                    ->where('prokeg_renstra.organisasi_no','=',Session::get('organisasi_no'))
	                    // ->groupBy('program.program_no')
	                    ->get();

	        }

	        $tahun=$request->tahun;

	                // return $indikator_sasaran;

	    return view('public.perencanaan.pk-opd', compact('tahun','opds','sasaran','indikator_sasaran','program','kegiatan'));

	}
    
    
}
