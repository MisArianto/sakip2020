<?php

namespace App\Http\Controllers\Admin;

use App\Models\SKM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SKMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.SKM.index');
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
        $this->validate($request, [
        	'email' => 'required|email|unique:skm',
        	'jk' => 'required',
        	'usia' => 'required',
        	'pendidikan' => 'required',
        	'u1' => 'required',
        	'u2' => 'required',
        	'u3' => 'required',
        	'u4' => 'required',
        	'u5' => 'required',
        	'u6' => 'required',
        	'u7' => 'required',
        	'u8' => 'required',
        	'u9' => 'required',
        	'u10' => 'required',
        	'u11' => 'required',
        	'u12' => 'required'
        ]);

        $array = [
        	'u1' => $request->u1,
        	'u2' => $request->u2,
        	'u3' => $request->u3,
        	'u4' => $request->u4,
        	'u5' => $request->u5,
        	'u6' => $request->u6,
        	'u7' => $request->u7,
        	'u8' => $request->u8,
        	'u9' => $request->u9,
        	'u10' => $request->u10,
        	'u11' => $request->u11,
        	'u12' => $request->u12
        ];

        SKM::create([
        	'email' => $request->email,
        	'jk' => $request->jk,
        	'usia' => $request->usia,
        	'pendidikan' => $request->pendidikan,
        	'jawaban' => json_encode($array)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
