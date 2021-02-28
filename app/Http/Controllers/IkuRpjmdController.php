<?php

namespace App\Http\Controllers;

use DB;
use App\Models\IndikatorSasaranRpjmd as is_rpjmd;
use App\Models\TujuanRpjmd as Tujuan;
use App\Models\SasaranRpjmd as Sasaran;
use App\Models\IkuRpjmd as iku;
use Illuminate\Http\Request;

class IkuRpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        return view('app.perencanaan.iku.index', compact('sasaran','indikator_sasaran','iku','periode'))->with('no',1);
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
