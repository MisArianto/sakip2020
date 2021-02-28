<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Auth;
use Alert;
use App\Models\Misi;
use App\Models\Satuan;
use App\Models\Organisasi;
// use App\Models\RencanaStrategisTujuan as Tujuan;
// use App\Models\RencanaStrategisIndikatorTujuan as IndikatorTujuan;
// use App\Models\RencanaStrategisSasaran as Sasaran;
// use App\Models\RencanaStrategisIndikatorSasaran as IndikatorSasaran;
use App\Models\SasaranRenstra as Sasaran;
use App\Models\IndikatorSasaranRenstra as IndikatorSasaran;
use App\Models\IkuRenstra as Iku;
use App\Models\RencanaStrategisTargetIndikatorSasaran as TargetIS;
use App\Models\GetApiController;
// use App\Http\Controllers\Api\GetApiController;
use Illuminate\Http\Request;

class IkuRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        GetApiController::get_api('iku_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');

        if(Auth::user()->level == 2){
            $opd = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
            ->get();;
            // return $opd;

            $sasaran =  Sasaran::leftJoin('indikator_sasaran_renstra as is','is.sasaran_id','sasaran_renstra.id')
                        ->leftJoin('iku', 'iku.indikator_sasaran_id', 'is.id')
                        ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'is.id')
                        ->leftJoin('satuan', 'satuan.id', 'is.satuan_id')
                        ->select(
                            'sasaran_renstra.id as sasaran_id',
                            'sasaran_renstra.sasaran_nama',
                            'is.id as indikator_sasaran_id',
                            'is.indikator_sasaran',
                            'iku.iku_id',
                            'iku.alasan',
                            'iku.formulasi',
                            'iku.sumber_data',
                            'iku.keterangan',
                            'cso.tahun'
                        )
                        ->where('sasaran_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                        ->get();
                // return $sasaran;

        

            $indikator_sasaran =  Iku::join('indikator_sasaran as is','is.id','iku.indikator_sasaran_id')
                ->leftJoin('satuan','satuan.id','=','is.satuan_id')
                ->where('iku.organisasi_no','=',Auth::user()->organisasi_no)
                ->where('iku.tahun','2019')
                // ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;

            
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        $sasaran =  [];
        $indikator_sasaran =  [];
        }

        
        $tahun = '2019';
        $opds=[];
        

        return view('app.perencanaan.iku_renstra.index', compact('opds','opd','indikator_sasaran','sasaran','tahun','opds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function dataIku (Request $request) 
    {
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        }



        // $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
        //         ->select('organisasi_no','organisasi_nama')
        //         ->get(); 
                // return $opds;
        $opds = [];

        // $sasaran =  Sasaran::where('organisasi_no','=',$request->organisasi_no)
        //         ->select('tujuan_id','sasaran_nomor','sasaran_nama', 'organisasi_no', 'tujuan_id')
        //         ->orderBy('tujuan_id')
        //         ->get();
                    // return $sasaran;
        $sasaran =  Sasaran::leftJoin('indikator_sasaran_renstra as is','is.sasaran_id','sasaran_renstra.id')
                        ->leftJoin('capaian_sasaran_opd as cso', 'cso.indikator_sasaran_id', 'is.id')
                        ->leftJoin('iku', 'iku.indikator_sasaran_id', 'is.id')
                        ->leftJoin('satuan', 'satuan.id', 'is.satuan_id')
                        ->select(
                            'sasaran_renstra.id as sasaran_id',
                            'sasaran_renstra.sasaran_nama',
                            'is.id as indikator_sasaran_id',
                            'is.indikator_sasaran',
                            'iku.id as iku_id',
                            'iku.alasan',
                            'iku.formulasi',
                            'iku.sumber_data',
                            'iku.keterangan',
                            'cso.tahun'
                        )
                        ->where('sasaran_renstra.organisasi_no','=',$request->organisasi_no)
                        ->where('cso.tahun','=',$request->tahun)
                        ->get();

                    // return $sasaran;
        
        $indikator_sasaran =  Iku::join('indikator_sasaran as is','is.id','iku.indikator_sasaran_id')
                ->leftJoin('satuan','satuan.id','=','is.satuan_id')
                ->where('iku.organisasi_no','=',$request->organisasi_no)
                ->where('iku.tahun','=',$request->tahun)
                // ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;
        $tahun = $request->tahun;
        $opds=$request->organisasi_no;

        return view('app.perencanaan.iku_renstra.index', compact('opd','opds','indikator_sasaran','sasaran','tahun','opds'));
    }

    public function create()
    {
        if(Auth::user()->level == 2){
            $orgs = Organisasi::orderBy('organisasi_no')
                    ->where('organisasi_no', Auth::user()->organisasi_no)->first();

            $indikator_sasarans = IndikatorSasaran::where('organisasi_no', $orgs->organisasi_no)->get();
        }else{
            $orgs = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $indikator_sasarans = IndikatorSasaran::get();
        }
        // return $opd;

        // $tujuans = TujuanRenstra::get();
        // $satuans = Satuan::get();
        // $programs = Program::get();
        // $kegiatans = Kegiatan::get();
     // return $tujuan;

        // return view('app.perencanaan.renstra.sasaran.tambah', compact ('opd','tujuan'));
        return view('app.perencanaan.iku_renstra.add', compact('orgs', 'indikator_sasarans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        if(Auth::user()->level == 1)
        {
            $this->validate($request, [
                'organisasi_no' => 'required',
                'indikator_sasaran_id' => 'required',
                'tahun' => 'required',
                'alasan' => 'required',
                'formulasi' => 'required',
                'sumber_data' => 'required',
                'keterangan' => 'required',
            ]);
        }
        else 
        {
            $this->validate($request, [
                'indikator_sasaran_id_user' => 'required',
                'tahun' => 'required',
                'alasan' => 'required',
                'formulasi' => 'required',
                'sumber_data' => 'required',
                'keterangan' => 'required',
            ]);
        }
            
            $model = new Iku;
            
            if(Auth::user()->level == 1){
                $model->organisasi_no          = $request->organisasi_no;
                $model->indikator_sasaran_id   = $request->indikator_sasaran_id;
                $model->tahun   = $request->tahun;
                $model->alasan   = $request->alasan;
                $model->formulasi   = $request->formulasi;
                $model->sumber_data   = $request->sumber_data;
                $model->keterangan   = $request->keterangan;
            }

            if(Auth::user()->level == 2){
                $model->organisasi_no        = Auth::user()->organisasi_no;
                $model->indikator_sasaran_id = $request->indikator_sasaran_id_user;
                $model->tahun   = $request->tahun;
                $model->alasan   = $request->alasan;
                $model->formulasi   = $request->formulasi;
                $model->sumber_data   = $request->sumber_data;
                $model->keterangan   = $request->keterangan;
            }

            $model->save();

            Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
            return redirect('perencanaan/iku-renstra');
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
        $model = Iku::where('iku_id', $id)->first();
        $model->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');
        return redirect('perencanaan/iku-renstra');
    }
}
