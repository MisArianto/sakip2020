<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class RktController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tujuan = [];
        // return $tujuan;

        $sasaran = [];
        // return $sasaran;

        $indikator_sasaran = [];
        // return $indikator_sasaran;
        
        $target_rkt =[];
        // return $target_rkt;

        return view('app.perencanaan.rkt.kabupaten.index',compact('target_rkt','tujuan','sasaran','indikator_sasaran'))->with('no',1);
    }

    public function dataRkt(Request $request)
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
                // ->select('tp_is_rpjmd.indikator_sasaran_id','satuan.satuan_nama','tp_is_rpjmd.target_t3 as target')
                ->get();
        $label='2019';
        // return $target_rkt;

        return view('app.perencanaan.rkt.kabupaten.index',compact('label','target_rkt','tujuan','sasaran','indikator_sasaran'))->with('no',1);
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
