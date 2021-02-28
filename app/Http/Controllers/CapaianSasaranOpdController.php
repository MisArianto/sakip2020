<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use Illuminate\Http\Request;
use App\Models\CapaianSasaranOpd;
class CapaianSasaranOpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $capaian_sasaran = [];
        $opds = [];

        if(Auth::user()->level != 1){

                $orgs = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('is.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

            }else{
                $orgs = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);

            }


        return view('app.capaian.sasaran.index', compact('orgs','opds', 'capaian_sasaran'))->with('no',1);
    }


    public function dataSasaran(Request $request)
    {

            if(Auth::user()->level != 1){

                $orgs = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('is.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                $opds = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->where('is.organisasi_no', Auth::user()->organisasi_no)
                    ->groupBy('org.organisasi_no')
                    ->get(['org.organisasi_nama']);

                $tahun = $request->tahun;
                $organisasi_no = Auth::user()->organisasi_no;

                $capaian_sasaran = $this->percabangan($tahun, $organisasi_no);

            }else{

                if ($request->organisasi_no == '') {
                    Alert::warning('Pilih OPD!!')->persistent('Close');

                    return redirect('capaian/sasaran');
                }

                if ($request->tahun == '') {
                    Alert::warning('Pilih Tahun!!')->persistent('Close');

                    return redirect('capaian/sasaran');
                }

                $orgs = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                $opds = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                    ->where('is.organisasi_no', $request->organisasi_no)
                    ->groupBy('org.organisasi_no')
                    ->get(['org.organisasi_nama']);

                $tahun = $request->tahun;
                $organisasi_no = $request->organisasi_no;

                $capaian_sasaran = $this->percabangan($tahun, $organisasi_no);

            }


        return view('app.capaian.sasaran.index', compact('orgs','opds', 'capaian_sasaran'))->with('no',1);
    }


    function percabangan($tahun, $organisasi_no)
    {

        if($tahun == '2017')
            {
               return CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('is.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran_nama','satuan.satuan_nama', 'is.target_t1 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4']);

            }
            elseif($tahun == '2018')
            {
                return $capaian_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('is.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran_nama','satuan.satuan_nama', 'is.target_t2 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4']);
            }
            elseif($tahun == '2019') 
            {
                return $capaian_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('is.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran_nama','satuan.satuan_nama', 'is.target_t3 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4']);
            }
            elseif($tahun == '2020')
            {
                return $capaian_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('is.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran_nama','satuan.satuan_nama', 'is.target_t4 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4']);
            
            }
            elseif($tahun == '2021')
            {
                return $capaian_sasaran = CapaianSasaranOpd::join('indikator_sasaran as is','is.id','=','capaian_sasaran_opd.indikator_sasaran_id')
                                    ->join('satuan', 'satuan.id', '=', 'is.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','is.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('is.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','is.indikator_sasaran_nama','satuan.satuan_nama', 'is.target_t5 as target_t' , 'tw_1','tw_2', 'tw_3', 'tw_4']);
            
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
