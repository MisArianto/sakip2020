<?php

namespace App\Http\Controllers\Admin;

use App\Models\SKM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkmAdminController extends Controller
{
   
    public function index()
    {
        return view('app.admin.skm.index');
    }

    public function fetch()
    {
        $skms = SKM::latest()->get();

        return response()->json([
            'skms' => $skms
        ],200);
    }
    
}
