<?php

namespace App\Http\Controllers\Admin;

use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SatuanController extends Controller
{
   
    public function index()
    {
        $satuans = Satuan::paginate(25);

         return view('app.admin.master.satuan.index', compact('satuans'))->with('no', 1);
    }
    
}
