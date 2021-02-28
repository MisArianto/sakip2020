<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Alert;
use Auth;
use App\Models\Satuan;
use App\Models\Organisasi;
use App\Models\TujuanRenstra as Tujuan;
use App\Models\SasaranRenstra;
use App\Models\IndikatorSasaranRenstra as IndikatorSasaran;
use Illuminate\Http\Request;

class SasaranRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level != 1){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();

            $opds  = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;

            $tujuan = Tujuan::where('tujuan.organisasi_no', Auth::user()->organisasi_no)
                        // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                        ->orderBy('tujuan_nomor')
                        ->groupBy('tujuan_nomor')
                        ->get();
                    // return $tujuan;

            $sasaran =  SasaranRenstra::where('organisasi_no','=',Auth::user()->organisasi_no)
                    ->select('tujuan_nomor','sasaran_nomor','sasaran_nama', 'sasaran_id')
                    ->orderBy('tujuan_nomor')
                    ->get();
                    // return $sasaran;

            $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
                    ->where('organisasi_no','=',Auth::user()->organisasi_no)
                    // ->where('tujuan')
                    // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                    ->orderBy('indikator_sasaran_nomor')
                    ->get();
        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $opds = [];
            $sasaran = [];
            $tujuan = [];
            $indikator_sasaran = [];
        }

        
        return view('app.perencanaan.renstra.sasaran.index', compact('opds','opd','tujuan','indikator_sasaran','sasaran'));
        
    }

     public function rkt()
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
        return view('app.perencanaan.rkt.sasaran.index', compact('opds','opd','tujuan'));
        
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

        $tujuan = Tujuan::where('tujuan.organisasi_no', $request->organisasi_no)
                    // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                    ->orderBy('tujuan_nomor')
                    ->groupBy('tujuan_nomor')
                    ->get();
                // return $tujuan;

        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('tujuan_nomor','sasaran_nomor','sasaran_nama', 'sasaran_id')
                ->orderBy('tujuan_nomor')
                ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;
                // 
        return view('app.perencanaan.renstra.sasaran.index', compact('opd','opds','tujuan','sasaran','indikator_sasaran'));
    }

    public function dataSasaranRKT (Request $request) 
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

        $tujuan = Tujuan::where('tujuan.organisasi_no', $request->organisasi_no)
                    // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                    ->orderBy('tujuan_nomor')
                    ->groupBy('tujuan_nomor')
                    ->get();
                // return $tujuan;

        $sasaran =  SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                ->select('tujuan_nomor','sasaran_nomor','sasaran_nama')
                ->orderBy('tujuan_nomor')
                ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaran::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
                ->where('organisasi_no','=',$request->organisasi_no)
                // ->where('tujuan')
                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                ->orderBy('indikator_sasaran_nomor')
                ->get();
                // return $indikator_sasaran;
        return view('app.perencanaan.rkt.sasaran.index', compact('opd','opds','tujuan','sasaran','indikator_sasaran'));
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
        if (Auth::user()->level == 2) {
            
            $orgs = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first();
            $tujuans = Tujuan::where('organisasi_no', Auth::user()->organisasi_no)->get(); 

        }else{

            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
            
        }
        return view('app.perencanaan.renstra.sasaran.tambah', compact('orgs', 'tujuans'));
    }

    public function createIndikatorSasaran()
    {
        if (Auth::user()->level == 2) {
            
            $orgs = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first();
            $sasarans = SasaranRenstra::where('organisasi_no', Auth::user()->organisasi_no)->get(); 

        }else{

            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
            
        }

        $satuans = Satuan::get();
        return view('app.perencanaan.renstra.sasaran.addIndikatorSasaran', compact('orgs', 'sasarans', 'satuans'));
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
        $this->validate($request, [
            // 'org'           => 'required',
            'tujuan_nomor'  => 'required',
            'sasaran_nomor' => 'required',
            'sasaran_nama'  => 'required'
        ]);

        $sasaran = new SasaranRenstra;
        if(Auth::user()->level == 1)
        {
            $sasaran->organisasi_no            = $request->organisasi_no;
        }else{
            $sasaran->organisasi_no            = Auth::user()->organisasi_no;
        }
        $sasaran->tujuan_nomor = $request->tujuan_nomor;
        $sasaran->sasaran_nomor = $request->sasaran_nomor;
        $sasaran->sasaran_nama = $request->sasaran_nama;
        // $sasaran->organisasi_no = $request->organisasi_no;
        $sasaran->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');

    }

    public function storeIndikatorSasaran(Request $request)
    {
        $this->validate($request, [
            'org'           => 'required',
            'sasaran_nama'  => 'required',
            'indikator_sasaran_nomor'  => 'required',
            'indikator_sasaran_nama' => 'required',
            'satuan' => 'required',
        ]);

        $model = IndikatorSasaran::where('organisasi_no', $request->org)->first();

        $sasaran = new IndikatorSasaran;
        // $sasaran->visi_misi_nomor      = $model->visi_misi_nomor;
        // $sasaran->tujuan_nomor         = $model->tujuan_nomor;
        // $sasaran->sasaran_nomor        = $model->sasaran_nomor;
        // $sasaran->sasaran_nama = $request->sasaran_nama;
        $sasaran->indikator_sasaran_nomor = $request->indikator_sasaran_nomor;
        $sasaran->indikator_sasaran_nama = $request->indikator_sasaran_nama;
        $sasaran->satuan_id = $request->satuan;
        $sasaran->organisasi_no = $request->org;
        $sasaran->perencanaan_awal = $request->perencanaan_awal;

        $sasaran->target_t1            = $request->target2017;
        $sasaran->target_t2            = $request->target2018;
        $sasaran->target_t3            = $request->target2019;
        $sasaran->target_t4            = $request->target2020;
        $sasaran->target_t5            = $request->target2021;
        
        $sasaran->pagu_t1              = str_replace([',',' '],'',$request->pagu2017);
        $sasaran->pagu_t2              = str_replace([',',' '],'',$request->pagu2018);
        $sasaran->pagu_t3              = str_replace([',',' '],'',$request->pagu2019);
        $sasaran->pagu_t4              = str_replace([',',' '],'',$request->pagu2020);
        $sasaran->pagu_t5              = str_replace([',',' '],'',$request->pagu2021);
        
        $sasaran->target_kondisi_akhir = $request->target_akhir;
        $sasaran->pagu_kondisi_akhir   = $request->pagu_akhir;
            
        $sasaran->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tujuan  $tujuanRenstra
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
        $model = SasaranRenstra::findOrFail($id);
        $tujuans = Tujuan::get();

        return view('app.perencanaan.renstra.sasaran.edit', compact('model', 'tujuans'));
    }

    public function editIndikatorSasaran($id)
    {
        $model = IndikatorSasaran::findOrFail($id);
        $tujuans = Tujuan::get();
        $satuans = Satuan::get();
        $sasarans = SasaranRenstra::get();

        return view('app.perencanaan.renstra.sasaran.editIndikatorSasaran', compact('model', 'tujuans', 'satuans', 'sasarans'));
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
            'tujuan_nomor'  => 'required',
            'sasaran_nomor' => 'required',
            'sasaran_nama'  => 'required'
        ]);

        $sasaran = SasaranRenstra::findOrFail($id);
        $sasaran->tujuan_nomor = $request->tujuan_nomor;
        $sasaran->sasaran_nomor = $request->sasaran_nomor;
        $sasaran->sasaran_nama = $request->sasaran_nama;
        $sasaran->save();

        Alert::success('Berhasil', 'Data Berhasil Diupdate.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    public function updateIndikatorSasaran(Request $request, $id)
    {
        return $id;
        $this->validate($request, [
            'sasaran_nama'  => 'required',
            'indikator_sasaran_nomor'  => 'required',
            'indikator_sasaran_nama' => 'required',
            'satuan' => 'required',
        ]);

        $sasaran = SasaranRenstra::findOrFail($id);
        $sasaran->sasaran_nama = $request->sasaran_nama;
        $sasaran->indikator_sasaran_nomor = $request->indikator_sasaran_nomor;
        $sasaran->indikator_sasaran_nama = $request->indikator_sasaran_nama;
        $sasaran->satuan = $request->satuan;

        $sasaran->target_t1            = $request->target2017;
        $sasaran->target_t2            = $request->target2018;
        $sasaran->target_t3            = $request->target2019;
        $sasaran->target_t4            = $request->target2020;
        $sasaran->target_t5            = $request->target2021;
        
        $sasaran->pagu_t1              = str_replace([',',' '],'',$request->pagu2017);
        $sasaran->pagu_t2              = str_replace([',',' '],'',$request->pagu2018);
        $sasaran->pagu_t3              = str_replace([',',' '],'',$request->pagu2019);
        $sasaran->pagu_t4              = str_replace([',',' '],'',$request->pagu2020);
        $sasaran->pagu_t5              = str_replace([',',' '],'',$request->pagu2021);
        
        $sasaran->target_kondisi_akhir = $request->target_akhir;
        $sasaran->pagu_kondisi_akhir   = $request->pagu_akhir;
            
        $sasaran->save();

        Alert::success('Berhasil', 'Data Berhasil Disupdate.')->persistent('Close');
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
        $model = SasaranRenstra::findOrFail($id);
        $model->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    public function destroyIndikatorSasaran($id)
    {
        $model = IndikatorSasaran::findOrFail($id);
        $model->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');
        return redirect('perencanaan/rencana-strategis');
    }

    public function ajax($org_no)
    {
        $org = Organisasi::where('organisasi_no', $org_no)->first();
        $tujuan = Tujuan::where('organisasi_no', $org->organisasi_no)->get();

        return response()->json($tujuan);
    }

    public function ajaxIndikator($org_no)
    {
        $org = Organisasi::where('organisasi_no', $org_no)->first();
        $sasaran = SasaranRenstra::where('organisasi_no', $org->organisasi_no)->get();


        return response()->json($sasaran);
    }

    public function editRKT($id)
    {
        return $id;
    }

    public function updateRKT(Request $request ,$id)
    {
        return $id;
    }

}
