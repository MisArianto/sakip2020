<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Alert;
use Auth;
use App\Models\Misi;
// use App\Models\visi_misi as Misi;
use App\Models\Organisasi;
// use App\Models\Tujuan;
use App\Models\RencanaStrategisTujuan as Tujuan;
use App\Models\RencanaStrategisIndikatorTujuan as IndikatorTujuan;
use App\Models\Satuan;
use App\Models\TujuanRenstra;
use App\Http\Controllers\Api\GetApiController;
// use App\Models\IndikatorTujuanRenstra as IndikatorTujuan;
use Illuminate\Http\Request;

class TujuanRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $api = GetApiController::get_api('kegiatan', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        
        if(Auth::user()->level = 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $opds  = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 

                // return $opds;

            $misi =  TujuanRenstra::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                    ->where('organisasi_no','=',Auth::user()->organisasi_no)
                    ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                    ->groupBy('misi_no')
                    ->get(); 
                    // return $misi;

            $tujuan =  TujuanRenstra::where('organisasi_no','=',Auth::user()->organisasi_no)
                    ->select('misi_nomor','tujuan_nomor','tujuan_nama','tujuan_id')
                    // ->orderBy('misi_nomor', 'tujuan_nomor')
                    ->get();
                    // return $tujuan;

            $indikator_tujuan =  IndikatorTujuan::join('satuan','satuan.id','=','indikator_tujuan_renstra.satuan_id')
                    ->where('organisasi_no','=',Auth::user()->organisasi_no)
                    // ->where('tujuan')
                    ->select('tujuan_nomor','indikator_tujuan_nomor as it_nomor','indikator_tujuan_nama as it_nama','satuan_nama','kondisi_akhir', 'indikator_tujuan.id')
                    // ->orderBy('tujuan_nomor','it_nomor')
                    ->get();

            // return $indikator_tujuan;
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();

            $opds = [];
            $misi = [];
            $tujuan = [];
            $indikator_tujuan = [];
        }

        
        // dd($request->organisasi_no);
        return view('app.perencanaan.renstra.tujuan-old.index', compact('opds','opd','misi','tujuan', 'indikator_tujuan', 'api'));
        
    }

    public function dataRenstra (Request $request) 
    {
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        }

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;

        $misi =  TujuanRenstra::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                ->where('organisasi_no','=',$request->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 
                // return $misi;

        $tujuan =  TujuanRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('misi_nomor','tujuan_nomor','tujuan_nama','tujuan_id')
                ->orderBy('misi_nomor', 'tujuan_nomor')
                ->get();
                // return $tujuan;

        $indikator_tujuan =  IndikatorTujuan::join('satuan','satuan.id','=','indikator_tujuan_renstra.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                ->select('tujuan_nomor','indikator_tujuan_nomor as it_nomor','indikator_tujuan_nama as it_nama','satuan_nama','kondisi_akhir', 'indikator_tujuan.id')
                ->orderBy('tujuan_nomor','it_nomor')
                ->get();
                // return $indikator_tujuan;
                // 
        return view('app.perencanaan.renstra.tujuan-old.index', compact('opd','opds','misi','tujuan','indikator_tujuan'));
    }



    public function dataRenstra1(Request $request)
    {
            if(Auth::user()->level != 1){
                $opd = Organisasi::orderBy('organisasi_no')
                ->where('organisasi_jenis','=','ORG')
                ->where('organisasi_no', Auth::user()->organisasi_no)->get();
            }else{
                $opd = Organisasi::orderBy('organisasi_no')
                ->where('organisasi_jenis','=','ORG')
                ->get();
            }

            $misis = TujuanRenstra::join('visi_misi as misi','misi.nomor','=','tujuan.misi_nomor')
                    ->where('tujuan.organisasi_no', $request->organisasi_no)
                    ->groupBy('misi.nomor')
                    ->get();

            $tujuan = TujuanRenstra::where('tujuan.organisasi_no', $request->organisasi_no)
                    ->orderBy('tujuan_nomor')
                    // ->groupBy('')
                    ->get();
                    // return $tujuan;
                

            if(count($misis) > 0){
                foreach($misis as $data)
                {
                    $misi[] = [
                        'organisasi_no'=> $data->organisasi_no,
                        'nomor'=> $data->nomor,
                        'nama' => $data->nama,
                        
                    ];
                }
            }else{
                $misi = [];
            }   

            if(count($tujuan) > 0){
                foreach($tujuan as $data1)
                {
                    $tujuan[] = [
                        'misi_nomor' => $data1->misi_nomor,
                        'tujuan_nomor' => $data1->tujuan_nomor,
                        'tujuan_nama' => $data1->tujuan_nama,
                        
                    ];
                }
            }else{
                $tujuan = [];
            }
            // return $misi;



            // if(count($arr) > 0)
            // {
            //     foreach($arr as $value)
            //     {
            //         if($value['status'] == 0)
            //         {
            //             $misi = [
            //                 'nama' => $value['nama'],
                            
            //             ];

            //         }
            //     }
            // }else{
            //     $misi = [];
            // }
            return view('app.perencanaan.renstra.tujuan-old.index', compact('opd','misi','tujuan'));

        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        }

        $misi= Misi::where('tipe','misi')->get();

        return view('app.perencanaan.renstra.tujuan-old.tambah', compact ('misi','opd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'misi_nomor'       => 'required',
            'tujuan_nomor'     => 'required',
            'tujuan_nama'      => 'required',
            // 'organisasi_no' => 'required',
            
        ]);
        $t_renstra = new TujuanRenstra;
        $t_renstra->misi_nomor = $request->misi_nomor;
        $t_renstra->tujuan_nomor = $request->tujuan_nomor;
        $t_renstra->tujuan_nama = $request->tujuan_nama;
        if(Auth::user()->level == 1)
        {
            $t_renstra->organisasi_no = $request->opd;
        }else{
            $t_renstra->organisasi_no = Auth::user()->organisasi_no;
        }
        $t_renstra->save();

  
        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        // Alert::success('Berhasil', 'Data Berhasil Disimpan.');
        return redirect('perencanaan/renstra-tujuan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TujuanRenstra  $tujuanRenstra
     * @return \Illuminate\Http\Response
     */
    public function show(TujuanRenstra $tujuanRenstra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TujuanRenstra  $tujuanRenstra
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if(Auth::user()->level == 2){
        //     $opd = Organisasi::orderBy('organisasi_no')
        //     ->where('organisasi_no', Auth::user()->organisasi_no)->get();

        //     $t_renstra = TujuanRenstra::where('tujuan_id', $id)->first();
        // }else{
        //     $opd = Organisasi::orderBy('organisasi_no')
        //     ->where('organisasi_jenis','=','ORG')
        //     ->get();
        //     $t_renstra = TujuanRenstra::where('tujuan_id', $id)->first();
        // }

        // $misi= Misi::where('tipe','misi')->get();

        // return view('app.perencanaan.renstra.tujuan-old.editTujuan', compact ('misi','opd', 't_renstra'));

        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $tujuan = Tujuan::where('id', $id)->first();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $tujuan = Tujuan::where('id', $id)->first();
        }

        $misi= Misi::get();

        return view('app.perencanaan.renstra.tujuan.editTujuan', compact ('misi','opd', 'tujuan'));
    }

    public function editIndikatorRenstra($id)
    {
        // if(Auth::user()->level != 1){
        //     $opds = Organisasi::orderBy('organisasi_no')
        //     ->where('organisasi_jenis','=','ORG')
        //     ->where('organisasi_no', Auth::user()->organisasi_no)->get();

        //     $model = IndikatorTujuan::where('id', $id)->first();
        // }else{
        //     $opds = Organisasi::orderBy('organisasi_no')
        //     ->where('organisasi_jenis','=','ORG')
        //     ->get();
        //     $model = IndikatorTujuan::where('id', $id)->first();
        // }
        // $satuans = Satuan::get();
        // $misi= Misi::where('tipe','misi')->get();

        // return view('app.perencanaan.renstra.tujuan-old.editIndikator', compact ('misi','opds', 'model', 'satuans'));

        if(Auth::user()->level != 1){
            $opds = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $model = IndikatorTujuan::where('id', $id)->first();
            $tujuans = Tujuan::get();
        }else{
            $opds = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $model = IndikatorTujuan::where('id', $id)->first();
            $tujuans = Tujuan::get();
        }
        $satuans = Satuan::get();
        $misi= Misi::get();

        return view('app.perencanaan.renstra.tujuan.editIndikatorNew', compact ('misi','opds', 'model', 'satuans', 'tujuans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TujuanRenstra  $tujuanRenstra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'misi_nomor'       => 'required',
            'tujuan_nomor'     => 'required',
            'tujuan_nama'      => 'required',
            // 'organisasi_no' => 'required',
            
        ]);

        DB::table('tujuan')->where('tujuan_id', $id)->update([
            'misi_nomor' => $request->misi_nomor,
            'tujuan_nomor' => $request->tujuan_nomor,
            'tujuan_nama' => $request->tujuan_nama,
            'organisasi_no' => $request->opd
        ]);

  
        Alert::success('Berhasil', 'Data Berhasil Di Update')->persistent('Close');
        // Alert::success('Berhasil', 'Data Berhasil Disimpan.');
        return redirect('perencanaan/renstra-tujuan');

        
        
    }

    public function updateIndikatorRenstra(Request $request, $id)
    {
        // return $request;
        // $this->validate($request, [
        //     'indikator_tujuan_nomor'    => 'required',
        //     'indikator_tujuan_nama'     => 'required',
        //     'satuan_id'                 => 'required',
        //     'kondisi_akhir'             => 'required'
        // ]);

        // $indikator = IndikatorTujuan::findOrfail($id);
        // $indikator->indikator_tujuan_nomor  = $request->indikator_tujuan_nomor;
        // $indikator->indikator_tujuan_nama   = $request->indikator_tujuan_nama;
        // $indikator->satuan_id               = $request->satuan_id;
        // $indikator->kondisi_akhir           = $request->kondisi_akhir;
        // $indikator->save();

        // Alert::success('Berhasil', 'Data Berhasil Dirubah.')->persistent('Close');
        // return redirect('perencanaan/renstra-tujuan/dataRenstra');

        $this->validate($request, [
            'tujuan_id'    => 'required',
            'indikator_tujuan'     => 'required',
            'satuan_id'                 => 'required',
            'kondisi_akhir'             => 'required'
        ]);

        $indikator = IndikatorTujuan::findOrfail($id);
        $indikator->tujuan_id  = $request->tujuan_id;
        $indikator->indikator_tujuan   = $request->indikator_tujuan;
        $indikator->satuan_id               = $request->satuan_id;
        $indikator->kondisi_akhir           = $request->kondisi_akhir;
        $indikator->organisasi_no           = $request->organisasi_no;
        $indikator->save();

        Alert::success('Berhasil', 'Data Berhasil Dirubah.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TujuanRenstra  $tujuanRenstra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;
        // DB::table('tujuan')->where('tujuan_id', $id)->delete();

        // Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
        // return redirect('perencanaan/renstra-tujuan');

        DB::table('tujuan_renstra')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    public function destroyIndikatorRenstra($id)
    {
        // return $id;
        // DB::table('indikator_tujuan')->where('id', $id)->delete();

        // Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
        // return redirect('perencanaan/renstra-tujuan');

        DB::table('indikator_tujuan_renstra')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }


    public function createIndikatorRenstra()
    {
        if (Auth::user()->level != 1) {
            
            $orgs = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first();
            $tujuans = Tujuan::where('organisasi_no', Auth::user()->organisasi_no)->get(); 
            $satuans = Satuan::get();

        }else{

            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
            $satuans = Satuan::get();
            
        }
        // return $orgs;

        return view('app.perencanaan.renstra.tujuan-old.addIndikator', compact('orgs', 'tujuans', 'satuans'));
        
    }

    public function storeIndikatorRenstra(Request $request)
    {
        $this->validate($request, [
            // 'organisasi_no'             => 'required',
            'tujuan_nomor'              => 'required',
            'indikator_tujuan_nomor'    => 'required',
            'indikator_tujuan_nama'     => 'required',
            'satuan_id'                 => 'required',
            'kondisi_akhir'             => 'required'
        ]);

        $indikator = new IndikatorTujuan;
        
        if(Auth::user()->level == 1)
        {
            $indikator->organisasi_no            = $request->organisasi_no;
        }else{
            $indikator->organisasi_no            = Auth::user()->organisasi_no;
        }

        $indikator->tujuan_nomor            = $request->tujuan_nomor;
        $indikator->indikator_tujuan_nomor  = $request->indikator_tujuan_nomor;
        $indikator->indikator_tujuan_nama   = $request->indikator_tujuan_nama;
        $indikator->satuan_id               = $request->satuan_id;
        $indikator->kondisi_akhir           = $request->kondisi_akhir;
        // $indikator->organisasi_no           = $request->organisasi_no;
        $indikator->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        return redirect('perencanaan/renstra-tujuan');

    }

    public function ajaxTujuanRenstra($org_no)
    {
        $org = Organisasi::where('organisasi_no', $org_no)->first();
        $tujuan = Tujuan::where('organisasi_no', $org->organisasi_no)->get();

        return response()->json($tujuan);
    }


}
