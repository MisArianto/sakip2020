<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use Illuminate\Http\Request;
use App\Models\CapaianKegiatanOpd;

class CapaianKegiatanOpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $capaian_kegiatan = [];
        $opds = [];

        if(Auth::user()->level != 1){

                $orgs = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('pr.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

            }else{
                $orgs = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);


            }


        return view('app.capaian.kegiatan.index', compact('orgs','opds', 'capaian_kegiatan'))->with('no',1);
    }

    public function dataKegiatan(Request $request)
    {

            if(Auth::user()->level != 1){

                $orgs = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->where('pr.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                $opds = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->where('pr.organisasi_no', Auth::user()->organisasi_no)
                    ->get(['org.organisasi_nama']);

                $tahun = $request->tahun;
                $organisasi_no = Auth::user()->organisasi_no;

                $capaian_kegiatan = $this->percabangan($tahun, $organisasi_no);

            }else{

                if ($request->organisasi_no == '') {
                    Alert::warning('Pilih OPD!!')->persistent('Close');

                    return redirect('capaian/kegiatan');
                }

                if ($request->tahun == '') {
                    Alert::warning('Pilih Tahun!!')->persistent('Close');

                    return redirect('capaian/kegiatan');
                }

                $orgs = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->orderBy('org.organisasi_no')
                    ->get(['org.organisasi_no','org.organisasi_nama']);

                $opds = CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                    ->groupBy('org.organisasi_no')
                    ->where('pr.organisasi_no', $request->organisasi_no)
                    ->get(['org.organisasi_nama']);


                $tahun = $request->tahun;
                $organisasi_no = $request->organisasi_no;

                $capaian_kegiatan = $this->percabangan($tahun, $organisasi_no);
            }


        return view('app.capaian.kegiatan.index', compact('orgs','opds', 'capaian_kegiatan'))->with('no',1);
    }


    function percabangan($tahun, $organisasi_no)
    {

        if($tahun == '2017')
            {
               return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t1 as target_t', 'tw_1','tw_2', 'tw_3', 'tw_4']);

            }
            elseif($tahun == '2018')
            {
               return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t2 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            }
            elseif($tahun == '2019') 
            {
                return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t3 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            }
            elseif($tahun == '2020')
            {
                return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t4 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            
            }
            elseif($tahun == '2021')
            {
                return CapaianKegiatanOpd::join('prokeg_renstra as pr','pr.renstra_id','=','capaian_kegiatan_opd.renstra_id')
                                    ->join('satuan', 'satuan.id', '=', 'pr.satuan_id')
                                    ->leftJoin('organisasi as org','org.organisasi_no','=','pr.organisasi_no')
                                    ->orderBy('org.organisasi_no')
                                    ->where('pr.organisasi_no', $organisasi_no)
                                    ->get(['org.organisasi_no','org.organisasi_nama','pr.indikator_kegiatan','satuan.satuan_nama', 'pr.target_t5 as target_t','tw_1','tw_2', 'tw_3', 'tw_4']);
            
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
