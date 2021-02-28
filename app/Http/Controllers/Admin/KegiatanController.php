<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KegiatanController extends Controller
{
    
    public function index()
    {
         $kegiatans = Kegiatan::paginate(25);

         return view('app.admin.master.kegiatan.index', compact('kegiatans'))->with('no', 1);
    }

}
