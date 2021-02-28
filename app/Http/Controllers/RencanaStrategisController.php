<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Auth;
use Alert;
use App\Models\Misi;
use App\Models\Program as MasterProgram;
use App\Models\Satuan;
use App\Models\Organisasi;
use App\Models\CapaianSasaranOpd;
use App\Models\RencanaStrategisTujuan as Tujuan;
use App\Models\RencanaStrategisIndikatorTujuan as IndikatorTujuan;
use App\Models\RencanaStrategisSasaran as Sasaran;
use App\Models\RencanaStrategisIndikatorSasaran as IndikatorSasaran;
use App\Models\RencanaStrategisProgram as Program;
use App\Models\RencanaStrategisIndikatorProgram as IndikatorProgram;
use App\Models\RencanaStrategisKegiatan as Kegiatan;
use App\Models\RencanaStrategisIndikatorKegiatan as IndikatorKegiatan;
use App\Models\RencanaStrategisTargetIndikatorSasaran as TargetIS;
use App\Models\ProgKegRenstra;
use App\Models\Renstra;
use App\Models\GetApiController;
// use App\Http\Controllers\Api\GetApiController;
use Illuminate\Http\Request;

class RencanaStrategisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // GetApiController::get_api('tujuan_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('sasaran_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('indikator_tujuan_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('indikator_sasaran_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('indikator_kegiatan_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('indikator_program_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('target_indikator_kegiatan', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('target_program_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('target_sasaran_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // GetApiController::get_api('renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        // dd(GetApiController::get_api('prokeg_renstra', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK'));

        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

          

                $misi =  Tujuan::join('visi_misi as misi','misi.nomor','=','tujuan_renstra.misi_id')
                ->where('tujuan_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 
                    // return Auth::user()->organisasi_no;

            // $tujuan = Tujuan::where('organisasi_no', Auth::user()->organisasi_no)->get();

            $tujuan = Tujuan::leftJoin('indikator_tujuan_renstra as itr', 'itr.tujuan_id', '=','tujuan_renstra.id')
                      ->leftJoin('satuan', 'satuan.id', '=','itr.satuan_id')
                      ->join('misi', 'misi.id', '=','tujuan_renstra.misi_id')
                      ->select(
                          'misi.id as misi_id',
                          'misi.nama',
                          'misi.nomor',
                          'tujuan_renstra.id as tujuan_id', 
                          'tujuan_renstra.tujuan_nama',
                          'itr.id as indikator_tujuan_id',
                          'itr.indikator_tujuan',
                          'itr.kondisi_akhir',
                          'satuan.satuan_nama'
                            )
                      ->where('tujuan_renstra.organisasi_no', Auth::user()->organisasi_no)
                      ->get();
                    // return $tujuan;
            $indikator_tujuan = IndikatorTujuan::join('satuan', 'satuan.id', '=', 'indikator_tujuan_renstra.satuan_id')->where('organisasi_no', Auth::user()->organisasi_no)->get();

            // $sasaran = Sasaran::where('organisasi_no', Auth::user()->organisasi_no)->get();

            $sasaran = Sasaran::join('tujuan_renstra', 'tujuan_renstra.id', '=','sasaran_renstra.tujuan_id')
                      ->leftJoin('indikator_sasaran_renstra as isr', 'isr.sasaran_id', '=','sasaran_renstra.id')
                      ->leftJoin('satuan', 'satuan.id', '=','isr.satuan_id')
                      // ->join('misi', 'misi.id', '=','isr.misi_id')
                      ->groupBy('sasaran_renstra.id')
                      ->groupBy('isr.id')
                      ->select(
                          // 'misi.id as misi_id',
                          // 'misi.nama',
                          'tujuan_renstra.id as tujuan_id',
                          'tujuan_renstra.tujuan_nama',
                          'sasaran_renstra.id as sasaran_id', 
                          'sasaran_renstra.sasaran_nama',
                          'isr.id as indikator_sasaran_id',
                          'isr.indikator_sasaran',
                          'isr.kondisi_awal',
                          'isr.target_akhir',
                          'satuan.satuan_nama'
                            )
                      ->where('sasaran_renstra.organisasi_no', Auth::user()->organisasi_no)
                      ->get();

            // return $sasaran;

            $indikator_sasaran = IndikatorSasaran::leftJoin('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                    ->groupBy('program.program_no')
                    ->groupBy('kegiatan.kegiatan_no')
                    ->get();


                // return $program;

            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();
                    // return $kegiatan;

            // $program = Program::join('program','program.program_no','=','renstra.program_no')
            //             ->where('renstra.organisasi_no', Auth::user()->organisasi_no)
            //             ->groupBy('renstra.program_no')
            //             ->get();

            // $kegiatan = Kegiatan::join('kegiatan','kegiatan.kegiatan_no','renstra.kegiatan_no')
            //             ->where('renstra.organisasi_no', Auth::user()->organisasi_no)
            //             ->get();
            // $indikator_program = [];
            // $indikator_kegiatan = IndikatorKegiatan::leftJoin('satuan','satuan.id','=','indikator_kegiatan_renstra.satuan_id')
            //                     ->where('organisasi_no',Auth::user()->organisasi_no)
            //                     ->select('indikator_kegiatan_renstra.id','indikator_kegiatan_renstra.indikator_kegiatan','indikator_kegiatan_renstra.kondisi_awal','indikator_kegiatan_renstra.target_akhir','indikator_kegiatan_renstra.pagu_akhir','indikator_kegiatan_renstra.kegiatan_no','satuan.satuan_nama')
            //                     ->get();

            // $target_ik = DB::table('target_ik_renstra')->where('organisasi_no',Auth::user()->organisasi_no)->get();
            // return $target_ik;
            // return $indikator_kegiatan;


            // return $program;
            // return $kegiatan;

            // return $indikator_tujuan;

            // $indikator_tujuan =  IndikatorTujuan::join('satuan','satuan.id','=','indikator_tujuan.satuan_id')
            //         ->where('organisasi_no','=',Auth::user()->organisasi_no)
            //         // ->where('tujuan')
            //         ->select('tujuan_nomor','indikator_tujuan_nomor as it_nomor','indikator_tujuan_nama as it_nama','satuan_nama','kondisi_akhir', 'indikator_tujuan.id')
            //         ->orderBy('tujuan_nomor')
            //         ->orderBy('it_nomor')
            //         ->get();

            // $sasaran =  SasaranRenstra::where('organisasi_no','=',Auth::user()->organisasi_no)
            //         ->select('tujuan_nomor','sasaran_nomor','sasaran_nama', 'sasaran_id')
            //         ->orderBy('tujuan_nomor')
            //         ->get();
            //         // return $sasaran;

            // $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
            //         ->where('organisasi_no','=',Auth::user()->organisasi_no)
            //         // ->where('tujuan')
            //         // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
            //         ->orderBy('indikator_sasaran_nomor')
            //         ->get();

            // $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
            //             // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
            //             // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
            //             ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
            //             ->groupBy('program.program_no')
            //             ->get();

            //             // return $program;

            // $kegiatan = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
            //             ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
            //             ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
            //             // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
            //             // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
            //             ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
            //             // ->groupBy('program.program_no')
            //             ->get();

            // return $indikator_tujuan;
        }else{
            // $opd = Organisasi::orderBy('organisasi_no')
            // ->where('organisasi_jenis','=','ORG')
            // ->get();

            $misi = [];
            $opd = [];
            $tujuan = [];
            $sasaran = [];
            $indikator_tujuan = [];
            $indikator_sasaran = [];
            $program = [];
            $kegiatan = [];
        }
            // $sasaran = [];
            // $indikator_sasaran = [];
            $opds = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();

        // return $opd;
         return view('app.perencanaan.renstra.index', compact('opds','opd','misi','tujuan', 'indikator_tujuan','sasaran','indikator_sasaran','program','kegiatan'))->with('no',1);

    }

    public function dataRenstra(Request $request)
    {

        $organisasi_no=$request->organisasi_no;
        
        $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', $request->organisasi_no)->get();

            // $misi = Tujuan::join('misi','misi.id','=','tujuan.misi_id')
            //         ->where('tujuan.organisasi_no', $request->organisasi_no)
            //         ->groupBy('tujuan.misi_id')
            //         ->get();

            $misi =  Tujuan::join('misi','misi.id','=','tujuan_renstra.misi_id')
                ->where('tujuan_renstra.organisasi_no','=',$request->organisasi_no)
                ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('misi_no')
                ->get(); 
                    // return $misi;

            $tujuan = Tujuan::where('tujuan_renstra.organisasi_no', $request->organisasi_no)
                      ->leftJoin('indikator_tujuan_renstra as itr', 'itr.tujuan_id', '=','tujuan_renstra.id')
                      ->leftJoin('satuan', 'satuan.id', '=','itr.satuan_id')
                      ->join('misi', 'misi.id', '=','tujuan_renstra.misi_id')
                      ->select(
                          'misi.id as misi_id',
                          'misi.nama',
                          'misi.nomor',
                          'tujuan_renstra.id as tujuan_id', 
                          'tujuan_renstra.tujuan_nama',
                          'itr.id as indikator_tujuan_id',
                          'itr.indikator_tujuan',
                          'itr.kondisi_akhir',
                          'satuan.satuan_nama'
                            )
                      ->get();
                    // return $tujuan;
            $indikator_tujuan = IndikatorTujuan::join('satuan', 'satuan.id', '=', 'indikator_tujuan_renstra.satuan_id')->where('organisasi_no', $request->organisasi_no)->get();

            // $sasaran = Sasaran::where('organisasi_no', $request->organisasi_no)->get();

            $sasaran = Sasaran::where('sasaran_renstra.organisasi_no',  $request->organisasi_no)
                      ->leftJoin('indikator_sasaran_renstra as isr', 'isr.sasaran_id', '=','sasaran_renstra.id')
                      ->leftJoin('tujuan_renstra', 'tujuan_renstra.id', '=','sasaran_renstra.tujuan_id')
                      ->leftJoin('indikator_tujuan_renstra as itr', 'itr.tujuan_id', 'tujuan_renstra.id')
                      ->leftJoin('satuan', 'satuan.id', '=','isr.satuan_id')
                      ->join('misi', 'misi.id', '=','tujuan_renstra.misi_id')
                      ->groupBy('sasaran_renstra.id')
                      ->groupBy('isr.id')
                      ->select(
                          'misi.id as misi_id',
                          'misi.nama',
                          'tujuan_renstra.id as tujuan_id',
                          'tujuan_renstra.tujuan_nama',
                          'sasaran_renstra.id as sasaran_id', 
                          'sasaran_renstra.sasaran_nama',
                          'isr.id as indikator_sasaran_id',
                          'isr.indikator_sasaran',
                          'isr.kondisi_awal',
                          'isr.target_akhir',
                          'satuan.satuan_nama',
                          'itr.id as indikator_tujuan_id',
                          'itr.indikator_tujuan',
                          'itr.kondisi_akhir',
                          'itr.kondisi_awal as kondisi_awal_itr'
                            )
                      ->get();

                  // return $sasaran;

            $indikator_sasaran = IndikatorSasaran::leftJoin('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')->where('organisasi_no', $request->organisasi_no)->get();

            $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->leftJoin('kegiatan', 'kegiatan.kegiatan_no', 'prokeg_renstra.kegiatan_no')
                    ->leftJoin('satuan', 'satuan.id', 'prokeg_renstra.satuan_id')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

                // return $program;

            $kegiatan = ProgKegRenstra::join('kegiatan','kegiatan.kegiatan_no','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_kegiatan as ik','ik.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();
            $opds = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();

            return view('app.perencanaan.renstra.index', compact('opds','opd','misi','tujuan', 'indikator_tujuan','sasaran','indikator_sasaran','program','kegiatan'))->with('no',1);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createKegiatanIndikator()
    {
        
    }

    public function  tambahTujuan()
    {
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        }

        $misi= Misi::get();

        return view('app.perencanaan.renstra.tujuan.tambah', compact('opd', 'misi'));
    }

    public function storeTujuan(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'misi_id'       => 'required',
            'tujuan_nama'   => 'required',
            
        ]);

        $model = new Tujuan;
        $model->misi_id = $request->misi_id;
        $model->tujuan_nama = $request->tujuan_nama;
        if(Auth::user()->level == 1)
        {
            $model->organisasi_no = $request->opd;
        }else{
            $model->organisasi_no = Auth::user()->organisasi_no;
        }
        $model->save();

  
        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        // Alert::success('Berhasil', 'Data Berhasil Disimpan.');
        return redirect('perencanaan/rencana-strategis');
    }

    public function  tambahIndikatorTujuan()
    {
        if (Auth::user()->level == 2) {
            
            $orgs = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first();
            $tujuans = Tujuan::where('organisasi_no', Auth::user()->organisasi_no)->get(); 
            $satuans = Satuan::get();

        }else{
            $tujuans = [];
            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
            $satuans = Satuan::get();
            
        }

        return view('app.perencanaan.renstra.tujuan.addIndikator', compact('orgs', 'tujuans', 'satuans'));
    }

    public function storeIndikatorTujuan(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'tujuan_id'                 => 'required',
            'indikator_tujuan'          => 'required',
            'satuan_id'                 => 'required',
            'kondisi_akhir'             => 'required'
        ]);

        // if(Session::get('tujuan_renstra_id') != '')
        // {

        //     $model = IndikatorTujuan::findOrfail(Session::get('tujuan_renstra_id'));
        
        //     if(Auth::user()->level == 1)
        //     {
        //         $model->organisasi_no       = $request->organisasi_no;
        //     }else{
        //         $model->organisasi_no       = Auth::user()->organisasi_no;
        //     }

        //     $model->tujuan_id               = Session::get('tujuan_renstra_id');
        //     $model->indikator_tujuan        = $request->indikator_tujuan;
        //     $model->satuan_id               = $request->satuan_id;
        //     $model->kondisi_akhir           = $request->kondisi_akhir;
        //     $model->save();
        // }


        $model = new IndikatorTujuan;
    
        if(Auth::user()->level == 1)
        {
            $model->organisasi_no       = $request->organisasi_no;
        }else{
            $model->organisasi_no       = Auth::user()->organisasi_no;
        }

        $model->tujuan_id               = $request->tujuan_id;
        $model->indikator_tujuan        = $request->indikator_tujuan;
        $model->satuan_id               = $request->satuan_id;
        $model->kondisi_akhir           = $request->kondisi_akhir;
        $model->save();
        

        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        // return back();
        return redirect('perencanaan/rencana-strategis');
    }

    public function tambahSasaran()
    {
        if (Auth::user()->level == 2) {
            
            $orgs = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first();
            $tujuans = Tujuan::where('organisasi_no', Auth::user()->organisasi_no)->get(); 

        }else{

            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
            $tujuans = [];
            
        }
        return view('app.perencanaan.renstra.sasaran.tambah', compact('orgs', 'tujuans'));
    }

    public function storeSasaran(Request $request)
    {
        // return $request;
         $this->validate($request, [
            'tujuan_id'  => 'required',
            'sasaran_nama'  => 'required'
        ]);

        $model = new Sasaran;
        $model->organisasi_no            = $request->org;
        $model->tujuan_id = $request->tujuan_id;
        $model->sasaran_nama = $request->sasaran_nama;
        $model->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    public function tambahIndikatorSasaran()
    {
        if (Auth::user()->level == 2) {
            
            $orgs = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first();
            $sasarans = Sasaran::where('organisasi_no', Auth::user()->organisasi_no)->get(); 

        }else{
            $sasarans = []; 
            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
            
        }

        // return $sasarans;

        $satuans = Satuan::get();
        return view('app.perencanaan.renstra.sasaran.addIndikatorSasaran', compact('orgs', 'sasarans', 'satuans'));
    }

    public function storeIndikatorSasaran(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'sasaran_id'  => 'required',
            'indikator_sasaran' => 'required',
            'satuan_id' => 'required',
            'kondisi_awal' => 'required',
            'target2017' => 'required',
            'target2018' => 'required',
            'target2019' => 'required',
            'target2020' => 'required',
            'target2021' => 'required',
            'pagu2017' => 'required',
            'pagu2018' => 'required',
            'pagu2019' => 'required',
            'pagu2020' => 'required',
            'pagu2021' => 'required',
            'target_akhir' => 'required',
            'pagu_akhir' => 'required',
        ]);

        $indikator_sasaran = new IndikatorSasaran;
        $indikator_sasaran->sasaran_id = $request->sasaran_id;
        $indikator_sasaran->indikator_sasaran = $request->indikator_sasaran;
        $indikator_sasaran->satuan_id = $request->satuan_id;
        $indikator_sasaran->kondisi_awal = $request->kondisi_awal;
        $indikator_sasaran->target_akhir = $request->target_akhir;
        $indikator_sasaran->pagu_akhir = $request->pagu_akhir;
        $indikator_sasaran->organisasi_no = $request->organisasi_no;
        $indikator_sasaran->save();


        // get last row 
        $last = IndikatorSasaran::latest()->first();

        $capaian = new CapaianSasaranOpd;
        $capaian->indikator_sasaran_id = $last->id;
        $capaian->tahun = '2017';
        $capaian->save();

        $capaian = new CapaianSasaranOpd;
        $capaian->indikator_sasaran_id = $last->id;
        $capaian->tahun = '2018';
        $capaian->save();

        $capaian = new CapaianSasaranOpd;
        $capaian->indikator_sasaran_id = $last->id;
        $capaian->tahun = '2019';
        $capaian->save();

        $capaian = new CapaianSasaranOpd;
        $capaian->indikator_sasaran_id = $last->id;
        $capaian->tahun = '2020';
        $capaian->save();

        $capaian = new CapaianSasaranOpd;
        $capaian->indikator_sasaran_id = $last->id;
        $capaian->tahun = '2021';
        $capaian->save();

        // insert target 2017
        $target = new TargetIS;
        $target->indikator_sasaran_id = $last->id;
        $target->tahun                = '2017';
        $target->target               = str_replace([',',' '],'',$request->target2017);
        $target->pagu                 = str_replace([',',' '],'',$request->pagu2017);
        
        if(Auth::user()->level == 1)
        {
            $target->organisasi_no = $request->org;

        }elseif(Auth::user()->level == 2){

            $target->organisasi_no = Auth::user()->organisasi_no;
        }

        $target->save();

        // insert target 2017
        $target = new TargetIS;
        $target->indikator_sasaran_id = $last->id;
        $target->tahun                = '2018';
        $target->target               = str_replace([',',' '],'',$request->target2018);
        $target->pagu                 = str_replace([',',' '],'',$request->pagu2018);

        if(Auth::user()->level == 1)
        {
            $target->organisasi_no = $request->org;

        }elseif(Auth::user()->level == 2){

            $target->organisasi_no = Auth::user()->organisasi_no;
        }

        $target->save();

        // insert target 2017
        $target = new TargetIS;
        $target->indikator_sasaran_id = $last->id;
        $target->tahun                = '2019';
        $target->target               = str_replace([',',' '],'',$request->target2019);
        $target->pagu                 = str_replace([',',' '],'',$request->pagu2019);

        if(Auth::user()->level == 1)
        {
            $target->organisasi_no = $request->org;

        }elseif(Auth::user()->level == 2){

            $target->organisasi_no = Auth::user()->organisasi_no;
        }

        $target->save();

        // insert target 2017
        $target = new TargetIS;
        $target->indikator_sasaran_id = $last->id;
        $target->tahun                = '2020';
        $target->target               = str_replace([',',' '],'',$request->target2020);
        $target->pagu                 = str_replace([',',' '],'',$request->pagu2020);

        if(Auth::user()->level == 1)
        {
            $target->organisasi_no = $request->org;

        }elseif(Auth::user()->level == 2){

            $target->organisasi_no = Auth::user()->organisasi_no;
        }

        $target->save();

        // insert target 2017
        $target = new TargetIS;
        $target->indikator_sasaran_id = $last->id;
        $target->tahun                = '2021';
        $target->target               = str_replace([',',' '],'',$request->target2021);
        $target->pagu                 = str_replace([',',' '],'',$request->pagu2021);

        if(Auth::user()->level == 1)
        {
            $target->organisasi_no = $request->org;

        }elseif(Auth::user()->level == 2){

            $target->organisasi_no = Auth::user()->organisasi_no;
        }

        $target->save();


        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');

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
     * @param  \App\RencanaStrategis  $rencanaStrategis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'tes';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RencanaStrategis  $rencanaStrategis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // buat session
        Session::put('tujuan_renstra_id', $id);

        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            // $misi = Tujuan::join('misi','misi.id','=','tujuan.misi_id')
            //         // ->where('tujuan_renstra.organisasi_no', Auth::user()->organisasi_no)
            //         ->groupBy('tujuan.misi_id')
            //         ->get();

              $misi =  Tujuan::join(' misi','misi.id','=','tujuan_renstra.misi_id')
                // ->where('tujuan.organisasi_no','=',Auth::user()->organisasi_no)
                // ->select('misi.nomor as misi_no','misi.nama as misi_nama')
                ->groupBy('tujuan_renstra.misi_id')
                ->get(); 

            // return $misi;
            $tujuan = Tujuan::where('id', $id)->first();

            $indikator_tujuan = IndikatorTujuan::join('satuan', 'satuan.id', '=', 'indikator_tujuan_renstra.satuan_id')->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $sasaran = Sasaran::where('organisasi_no', Auth::user()->organisasi_no)->get();
        // return $sasaran;

        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $tujuan = Tujuan::where('id', $id)->first();
            $misi = [];

            $indikator_tujuan = [];
            $sasaran = [];
        }

        return view('app.perencanaan.renstra.tujuan.editTujuan', compact ('misi','opd', 'tujuan','indikator_tujuan','sasaran'))->with('no', 1);
    }


    public function edit_sasaran($id)
    {
        $tujuans = Tujuan::get();
        $model = Sasaran::findOrfail($id);
        // return $model;
        return view('app.perencanaan.renstra.sasaran.edit', compact ('tujuans','model'))->with('no', 1);
    }

    public function edit_indikator_sasaran($id)
    {
        // return $id;
        $tujuans = Tujuan::get();
        $satuans = Satuan::get();
        $sasarans = Sasaran::get();
        $model = IndikatorSasaran::leftJoin('satuan','satuan.id','=','indikator_sasaran_renstra.satuan_id')
                ->join('sasaran_renstra', 'sasaran_renstra.id', '=', 'indikator_sasaran_renstra.sasaran_id')
                ->select(
                    'sasaran_renstra.id as sasaran_id',
                    'sasaran_renstra.sasaran_nama',
                    'indikator_sasaran_renstra.id as indikator_sasaran_id',
                    'indikator_sasaran_renstra.organisasi_no',
                    'indikator_sasaran_renstra.indikator_sasaran',
                    'indikator_sasaran_renstra.kondisi_awal',
                    'satuan.satuan_id',
                    'satuan.satuan_nama'
                )
                ->first();

                // return $model;
        return view('app.perencanaan.renstra.sasaran.editIndikatorSasaran', compact ('tujuans','model', 'sasarans', 'satuans'))->with('no', 1);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RencanaStrategis  $rencanaStrategis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'misi_id'       => 'required',
            'tujuan_nama'      => 'required',
        ]);

       $model = Tujuan::findOrfail($id);
       $model->organisasi_no   = $request->opd;
       $model->misi_id         = $request->misi_id;
       $model->tujuan_nama     = $request->tujuan_nama;
       $model->save();

        Alert::success('Berhasil', 'Data Berhasil Di Update!')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    public function update_sasaran(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'tujuan_id'       => 'required',
            'sasaran_nama'      => 'required',
        ]);

       $model = Sasaran::findOrfail($id);
        $model->organisasi_no   = $request->organisasi_no;
        $model->tujuan_id         = $request->tujuan_id;
        $model->sasaran_nama     = $request->sasaran_nama;
        $model->save();

        Alert::success('Berhasil', 'Data Berhasil Di Update')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    public function update_indikator_sasaran(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'sasaran_id'       => 'required',
            'indikator_sasaran'      => 'required',
            'satuan_id'      => 'required',
            'kondisi_awal'      => 'required',
        ]);

       $model = IndikatorSasaran::findOrfail($id);
       // return $model;
        $model->organisasi_no      = $request->organisasi_no;
        $model->sasaran_id         = $request->sasaran_id;
        $model->indikator_sasaran  = $request->indikator_sasaran;
        $model->satuan_id          = $request->satuan_id;
        $model->kondisi_awal       = $request->kondisi_awal;
        $model->save();

        Alert::success('Berhasil', 'Data Berhasil Di Update')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RencanaStrategis  $rencanaStrategis
     * @return \Illuminate\Http\Response
     */
    public function destroy_sasaran($id)
    {
        $model = Sasaran::findOrfail($id);
        $indikator_sasaran = IndikatorSasaran::where('sasaran_id', $model->id)->get();
        foreach ($indikator_sasaran as $value) {
            $value->delete;
        }
        $model->delete();

        Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
        // Alert::success('Berhasil', 'Data Berhasil Disimpan.');
        return redirect('perencanaan/rencana-strategis');
    }

    public function destroy_indikator_sasaran($id)
    {
        $model = IndikatorSasaran::findOrfail($id);
        $model->delete();

        Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
        // Alert::success('Berhasil', 'Data Berhasil Disimpan.');
        return redirect('perencanaan/rencana-strategis');
    }

    public function destroy($id)
    {
        // return $id;
        $model = Tujuan::findOrfail($id);
        $model->delete();

        Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
        // Alert::success('Berhasil', 'Data Berhasil Disimpan.');
        return redirect('perencanaan/rencana-strategis');
    }


}
