<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use DB;
use App\Models\Organisasi;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\visi_misi;
use App\Models\TujuanRpjmd;
use App\Models\SasaranRpjmd;
use App\Models\IndikatorSasaranRpjmd;
use App\Models\ProgramRpjmd;
use App\Models\TujuanRenstra;
use App\Models\SasaranRenstra;
use App\Models\IndikatorSasaranRenstra;
use App\Models\ProgKegRenstra;
use App\Models\CascadingRpjmd;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CascadingController extends Controller
{
    public function index()
    {
    	$orgs = Organisasi::where('organisasi_jenis','ORG')->get();
    	return view('public.cascading.index', compact('orgs'));
    }


    public function index_upload_cascading_rpjmd()
    {
        // $cascading_rpjmd = CascadingRpjmd::get();
        // return view('app.perencanaan.upload_cascading_rpjmd.index', compact('cascading_rpjmd'));


        if(Auth::user()->level == 1)
        {
            $cascading_rpjmd = [];

        }else{
            $org_nama = Organisasi::where('organisasi_jenis', 'ORG')->where('organisasi_no', Auth::user()->organisasi_no)->first();
            $cascading_rpjmd = CascadingRpjmd::where('organisasi_nama', str_slug($org_nama->organisasi_nama))->get();
        }


        $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
        return view('app.perencanaan.upload_cascading_rpjmd.index', compact('cascading_rpjmd', 'orgs'));
    }

    public function data_upload_cascading_rpjmd(Request $request)
    {
        $cascading_rpjmd = CascadingRpjmd::where('organisasi_nama', str_replace(' ', '-', $request->org))->get();
        $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
        return view('app.perencanaan.upload_cascading_rpjmd.index', compact('cascading_rpjmd', 'orgs'));
    }
    
    public function upload_cascading_rpjmd(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf',
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        // $nama_file = rand().$file->getClientOriginalName();
        // $nama_file = rand().$file->getClientOriginalExtension();
        $nama_org = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->first()->organisasi_nama;
        $name_organisasi = str_slug($nama_org);
        $nama_file = $name_organisasi.'-'.time().'.'.$file->getClientOriginalExtension();

        // upload ke folder import_data di dalam folder public
        // $file->move('lkjip',$nama_file);

        Storage::putFileAs('public/cascading_rpjmd', $request->file('file'), $nama_file);


        $model = new CascadingRpjmd;
        $model->nama_file = $nama_file;
        $model->organisasi_nama = $name_organisasi;
        $model->save();

        // notifikasi dengan session
        Alert::success('Data Berhasil Diupload.', 'Berhasil!')->persistent('Close');

        // alihkan halaman kembali
        return redirect('perencanaan/upload-cascading-rpjmd');
    }

    public function delete_upload_cascading_rpjmd($id)
    {
        $model = CascadingRpjmd::findOrFail($id);
        Storage::disk('local')->delete('public/cascading_rpjmd/'. $model->nama_file);
        // $destinationPath = public_path().'/storage/cascading_rpjmd/'.$model->nama_file;
        // File::delete($destinationPath);
        $model->delete();

        // notifikasi dengan session
        Alert::success('Data Berhasil di hapus.', 'Berhasil!')->persistent('Close');

        // alihkan halaman kembali
        return redirect('perencanaan/upload-cascading-rpjmd');
    }
    

    public function kab()
    {
        $periode = Visi::get(['periode']);
        $visi = Visi::get();
        $misi = Misi::get();
        $tujuan_rpjmd = TujuanRpjmd::get();
     //    $sasaran_rpjmd = SasaranRpjmd::get();

    	// $periode = visi_misi::groupBy('periode')->get(['periode']);
    	// $visi = visi_misi::where('tipe','visi')->get(['nama']);
    	// $misi = visi_misi::where('tipe','misi')->get(['nomor','nama']);
     //    $tujuan_rpjmd = TujuanRpjmd::get(['misi_no','id','tujuan_nama']);
    	// $indikator_tujuan_rpjmd = TujuanRpjmd::get(['misi_no','id','tujuan_nama']);
    	$sasaran_rpjmd = SasaranRpjmd::get(['id','tujuan_id','sasaran_nama']);
    	$indikator_sasaran_rpjmd = IndikatorSasaranRpjmd::get(['id','sasaran_id','indikator_sasaran']);
    	$program_rpjmd = ProgramRpjmd::join('program','program.program_no','=','program_rpjmd.program_no')->get(['program_rpjmd.id','indikator_sasaran_id','program_rpjmd.program_no','program_nama','indikator_program']);

    	// return $indikator_sasaran_rpjmd;
    	// return $program_rpjmd;

    	return view('public.cascading.kabupaten', compact('periode','visi','misi','tujuan_rpjmd','sasaran_rpjmd','indikator_sasaran_rpjmd','program_rpjmd'));
    }

    public function opd(Request $request)
    {
    	$periode = Visi::get(['periode']);
    	$visi = Visi::get();
    	$misi 	 = TujuanRenstra::join('misi','misi.nomor','=','tujuan.misi_nomor')
    			   ->groupBy('misi_nomor')
    			   ->where('organisasi_no','=',$request->organisasi_no)
    			   ->get();
    			   // return $misi;
    	$opds    = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                   ->select('organisasi_no','organisasi_nama')
                // ->groupBy('misi_no')
                   ->get(); 
                // return $opds;

        $tujuan  = TujuanRenstra::where('tujuan.organisasi_no', $request->organisasi_no)
                    // ->select('tujuan.tujuan_nomor', 'tujuan_nama')
                    ->orderBy('tujuan_nomor')
                    ->groupBy('tujuan_nomor')
                    ->get();
                // return $tujuan;

        $sasaran = SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                   ->select('tujuan_nomor','sasaran_nomor','sasaran_nama')
                   ->orderBy('tujuan_nomor')
                   ->get();
                // return $sasaran;

        $indikator_sasaran =  IndikatorSasaranRenstra::join('satuan','satuan.id','=','indikator_sasaran.satuan_id')
	                ->where('organisasi_no','=',$request->organisasi_no)
	                // ->where('tujuan')
	                // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
	                ->orderBy('indikator_sasaran_nomor')
	                ->get(['indikator_sasaran.id','indikator_sasaran.indikator_sasaran_nama','sasaran_nomor']);
	                // return $indikator_sasaran;
	                
        $program = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->groupBy('program.program_no')
                    ->get(['prokeg_renstra.indikator_sasaran_id','prokeg_renstra.program_no','program.program_nama']);

                    // return $program;

        $kegiatans = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get(['prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.indikator_kegiatan']);
                // return $kegiatan;

        return view('public.cascading.opd', compact('opds','periode','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));
    }

    public function pohonKinerja ()
    {
        $opd = Organisasi::where('organisasi_jenis','ORG')->get();
        $visi = [];
        $misi = [];
        $tujuan = [];
        $sasaran = [];
        $indikator_sasaran = [];
        $program = [];
        $kegiatans = [];
        $opds = [];
        $org = [];


        return view('public.cascading.pohon-kinerja', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));
    }

    public function pohonKinerjaRpjmd ()
    {
        $opd = Organisasi::where('organisasi_jenis','ORG')->get();
        $cascading_rpjmd = [];
        // $cascading_rpjmd = CascadingRpjmd::get();
        $visi = [];
        $misi = [];
        $tujuan = [];
        $sasaran = [];
        $indikator_sasaran = [];
        $program = [];
        $kegiatans = [];
        $opds = [];
        $org = [];


        return view('public.cascading.pohon-kinerja-rpjmd', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans', 'cascading_rpjmd'));
    }

    public function pohonKinerja1 ()
    {
        $opd = Organisasi::where('organisasi_jenis','ORG')->get();
        $visi = [];
        $misi = [];
        $tujuan = [];
        $sasaran = [];
        $indikator_sasaran = [];
        $program = [];
        $kegiatans = [];
        $opds = [];
        $org = [];


        return view('public.cascading.pohon-kinerja', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));
    }



    public function dataPohonKinerja (Request $request)
    {
        $org        = Organisasi::where('organisasi.organisasi_no','=',$request->organisasi_no)->get();
        $opd        = Organisasi::where('organisasi_jenis','ORG')->get();
        $opds       = $request->organisasi_no;
        $visi       = Visi::get(['id','nama']);
        $misi       = TujuanRenstra::join('misi', 'misi.id','=','tujuan_renstra.misi_id')
                    ->where('tujuan_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->where('misi.visi_id',$visi->id)
                    ->groupBy('misi.nomor')
                    ->get(['misi.visi_id', 'misi.nama', 'misi.id']);


        $tujuan     = TujuanRenstra::where('organisasi_no','=',$request->organisasi_no)->get();
                // return $tujuan;
        $sasaran    = SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)->get();
                // return $sasaran;
        $indikator_sasaran =  IndikatorSasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                    // ->where('tujuan')
                    // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                    // ->orderBy('indikator_sasaran_nomor')
                    ->get(['indikator_sasaran_renstra.id','indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama', 'indikator_sasaran_renstra.sasaran_id']);
                    // return $indikator_sasaran;

        $program    = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->orderBy('prokeg_renstra.indikator_sasaran_id')
                    ->groupBy('prokeg_renstra.program_no')
                    ->get(['prokeg_renstra.indikator_sasaran_id','prokeg_renstra.program_no','program.program_nama']);
                    // return $program;
        $kegiatans  = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get(['prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.indikator_kegiatan']);

                    // return $kegiatans;

            // $arr[] = $m->nama;       
        // foreach (collect($misi)->where('visi_id', $visi->id) as $m) {


        // $data_json = [
        //     'name' => 'Visi',
        //     'title' => $visi->nama,
        //     'children' => array([
        //         'name' => 'Misi',
        //         'title' => $m->nama,
        //         'className' => 'middle-level'
        //     ])
        //     // 'Visi' => $visi,
        //     // 'Misi' => $misi,
        //     // 'tujuan' => $tujuan,
        //     // 'sasaran' => $sasaran,
        //     // 'indikator_sasaran' => $indikator_sasaran,
        //     // 'program' => $program,
        //     // 'kegiatans' => $kegiatans
        // ];

        return view('public.perencanaan.pohon_kinerja', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));
        // return view('public.cascading.pohon-kinerja', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));

        // return view('public.cascading.pohon_kinerja', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));

    }

    public function dataPohonKinerjaRpjmd (Request $request)
    {

        $org        = Organisasi::where('organisasi.organisasi_no','=',$request->organisasi_no)->get();
        $opd        = Organisasi::where('organisasi_jenis','ORG')->get();
        $opds       = $request->organisasi_no;
        $visi       = Visi::get(['id','nama']);
        $misi       = TujuanRenstra::join('misi', 'misi.id','=','tujuan_renstra.misi_id')
                    ->where('tujuan_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->where('misi.visi_id',$visi->id)
                    ->groupBy('misi.nomor')
                    ->get(['misi.visi_id', 'misi.nama', 'misi.id']);


        $tujuan     = TujuanRenstra::where('organisasi_no','=',$request->organisasi_no)->get();
                // return $tujuan;
        $sasaran    = SasaranRenstra::where('organisasi_no','=',$request->organisasi_no)->get();
                // return $sasaran;
        $indikator_sasaran =  IndikatorSasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                    // ->where('tujuan')
                    // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                    // ->orderBy('indikator_sasaran_nomor')
                    ->get(['indikator_sasaran_renstra.id','indikator_sasaran_renstra.indikator_sasaran as indikator_sasaran_nama', 'indikator_sasaran_renstra.sasaran_id']);
                    // return $indikator_sasaran;

        $program    = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->orderBy('prokeg_renstra.indikator_sasaran_id')
                    ->groupBy('prokeg_renstra.program_no')
                    ->get(['prokeg_renstra.indikator_sasaran_id','prokeg_renstra.program_no','program.program_nama']);
                    // return $program;
        $kegiatans  = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get(['prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.indikator_kegiatan']);

        $cascading_rpjmd = CascadingRpjmd::get();

        return view('public.perencanaan.pohon_kinerja_rpjmd', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans', 'cascading_rpjmd'));

    }

    public function dataPohon (Request $request)
    {
        // return $request->organisasi_no;

        $org        = Organisasi::where('organisasi.organisasi_no','=',$request->organisasi_no)->get();
        $opd        = Organisasi::where('organisasi_jenis','ORG')->get();
        $opds       = $request->organisasi_no;
        $visi       = Visi::first(['id','nama']);
        $misi       = TujuanRenstra::join('misi', 'misi.nomor','=','tujuan.misi_nomor')
                    ->where('tujuan.organisasi_no','=',$request->organisasi_no)
                    // ->where('misi.visi_id',$visi->id)
                    ->groupBy('misi.nomor')
                    ->get(['visi_id','nomor','nama']);
                    // return $misi;
        $tujuan     = TujuanRenstra::where('tujuan.organisasi_no','=',$request->organisasi_no)
                    // ->where('tujuan.misi_nomor','=',$misi->nomor)
                    ->get();
                    // return $tujuan;
        $sasaran    = SasaranRenstra::where('sasaran.organisasi_no','=',$request->organisasi_no)->get();
                // return $sasaran;
        $indikator_sasaran =  IndikatorSasaranRenstra::where('organisasi_no','=',$request->organisasi_no)
                    // ->where('tujuan')
                    // ->select('visi_misi_nomor','tujuan_nomor','tujuan_nama')
                    ->orderBy('indikator_sasaran_nomor')
                    ->get(['indikator_sasaran.id','indikator_sasaran.indikator_sasaran_nama','sasaran_nomor']);
                    // return $indikator_sasaran;

        $program    = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    ->orderBy('prokeg_renstra.indikator_sasaran_id')
                    ->groupBy('prokeg_renstra.program_no')
                    ->get(['prokeg_renstra.indikator_sasaran_id','prokeg_renstra.program_no','program.program_nama']);
                    // return $program;
        $kegiatans  = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    // ->join('indikator_program as ip','ip.program_no','=','prokeg_renstra.program_no')
                    // ->select('indikator_sasaran_id','program.program_no','program.program_nama','ip.indikator_program')
                    ->where('prokeg_renstra.organisasi_no','=',$request->organisasi_no)
                    // ->groupBy('program.program_no')
                    ->get(['prokeg_renstra.program_no','kegiatan.kegiatan_nama','prokeg_renstra.indikator_kegiatan']);
                    // return $kegiatans;

        
        return view('public.cascading.pohon-kinerja', compact('org','opds','opd','visi','misi','tujuan','sasaran','indikator_sasaran','program','kegiatans'));

    }

    public function download_cascading_rpjmd(Request $request)
    {
        // return $request->organisasi_no;
        $model = CascadingRpjmd::where('organisasi_nama', str_replace(' ','-',$request->org))->first();

           if($model == false)
           {
                Alert::warning('Data Tidak Ada.', 'Gagal!')->persistent('Close');
                return back();
           }else{
           //  $file = public_path() . '/lkjip/' . $model->nama_file;//Mencari file dari model yang sudah dicari
           // return response()->download($file); //Download file yang dicari berdasarkan nama file

            return Storage::disk('local')->download('public/cascading_rpjmd/'.$model->nama_file);
           }
    }

}
