<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use Session;
use Storage;
use App\Models\Organisasi;
use App\Lkjip;
use Illuminate\Http\Request;

class LkjipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level == 1)
        {
            $lkjips = [];
            $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();

        }elseif(Auth::user()->level == 2)
        {
            $lkjips = Lkjip::where('organisasi_no', Auth::user()->organisasi_no)->get();
            $orgs = [];
        }
        
        $organisasi_no = '';
       
        return view('app.pelaporan.lkjip', compact('orgs', 'lkjips', 'organisasi_no'))->with('no', 1);
    }

    public function dataRequest(Request $request)
    {
        Session::put('organisasi_no', $request->organisasi_no);
        $lkjips = Lkjip::where('organisasi_no', Session::get('organisasi_no'))->get();
        $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
        $organisasi_no = Session::get('organisasi_no');
        return view('app.pelaporan.lkjip', compact('orgs', 'lkjips', 'organisasi_no'))->with('no', 1);
    }

    public function download(Request $request)
    {

        if(Auth::user()->level == 1)
        {
          
          $model = Lkjip::where('organisasi_no', $request->organisasi_no)->where('tahun', $request->tahun)->first();

           if($model == false)
           {
                Alert::warning('Data Tidak Ada.', 'Gagal!')->persistent('Close');
                return redirect('laporan/lkjip');
           }else{
           //  $file = public_path() . '/lkjip/' . $model->nama_file;//Mencari file dari model yang sudah dicari
           // return response()->download($file); //Download file yang dicari berdasarkan nama file

            return Storage::disk('local')->download('public/lkjip/'.$model->nama_file);
           }


        }elseif(Auth::user()->level == 2)
        {
           $model = Lkjip::where('organisasi_no', Auth::user()->organisasi_no)->where('tahun', $request->tahun)->first();

           if($model == false)
           {
                Alert::warning('Data Tidak Ada.', 'Gagal!')->persistent('Close');
                return redirect('laporan/lkjip');
           }else{
           //  $file = public_path() . '/lkjip/' . $model->nama_file;//Mencari file dari model yang sudah dicari
           // return response()->download($file); //Download file yang dicari berdasarkan nama file

            return Storage::disk('local')->download('public/lkjip/'.$model->nama_file);
           }
        }

       
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf',
            'tahun' => 'required'
        ]);

        if ($request->file == '') {
            Alert::warning('Pilih File.', 'Warning!')->persistent('Close');

            // alihkan halaman kembali
            return redirect('laporan/lkjip');
        }

        if(Auth::user()->level == 1)
        {
              // menangkap file excel
            $file = $request->file('file');

            // membuat nama file unik
            // $nama_file = rand().$file->getClientOriginalName();
            // $nama_file = rand().$file->getClientOriginalExtension();
            $name_organisasi = str_slug(Organisasi::where('organisasi_no', Session::get('organisasi_no'))->first()->organisasi_nama);
            $nama_file = $request->tahun.'-'.$name_organisasi.'-'.time().'.'.$file->getClientOriginalExtension();

            // upload ke folder import_data di dalam folder public
            // $file->move('lkjip',$nama_file);

            Storage::putFileAs('public/lkjip', $request->file('file'), $nama_file);


            $model = new Lkjip;
            $model->nama_file = $nama_file;
            $model->organisasi_no = Session::get('organisasi_no');
            $model->tahun = $request->tahun;
            $model->save();

        }elseif(Auth::user()->level == 2)
        {
            // menangkap file excel
            $file = $request->file('file');

            // membuat nama file unik
            // $nama_file = rand().$file->getClientOriginalName();
            // $nama_file = rand().$file->getClientOriginalExtension();
            $name_organisasi = str_slug(Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first()->organisasi_nama);
            $nama_file = $request->tahun.'-'.$name_organisasi.'-'.time().'.'.$file->getClientOriginalExtension();

            // upload ke folder import_data di dalam folder public
            // $file->move('lkjip',$nama_file);

            Storage::putFileAs('public/lkjip', $request->file('file'), $nama_file);


            $model = new Lkjip;
            $model->nama_file = $nama_file;
            $model->organisasi_no = Auth::user()->organisasi_no;
             $model->tahun = $request->tahun;
            $model->save();
        }

        // notifikasi dengan session
        Alert::success('Data Berhasil Diupload.', 'Berhasil!')->persistent('Close');

        // alihkan halaman kembali
        return redirect('laporan/lkjip');
    }

    public function ajax_view_lkjip($id)
    {
        return $id;
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
     * @param  \App\Lkjip  $lkjip
     * @return \Illuminate\Http\Response
     */
    public function show(Lkjip $lkjip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lkjip  $lkjip
     * @return \Illuminate\Http\Response
     */
    public function edit(Lkjip $lkjip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lkjip  $lkjip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lkjip $lkjip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lkjip  $lkjip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Lkjip::where('id', $id)->first();
        // unlink(public_path('storage/lkjip/', $model->nama_file));
        Storage::disk('local')->delete('public/lkjip/'. $model->nama_file);
        $model->delete();

        // notifikasi dengan session
        Alert::success('Data Berhasil Di hapus.', 'Berhasil!')->persistent('Close');

        // alihkan halaman kembali
        return redirect('laporan/lkjip');
    }
}
