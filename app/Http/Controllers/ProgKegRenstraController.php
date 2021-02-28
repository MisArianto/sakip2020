<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Alert;
use App\Models\Satuan;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\Organisasi;
use App\Models\TujuanRenstra;
use App\Models\ProgKegRenstra;
use App\Models\Renstra;
use App\Models\TargetIkRenstra;
use App\Models\TargetIpRenstra;
use App\Models\SasaranRenstra;
use App\Models\CapaianSasaranOpd;
use App\Models\IndikatorProgramRenstra;
use App\Models\RencanaStrategisIndikatorSasaran as IndikatorSasaran;
use App\Models\RencanaStrategisIndikatorProgram as IndikatorProgram;
use App\Models\RencanaStrategisIndikatorKegiatan as IndikatorKegiatan;
use Illuminate\Http\Request;

class ProgKegRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $opds  = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;

            $indikator_sasaran =  IndikatorSasaran::where('organisasi_no','=',Auth::user()->organisasi_no)
                    // ->where('tujuan')
                    // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                    ->orderBy('indikator_sasaran_nomor')
                    ->get();
                    // return $indikator_sasaran;

            $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                        // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                        // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                        ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                        ->groupBy('program.program_no')
                        ->get();

                        // return $program;

            $kegiatan = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                        ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                        ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                        // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                        // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                        ->where('prokeg_renstra.organisasi_no','=',Auth::user()->organisasi_no)
                        // ->groupBy('program.program_no')
                        ->get();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $opds = [];
            $program = [];
            $sasaran = [];
            $tujuan = [];
            $indikator_sasaran = [];
        }

        
        // dd($request->organisasi_no);
        return view('app.perencanaan.renstra.program.index', compact('opds','opd','tujuan','indikator_sasaran', 'program','kegiatan'));
        
    } 

    public function kegiatan()
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

        $opds = [];
        $program = [];
        $kegiatan = [];
        // dd($request->organisasi_no);
        return view('app.perencanaan.renstra.kegiatan.index', compact('opds','opd','kegiatan','program'));
        
    }

    public function programRkt()
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

        $opds = [];
        $sasaran = [];
        $tujuan = [];
        $indikator_sasaran = [];
        // dd($request->organisasi_no);
        return view('app.perencanaan.rkt.program.index', compact('opds','opd','tujuan','indikator_sasaran'));
        
    }

    public function kegiatanRkt()
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

        $opds = [];
        $program = [];
        $kegiatan = [];
        // dd($request->organisasi_no);
        return view('app.perencanaan.rkt.kegiatan.index', compact('opds','opd','kegiatan','program'));
        
    }


    public function dataRenstra (Request $request) 
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

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;


        $indikator_sasaran =  IndikatorSasaran::where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;

        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

                    // return $program;

        $kegiatan = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get();
                // return $kegiatan;

        return view('app.perencanaan.renstra.program.index', compact('opd','opds','program','indikator_sasaran','kegiatan'));
    }

    public function dataProgramRKT (Request $request) 
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

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;


        $indikator_sasaran =  IndikatorSasaran::where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;

        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get();

                // return $program;

        return view('app.perencanaan.rkt.program.index', compact('opd','opds','program','indikator_sasaran'));
    }

    public function dataKegiatan (Request $request) 
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

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;


        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
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

                // return $kegiatan;

        return view('app.perencanaan.renstra.kegiatan.index', compact('opd','opds','program','kegiatan'));
    }

    public function dataKegiatanRKT (Request $request) 
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

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;


        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
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

                // return $kegiatan;

        return view('app.perencanaan.rkt.kegiatan.index', compact('opd','opds','program','kegiatan'));
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

            $misis = SasaranRenstra::join('visi_misi as misi','misi.nomor','=','tujuan.visi_misi_nomor')
                    ->where('tujuan.organisasi_no', $request->organisasi_no)
                    ->groupBy('misi.nomor')
                    ->get();

            $tujuan = SasaranRenstra::where('tujuan.organisasi_no', $request->organisasi_no)
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
                        'visi_misi_nomor' => $data1->visi_misi_nomor,
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
            return view('app.perencanaan.renstra.tujuan.index', compact('opd','misi','tujuan'));

        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 2){
            $org = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->where('organisasi_no', Auth::user()->organisasi_no)->first();

            $indikator_sasarans = IndikatorSasaran::where('organisasi_no', Auth::user()->organisasi_no)->get();
            // return $indikator_sasarans;
            $orgs = [];
        }else{
            $orgs = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        $indikator_sasarans = [];
        }
        // return $opd;

        $tujuans = TujuanRenstra::get();
        $satuans = Satuan::get();
        $programs = Program::get();
        $kegiatans = Kegiatan::get();
     // return $tujuan;

        // return view('app.perencanaan.renstra.sasaran.tambah', compact ('opd','tujuan'));
        return view('app.perencanaan.renstra.program.add', compact('orgs', 'tujuans', 'satuans', 'indikator_sasarans', 'programs', 'kegiatans'));
    }

    function data(Request $request)
    {
         $select = $request->get('select');
         $value = $request->get('value');
         $dependent = $request->get('dependent');
         $data = DB::table('organisasi')
           ->where($select, $value)
           ->groupBy($dependent)
           ->get();
         $output = '<option value="">Select '.ucfirst($dependent).'</option>';
         foreach($data as $row)
         {
          $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
         }
         echo $output;
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
            $this->validate($request, [
                'indikator_sasaran_id' => 'required',
                'program_no' => 'required',
                'kegiatan_no' => 'required',
                'indikator_kegiatan' => 'required',
                'sasaran_kegiatan' => 'required',
                'kondisi_awal' => 'required',
                'satuan_id' => 'required',

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

            $pro_keg                         = new ProgKegRenstra;
            $pro_keg->organisasi_no      = $request->organisasi_no;
            $pro_keg->indikator_sasaran_id   = $request->indikator_sasaran_id;
            $pro_keg->program_no             = $request->program_no;
            $pro_keg->kegiatan_no            = $request->kegiatan_no;
            $pro_keg->indikator_kegiatan            = $request->indikator_kegiatan;
            $pro_keg->sasaran_kegiatan            = $request->sasaran_kegiatan;
            $pro_keg->organisasi_no            = $request->organisasi_no;
            $pro_keg->satuan_id            = $request->satuan_id;
            $pro_keg->perencanaan_awal           = $request->kondisi_awal;
            $pro_keg->target_t1            = $request->target2017;
            $pro_keg->target_t2            = $request->target2018;
            $pro_keg->target_t3            = $request->target2019;
            $pro_keg->target_t4            = $request->target2020;
            $pro_keg->target_t5            = $request->target2021;
            $pro_keg->pagu_t1            = str_replace([',',' '],'',$request->pagu2017);
            $pro_keg->pagu_t2            = str_replace([',',' '],'',$request->pagu2018);
            $pro_keg->pagu_t3            = str_replace([',',' '],'',$request->pagu2019);
            $pro_keg->pagu_t4            = str_replace([',',' '],'',$request->pagu2020);
            $pro_keg->pagu_t5            = str_replace([',',' '],'',$request->pagu2021);
            $pro_keg->target_kondisi_akhir            = $request->target_akhir;
            $pro_keg->pagu_kondisi_akhir            = $request->pagu_akhir;
            $pro_keg->save();

            // return $pro_keg;



            Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
            return redirect('perencanaan/rencana-strategis');

            
			// $pro_keg                         = new Renstra;

   //          if(Auth::user()->level == 1){
   //              $pro_keg->organisasi_no      = $request->organisasi_no;
   //          }

   //          if(Auth::user()->level == 2){
   //              $pro_keg->organisasi_no      = Auth::user()->organisasi_no;
   //          }

   //          $pro_keg->indikator_sasaran_id   = $request->indikator_sasaran_id;

   //          $pro_keg->program_no             = $request->program_no;
			// $pro_keg->kegiatan_no            = $request->kegiatan_no;
   //          $pro_keg->save();

   //          $last = Renstra::latest()->first();

   //          $ik                     = new IndikatorKegiatan;
   //          $ik->indikator_kegiatan = $request->indikator_kegiatan;
   //          $ik->sasaran_kegiatan   = $request->sasaran_kegiatan;
   //          $ik->kondisi_awal       = $request->kondisi_awal ? $request->kondisi_awal : '0';
   //          $ik->target_akhir       = $request->target_akhir;
   //          $ik->pagu_akhir         = $request->pagu_akhir;
   //          $ik->kegiatan_no        = $last->kegiatan_no;
   //          $ik->satuan_id          = $request->satuan_id;
   //          $ik->organisasi_no      = $request->organisasi_no;
   //          $ik->save();

   //          // get last row indikator kegiatan
   //          $getLastIndikatorKegiatan = IndikatorKegiatan::latest()->first();

   //           // insert target 2017
   //          $target = new TargetIkRenstra;
   //          $target->indikator_kegiatan_id = $getLastIndikatorKegiatan->id;
   //          $target->tahun                = '2017';
   //          $target->target               = str_replace([',',' '],'',$request->target2017);
   //          $target->pagu                 = str_replace([',',' '],'',$request->pagu2017);
            
   //          if(Auth::user()->level == 1)
   //          {
   //              $target->organisasi_no = $request->org;

   //          }elseif(Auth::user()->level == 2){

   //              $target->organisasi_no = Auth::user()->organisasi_no;
   //          }

   //          $target->save();

   //          // insert target 2017
   //          $target = new TargetIkRenstra;
   //          $target->indikator_kegiatan_id = $getLastIndikatorKegiatan->id;
   //          $target->tahun                = '2018';
   //          $target->target               = str_replace([',',' '],'',$request->target2018);
   //          $target->pagu                 = str_replace([',',' '],'',$request->pagu2018);

   //          if(Auth::user()->level == 1)
   //          {
   //              $target->organisasi_no = $request->org;

   //          }elseif(Auth::user()->level == 2){

   //              $target->organisasi_no = Auth::user()->organisasi_no;
   //          }

   //          $target->save();

   //          // insert target 2017
   //          $target = new TargetIkRenstra;
   //          $target->indikator_kegiatan_id = $getLastIndikatorKegiatan->id;
   //          $target->tahun                = '2019';
   //          $target->target               = str_replace([',',' '],'',$request->target2019);
   //          $target->pagu                 = str_replace([',',' '],'',$request->pagu2019);

   //          if(Auth::user()->level == 1)
   //          {
   //              $target->organisasi_no = $request->org;

   //          }elseif(Auth::user()->level == 2){

   //              $target->organisasi_no = Auth::user()->organisasi_no;
   //          }

   //          $target->save();

   //          // insert target 2017
   //          $target = new TargetIkRenstra;
   //          $target->indikator_kegiatan_id = $getLastIndikatorKegiatan->id;
   //          $target->tahun                = '2020';
   //          $target->target               = str_replace([',',' '],'',$request->target2020);
   //          $target->pagu                 = str_replace([',',' '],'',$request->pagu2020);

   //          if(Auth::user()->level == 1)
   //          {
   //              $target->organisasi_no = $request->org;

   //          }elseif(Auth::user()->level == 2){

   //              $target->organisasi_no = Auth::user()->organisasi_no;
   //          }

   //          $target->save();

   //          // insert target 2017
   //          $target = new TargetIkRenstra;
   //          $target->indikator_kegiatan_id = $getLastIndikatorKegiatan->id;
   //          $target->tahun                = '2021';
   //          $target->target               = str_replace([',',' '],'',$request->target2021);
   //          $target->pagu                 = str_replace([',',' '],'',$request->pagu2021);

   //          if(Auth::user()->level == 1)
   //          {
   //              $target->organisasi_no = $request->org;

   //          }elseif(Auth::user()->level == 2){

   //              $target->organisasi_no = Auth::user()->organisasi_no;
   //          }

   //          $target->save();


   //          Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
   //          return redirect('perencanaan/rencana-strategis');

        
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
        $model = ProgKegRenstra::findOrFail($id);
        $indikator_sasarans = IndikatorSasaran::where('organisasi_no', $model->organisasi_no)->get();
        $satuans = Satuan::get();
        $programs = Program::get();
        $kegiatans = Kegiatan::get();
        // return $model;
        return view('app.perencanaan.renstra.program.edit', compact('satuans', 'model', 'indikator_sasarans', 'programs', 'kegiatans'));
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
        // return $capaian = CapaianSasaranOpd::where('indikator_sasaran_id', $request->indikator_sasaran_id)->first();
        // return $request;
        if(Auth::user()->level == 1)
        {
            $this->validate($request, [
                'indikator_kegiatan' => 'required',
                'satuan_id' => 'required',
                'perencanaan_awal' => 'required',
            ]);
        }
        else 
        {
            $this->validate($request, [
                'indikator_kegiatan' => 'required',
                'satuan_id' => 'required',
                'perencanaan_awal' => 'required',
            ]);
        }

            $pro_keg                       = ProgKegRenstra::findOrFail($id);
            $pro_keg->indikator_sasaran_id   = $request->indikator_sasaran_id;
            $pro_keg->program_no   = $request->program_no;
            $pro_keg->kegiatan_no   = $request->kegiatan_no;
            $pro_keg->indikator_kegiatan   = $request->indikator_kegiatan;
            $pro_keg->satuan_id            = $request->satuan_id;
            $pro_keg->perencanaan_awal     = $request->perencanaan_awal;
            
            $pro_keg->target_t1            = $request->target2017;
            $pro_keg->target_t2            = $request->target2018;
            $pro_keg->target_t3            = $request->target2019;
            $pro_keg->target_t4            = $request->target2020;
            $pro_keg->target_t5            = $request->target2021;
            
            $pro_keg->pagu_t1              = str_replace([',',' '],'',$request->pagu2017);
            $pro_keg->pagu_t2              = str_replace([',',' '],'',$request->pagu2018);
            $pro_keg->pagu_t3              = str_replace([',',' '],'',$request->pagu2019);
            $pro_keg->pagu_t4              = str_replace([',',' '],'',$request->pagu2020);
            $pro_keg->pagu_t5              = str_replace([',',' '],'',$request->pagu2021);
            
            $pro_keg->target_kondisi_akhir = $request->target_akhir;
            $pro_keg->pagu_kondisi_akhir   = $request->pagu_akhir;
            
            $pro_keg->save();

            $capaian = CapaianSasaranOpd::where('indikator_sasaran_id', $request->indikator_sasaran_id)->first();
            $capaian->indikator_sasaran_id = $request->indikator_sasaran_id;
            $capaian->save();

            Alert::success('Berhasil', 'Data Berhasil Diupdate.')->persistent('Close');
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
        $model = ProgKegRenstra::findOrFail($id);
        $model->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');

    }

    public function ajaxIndikator($org_no)
    {
        $org = Organisasi::where('organisasi_no', $org_no)->first();
        $sasaran = IndikatorSasaran::where('organisasi_no', $org->organisasi_no)->get();


        return response()->json($sasaran);
    }

    public function ajaxProgramIndikator($org_no)
    {
        $org = ProgKegRenstra::join('organisasi as org','org.organisasi_no','=','prokeg_renstra.organisasi_no')
            ->where('prokeg_renstra.organisasi_no', $org_no)->first();
            // return $org;
        // $programs = ProgKegRenstra::where('organisasi_no', $org_no)->get();
        $programs = ProgKegRenstra::join('program', 'program.program_no', '=', 'prokeg_renstra.program_no')
                        ->where('organisasi_no', $org_no)
                        ->orderBy('program.program_no')
                        ->groupBy('program.program_no')
                        ->get();

        return response()->json($programs);
    }

    public function ajaxProgram($program_no)
    {
        $kegiatans = Kegiatan::where('program_no', $program_no)->get();

        return response()->json($kegiatans);
    }

    public function createProgramIndikator(Request $request)
    {
    	if(Auth::user()->level != 1){
            // $org = Organisasi::orderBy('organisasi_no')
            // ->where('organisasi_jenis','=','ORG')
            // ->where('organisasi_no', Auth::user()->organisasi_no)->first();

            $orgs = ProgKegRenstra::join('organisasi as org','org.organisasi_no','=','prokeg_renstra.organisasi_no')
                    ->where('org.organisasi_no', Auth::user()->organisasi_no)->first();

            $programs = ProgKegRenstra::join('program', 'program.program_no', '=', 'prokeg_renstra.program_no')
                        ->where('organisasi_no', $orgs->organisasi_no)
                        ->orderBy('program.program_no')
                        ->groupBy('program.program_no')
                        ->get();
        }else{
            // $orgs = Organisasi::orderBy('organisasi_no')
            // ->where('organisasi_jenis','=','ORG')
            // ->get();
             $programs = [];

            $orgs = ProgKegRenstra::join('organisasi as org','org.organisasi_no','=','prokeg_renstra.organisasi_no')
                    ->orderBy('org.organisasi_no')->groupBy('org.organisasi_no')->get();
        }

        $satuans = Satuan::get();

        return view('app.perencanaan.renstra.program.addIndikatorProgram', compact('orgs', 'satuans', 'programs'));
    }

    public function storeProgramIndikator(Request $request)
    {
        // return $request;
            $this->validate($request, [
                'program_no' => 'required',
                'indikator_program' => 'required',
                'sasaran_program' => 'required',
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

            $ip                         = new IndikatorProgram;

            if(Auth::user()->level == 1){
                $ip->organisasi_no      = $request->organisasi_no;
            }

            if(Auth::user()->level == 2){
                $ip->organisasi_no      = Auth::user()->organisasi_no;
            }

            $ip->program_no             = $request->program_no;
            $ip->indikator_program      = $request->indikator_program;
            $ip->sasaran_program        = $request->sasaran_program;
            $ip->satuan_id              = $request->satuan_id;
            $ip->kondisi_awal           = $request->kondisi_awal ? $request->kondisi_awal : '0';
            $ip->target_akhir = $request->target_akhir;
            $ip->pagu_akhir = $request->pagu_akhir;

            $ip->save();

            // get last row 
            $last = IndikatorProgram::latest()->first();
            
             // insert target 2017
            $target = new TargetIpRenstra;
            $target->indikator_program_id = $last->id;
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
            $target = new TargetIpRenstra;
            $target->indikator_program_id = $last->id;
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
            $target = new TargetIpRenstra;
            $target->indikator_program_id = $last->id;
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
            $target = new TargetIpRenstra;
            $target->indikator_program_id = $last->id;
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
            $target = new TargetIpRenstra;
            $target->indikator_program_id = $last->id;
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



			// $pro_keg                         = new IndikatorProgramRenstra;
   //          if(Auth::user()->level == 1){
			//  $pro_keg->organisasi_no          = $request->organisasi_no;
   //          }
			// $pro_keg->indikator_program_nama = $request->indikator_program_nama;
			// $pro_keg->program_no             = $request->program_no;

   //          if(Auth::user()->level != 1){
   //              $pro_keg->program_no             = $request->program_no_user;
   //          }

			// $pro_keg->satuan_id              = $request->satuan_id;
			// $pro_keg->perencanaan_awal       = $request->perencanaan_awal ? $request->perencanaan_awal : '0';
			
			// $pro_keg->target_t1              = $request->target2017 ? $request->target2017 : '0';
			// $pro_keg->target_t2              = $request->target2018 ? $request->target2018 : '0';
			// $pro_keg->target_t3              = $request->target2019 ? $request->target2019 : '0';
			// $pro_keg->target_t4              = $request->target2020 ? $request->target2020 : '0';
			// $pro_keg->target_t5              = $request->target2021 ? $request->target2021 : '0';
			
			// $pro_keg->pagu_t1                = str_replace([',',' '],'',$request->pagu2017) ? str_replace([',',' '],'',$request->pagu2017) : '0';
			// $pro_keg->pagu_t2                = str_replace([',',' '],'',$request->pagu2018) ? str_replace([',',' '],'',$request->pagu2018) : '0';
			// $pro_keg->pagu_t3                = str_replace([',',' '],'',$request->pagu2019) ? str_replace([',',' '],'',$request->pagu2019) : '0';
			// $pro_keg->pagu_t4                = str_replace([',',' '],'',$request->pagu2020) ? str_replace([',',' '],'',$request->pagu2020) : '0';
			// $pro_keg->pagu_t5                = str_replace([',',' '],'',$request->pagu2021) ? str_replace([',',' '],'',$request->pagu2021) : '0';
			
			// $pro_keg->target_kondisi_akhir   = $request->target_akhir ? $request->target_akhir : '0';
			// $pro_keg->pagu_kondisi_akhir     = $request->pagu_akhir ? $request->pagu_akhir : '0';
            
   //          $pro_keg->save();

            Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
            return redirect('perencanaan/rencana-strategis');
    }


    public function editProgramIndikator($id)
    {
        $model = IndikatorProgramRenstra::findOrFail($id);
        return $model;
        $satuans = Satuan::get();
        return view('app.perencanaan.renstra.program.editIndikatorProgram', compact('model', 'satuans'));
    }

    public function updateProgramIndikator(Request $request, $id)
    {
        // return $id;
        if(Auth::user()->level == 1)
        {
            $this->validate($request, [
                'indikator_program_nama' => 'required',
                'program_no' => 'required',
                'satuan_id' => 'required',
                'perencanaan_awal' => 'required',
            ]);
        }
        else 
        {
            $this->validate($request, [
                'indikator_program_nama' => 'required',
                'program_no' => 'required',
                'satuan_id' => 'required',
                'perencanaan_awal' => 'required',
            ]);
        }

            $pro_keg                         = IndikatorProgramRenstra::findOrFail(id);
            $pro_keg->indikator_program_nama = $request->indikator_program_nama;
            $pro_keg->program_no             = $request->program_no;
            $pro_keg->satuan_id              = $request->satuan_id;
            $pro_keg->perencanaan_awal       = $request->perencanaan_awal;
            
            $pro_keg->target_t1              = $request->target2017;
            $pro_keg->target_t2              = $request->target2018;
            $pro_keg->target_t3              = $request->target2019;
            $pro_keg->target_t4              = $request->target2020;
            $pro_keg->target_t5              = $request->target2021;
            
            $pro_keg->pagu_t1                = str_replace([',',' '],'',$request->pagu2017);
            $pro_keg->pagu_t2                = str_replace([',',' '],'',$request->pagu2018);
            $pro_keg->pagu_t3                = str_replace([',',' '],'',$request->pagu2019);
            $pro_keg->pagu_t4                = str_replace([',',' '],'',$request->pagu2020);
            $pro_keg->pagu_t5                = str_replace([',',' '],'',$request->pagu2021);
            
            $pro_keg->target_kondisi_akhir   = $request->target_akhir;
            $pro_keg->pagu_kondisi_akhir     = $request->pagu_akhir;
            
            $pro_keg->save();

            Alert::success('Berhasil', 'Data Berhasil Diupdate.')->persistent('Close');
            return redirect('perencanaan/rencana-strategis');
    }

    public function destroyProgramIndikator($id)
    {
       $model = IndikatorProgramRenstra::findOrFail($id);
       $model->delete();
       Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');
       return redirect('perencanaan/rencana-strategis');
    }



}
