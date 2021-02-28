<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Organisasi;
use App\Models\Sasaran;
use App\Models\Tujuan;
use Illuminate\Http\Request;

class SasaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisasis = Organisasi::where('organisasi_jenis', 'ORG')->get();
        $sasarans = Sasaran::get();
        return view('app.sasaran.index', compact('sasarans', 'organisasis'))->with('no', 1); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->level != 1) {
            $org = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first();
            $tujuan = Tujuan::where('organisasi_no', $org->organisasi_no)->get();
        } else {
            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
        }
        
        return view('app.sasaran.add', compact('orgs', 'tujuan'));
    }

    public function ajax($org_no)
    {
        $org = Organisasi::where('organisasi_no', $org_no)->first();
        $tujuan = Tujuan::where('organisasi_no', $org->organisasi_no)->get();

        return response()->json($tujuan);
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
     * @param  \App\Sasaran  $sasaran
     * @return \Illuminate\Http\Response
     */
    public function show(Sasaran $sasaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sasaran  $sasaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Sasaran $sasaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sasaran  $sasaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sasaran $sasaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sasaran  $sasaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sasaran $sasaran)
    {
        //
    }
}
