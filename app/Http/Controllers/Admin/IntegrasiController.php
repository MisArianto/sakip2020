<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegrasiController extends Controller
{
    public function index()
    {
    	return view('app.admin.integrasi.index');
    }
}
