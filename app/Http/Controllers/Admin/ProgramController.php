<?php

namespace App\Http\Controllers\Admin;

use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::paginate(25);
        return view('app.admin.master.program.index', compact('programs'))->with('no', 1);
    }

    
}
