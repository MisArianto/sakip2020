<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Alert;
use App\Models\Misi;
use App\Models\Satuan;
use App\Models\Organisasi;
use App\Models\RencanaStrategisTujuan as Tujuan;
use App\Models\RencanaStrategisIndikatorTujuan as IndikatorTujuan;
use App\Models\RencanaStrategisSasaran as Sasaran;
use App\Models\RencanaStrategisIndikatorSasaran as IndikatorSasaran;
use App\Models\RencanaStrategisProgram as Program;
use App\Models\RencanaStrategisIndikatorProgram as IndikatorProgram;
use App\Models\RencanaStrategisKegiatan as Kegiatan;
use App\Models\RencanaStrategisIndikatorKegiatan as IndikatorKegiatan;
use App\Models\RencanaStrategisTargetIndikatorSasaran as TargetIS;
use Illuminate\Http\Request;

class RenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return 'test';
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

      
                    $misi =  Tujuan::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                ->where('tujuan.organisasi_no','=',Auth::user()->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 
                    // return $misi;

            $tujuan = Tujuan::where('organisasi_no', Auth::user()->organisasi_no)->get();
                    // return $tujuan;
            $indikator_tujuan = IndikatorTujuan::join('satuan', 'satuan.id', '=', 'indikator_tujuan.satuan_id')->where('organisasi_no', Auth::user()->organisasi_no)->get();

            // return $indikator_tujuan;

            // $indikator_tujuan =  IndikatorTujuan::join('satuan','satuan.id','=','indikator_tujuan.satuan_id')
            //         ->where('organisasi_no','=',Auth::user()->organisasi_no)
            //         // ->where('tujuan')
            //         ->select('tujuan_nomor','indikator_tujuan_nomor as it_nomor','indikator_tujuan_nama as it_nama','satuan_nama','kondisi_akhir', 'indikator_tujuan.id')
            //         ->orderBy('tujuan_nomor')
            //         ->orderBy('it_nomor')
            //         ->get();

            // $sasaran =  SasaranRenstra::where('organisasi_no','=',Auth::user()->organisasi_no)
            //         ->select('tujuan_nomor','sasaran_nomor','sasaran_nama', 'sasaran_id')
            //         ->orderBy('tujuan_nomor')
            //         ->get();
            //         // return $sasaran;

            // $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
            //         ->where('organisasi_no','=',Auth::user()->organisasi_no)
            //         // ->where('tujuan')
            //         // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
            //         ->orderBy('indikator_sasaran_nomor')
            //         ->get();

            // $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
            //             // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
            //             // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
            //             ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
            //             ->groupBy('program.program_no')
            //             ->get();

            //             // return $program;

            // $kegiatan = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
            //             ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
            //             ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
            //             // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
            //             // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
            //             ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
            //             // ->groupBy('program.program_no')
            //             ->get();

            // return $indikator_tujuan;
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();

            $misi = [];
            $tujuan = [];
            $indikator_tujuan = [];
        }
            $sasaran = [];
            $indikator_sasaran = [];
            $program = [];
            $kegiatan = [];
            $opds = [];
        // return $opd;
         return view('app.perencanaan.renstra.index', compact('opds','opd','misi','tujuan', 'indikator_tujuan','sasaran','indikator_sasaran','program','kegiatan'));
    }

    public function dataRenstra (Request $request) 
    {
        if(Auth::user()->level != 1){
            $opd = Organisasi::orderBy('organisasi_no')
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

        $misi =  Tujuan::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                ->where('organisasi_no','=',$request->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 
                // return $misi;

        $tujuan =  Tujuan::where('organisasi_no','=',$request->organisasi_no)
                ->select('misi_nomor','tujuan_nomor','tujuan_nama','tujuan_id')
                ->orderBy('misi_nomor')
                ->orderBy('tujuan_nomor')
                ->get();
                // return $tujuan;

        $indikator_tujuan =  IndikatorTujuan::join('satuan','satuan.id','=','indikator_tujuan.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                ->select('tujuan_nomor','indikator_tujuan_nomor as it_nomor','indikator_tujuan_nama as it_nama','satuan_nama','kondisi_akhir', 'indikator_tujuan.id')
                ->orderBy('tujuan_nomor')
                ->orderBy('it_nomor')
                ->get();
                // return $indikator_tujuan;
                
        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('tujuan_nomor','sasaran_nomor','sasaran_nama', 'sasaran_id')
                ->orderBy('tujuan_nomor')
                ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_nomor')
                ->get();


        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

                    // return $program;

        $kegiatan = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();
                // return $kegiatan;

        return view('app.perencanaan.renstra.index', compact('opd','opds','misi','tujuan','indikator_tujuan','sasaran','indikator_sasaran','program','kegiatan'));
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
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            // $misi = Tujuan::join('misi','misi.id','=','tujuan.misi_id')
            //         ->where('tujuan.organisasi_no', Auth::user()->organisasi_no)
            //         ->groupBy('tujuan.misi_id')
            //         ->get();

                    $misi =  Tujuan::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                ->where('tujuan.organisasi_no','=',Auth::user()->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 

            // return $misi;
            $tujuan = Tujuan::where('id', $id)->first();

            $indikator_tujuan = IndikatorTujuan::join('satuan', 'satuan.id', '=', 'indikator_tujuan.satuan_id')->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $sasaran = Sasaran::where('organisasi_no', Auth::user()->organisasi_no)->get();

        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $tujuan = Tujuan::where('tujuan_id', $id)->first();
            $misi = [];

            $indikator_tujuan = [];
            $sasaran = [];
        }

        return view('app.perencanaan.renstra.tujuan.editTujuan', compact ('misi','opd', 'tujuan','indikator_tujuan','sasaran'))->with('no', 1);


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
