<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\TujuanRpjmd;
use App\Models\ProgramRpjmd;
use App\Models\GetApiController;
// use App\Http\Controllers\Api\GetApiController;
use Illuminate\Http\Request;

class RpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // GetApiController::get_api('target_program_rpjmd', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('program_rpjmd', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('misi', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('visi', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('tujuan_rpjmd', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('sasaran_rpjmd', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('indikator_program_rpjmd', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('indikator_sasaran_rpjmd', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');

        $periode = Visi::groupBy('periode')->get();

        $visi = Visi::get();

        $misi = Misi::get();

        $tujuan = TujuanRpjmd::join('misi','misi.id','=','tujuan_rpjmd.misi_id')->get();
        
        // return $tujuan;

        $sasaran = DB::table('tp_is_rpjmd')->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','tp_is_rpjmd.indikator_sasaran_id')
                ->leftJoin('sasaran_rpjmd','sasaran_rpjmd.id','=','indikator_sasaran_rpjmd.sasaran_id')
                // ->leftJoin('tujuan_rpjmd','tujuan_rpjmd.id','=','sasaran_rpjmd.tujuan_id')
                ->groupBy('sasaran_rpjmd.id')
                // ->select('sasaran_rpjmd.id','sasaran_rpjmd.tujuan_id','sasaran_rpjmd.sasaran_nama')
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

        $indikator_sasarans = ProgramRpjmd::join('indikator_sasaran_rpjmd as is','is.id','=','program_rpjmd.indikator_sasaran_id')
                            ->groupBy('indikator_sasaran_id')
                            ->get(['indikator_sasaran_id','indikator_sasaran']);

        $program = ProgramRpjmd::join('program','program.program_no','=','program_rpjmd.program_no')
                ->get(['indikator_sasaran_id','program.program_no','program.program_nama']);
                // return $program;

        $target_program =   DB::table('tp_program_rpjmd')
                            // ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('satuan','satuan.id','=','tp_program_rpjmd.satuan_id')
                            ->groupBy('tp_program_rpjmd.program_no')
                            ->get();

        $programs = DB::table('program_rpjmd')->leftJoin('program', 'program.program_no', 'program_rpjmd.program_no')
                        ->leftJoin('indikator_program_rpjmd as ipr', 'ipr.program_rpjmd_id', 'program_rpjmd.id')
                        // ->leftJoin('target_ip_rpjmd as tipr', 'tipr.indikator_program_id', 'ipr.id')
                        ->leftJoin('satuan', 'satuan.id', 'ipr.satuan_id')
                        ->select(
                            'program_rpjmd.id as program_rpjmd_id',
                            'program.program_nama',
                            'ipr.id as indikator_program_id',
                            'ipr.indikator_program_nama',
                            'ipr.kondisi_awal as perencanaan_awal',
                            // 'tipr.id as target_indikator_program_id',
                            // 'tipr.tahun',
                            // 'tipr.target',
                            // 'tipr.pagu',
                            'satuan.satuan_nama'
                        )
                        // ->where('tipr.tahun', date('Y') - 1)
                        ->get();

    $targets = DB::table('target_ip_rpjmd')->get();

    // return collect($targets)->where('indikator_program_id',2)->where('tahun', '2017')->first()->target;

                        // return $targets;

       
         return view('app.perencanaan.rpjmd.index', compact('visi','misi','periode','tujuan','sasaran','indikator_sasaran','target_sasaran','indikator_sasarans','program','target_program', 'programs', 'targets'))->with('no',1);
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
