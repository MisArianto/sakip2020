<?php

namespace App\Http\Controllers\User;

use Auth;
use DB;
use App\Models\Skp;
use App\Models\Pegawai;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class SkpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('app.user.skp.index');
    }

    public function fetch_pegawai()
    {
        if(Auth::user()->organisasi_no == '2.01.06.01.')
        {
            $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'PERINDUSTRIAN' . '%')
                        ->select(
                                'pegawai.id',
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                        ->get();

        }elseif(Auth::user()->organisasi_no == '3.01.03.02.')
        {
            $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'PAJAK' . '%')
                        ->select(
   
   'pegawai.id',                             'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                        ->get();

        }elseif(Auth::user()->organisasi_no == '1.02.07.01.')
        {
            $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'DESA' . '%')
                        ->select(
   
   'pegawai.id',                             'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                        ->get();

        }elseif(Auth::user()->organisasi_no == '2.01.02.01.')
        {
                $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'OLAHRAGA' . '%')
                            ->select(
                                'pegawai.id',
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                            ->get();

        }elseif(Auth::user()->organisasi_no == '6.01.01.01.')
        {
                $pegawais = Pegawai::where('organisasi_nama', 'like', '%'.'KECAMATAN TEBING TINGGI'.'%')
                            ->select(
                                'pegawai.id',
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                            ->get();

        }elseif(Auth::user()->organisasi_no == '6.01.01.08.')
        {
                $pegawais = Pegawai::where('organisasi_nama', 'like', 'KECAMATAN TASIK PUTRI PUYU')
                            ->select(
                                'pegawai.id',
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                            ->get();

        }else{
            $pegawais = Pegawai::leftJoin('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
                    ->select(
                        'pegawai.id',
                        'pegawai.nama',
                        'pegawai.nip',
                        'pegawai.jabatan',
                        'pegawai.pangkat'
                    )
                    ->where('o.organisasi_no', Auth::user()->organisasi_no)
                    ->where('o.organisasi_jenis', 'ORG')
                    ->get();
        }

        // $pegawais = Pegawai::orderBy('created_at', 'desc')->get();
        return response()->json([
            'pegawais' => $pegawais
        ]);
    }


    public function get_pegawai(Request $request)
    {

        return $this->fetch_emit($request->organisasi_no, $request->tahun);
    }

    public function fetch_emit($organisasi_no, $tahun)
    {
        $pegawais = Skp::join('pegawai', 'pegawai.id', '=', 'skp.pegawai_id')
                        ->join('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
                        ->select(
                            'skp.*',
                            'pegawai.id as pegawai_id',
                            'pegawai.nama',
                            'pegawai.jabatan'
                        )
                        ->where('o.organisasi_no',$organisasi_no)
                        ->where('o.organisasi_jenis', 'ORG')
                        ->where('skp.tahun',$tahun)
                        ->groupBy('pegawai.id')
                        ->get();

        return response()->json([
            'pegawais' => $pegawais
        ]);
    }


    public function detail($id)
    {
        $pegawai = '';
        $pejabat = '';
        $skps = [];
        $skp = '';

        $skp = Skp::find($id);

        if($skp)
        {
            $pegawai = Pegawai::join('organisasi as org', 'org.organisasi_no', 'pegawai.organisasi_no')
                                ->select(
                                    'pegawai.*',
                                    'org.organisasi_nama'
                                )
                                ->where('pegawai.id', $skp->pegawai_id)->first();

            $pejabat = Pegawai::leftJoin('organisasi as org', 'org.organisasi_no', 'pegawai.organisasi_no')
                                ->select(
                                    'pegawai.*',
                                    'org.organisasi_nama'
                                )
                                ->where('pegawai.id', $skp->pejabat_id)->first();

            $skps = Skp::where('pegawai_id', $skp->pegawai_id)->get();
        }

        return response()->json([
            'skp' => $skp,
            'skps' => $skps,
            'pegawai' => $pegawai,
            'pejabat' => $pejabat
        ]);
    }

    public function filter_skp($id)
    {
        $skp = '';
        $skps = [];

        $skp = Skp::find($id);

        if($skp)
        {
            $skps = Skp::where('pegawai_id', $skp->pegawai_id)->get();
        }

        return response()->json([
            'skps' => $skps,
            'skp' => $skp
        ]);

       
    }


    public function store(Request $request)
    {


    	$box = $request->all();        
	    $formFilter=  array();
	    parse_str($box['formFilter'], $formFilter);
	    $form=  array();
	    parse_str($box['form'], $form);

		$params = array(
	        'pegawai_id' => $form['pegawai_id'],
	        'pejabat_id'   => $form['pejabat_id'],
	        'tahun'       => $form['tahun'],
	    );

	    $rules = array(
	        'pegawai_id' => ['required'],
	        'pejabat_id'   => ['required'],
	        'tahun'       => ['required'],
	    );

	    $validator = \Validator::make($params, $rules);

	    if ($validator->fails())
    		throw new ValidationException($validator);

        // $this->validate($box['form'], [
        //     'pegawai_id' => 'required',
        //     'pejabat_id' => 'required',
        //     'tahun' => 'required'
        // ]);

        date_default_timezone_set('Asia/Jakarta');

        $obj = $form['tugas_jabatan_array'];
        // $obj = \Request::get('tugas_jabatan_array');


        for ($i=0; $i < count($obj); $i++) { 
            $skp = new Skp;
            $skp->pejabat_id = $form['pejabat_id'];
            $skp->pegawai_id = $form['pegawai_id'];
            $skp->tahun = $form['tahun'];
            $skp->kegiatan = $form['tugas_jabatan_array'][$i];
            $skp->ak = $form['ak_array'][$i];
            $skp->output = $form['kuant_output_array'][$i];
            $skp->mutu = $form['kual_mutu_array'][$i];
            $skp->waktu = $form['waktu_array'][$i];
            $skp->biaya = $form['biaya_array'][$i];
            $skp->organisasi_no = Auth::user()->organisasi_no;
            $skp->save();
        }

        if($formFilter['organisasi_no'] !== '' && $formFilter['tahun_filter'] !== '')
	    {
	    	$pegawais = Skp::join('pegawai', 'pegawai.id', '=', 'skp.pegawai_id')
                        ->join('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
                        ->select(
                            'skp.*',
                            'pegawai.id as pegawai_id',
                            'pegawai.nama',
                            'pegawai.jabatan'
                        )
                        ->where('o.organisasi_no',$formFilter['organisasi_no'])
                        ->where('o.organisasi_jenis','ORG')
                        ->where('skp.tahun',$formFilter['tahun_filter'])
                        ->groupBy('pegawai.id')
                        ->get();

            return response()->json([
	            'pegawais' => $pegawais
	        ]);

	    }

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
        $this->validate($request, [
            'pegawai_id' => 'required',
            'pejabat_id' => 'required',
            'tahun' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');

        $obj = \Request::get('tugas_jabatan_array');

        // return $request->all();

        for ($i=0; $i < count($obj); $i++) { 
            $skp = Skp::find($request->id_array[$i]);

            // jika update normal tanpa ada menambahkan data baru saat update
            if($skp)
            {
                $skp->pejabat_id = $request->pejabat_id;
                $skp->pegawai_id = $request->pegawai_id;
                $skp->tahun = $request->tahun;
                $skp->kegiatan = $request->tugas_jabatan_array[$i];
                $skp->ak = $request->ak_array[$i];
                $skp->output = $request->kuant_output_array[$i];
                $skp->mutu = $request->kual_mutu_array[$i];
                $skp->waktu = $request->waktu_array[$i];
                $skp->biaya = $request->biaya_array[$i];
                $skp->save();
            }else{
                // jika update ada menambahkan data baru saat update
                $skp = new Skp;
                $skp->pejabat_id = $request->pejabat_id;
                $skp->pegawai_id = $request->pegawai_id;
                $skp->tahun = $request->tahun;
                $skp->kegiatan = $request->tugas_jabatan_array[$i];
                $skp->ak = $request->ak_array[$i];
                $skp->output = $request->kuant_output_array[$i];
                $skp->mutu = $request->kual_mutu_array[$i];
                $skp->waktu = $request->waktu_array[$i];
                $skp->biaya = $request->biaya_array[$i];
                $skp->save();
            }
        }

        if($request->tahun_emit !== '')
        {
            return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun_emit);

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $pegawai_id)
    {

        $model = Skp::leftJoin('pegawai as p', 'p.id', 'skp.pegawai_id')
                    ->leftJoin('organisasi as o', 'o.organisasi_nama', 'p.organisasi_nama')
                    ->select(
                        'skp.id'
                    )
                    ->where('skp.pegawai_id', $request->id)
                    ->where('o.organisasi_no',Auth::user()->organisasi_no)
                    ->where('o.organisasi_jenis', 'ORG')
                    ->where('skp.tahun',$request->tahun)
                    ->get();


        foreach ($model as $value) {
            $skp = Skp::findOrFail($value->id);
            $skp->delete();
        }

	    return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun);
    }




}
