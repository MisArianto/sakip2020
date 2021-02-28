<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\Iki;
use App\Models\Satuan;
use App\Models\Pegawai;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class IkiController extends Controller
{
    public function index(Request $request)
    {
    	return view('app.user.iki.index');
    }

    public function fetch_pegawai_pimpinan()
    {
   //      if(Auth::user()->organisasi_no == '2.01.06.01.')
   //      {
   //          $pegawais_pimpinans = Pegawai::where('organisasi_nama', 'like', '%' . 'PERINDUSTRIAN' . '%')
   //                      ->select(
   //                              'pegawai.id',
   //                              'pegawai.nama',
   //                              'pegawai.nip',
   //                              'pegawai.jabatan',
   //                              'pegawai.pangkat'
   //                          )
   //                      ->get();

   //      }elseif(Auth::user()->organisasi_no == '3.01.03.02.')
   //      {
   //          $pegawais_pimpinans = Pegawai::where('organisasi_nama', 'like', '%' . 'PAJAK' . '%')
   //                      ->select(
   
   // 'pegawai.id',                             'pegawai.nama',
   //                              'pegawai.nip',
   //                              'pegawai.jabatan',
   //                              'pegawai.pangkat'
   //                          )
   //                      ->get();

   //      }elseif(Auth::user()->organisasi_no == '1.02.07.01.')
   //      {
   //          $pegawais_pimpinans = Pegawai::where('organisasi_nama', 'like', '%' . 'DESA' . '%')
   //                      ->select(
   
   // 'pegawai.id',                             'pegawai.nama',
   //                              'pegawai.nip',
   //                              'pegawai.jabatan',
   //                              'pegawai.pangkat'
   //                          )
   //                      ->get();

   //      }elseif(Auth::user()->organisasi_no == '2.01.02.01.')
   //      {
   //              $pegawais_pimpinans = Pegawai::where('organisasi_nama', 'like', '%' . 'OLAHRAGA' . '%')
   //                          ->select(
   //                              'pegawai.id',
   //                              'pegawai.nama',
   //                              'pegawai.nip',
   //                              'pegawai.jabatan',
   //                              'pegawai.pangkat'
   //                          )
   //                          ->get();

   //      }elseif(Auth::user()->organisasi_no == '6.01.01.01.')
   //      {
   //              $pegawais_pimpinans = Pegawai::where('organisasi_nama', 'like', '%'.'KECAMATAN TEBING TINGGI'.'%')
   //                          ->select(
   //                              'pegawai.id',
   //                              'pegawai.nama',
   //                              'pegawai.nip',
   //                              'pegawai.jabatan',
   //                              'pegawai.pangkat'
   //                          )
   //                          ->get();

   //      }elseif(Auth::user()->organisasi_no == '6.01.01.08.')
   //      {
   //              $pegawais_pimpinans = Pegawai::where('organisasi_nama', 'like', 'KECAMATAN TASIK PUTRI PUYU')
   //                          ->select(
   //                              'pegawai.id',
   //                              'pegawai.nama',
   //                              'pegawai.nip',
   //                              'pegawai.jabatan',
   //                              'pegawai.pangkat'
   //                          )
   //                          ->get();

   //      }else{
   //          $pegawais_pimpinans = Pegawai::leftJoin('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
   //                  ->select(
   //                      'pegawai.id',
   //                      'pegawai.nama',
   //                      'pegawai.nip',
   //                      'pegawai.jabatan',
   //                      'pegawai.pangkat'
   //                  )
   //                  ->where('o.organisasi_no', Auth::user()->organisasi_no)
   //                  ->where('o.organisasi_jenis', 'ORG')
   //                  ->get();
   //      }

        $pegawais_pimpinans = Pegawai::select(
                        'id',
                        'nama',
                        'nip',
                        'jabatan',
                        'pangkat'
                    )
                    ->where('organisasi_no', Auth::user()->organisasi_no)
                    ->get();

        // $pegawais_pimpinans = Pegawai::orderBy('created_at', 'desc')->get();
        return response()->json([
            'pegawais_pimpinans' => $pegawais_pimpinans
        ]);
    }


    public function fetch_satuan()
    {
        $satuans = Satuan::latest()->get();
        return response()->json([
            'satuans' => $satuans
        ]);
    }

    public function get_pegawai(Request $request)
    {
         return $this->fetch_emit($request->organisasi_no, $request->tahun);
    }

    public function fetch_emit($organisasi_no, $tahun)
    {
       $pegawais = Iki::join('pegawai', 'pegawai.id', '=', 'iki.pegawai_id')
                        ->join('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
                        ->select(
                            'iki.*',
                            'pegawai.id as pegawai_id',
                            'pegawai.nama',
                            'pegawai.jabatan'
                        )
                        ->where('o.organisasi_no',$organisasi_no)
                        ->where('o.organisasi_jenis', 'ORG')
                        ->where('iki.tahun',$tahun)
                        ->groupBy('pegawai.id')
                        ->latest()
                        ->get();

        return response()->json([
            'pegawais' => $pegawais
        ]);
    }

    public function detail($id)
    {
        $pegawai = '';
        $pimpinan = '';
        $ikis = [];
        $iki = '';

        $iki = Iki::find($id);

        if($iki)
        {
            $pegawai = Pegawai::join('organisasi as org', 'org.organisasi_no', 'pegawai.organisasi_no')
                                ->select(
                                    'pegawai.*',
                                    'org.organisasi_nama'
                                )
                                ->where('pegawai.id', $iki->pegawai_id)->first();

            $pimpinan = Pegawai::leftJoin('organisasi as org', 'org.organisasi_no', 'pegawai.organisasi_no')
                                ->select(
                                    'pegawai.*',
                                    'org.organisasi_nama'
                                )
                                ->where('pegawai.id', $iki->pimpinan_id)->first();

            $ikis = Iki::join('satuan as s', 's.id', 'iki.satuan_id')
                    ->select(
                        'iki.*',
                        's.satuan_nama'
                    )
                    ->where('iki.pegawai_id', $iki->pegawai_id)
                    ->get();
        }

        return response()->json([
            'iki' => $iki,
            'ikis' => $ikis,
            'pegawai' => $pegawai,
            'pimpinan' => $pimpinan
        ]);
    }

    public function filter_iki($id)
    {
        $iki = '';
        $ikis = [];

        $iki = Iki::find($id);

        if($iki)
        {
            $ikis = Iki::join('satuan as s', 's.id', 'iki.satuan_id')
                    ->select(
                        'iki.*',
                        's.satuan_nama'
                    )
                    ->where('iki.pegawai_id', $iki->pegawai_id)->get();
        }

        return response()->json([
            'ikis' => $ikis,
            'iki' => $iki
        ]);

       
    }


    public function create()
    {
        // 
    }


    // post
    public function store(Request $request)
    {


        $box = $request->all();        
        $formFilter=  array();
        parse_str($box['formFilter'], $formFilter);
        $form=  array();
        parse_str($box['form'], $form);

        $params = array(
            'pegawai_id' => $form['pegawai_id'],
            'pimpinan_id'   => $form['pimpinan_id'],
            'tahun'       => $form['tahun'],
        );

        $rules = array(
            'pegawai_id' => ['required'],
            'pimpinan_id'   => ['required'],
            'tahun'       => ['required'],
        );

        $validator = \Validator::make($params, $rules);

        if ($validator->fails())
            throw new ValidationException($validator);

        date_default_timezone_set('Asia/Jakarta');

        $obj = $form['sasaran_strategis_array'];
        // $obj = \Request::get('sasaran_strategis_array');


        for ($i=0; $i < count($obj); $i++) { 
            $iki = new Iki;
            $iki->pegawai_id = $form['pegawai_id'];
            $iki->pimpinan_id = $form['pimpinan_id'];
            $iki->tahun = $form['tahun'];
            $iki->sasaran_strategis = $form['sasaran_strategis_array'][$i];
            $iki->indikator_sasaran = $form['indikator_sasaran_array'][$i];
            $iki->satuan_id = $form['satuan_id_array'][$i];
            $iki->target = $form['target_array'][$i];
            $iki->organisasi_no = Auth::user()->organisasi_no;
            $iki->save();
        }

        if($formFilter['organisasi_no'] !== '' && $formFilter['tahun_filter'] !== '')
        {
            $pegawais = Iki::join('pegawai', 'pegawai.id', '=', 'iki.pegawai_id')
                        ->join('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
                        ->select(
                            'iki.*',
                            'pegawai.id as pegawai_id',
                            'pegawai.nama',
                            'pegawai.jabatan'
                        )
                        ->where('o.organisasi_no',$formFilter['organisasi_no'])
                        ->where('o.organisasi_jenis', 'ORG')
                        ->where('iki.tahun',$formFilter['tahun_filter'])
                        ->groupBy('pegawai.id')
                        ->latest()
                        ->get();

            return response()->json([
                'pegawais' => $pegawais
            ]);

        }

    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'pegawai_id' => 'required',
            'pimpinan_id' => 'required',
            'tahun' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');

        $obj = \Request::get('sasaran_strategis_array');

        // return $request->all();

        for ($i=0; $i < count($obj); $i++) { 
            $iki = Iki::find($request->id_array[$i]);

            // jika update normal tanpa ada menambahkan data baru saat update
            if($iki)
            {
                $iki->pegawai_id = $request->pegawai_id;
                $iki->pimpinan_id = $request->pimpinan_id;
                $iki->tahun = $request->tahun;
                $iki->sasaran_strategis = $request->sasaran_strategis_array[$i];
                $iki->indikator_sasaran = $request->indikator_sasaran_array[$i];
                $iki->satuan_id = $request->satuan_id_array[$i];
                $iki->target = $request->target_array[$i];
                $iki->organisasi_no = Auth::user()->organisasi_no;
                $iki->save();
            }else{
                // jika update ada menambahkan data baru saat update
                $iki = new Iki;
                $iki->pegawai_id = $request->pegawai_id;
                $iki->pimpinan_id = $request->pimpinan_id;
                $iki->tahun = $request->tahun;
                $iki->sasaran_strategis = $request->sasaran_strategis_array[$i];
                $iki->indikator_sasaran = $request->indikator_sasaran_array[$i];
                $iki->satuan_id = $request->satuan_id_array[$i];
                $iki->target = $request->target_array[$i];
                $iki->organisasi_no = Auth::user()->organisasi_no;
                $iki->save();
            }
        }

        if($request->tahun_emit !== '')
        {
            return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun_emit);
        }
    }


    public function edit($id)
    {
        // 
    }

    public function destroy(Request $request, $id)
    {

        $ikis = Iki::join('pegawai', 'pegawai.id', '=', 'iki.pegawai_id')
                        ->join('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
                        ->select(
                            'iki.id'
                        )
                        ->where('o.organisasi_no',Auth::user()->organisasi_no)
                        ->where('o.organisasi_jenis', 'ORG')
                        ->where('iki.tahun',$request->tahun)
                        ->where('pegawai.id',$request->id)
                        ->groupBy('pegawai.id')
                        ->get();

        foreach ($ikis as $value) {
            $model = Iki::find($value->id);
            $model->delete();
        }



        if($request->tahun !== '')
        {
            return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun);

        }
    }


}
