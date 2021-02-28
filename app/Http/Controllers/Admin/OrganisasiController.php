<?php

namespace App\Http\Controllers\Admin;

use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganisasiController extends Controller
{
    
    public function index()
    {
       $orgs = Organisasi::where('organisasi_jenis','=','ORG')->get();

       return view('app.admin.master.organisasi.index', compact('orgs'))->with('no',1);
    }
}
