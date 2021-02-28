<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use Illuminate\Http\Request;
use App\Models\CapaianProgramOpd;

class CapaianProgramOpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $capaian_program = [];
        $opds = [];

        if(Auth::user()->level != 1){

                $orgs = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('ip.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

            }else{
                $orgs = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);


            }


        return view('app.capaian.program.index', compact('orgs','opds', 'capaian_program'))->with('no',1);
    }

    public function dataProgram(Request $request)
    {

            if(Auth::user()->level != 1){

                $orgs = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('ip.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                $opds = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->where('ip.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_nama']);

                $tahun = $request->tahun;
                $organisasi_no = Auth::user()->organisasi_no;

                $capaian_program = $this->percabangan($tahun, $organisasi_no);

            }else{

                if ($request->organisasi_no == '') {
                    Alert::warning('Pilih OPD!!')->persistent('Close');

                    return redirect('capaian/program');
                }

                if ($request->tahun == '') {
                    Alert::warning('Pilih Tahun!!')->persistent('Close');

                    return redirect('capaian/program');
                }

                $orgs = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                $opds = CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->where('ip.organisasi_no', $request->organisasi_no)
                    ->get(['org.organisasi_nama']);

                $tahun = $request->tahun;
                $organisasi_no = $request->organisasi_no;

                $capaian_program = $this->percabangan($tahun, $organisasi_no);
            }


        return view('app.capaian.program.index', compact('orgs','opds', 'capaian_program'))->with('no',1);
    }

    function percabangan($tahun, $organisasi_no)
    {

        if($tahun == '2017')
            {
               return CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('ip.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'ip.target_t1 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);

            }
            elseif($tahun == '2018')
            {
               return CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('ip.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'ip.target_t2 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            }
            elseif($tahun == '2019') 
            {
                return CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('ip.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'ip.target_t3 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            }
            elseif($tahun == '2020')
            {
                return CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('ip.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'ip.target_t4 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            
            }
            elseif($tahun == '2021')
            {
                return CapaianProgramOpd::join('indikator_program as ip','ip.indikator_program_id','=','capaian_program_opd.indikator_program_id')
                                    ->join('satuan', 'satuan.id', '=', 'ip.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','ip.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('ip.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','ip.indikator_program_nama','satuan.satuan_nama', 'ip.target_t5 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            
            }
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
