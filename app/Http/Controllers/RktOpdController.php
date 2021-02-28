<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Alert;
use App\Models\Satuan;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\Organisasi;
use App\Models\TujuanRenstra as Tujuan;
use App\Models\ProgKegRenstra;
use App\Models\SasaranRenstra;
use App\Models\IndikatorSasaranRenstra as IndikatorSasaran;
use App\Models\IndikatorProgramRenstra;
use Illuminate\Http\Request;

class RktOpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $opds  = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;

            $tujuan = Tujuan::where('tujuan_renstra.organisasi_no', Auth::user()->organisasi_no)
                        // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                        ->orderBy('id')
                        ->groupBy('id')
                        ->get();
                    // return $tujuan;

            $sasaran =  SasaranRenstra::where('organisasi_no','=',Auth::user()->organisasi_no)
                    ->select('tujuan_id','sasaran_nomor','sasaran_nama')
                    ->orderBy('tujuan_id')
                    ->get();
                    // return $sasaran;

            $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id_api','=','indikator_sasaran_renstra.satuan_id')
                    ->where('organisasi_no','=',Auth::user()->organisasi_no)
                    // ->where('tujuan')
                    // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                    ->orderBy('indikator_sasaran')
                    ->get();
                    // return $indikator_sasaran;

            $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                        // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                        // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                        ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                        ->groupBy('program.program_no')
                        ->get();

             $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                        ->join('satuan','satuan.id_api','=','prokeg_renstra.satuan_id')
                        // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                        // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                        ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                        // ->groupBy('program.program_no')
                        ->get();


        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $opds = [];
            $sasaran = [];
            $tujuan = [];
            $indikator_sasaran = [];
            $program = [];
            $kegiatan = [];
        }

        
        // dd($request->organisasi_no);
        return view('app.perencanaan.rkt.sasaran.index', compact('opds','opd','tujuan','indikator_sasaran','sasaran','program','kegiatan'));
    }

    public function dataRKT (Request $request) 
    {
        if(Auth::user()->level != 1){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        }

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;

        $tujuan = Tujuan::where('tujuan_renstra.organisasi_no', $request->organisasi_no)
                    // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                    ->orderBy('id')
                    ->groupBy('id')
                    ->get();
                // return $tujuan;

        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('id','sasaran_nomor','sasaran_nama')
                ->orderBy('id')
                ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
                // ->leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'indikator_sasaran_renstra.id')
                ->where('indikator_sasaran_renstra.organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_renstra.id')
                // ->where('tisr.tahun', date('Y'))
                ->get();
                // return $indikator_sasaran;

        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

         $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();


                
        return view('app.perencanaan.rkt.sasaran.index', compact('opd','opds','tujuan','sasaran','indikator_sasaran','program','kegiatan'));
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
