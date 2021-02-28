<?php

namespace App\Http\Controllers;

use DB;
use Alert;
use Auth;
use App\Models\Pegawai;
use App\Models\Organisasi;
use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pegawais = Pegawai::get();

        // foreach ($pegawais as $dd) {
            
        //     $pegawai = Pegawai::where('id', $dd->id)->first();

        //     return $pegawai;

        //     if($pegawai->jabatan == 'Kepala' || $pegawai->jabatan == 'Inspektur' || $pegawai->jabatan == 'Camat')
        //     {
        //         $pegawai->status = 1;

        //     }elseif($pegawai->jabatan == 'Sekretaris' || $pegawai->jabatan == 'Sekretaris Camat')
        //     {
        //         $pegawai->status = 2;

        //     }elseif($pegawai->jabatan == 'Kepala Bidang')
        //     {
        //         $pegawai->status = 3;

        //     }elseif($pegawai->jabatan == 'Kepala Seksi' || $pegawai->jabatan == 'Kepala Sub Bidang')
        //     {
        //         $pegawai->status = 4;

        //     }elseif($pegawai->jabatan == 'Staff')
        //     {
        //         $pegawai->status = 0;

        //     }
            
        //     $pegawai->save();


        // }

        // return 'selesai';

        $opds  = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get();
        //         return $opds;

        if(Auth::user()->level == 2){
            // $pegawai = Pegawai::join('organisasi as org','org.organisasi_no','=','pegawai.organisasi_no')
            // ->orderBy('status')
            // ->where('pegawai.organisasi_no', Auth::user()->organisasi_no)->get();

            $pegawai = Pegawai::where('pegawai.organisasi_no','=',Auth::user()->organisasi_no)->get();

            $opd = [];
        }else{
            $pegawai = [];
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
        }
        // return $opd;

        // $pegawai = Pegawai::join('organisasi','organisasi.organisasi_no','=','pegawai.organisasi_no')->get();
        
        // return $pegawai;
        return view('app.master.pegawai.index', compact('pegawai','opd','opds'))->with('no', 1);
    }

    public function dataPegawai(Request $request)
    {
        // if(Auth::user()->level != 1){
        //     $opd = Organisasi::orderBy('organisasi_no')
        //     ->where('organisasi_jenis','=','ORG')
        //     ->where('organisasi_no', Auth::user()->organisasi_no)->get();
        // }else{
        //     $opd = Organisasi::orderBy('organisasi_no')
        //     ->where('organisasi_jenis','=','ORG')
        //     ->get();
        // }
        $opd = Organisasi::orderBy('organisasi_no')
                ->where('organisasi_jenis','=','ORG')
                // ->where('organisasi_no','=',$request->organisasi_no)
                ->get();

        $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                ->get(); 
                // return $opds;
        $pegawai = Pegawai::where('pegawai.organisasi_no','=',$request->organisasi_no)->get();
        // return $pegawai;

        return view('app.master.pegawai.index', compact('opd','opds','pegawai'))->with('no', 1);
        
    }
// join('organisasi','organisasi.kdunit','=','pegawai.kdunit')
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opd = Organisasi::where('organisasi_jenis','=','ORG')->get();
        return view('app.master.pegawai.create', compact('opd'));
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
            'nama' => 'required',
            'nip' => 'required',
            'golongan' => 'required',
            'jabatan' => 'required',
        ]);

        $pegawai = new Pegawai;
        $pegawai->nama = $request->nama;
        $pegawai->nip = $request->nip;
        $pegawai->golongan = $request->golongan;
        $pegawai->jabatan = $request->jabatan;
        $pegawai->uraian = $request->uraian;
        // $pegawai->organisasi_no = $request->opd;
        if($request->jabatan == 'Sekretaris Daerah')
        {
            $pegawai->status = 1;

        }
        elseif($request->jabatan == 'Kepala' || $request->jabatan == 'Inspektur' || $request->jabatan == 'Camat' || $request->jabatan == 'Sekretaris DPRD' || $request->jabatan == 'Kepala Bagian')
        {
            $pegawai->status = 2;

        }
        elseif($request->jabatan == 'Sekretaris' || $request->jabatan == 'Sekretaris Camat' || $request->jabatan == 'Kepala Bidang' )
        {
            $pegawai->status = 3;

        }elseif($request->jabatan == 'Kepala Seksi' || $request->jabatan == 'Kepala Sub Bidang' || $request->jabatan == 'Kepala Sub Bagian')
        {
            $pegawai->status = 4;

        }elseif($request->jabatan == 'Staff')
        {
            $pegawai->status = 5;

        }
        if(Auth::user()->level == 1)
        {
            $pegawai->organisasi_no = $request->opd;
        }else{
            $pegawai->organisasi_no = Auth::user()->organisasi_no;
        }
        $pegawai->save();

        Alert::success('Data Berhasil Ditambahkan.', 'Berhasil!')->persistent('Close');

        return redirect('pegawai');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai, $id)
    {
        $blog = Pegawai::find($id);
        return view('app.master.pegawai',compact('blog'))->renderSections()['content'];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $opd = Organisasi::where('organisasi_jenis','=','ORG')->get();


        $pegawai = Pegawai::where('id', Hashids::decode($id))->first();

        // $opds  = Organisasi::where('organisasi_no','=',$pegawai->organisasi_no)
        //         ->select('organisasi_no','organisasi_nama')
        //         // ->groupBy('misi_no')
        //         ->get(); 
        //         return $opds;
                

        return view('app.master.pegawai.edit', compact('opd', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nip' => 'required|unique:pegawai,nip,'.$id,
            'golongan' => 'required',
            'jabatan' => 'required',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->nama = $request->nama;
        $pegawai->nip = $request->nip;
        $pegawai->golongan = $request->golongan;
        $pegawai->jabatan = $request->jabatan;
        $pegawai->uraian = $request->uraian;
        // $pegawai->organisasi_no = $request->opd;
        if($request->jabatan == 'Kepala' || $request->jabatan == 'Inspektur' || $request->jabatan == 'Camat')
        {
            $pegawai->status = 1;

        }elseif($request->jabatan == 'Sekretaris' || $request->jabatan == 'Sekretaris Camat')
        {
            $pegawai->status = 2;

        }elseif($request->jabatan == 'Kepala Bidang')
        {
            $pegawai->status = 3;

        }elseif($request->jabatan == 'Kepala Seksi' || $request->jabatan == 'Kepala Sub Bidang')
        {
            $pegawai->status = 4;

        }elseif($request->jabatan == 'Staff')
        {
            $pegawai->status = 0;

        }
        if(Auth::user()->level == 1)
        {
            $pegawai->organisasi_no = $request->opd;
        }else{
            $pegawai->organisasi_no = Auth::user()->organisasi_no;
        }
        $pegawai->save();

        Alert::success('Data Berhasil Diupdate.', 'Berhasil!')->persistent('Close');

        return redirect('pegawai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::where('id', Hashids::decode($id))->first();
        $pegawai->delete();

        Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');

        // $pegawai=Pegawai::findOrFail($id);
        // $pegawai->delete();
        // Alert::success('Data Berhasil Dihapus.', 'Berhasil!')->persistent('Close');
        return back();
        // return redirect('pegawai');
    }
}
