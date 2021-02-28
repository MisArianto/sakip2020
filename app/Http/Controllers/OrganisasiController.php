<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Organisasi;
use App\Models\GetApiController;
// use App\Http\Controllers\API\GetApiController;
// use App\Models\Organisasi2;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $api = GetApiController::get_api('organisasi', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
       // dd($api);
       $orgs = Organisasi::get();

       return view('app.master.organisasi.index', compact('orgs'));
    }

    public function dataOrgs()
    {
        return DataTables::of(Organisasi::where('organisasi_jenis','=','ORG'))->make(true);
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
     * @param  \App\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function show(Organisasi $organisasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $opd = Organisasi::findOrFail($id);
        return view('app.master.organisasi.edit',compact('opd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $id;
        $organisasi=Organisasi::findOrFail($id)->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');

        return redirect('master/organisasi');
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

        // return $organisasi;
                
       

        // return $kegiatan;
        return view('kegiatan', compact('kegiatan','program','organisasi'));
    }
}
