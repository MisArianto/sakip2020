<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GetApiController;
// use App\Http\Controllers\Api\GetApiController;
use App\Models\Satuan;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $api = GetApiController::get_api('satuan', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        $satuan = Satuan::orderBy('satuan_nama')->get();

         return view('app.master.satuan.index', compact('satuan', 'api'))->with('no', 1);
    }
    public function dataSatuan()
    {
        return DataTables::of(Satuan::orderBy('satuan_nama'))
        ->addIndexColumn()
        ->make(true);
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
     * @param  \App\satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show(satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, satuan $satuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(satuan $satuan)
    {
        //
    }
}
