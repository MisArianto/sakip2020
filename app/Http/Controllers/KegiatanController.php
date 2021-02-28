<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Program;
use App\Models\Kegiatan;
use Yajra\Datatables\Datatables;
use App\Models\GetApiController;
// use App\Http\Controllers\Api\GetApiController;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $api = GetApiController::get_api('kegiatan', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
         // dd($api);
         $kegiatan = Kegiatan::get();

         return view('app.master.kegiatan.index', compact('kegiatan', 'api'))->with('no', 1);
    }

    public function dataKeg()
    {
        return DataTables::of(Kegiatan::join('program','program.program_no','=','kegiatan.program_no'))->make(true);
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
     * @param  \App\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return $kegiatan;
        return view('app.master.kegiatan.edit',compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kegiatan=Kegiatan::findOrFail($id);
        return $kegiatan;
        $kegiatan->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');

        return redirect('master/kegiatan');
    }

    public function kegiatan($unitkey, $kdkegunit)
    {
        // $dpa = DB::table('dpa')->join('organisasi', 'organisasi.unitkey', '=' ,'dpa.unitkey')->get();
        // $dpa = Dpa::where('kdkegunit', $kdkegunit)->where('unitkey', $unitkey)->get();
        $dpa_keg = Dpa::join('kegiatan', 'kegiatan.kdkegunit', '=', 'dpa.kdkegunit')
                ->join('organisasi', 'organisasi.unitkey', '=', 'dpa.unitkey')
                ->leftJoin('program', 'program.idprgrm', '=', 'kegiatan.idprgrm')
                ->select('organisasi.kdunit','program.nuprgrm','program.nmprgrm','kegiatan.nukeg','kegiatan.nmkegunit')
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
                ->select('dpa.mtgkey','dpa.kdjabar','dpa.uraian','dpa.jumbyek','dpa.satuan','dpa.tarif','dpa.subtotal')
                // ->groupBy('kegiatan.nukeg','kegiatan.nmkegunit','dpa.mtgkey','mata_anggaran.kdper','mata_anggaran.nmper','dpa.kdjabar','dpa.uraian','dpa.jumbyek','dpa.satuan','dpa.tarif','dpa.subtotal')
                // ->groupBy('dpa.mtgkey')
                ->where('dpa.kdkegunit', $kdkegunit)
                ->where('dpa.unitkey', $unitkey)
                ->orderBy('dpa.kdjabar')
                ->get();
                // return $anggaran;
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
        return view('uraian', compact('dpa','dpa2','dpa_keg', 'dinas2', 'program2', 'kegiatan2'));
    }

}
