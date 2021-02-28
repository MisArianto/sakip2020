<?php

namespace App\Http\Controllers\User;

use PDF;
use Auth;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CetakController extends Controller
{

    public function index()
    {
        return view('app.user.cetak.index');
    }

    public function cetak_pk_pdf()
    {
        $model = Pegawai::where('organisasi_no', Auth::user()->organisasi_no)->get();

        return view('app.user.cetak.cetak_pk_pdf', $model);


        // $pdf = PDF::loadView('app.user.cetak.cetak_pk_pdf', $model);
        // return $pdf->download('Perjanjian Kinerja '.get_name_opd(Auth::user()->organisasi_no).'.pdf');

    }
}
