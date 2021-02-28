<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\SasaranRpjmd;
use App\Models\TujuanRpjmd;
use App\Models\IndikatorSasaranRpjmd;
use Illuminate\Http\Request;

class SasaranRpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = TujuanRpjmd::join('misi','misi.id','=','tujuan_rpjmd.misi_id')
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
        
         return view('app.perencanaan.rpjmd.sasaran_rpjmd', compact('tujuan','sasaran','periode','indikator_sasaran','target_sasaran'))->with('no',1);
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
     * @param  \App\SasaranRpjmd  $sasaranRpjmd
     * @return \Illuminate\Http\Response
     */
    public function show(SasaranRpjmd $sasaranRpjmd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SasaranRpjmd  $sasaranRpjmd
     * @return \Illuminate\Http\Response
     */
    public function edit(SasaranRpjmd $sasaranRpjmd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SasaranRpjmd  $sasaranRpjmd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SasaranRpjmd $sasaranRpjmd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SasaranRpjmd  $sasaranRpjmd
     * @return \Illuminate\Http\Response
     */
    public function destroy(SasaranRpjmd $sasaranRpjmd)
    {
        //
    }
}
