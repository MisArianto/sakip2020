<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TujuanRpjmd;
use Illuminate\Http\Request;

class TujuanRpjmdController extends Controller
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
        $misi = TujuanRpjmd::join('misi','misi.id','=','tujuan_rpjmd.misi_id')
                ->groupBy('misi.id')
                ->orderBy('misi.id')
                ->get();
                // return $misi;
        $tujuan = TujuanRpjmd::join('misi','misi.id','=','tujuan_rpjmd.misi_id')->get();
        // return $tujuan;


       
         return view('app.perencanaan.rpjmd.tujuan_rpjmd', compact('tujuan','misi','periode'));
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
     * @param  \App\TujuanRpjmd  $tujuanRpjmd
     * @return \Illuminate\Http\Response
     */
    public function show(TujuanRpjmd $tujuanRpjmd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TujuanRpjmd  $tujuanRpjmd
     * @return \Illuminate\Http\Response
     */
    public function edit(TujuanRpjmd $tujuanRpjmd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TujuanRpjmd  $tujuanRpjmd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TujuanRpjmd $tujuanRpjmd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TujuanRpjmd  $tujuanRpjmd
     * @return \Illuminate\Http\Response
     */
    public function destroy(TujuanRpjmd $tujuanRpjmd)
    {
        //
    }
}
