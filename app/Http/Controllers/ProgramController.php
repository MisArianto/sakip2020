<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Program;
use Yajra\Datatables\Datatables;
use Zofe\Rapyd\DataGrid\DataGrid;
use App\Models\GetApiController;
// use App\Http\Controllers\Api\GetApiController;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $api = GetApiController::get_api('program', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        $program = Program::get();
        return view('app.master.program.index', compact('program', 'api'))->with('no', 1);
    }

    public function dataPrgrm()
    {
        return DataTables::of(Program::query())->make(true);
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
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return $program;
        return view('app.master.program.edit',compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program=Program::findOrFail($id);
        return $program;
        $program->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus.')->persistent('Close');

        return redirect('master/program');
    }
}
