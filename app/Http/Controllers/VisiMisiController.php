<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\visi_misi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = visi_misi::groupBy('periode')
        ->get();
        $visi = visi_misi::where('tipe','=','visi')->get();
        $misi = visi_misi::where('tipe','=','misi')->get();

       
         return view('app.perencanaan.rpjmd.visi_misi', compact('visi','misi','periode'));
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
     * @param  \App\visi_misi  $visi_misi
     * @return \Illuminate\Http\Response
     */
    public function show(visi_misi $visi_misi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\visi_misi  $visi_misi
     * @return \Illuminate\Http\Response
     */
    public function edit(visi_misi $visi_misi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\visi_misi  $visi_misi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, visi_misi $visi_misi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\visi_misi  $visi_misi
     * @return \Illuminate\Http\Response
     */
    public function destroy(visi_misi $visi_misi)
    {
        //
    }
}
