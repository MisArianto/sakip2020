<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\ProgramRpjmd;
use App\Models\Program;
use App\Models\Satuan;
use App\Models\TujuanRpjmd;
use App\Models\IndikatorSasaranRpjmd;
use Alert;
use Illuminate\Http\Request;

class ProgramRpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cari_program = DB::table('tp_program_rpjmd')->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                        ->where('program.program_nama', 'LIKE', '%cari%')->get();
                        // return $cari_program;
        $indikator_sasaran = ProgramRpjmd::join('indikator_sasaran_rpjmd as is','is.id','=','program_rpjmd.indikator_sasaran_id')
                            ->groupBy('indikator_sasaran_id')
                            ->get(['indikator_sasaran_id','indikator_sasaran']);
                            // return $indikator_sasaran;
        //                     
        $program = ProgramRpjmd::join('program','program.program_no','=','program_rpjmd.program_no')->get(['indikator_sasaran_id','program.program_no','program.program_nama','indikator_program']);
        // return $program;

        // $program = DB::table('tp_program_rpjmd')
        //                     ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
        //                     ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
        //                     ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
        //                     ->select('indikator_sasaran_rpjmd.id as is_id','program.program_no','program.program_nama')
        //                     ->groupBy('program_no')
        //                     ->orderBy('program.program_no')
        //                     ->get();
                            // return $program;

        // $program = DB::table('program_rpjmd')
        //                     ->join('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
        //                     ->join('program','program.program_no','=','program_rpjmd.program_no')
        //                     // ->leftJoin('indikator_sasaran_rpjmd','indikator_sasaran_rpjmd.id','=','program_rpjmd.indikator_sasaran_id')
        //                     // ->select('indikator_sasaran_rpjmd.id as is_id','program.program_no','program.program_nama')
        //                     ->groupBy('program_rpjmd.program_no')
        //                     ->orderBy('program.program_no')
        //                     ->get();
        //                     return $program;

        // $indikator_program = DB::table('tp_program_rpjmd')
        //                     ->join('program_rpjmd','program_rpjmd.program_no','=','tp_program_rpjmd.program_no')
        //                     ->select('tp_program_rpjmd.tp_program_id as tp_id','tp_program_rpjmd.program_no','program_rpjmd.indikator_program')
        //                     // ->orderBy('program_id')
        //                     ->groupBy('program_no')
        //                     ->get();
        //                     // return $indikator_program;
        $target_program =   DB::table('tp_program_rpjmd')
                            // ->join('program','program.program_no','=','tp_program_rpjmd.program_no')
                            ->join('satuan','satuan.id','=','tp_program_rpjmd.satuan_id')
                            ->groupBy('tp_program_rpjmd.program_no')
                            ->get();
                            // return $target_program;


        $periode = TujuanRpjmd::join('misi','misi.id','=','tujuan_rpjmd.misi_id')
                ->groupBy('misi.periode')->get();

         return view('app.perencanaan.rpjmd.program_rpjmd', compact('indikator_sasaran','program','periode','indikator_program','target_program'))->with('no',1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $opd = Organisasi::where('organisasi_jenis','=','ORG')->get();
        $indikator_sasaran = IndikatorSasaranRpjmd::select('id as indikator_sasaran_id','indikator_sasaran')->get();
        // return $indikator_sasaran;
        $program = Program::get();
        $satuan = Satuan::get();
       return view('app.perencanaan.rpjmd.tambah', compact('indikator_sasaran','program','satuan'));
    }

    public function tambahIndikator()
    {
        // $opd = Organisasi::where('organisasi_jenis','=','ORG')->get();
        $indikator_sasaran = IndikatorSasaranRpjmd::select('id as indikator_sasaran_id','indikator_sasaran')->get();
        // return $indikator_sasaran;
        $program = Program::get();
        $satuan = Satuan::get();
       return view('app.perencanaan.rpjmd.tambah_indikator', compact('indikator_sasaran','program','satuan'));
    }
    public function loadData(Request $request)
    {
        if ($request->has('q')) {
            $cari = $request->q;
            $data = DB::table('program')->where('program_nama', 'LIKE', '%cari%')->get();
            return response()->json($data);
        }
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
            'indikator_sasaran_id' => 'required',
            'program_no' => 'required',
            'indikator_program' => 'required',
            // 'satuan_id' => 'required',
            
        ]);
        $p_rpjmd = new ProgramRpjmd;
        $p_rpjmd->indikator_sasaran_id = $request->indikator_sasaran_id;
        $p_rpjmd->program_no = $request->program_no;
        $p_rpjmd->indikator_program = $request->indikator_program;
        // $p_rpjmd->satuan_id = $request->satuan_id;
        $p_rpjmd->save();

        // $p_rpjmd = new ProgramRpjmd;
        // $p_rpjmd->indikator_sasaran_id = $request->is_id;
        // $p_rpjmd->program_id = $request->program_id;
        // $p_rpjmd->save();

    
        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');

        return redirect('perencanaan/rpjmd-program');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgramRpjmd  $programRpjmd
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramRpjmd $programRpjmd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgramRpjmd  $programRpjmd
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramRpjmd $programRpjmd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgramRpjmd  $programRpjmd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramRpjmd $programRpjmd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgramRpjmd  $programRpjmd
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramRpjmd $programRpjmd)
    {
        //
    }
}
