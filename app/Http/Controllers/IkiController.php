<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\Models\Iki;
use App\Models\Organisasi;
use App\Models\Satuan;
use App\Models\Pegawai;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class IkiController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->level == 2){
            // $pegawai = Iki::join('pegawai', 'pegawai.id', '=', 'iki.pegawai_id')
            //         ->leftJoin('organisasi','organisasi.organisasi_no','=','pegawai.organisasi_no')
            //         ->where('pegawai.organisasi_no', Auth::user()->organisasi_no)
            //         ->orderBy('pegawai.status')
            //          ->get(['iki.id','pegawai.id as pegawai_id', 'pegawai.nama','pegawai.jabatan']);
                    // return $pegawai;
            

            $opd  = $opd = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
		            ->get();


        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();

        }
            $pegawai = [];
            $opds  = [];

        // if(Auth::user()->level != 1){
        //     $pejabats = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
        //     $pegawais = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
        // }else{
        //     $pejabats = Pegawai::orderBy('created_at', 'desc')->where('status', '!=', 5)->get();
        //     $pegawais = Pegawai::orderBy('created_at', 'desc')->where('status', '=', 5)->get();
        // }

        // $pegawais = kip::join('pegawai' ,'pegawai.id', '=', 'kip.pegawai_id')
                    // ->leftJoin('organisasi' ,'organisasi.organisasi_no', '=', 'pegawai.organisasi_no')
                    // ->leftJoin('users' ,'users.organisasi_no', '=', 'organisasi.organisasi_no')
                    // ->select('users.organisasi_no')
                    // ->orderBy('created_at', 'desc')
                    // ->where('pegawai.organisasi_no', Auth::user()->organisasi_no)
                    // ->get();

        // return $pegawais;
        
        // $kips = [];
        // $pegawai = [];
        // $pimpinan = [];
        
        $tahun = '';
        $get_opd = '';
        

    	return view('app.master.iki.index', compact('pegawai','opd','opds', 'tahun', 'get_opd'))->with('no', 1);
    }

    public function get_pegawai(Request $request)
    {



        if(Auth::user()->level == 2)
        {
            if($request->tahun == '')
            {
                Alert::warning('Warning', 'Pilih Tahun.!')->persistent('Close');
                return redirect('iki');
            }

            $pegawai = Iki::join('pegawai', 'pegawai.id', '=', 'iki.pegawai_id')
                    ->leftJoin('organisasi','organisasi.organisasi_no','=','pegawai.organisasi_no')
                    ->where('pegawai.organisasi_no',Auth::user()->organisasi_no)
                    ->where('iki.tahun',$request->tahun)
                    ->orderBy('pegawai.status')
                     ->get(['iki.id','pegawai.id as pegawai_id', 'pegawai.nama','pegawai.jabatan']);

            $opds  = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)
                        ->select('organisasi_no','organisasi_nama')
                        ->get();
                    

            $opd = [];
        }else{
            if($request->tahun == '')
            {
                Alert::warning('Warning', 'Pilih Tahun.!')->persistent('Close');
                return redirect('skp');
            }
            elseif($request->organisasi_no == '') 
            {
                Alert::warning('Warning', 'Pilih Opd.!')->persistent('Close');
                return redirect('skp');
            }
            elseif($request->organisasi_no == '' || $request->tahun == '')
            {
                Alert::warning('Warning', 'Pilih Opd dan Tahun.!')->persistent('Close');
                return redirect('skp');
            }

              $pegawai = Iki::join('pegawai', 'pegawai.id', '=', 'iki.pegawai_id')
                    ->leftJoin('organisasi','organisasi.organisasi_no','=','pegawai.organisasi_no')
                    ->where('pegawai.organisasi_no',$request->organisasi_no)
                    ->where('iki.tahun',$request->tahun)
                    ->orderBy('pegawai.status')
                     ->get(['iki.id','pegawai.id as pegawai_id', 'pegawai.nama','pegawai.jabatan']);

                $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                            ->select('organisasi_no','organisasi_nama')
                            ->get();

                $opd = Organisasi::orderBy('organisasi_no')
                    ->where('organisasi_jenis','=','ORG')
                    ->get();
                

            }


        $tahun = $request->tahun;
        $get_opd = $request->organisasi_no;

        return view('app.master.iki.index', compact('pegawai', 'opds', 'opd', 'tahun', 'get_opd'))->with('no', 1);

    }


    public function dataRequest(Request $request)
    {
        return $request->tahun;
        
            if(Auth::user()->level != 1){
                $pejabats = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
                $pegawais = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
            }else{
                $pejabats = Pegawai::orderBy('created_at', 'desc')->where('status', '!=', 5)->get();
                $pegawais = Pegawai::orderBy('created_at', 'desc')->where('status', '=', 5)->get();
            }

            

            $kips = Iki::join('satuan', 'satuan.id', '=', 'iki.satuan_id')
                    ->where('pegawai_id', $request->id_pegawai)
                    ->where('tahun', $request->tahun)->get();

            // return $kips;



            $kip = Iki::join('pegawai', function($join){
                        $join->on('pegawai.id', '=', 'iki.pegawai_id')
                             ->orOn('pegawai.id', '=', 'iki.pimpinan_id');
                    })
                    ->join('satuan', 'satuan.id', '=', 'iki.satuan_id')
                    ->where('pegawai_id', $request->id_pegawai)
                    ->where('tahun', $request->tahun)->get();

        // return $kip;

            if(count($kip) > 0){
                foreach($kip as $data)
                {
                    $arr[] = [
                        'nama' => $data->nama,
                        'jabatan' => $data->jabatan,
                        'status' => $data->status,
                    ];
                }


                foreach($arr as $value)
                {
                    if($value['status'] == 0)
                    {
                        $pegawai = [
                            'nama_pegawai' => $value['nama'],
                            'jabatan_pegawai' => $value['jabatan']
                        ];

                    }
                    else
                    {
                        $pegawai = [];
                    }
                    
                    if($value['status'] != 0)
                    {
                        $pimpinan = [
                            'nama_pimpinan' => $value['nama'],
                            'jabatan_pimpinan' => $value['jabatan']
                        ];
                    }
                    else
                    {
                        $pimpinan = [];
                    }

                }
            }

            return $pimpinan;

            // foreach($kips as $kip)
            // {
            //     $arr[] = [
            //         'nama_pegawai' => $kip->nama,
            //         'jabatan' => $kip->jabatan,
            //         'nama_pegawai' => $kip->nama,
            //     ]
            // }


            return view('app.master.iki.index', compact('pegawais', 'pejabats','kips', 'pimpinan', 'pegawai'))->with('no', 1);

    }

    // public function test()
    // {
    //      if(Auth::user()->level != 1){
    //         $pejabats = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
    //         $pegawais = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
    //         $pimpinans = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->where('status', '!=', 5)->get();
    //     }else{
    //         $pejabats = Pegawai::orderBy('created_at', 'desc')->get();
    //         $pegawais = Pegawai::orderBy('created_at', 'desc')->get();
    //         $pimpinans = Pegawai::orderBy('created_at', 'desc')->where('status', '!=', 5)->get();
    //     }

    //     $satuans = Satuan::get();
    //     return view('app.master.iki.add2', compact('pegawais','satuans', 'pimpinans'));
    // }

    // create
    public function create()
    {
        if(Auth::user()->level != 1){
            $pejabats = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
            $pegawais = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->get();
            $pimpinans = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->where('status', '!=', 5)->get();
        }else{
            $pejabats = Pegawai::orderBy('created_at', 'desc')->get();
            $pegawais = Pegawai::orderBy('created_at', 'desc')->get();
            $pimpinans = Pegawai::orderBy('created_at', 'desc')->where('status', '!=', 5)->get();
        }

        // $pegawais = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->where('status', '=', 0)->get();
        $satuans = Satuan::get();
        // $satuans = Satuan::orderBy('created_at', 'desc')->get();
        return view('app.master.iki.add', compact('pegawais','satuans', 'pimpinans'));
    }


    // post
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'pegawai_id' => 'required',
        //     'pimpinan_id' => 'required',
        //     'sasaran_strategis' => 'required',
        //     // 'satuan_id' => 'required',
        //     'target' => 'required',
        //     'tahun' => 'required',
        // ]);

        if($request->tahun == '')
        {
            Alert::warning('Warning', 'Pilih Tahun.!')->persistent('Close');
            return back();
        }elseif($request->pimpinan_id == '')
        {
            Alert::warning('Warning', 'Pilih Pimpinan.!')->persistent('Close');
            return back();
        }elseif($request->pegawai_id == '')
        {
            Alert::warning('Warning', 'Pilih Pegawai.!')->persistent('Close');
            return back();
        }
        
        


        $obj = \Request::get('sasaran_strategis_array');


        for ($i=0; $i < count($obj); $i++) { 
            $iki = new Iki;
            $iki->pegawai_id = $request->pegawai_id;
            $iki->pimpinan_id = $request->pimpinan_id;
            $iki->sasaran_strategis = $request->sasaran_strategis_array[$i];
            $iki->satuan_id = $request->satuan_id_array[$i];
            $iki->target = $request->target_array[$i];
            $iki->tahun = $request->tahun;
            $iki->save();
        }

        Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        return redirect('iki');

        // $iki = new Iki;
        // $iki->pegawai_id = $request->pegawai_id;
        // $iki->pimpinan_id = $request->pimpinan_id;
        // $iki->sasaran_strategis = $request->sasaran_strategis;
        // $iki->satuan_id = $request->satuan_id;
        // $iki->target = $request->target;
        // $iki->tahun = $request->tahun;
        // $iki->save();

        // Alert::success('Berhasil', 'Data Berhasil Disimpan.')->persistent('Close');
        // return redirect('iki');
    }

    public function dataIki($id)
    {

       $pimpinans = Iki::join('pegawai', 'pegawai.id', '=', 'iki.pimpinan_id')
                 ->leftJoin('organisasi', 'organisasi.organisasi_no','=','pegawai.organisasi_no')
                 ->where('iki.id', Hashids::decode($id))
                 ->get();
       // return $pejabats;
        $pegawais = Iki::join('pegawai','pegawai.id','=','pegawai_id')
                     ->leftJoin('organisasi', 'organisasi.organisasi_no','=','pegawai.organisasi_no')
                 ->where('iki.id', Hashids::decode($id))
                 ->get();
       // return $pegawais;

        // $ikis = Iki::join('pegawai','pegawai.id','=','pegawai_id')
        //          ->join('satuan','satuan.id','=','iki.satuan_id')
        //          ->leftJoin('organisasi', 'organisasi.organisasi_no','=','pegawai.organisasi_no')
        //          ->where('iki.id', Hashids::decode($id))
        //          ->get();

       $iki = Iki::join('pegawai','pegawai.id','=','pegawai_id')
                 ->join('satuan','satuan.id','=','iki.satuan_id')
                 ->leftJoin('organisasi', 'organisasi.organisasi_no','=','pegawai.organisasi_no')
                 ->where('iki.id', Hashids::decode($id))
                 ->first();

         $ikis = Iki::join('pegawai','pegawai.id','=','pegawai_id')
                 ->join('satuan','satuan.id','=','iki.satuan_id')
                 ->leftJoin('organisasi', 'organisasi.organisasi_no','=','pegawai.organisasi_no')
                 ->where('iki.pegawai_id', $iki->pegawai_id)
                 ->where('iki.pimpinan_id', $iki->pimpinan_id)
                 ->get();

                // return $ikis;
         return view('app.master.iki.iki', compact('pegawais','ikis', 'pimpinans'))->with('no', 1);
     }

     public function edit($id)
     {
         $model = Iki::where('id', Hashids::decode($id))->first();

         if(Auth::user()->level != 1){
            $pejabats = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->where('status', '!=', 5)->get();
            $pegawais = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->where('status', '=', 5)->get();
        }else{
            $pejabats = Pegawai::orderBy('created_at', 'desc')->where('status', '!=', 5)->get();
            $pegawais = Pegawai::orderBy('created_at', 'desc')->where('status', '=', 5)->get();
        }

        $pimpinans = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->where('status', '!=', 5)->get();
        // $pegawais = Pegawai::orderBy('created_at', 'desc')->where('organisasi_no', Auth::user()->organisasi_no)->where('status', '=', 0)->get();
        $satuans = Satuan::get();

         return view('app.master.iki.edit', compact('model', 'pegawais','satuans', 'pimpinans'))->with('no', 1);
     }

     public function update(Request $request, $id)
     {

        $this->validate($request, [
            'pegawai_id' => 'required|unique:iki,pegawai_id,'.$id,
            'pimpinan_id' => 'required|unique:iki,pimpinan_id,'.$id,
            'sasaran_strategis' => 'required',
            'satuan_id' => 'required',
            'target' => 'required',
            'tahun' => 'required',
        ]);

        $iki = Iki::where('id', $id)->first();

        $iki->pegawai_id = $request->pegawai_id;
        $iki->pimpinan_id = $request->pimpinan_id;
        $iki->sasaran_strategis = $request->sasaran_strategis;
        $iki->satuan_id = $request->satuan_id;
        $iki->target = $request->target;
        $iki->tahun = $request->tahun;
        $iki->save();

        Alert::success('Berhasil', 'Data Berhasil Diupdate.')->persistent('Close');
        return redirect('iki');

     }

     public function destroy($id)
     {
        $iki = Iki::where('id', Hashids::decode($id))->first();
        $ikis = Iki::where('pegawai_id', $iki->pegawai_id)
                ->where('pimpinan_id', $iki->pimpinan_id)
                ->get();

        // return $ikis;

        if(count($ikis) > 0)
        {

            foreach ($ikis as $value) {
                $hapus = Iki::where('id',$value->id)->first()->delete();;
            }
        }

        Alert::success('Berhasil', 'Data Berhasil Di Hapus.')->persistent('Close');
        return redirect('iki');
     }


}
