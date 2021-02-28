<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Alert;
use App\Models\Organisasi;
use App\Models\lhe;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    public function index()
    {
        $lhes =lhe::join('organisasi', 'organisasi.organisasi_no', '=', 'lhe.organisasi_no')->where('tahun', '2018')->get(['lhe.id', 'lhe.nilai', 'organisasi.organisasi_nama', 'lhe.tahun']);

       

        $tahun = '2018';
        $tahun_int = '2018';


        return view('app.evaluasi.index', compact('lhes', 'tahun','tahun_int'))->with('no', 1);
    }

    public function create()
    {
         $orgs = Organisasi::where('organisasi_jenis','ORG')->get();
         return view('app.evaluasi.add', compact('orgs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'organisasi_no' => 'required',
            'nilai' => 'required',
            'tahun' => 'required',
        ]);

        $model = new lhe;
        $model->organisasi_no = $request->organisasi_no;
        $model->nilai = $request->nilai;
        $model->tahun = $request->tahun;
        $model->save();

        Alert::success('Data Berhasil di Simpan', 'Success');
        return redirect('evaluasi/lhe');

    }


    public function index_lhe()
    {
        // $orgs = Organisasi::where('organisasi_jenis','ORG')->get();

        $lhes =lhe::join('organisasi', 'organisasi.organisasi_no', '=', 'lhe.organisasi_no')->where('tahun', date('Y') - 1)->orderBy('lhe.nilai', 'DESC')->get(['lhe.id', 'lhe.nilai', 'organisasi.organisasi_nama','organisasi.organisasi_no', 'lhe.tahun']);
        $tahun_int = date('Y') - 1;
        // $tahun_int = '2018';

        return view('public.evaluasi.index', compact('lhes', 'tahun_int'))->with('no', 1);
    }



    public function requestLhe(Request $request)
    {

        if(Auth::user()->level == 2){

             $lhes = lhe::join('organisasi', 'organisasi.organisasi_no', '=', 'lhe.organisasi_no')
                    ->where('lhe.organisasi_no', Auth::user()->organisasi_no)
                    ->where('lhe.tahun', $request->tahun)
                    ->groupBy('organisasi.organisasi_no')
                    ->orderBy('organisasi.organisasi_no')
                    ->get(['lhe.id', 'lhe.nilai', 'organisasi.organisasi_nama', 'lhe.tahun']);
                    
            $opd = Organisasi::where('organisasi_jenis','ORG')->where('organisasi_no', Auth::user()->organisasi_no)->first();
        }else{

            $lhes = lhe::join('organisasi', 'organisasi.organisasi_no', '=', 'lhe.organisasi_no')
                    // ->where('lhe.organisasi_no', $request->organisasi_no)
                    ->where('lhe.tahun', $request->tahun)
                    ->groupBy('organisasi.organisasi_no')
                    ->orderBy('organisasi.organisasi_no')
                    ->get(['lhe.id', 'lhe.nilai', 'organisasi.organisasi_nama', 'lhe.tahun']);

                    // return $lhes;
            $opd = '';
        }

        $tahun = $request->tahun;
        $tahun_int = $request->tahun;



        return view('app.evaluasi.index', compact('opd', 'lhes', 'tahun','tahun_int'))->with('no', 1);
    }

    public function requestTahun(Request $request)
    {
        $lhes = lhe::join('organisasi', 'organisasi.organisasi_no', '=', 'lhe.organisasi_no')
                ->where('lhe.tahun', $request->tahun)
                ->groupBy('organisasi.organisasi_no')
                ->orderBy('organisasi.organisasi_no')
                ->get(['lhe.id', 'lhe.nilai', 'organisasi.organisasi_nama', 'lhe.tahun']);


        $tahun_int = $request->tahun;



        return view('public.evaluasi.index', compact('lhes', 'tahun_int'));
    }

    public function edit($id)
    {
    	$model = Lhe::findOrFail($id);
    	 return view('app.evaluasi.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
    		'nilai' => 'required'
    	]);

    	$model = Lhe::findOrFail($id);
    	$model->nilai = $request->nilai;
    	$model->save();

    	Alert::success('Data Berhasil di Update', 'Success');
        return redirect('evaluasi/lhe');

    }


}
