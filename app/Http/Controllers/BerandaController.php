<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Dpa;
use App\Models\Organisasi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        // $dpa = file_get_contents('http://36.89.42.125:8080/api/v1/$2y$10$9DdIturRHsmF7ZlPHvccB.Ha6KPp2lPmUjf1JcmAQwt.JcCeUF79G');
        // $data=json_decode($dpa);

        // $ss = Dpa::get();
        // if (!$ss->isEmpty()) {
        //     // dd ($data);
        //     return $data;
        //      // return view('app.master.dpa.index', compact('data'))->with('no',1);
        //  }else{
        //     foreach ($data as  $value) {
        //         $dpa = new Dpa;
        //         $dpa->unitkey = $value->UNITKEY;
        //         $dpa->kdkegunit = $value->KDKEGUNIT;
        //         $dpa->mtgkey = $value->MTGKEY;
        //         // $dpa->idxdask = $value->IDXDASK;
        //         // $dpa->kdnilai = $value->KDNILAI;
        //         $dpa->kdjabar = $value->KDJABAR;
        //         $dpa->uraian = $value->URAIAN;
        //         // $dpa->jumbyek = $value->JUMBYEK;
        //         $dpa->satuan = $value->SATUAN;
        //         $dpa->tarif = $value->TARIF;
        //         $dpa->subtotal = $value->SUBTOTAL;
        //         $dpa->ekspresi = $value->EKSPRESI;
        //         // $dpa->inclsubtotal = $value->INCLSUBTOTAL;
        //         $dpa->type = $value->TYPE;
        //         // $dpa->idstdharga = $value->IDSTDHARGA;
        //         // $dpa->kddana = $value->KDDANA;
        //         $dpa->save();
        //     }
        //     // dd ($data);
        //     return $data;
        // }

            // $orgs = Dpa::join('organisasi','organisasi.unitkey','=','dpa.unitkey')
            //     ->groupBy('dpa.unitkey')
            //     ->orderBy('organisasi.kdunit')->paginate(10);
            //     // return $orgs;

            // $total2 = Dpa::select('unitkey',DB::raw('SUM(subtotal) as total'))
            //     ->groupBy('unitkey')
            //     ->get();
            //     // return $total2;
            // $grandtotal = Dpa::select('subtotal',DB::raw('SUM(subtotal) as total') )
            //     ->get();
            return view('public.beranda');
         
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
        $dpa = Dpa::join('organisasi','organisasi.unitkey', '=', 'dpa.unitkey')
                ->join('kegiatan','kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('mata_anggaran','mata_anggaran.mtgkey', '=', 'dpa.mtgkey')
                ->leftJoin('program','program.idprgrm', '=', 'kegiatan.idprgrm')
                // ->select('dpa.unitkey')
                ->select('organisasi.nmunit')
                // ->where('kegiatan.kdkegunit','=','1_')
                ->orderBy('kegiatan.nukeg')
                ->get();

        $dpa2 = Dpa::where('unitkey', $request->unitkey)->first();
        // $kegiatan = Kegiatan::where('kdkegunit', $dpa2->kdkegunit)->get();
        // dump($request->unitkey);

        // return view('dpa', compact('dpa'))->with('no', 1);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dpa  $dpa
     * @return \Illuminate\Http\Response
     */
    public function show(Dpa $dpa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dpa  $dpa
     * @return \Illuminate\Http\Response
     */
    public function edit(Dpa $dpa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dpa  $dpa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dpa $dpa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dpa  $dpa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dpa $dpa)
    {
        //
    }

    public function organisasi($unitkey)
    {
        // $dpa = Dpa::where('unitkey', $unitkey)->first();
        // $dpa = Dpa::where('unitkey', $unitkey)->paginate(10);
        // return $dpa;
        $kegiatan = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi','organisasi.unitkey', '=', 'dpa.unitkey')
                ->leftJoin('program' , 'program.idprgrm', '=', 'kegiatan.idprgrm')
                // ->join('organisasi', 'organisasi.unitkey', '=','dpa.unitkey')
                ->select( 'dpa.unitkey','dpa.kdkegunit', 'organisasi.kdunit','kegiatan.idprgrm','kegiatan.nmkegunit', 'kegiatan.nukeg')
                ->where('dpa.unitkey', $unitkey)
                // ->groupBy('dpa.unitkey')
                // ->groupBy('dpa.kdkegunit')
                ->groupBy('kegiatan.nmkegunit')
                // ->groupBy('kegiatan.nukeg')
                // ->groupBy('program.nuprgrm')
                // ->groupBy('program.nmprgrm')
                // ->groupBy('organisasi.kdunit')
                // ->groupBy('organisasi.nmunit')
                ->orderBy('program.nuprgrm')
                ->orderBy('kegiatan.nukeg')
                // ->groupBy('organisasi.nmunit')
                ->get();
                // return $kegiatan;

        $total_keg = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi','organisasi.unitkey', '=', 'dpa.unitkey')
                ->leftJoin('program' , 'program.idprgrm', '=', 'kegiatan.idprgrm')
                // ->join('organisasi', 'organisasi.unitkey', '=','dpa.unitkey')
                ->select( 'dpa.unitkey','dpa.kdkegunit', 'organisasi.kdunit','kegiatan.idprgrm','kegiatan.nmkegunit', 'kegiatan.nukeg', DB::raw('SUM(subtotal) as total'))
                ->where('dpa.unitkey', $unitkey)
                // ->groupBy('dpa.unitkey')
                // ->groupBy('dpa.kdkegunit')
                ->groupBy('kegiatan.nmkegunit')
                // ->groupBy('kegiatan.nukeg')
                // ->groupBy('program.nuprgrm')
                // ->groupBy('program.nmprgrm')
                // ->groupBy('organisasi.kdunit')
                // ->groupBy('organisasi.nmunit')
                ->orderBy('program.nuprgrm')
                ->orderBy('kegiatan.nukeg')
                // ->groupBy('organisasi.nmunit')
                ->get();
                // return $total_keg;


        $program = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi','organisasi.unitkey', '=', 'dpa.unitkey')
                ->leftJoin('program' , 'program.idprgrm', '=', 'kegiatan.idprgrm')
                // ->join('organisasi', 'organisasi.unitkey', '=','dpa.unitkey')
                ->select('dpa.unitkey','organisasi.kdunit', 'program.idprgrm','program.nuprgrm', 'program.nmprgrm')
                ->where('dpa.unitkey', $unitkey)
                // ->groupBy('dpa.unitkey')
                // ->groupBy('dpa.kdkegunit')
                // ->groupBy('kegiatan.nmkegunit') 
                // ->groupBy('kegiatan.nukeg')
                ->groupBy('program.nuprgrm')
                // ->groupBy('program.nmprgrm')
                // ->groupBy('organisasi.kdunit')
                // ->groupBy('organisasi.nmunit')
                ->orderBy('program.nuprgrm')
                ->orderBy('kegiatan.nukeg')
                // ->groupBy('organisasi.nmunit')
                ->get();
                // return $program;
                
        $total_p = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi','organisasi.unitkey', '=', 'dpa.unitkey')
                ->leftJoin('program' , 'program.idprgrm', '=', 'kegiatan.idprgrm')
                // ->join('organisasi', 'organisasi.unitkey', '=','dpa.unitkey')
                ->select('dpa.unitkey','organisasi.kdunit', 'program.idprgrm','program.nuprgrm', 'program.nmprgrm',DB::raw('SUM(subtotal) as total'))
                ->where('dpa.unitkey', $unitkey)
                // ->groupBy('dpa.unitkey')
                // ->groupBy('dpa.kdkegunit')
                // ->groupBy('kegiatan.nmkegunit') 
                // ->groupBy('kegiatan.nukeg')
                ->groupBy('program.nuprgrm')
                // ->groupBy('program.nmprgrm')
                // ->groupBy('organisasi.kdunit')
                // ->groupBy('organisasi.nmunit')
                ->orderBy('program.nuprgrm')
                ->orderBy('kegiatan.nukeg')
                // ->groupBy('organisasi.nmunit')
                ->get();
                // return $total_p;

        $organisasi = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi','organisasi.unitkey', '=', 'dpa.unitkey')
                ->leftJoin('program' , 'program.idprgrm', '=', 'kegiatan.idprgrm')
                // ->join('organisasi', 'organisasi.unitkey', '=','dpa.unitkey')
                ->select('dpa.unitkey','organisasi.kdunit', 'organisasi.nmunit')
                ->where('dpa.unitkey', $unitkey)
                // ->groupBy('dpa.unitkey')
                // ->groupBy('dpa.kdkegunit')
                // ->groupBy('kegiatan.nmkegunit')
                // ->groupBy('kegiatan.nukeg')
                // ->groupBy('program.nuprgrm')
                // ->groupBy('program.nmprgrm')
                ->groupBy('organisasi.kdunit')
                // ->groupBy('organisasi.nmunit')
                ->orderBy('program.nuprgrm')
                ->orderBy('kegiatan.nukeg')
                // ->groupBy('organisasi.nmunit')
                ->get();

        $total = Dpa::select('unitkey',DB::raw('SUM(subtotal) as total'))
                ->groupBy('unitkey')
                ->where('unitkey', $unitkey)
                ->get();

        // return $organisasi;
                
       

        // return $kegiatan;
        return view('app.master.dpa.kegiatan', compact('kegiatan','program','organisasi','total','total_p','total_keg'));
    }

    public function kegiatan($unitkey, $kdkegunit)
    {
        // $dpa = DB::table('dpa')->join('organisasi', 'organisasi.unitkey', '=' ,'dpa.unitkey')->get();
        // $dpa = Dpa::where('kdkegunit', $kdkegunit)->where('unitkey', $unitkey)->get();
        $dpa_keg = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi', 'organisasi.unitkey', '=', 'dpa.unitkey')
                ->leftJoin('program', 'program.idprgrm', '=', 'kegiatan.idprgrm')
                ->select('organisasi.kdunit','organisasi.nmunit','program.nuprgrm','program.nmprgrm','dpa.kdkegunit','kegiatan.nukeg','kegiatan.nmkegunit')
                ->groupBy('organisasi.kdunit','program.nuprgrm','program.nmprgrm','kegiatan.nukeg','kegiatan.nmkegunit')
                ->where('dpa.kdkegunit', $kdkegunit)->where('dpa.unitkey', $unitkey)
                ->get();
// return $dpa_keg;
        $dpa = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi', 'organisasi.unitkey', '=', 'dpa.unitkey')
                ->join('mata_anggaran', 'mata_anggaran.mtgkey', '=', 'dpa.mtgkey')
                ->leftJoin('program', 'program.idprgrm', '=', 'kegiatan.idprgrm')
                ->select('mata_anggaran.kdper','mata_anggaran.nmper','dpa.mtgkey')
                // ->groupBy('kegiatan.nukeg','kegiatan.nmkegunit','dpa.mtgkey','mata_anggaran.kdper','mata_anggaran.nmper','dpa.kdjabar','dpa.uraian','dpa.jumbyek','dpa.satuan','dpa.tarif','dpa.subtotal')
                ->groupBy('dpa.mtgkey')
                ->where('dpa.kdkegunit', $kdkegunit)
                ->where('dpa.unitkey', $unitkey)
                ->get();

        $dpa2 = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi', 'organisasi.unitkey', '=', 'dpa.unitkey')
                ->join('mata_anggaran', 'mata_anggaran.mtgkey', '=', 'dpa.mtgkey')
                ->leftJoin('program', 'program.idprgrm', '=', 'kegiatan.idprgrm')
                ->select('dpa.mtgkey','dpa.kdjabar','dpa.uraian','dpa.ekspresi','dpa.satuan','dpa.tarif','dpa.subtotal')
                // ->groupBy('kegiatan.nukeg','kegiatan.nmkegunit','dpa.mtgkey','mata_anggaran.kdper','mata_anggaran.nmper','dpa.kdjabar','dpa.uraian','dpa.jumbyek','dpa.satuan','dpa.tarif','dpa.subtotal')
                // ->groupBy('dpa.mtgkey')
                ->where('dpa.kdkegunit', $kdkegunit)
                ->where('dpa.unitkey', $unitkey)
                ->orderBy('dpa.kdjabar')
                ->get();

  
        $total_k = Dpa::select('kdkegunit','uraian',DB::raw('SUM(subtotal) as total'))
                ->groupBy('kdkegunit')

                ->where('unitkey', $unitkey)
                ->where('dpa.kdkegunit', $kdkegunit)
                ->get();

                // return $total_k;
                // return $dpa;
            
        // $total = Dpa::join('organisasi','organisasi.unitkey', '=', 'dpa.unitkey')
        //         ->join('kegiatan','kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
        //         ->join('mata_anggaran','mata_anggaran.mtgkey', '=', 'dpa.mtgkey')
        //         ->leftJoin('program','program.idprgrm', '=', 'kegiatan.idprgrm')
        //         ->select('organisasi.kdunit','organisasi.nmunit','program.nuprgrm','program.nmprgrm','kegiatan.nukeg','kegiatan.nmkegunit','mata_anggaran.kdper','mata_anggaran.nmper','dpa.kdjabar','dpa.uraian','dpa.jumbyek','dpa.satuan','dpa.tarif','dpa.subtotal', 'dpa.kdkegunit', 'dpa.mtgkey')
        //         ->groupBy('organisasi.kdunit','organisasi.nmunit','program.nuprgrm','program.nmprgrm','kegiatan.nukeg','kegiatan.nmkegunit','mata_anggaran.kdper','mata_anggaran.nmper','dpa.kdjabar','dpa.uraian','dpa.jumbyek','dpa.satuan','dpa.tarif','dpa.subtotal', 'dpa.kdkegunit', 'dpa.mtgkey')
        //         ->where('dpa.unitkey','=',$request->unitkey)
        //         ->orderBy('organisasi.kdunit')
        //         ->orderBy('program.nuprgrm')
        //         ->orderBy('kegiatan.nukeg')
        //         ->orderBy('dpa.kdjabar')
        //         ->get();


                foreach ($dpa as $value) {
                    $dinas[] = [
                        'kdunit' => $value->kdunit,
                        'nmunit' => $value->nmunit,
                    ];
                }
                
                $dinas2 = collect($dinas)->first();


                foreach ($dpa as $value1) {
                    $program[] = [
                        'nuprgrm' => $value1->nuprgrm,
                        'nmprgrm' => $value1->nmprgrm,
                    ];
                }

                 $program2 = collect($program)->first();

                 foreach ($dpa as $value2) {
                    $kegiatan[] = [
                        'nukeg' => $value2->nukeg,
                        'nmkegunit' => $value2->nmkegunit,
                        'uraian' => $value2->uraian,

                    ];
                }

                 $kegiatan2 = collect($kegiatan)->first();
                 
                 // return $dpa;
                //  foreach ($total as $value3) {
                //     $total_pagu[] = [
                //         'pagu' => $value3->subtotal,
                //     ];
                // }

                // $total_pagu2 = collect($total_pagu)->sum('pagu');
                // 
                // 
                // 
        // return $dpa;
        // return $dpa;
        // 
        // 
        // foreach($dpa as $value){
        //     $subtotal[] = [
        //         'subtotal' => $value->subtotal
        //     ];
        // }

        // foreach($dpa as $value1){
        //     // $kode[] = [
        //     //     'kode' => $value->subtotal
        //     // ];
        //     $kode[] =  $value1->subtotal;
        // }

        // // return $kode;

        // foreach($dpa as $value2){
        //     // $nama[] = $value->nmkegunit;
        //     $namakeg[] = $value2->nmkegunit; 
        // }
        // // $namakeg = collect($nama)->first();
        // // return collect($nama);

        // foreach($dpa as $value3){
        //     $arr[] = [
        //         'kode' => collect('kode'),    
        //         'nama' => collect('nama'),    
        //         'anggaran' => collect($subtotal)->sum('subtotal')   
        //     ];
        // }
        // return $arr;
        // 
        // 
        return view('app.master.dpa.uraian', compact('dpa','dpa2','dpa_keg', 'dinas2', 'total_k', 'kegiatan2'));
    }
}
