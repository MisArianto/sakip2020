<?php

namespace App\Http\Controllers;

use DB;
use Storage;
use App\Lkjip;
use App\Models\Organisasi;
use Illuminate\Http\Request;

class PelaporanController extends Controller
{
   public function index()
    {
        $orgs = Organisasi::where('organisasi_jenis','ORG')->get();
        // return $orgs;

        return view('public.pelaporan.index', compact('orgs'));
    }

    public function form($organisasi_no)
    {
      $lkjips = Lkjip::where('organisasi_no', $organisasi_no)->get();
      $org = Organisasi::where('organisasi_jenis','ORG')->where('organisasi_no', $organisasi_no)->first();
      $nama_opd = $org->organisasi_nama;
      return view('public.pelaporan.form', compact('lkjips', 'nama_opd'))->with('no', 1);
    }

    public function download(Request $request)
    {
    	// return $request->organisasi_no;
    	$model = Lkjip::where('organisasi_no', $request->organisasi_no)->first();

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
