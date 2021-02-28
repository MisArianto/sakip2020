<?php

namespace App\Http\Controllers;

use DB;
use Alert;
use Auth;
use App\Models\Jabatan;
use App\Models\Organisasi;
use App\Models\SasaranRenstra as Sasaran;
use App\Models\IndikatorSasaranRenstra as IndikatorSasaran;
use App\Models\IndikatorProgramRenstra as IndikatorProgram;
use App\Models\IndikatorKegiatanRenstra as IndikatorKegiatan;
use App\Models\PerjanjianKinerjaEselon2 as PK2;
use App\Models\PerjanjianKinerjaEselon3 as PK3;
use App\Models\PerjanjianKinerjaEselon4 as PK4;
use Illuminate\Http\Request;

class PerjanjianKinerjaController extends Controller
{
    public function index()
    {
           

            $opd = [];
            $opds  = [];
            $sasaran = [];
            $program = [];
            $indikator_kinerja = [];
            $eselon = [];
            $eselonIII = [];
            $eselonIV = [];
            $tahun = '';
            $dinas = '';

            if(Auth::user()->level == 1)
            {
                $opd = Organisasi::orderBy('organisasi_no')->where('organisasi_jenis', 'ORG')->get();
            }
        
    return view('app.perencanaan.pk.index', compact('opd','opds','sasaran','indikator_kinerja','tahun','program', 'dinas', 'eselon', 'eselonIII', 'eselonIV'));
    }



    public function dataPk (Request $request) 
    {
        if(Auth::user()->level == 2){
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_no', Auth::user()->organisasi_no)->get();
            $opds  = Organisasi::where('organisasi_no','=',Auth::user()->organisasi_no)->get();
            $sasaran = Sasaran::where('organisasi_no','=',Auth::user()->organisasi_no)->get();

            $indikator_kinerja = PK2::join('indikator_sasaran as is','is.id','pk_eselon_2.indikator_sasaran_id')
                                ->leftJoin('satuan', 'satuan.id','=','is.satuan_id')
                                ->where('is.organisasi_no',Auth::user()->organisasi_no)
                                ->where('pk_eselon_2.tahun', $request->tahun)
                                ->get(['pk_eselon_2.id','pk_eselon_2.tahun','pk_eselon_2.target','pk_eselon_2.pagu','is.indikator_sasaran_nama','is.sasaran_nomor','satuan.satuan_nama']);
                               

            // $eselon = PK2::join('indikator_sasaran_renstra as is','is.id','pk_eselon_2.indikator_sasaran_id')
            //             ->leftJoin('sasaran_renstra as sr','sr.id','is.sasaran_id')
            //             ->leftJoin('satuan', 'satuan.id','=','is.satuan_id')
            //             ->leftJoin('prokeg_renstra as pr', 'pr.indikator_sasaran_id', 'is.id')
            //             ->where('is.organisasi_no',Auth::user()->organisasi_no)
            //             ->where('pk_eselon_2.tahun', $request->tahun)
            //             ->get(['pk_eselon_2.id','pk_eselon_2.tahun','pk_eselon_2.target','pk_eselon_2.pagu','is.id as indikator_sasaran_id','is.indikator_sasaran as indikator_sasaran_nama','satuan.satuan_nama', 'sr.sasaran_nama','sr.id as sasaran_id','pr.target_t1',
            //                 'pr.target_t2',
            //                 'pr.target_t3',
            //                 'pr.target_t4',
            //                 'pr.target_t5',
            //                 'pr.pagu_t1',
            //                 'pr.pagu_t2',
            //                 'pr.pagu_t3',
            //                 'pr.pagu_t4',
            //                 'pr.pagu_t5',
            //             ]);


            $eselon = PK2::leftJoin('indikator_sasaran_renstra as is','is.id','pk_eselon_2.indikator_sasaran_id')
                        ->leftJoin('sasaran_renstra as sr','sr.id','is.sasaran_id')
                        ->leftJoin('satuan', 'satuan.id','=','is.satuan_id')
                        ->select(
                            'pk_eselon_2.id',
                            'pk_eselon_2.tahun',
                            'pk_eselon_2.target',
                            'pk_eselon_2.pagu',
                            'is.id as indikator_sasaran_id',
                            'is.indikator_sasaran as indikator_sasaran_nama',
                            'satuan.satuan_nama', 
                            'sr.sasaran_nama',
                            'sr.id as sasaran_id'

                        )
                        ->where('is.organisasi_no',Auth::user()->organisasi_no)
                        ->where('pk_eselon_2.tahun', $request->tahun)
                        ->get();

            
            $eselonIII = PK3::leftJoin('indikator_program_renstra as ipr','ipr.id','pk_eselon_3.indikator_program_id')
                        ->leftJoin('program', 'program.program_no', 'ipr.program_no')
                        ->leftJoin('satuan', 'satuan.id','=','ipr.satuan_id')
                        ->select(
                            'program.id as program_id',
                            'program.program_nama',
                            'pk_eselon_3.id',
                            'pk_eselon_3.tahun',
                            'pk_eselon_3.target',
                            'pk_eselon_3.pagu',
                            'ipr.id as indikator_program_id',
                            'ipr.indikator_program_nama',
                            'satuan.satuan_nama', 
                            'ipr.sasaran_program'

                        )
                        ->where('ipr.organisasi_no',Auth::user()->organisasi_no)
                        ->where('pk_eselon_3.tahun', $request->tahun)
                        ->get();
                        // dd($eselonIII);

            $eselonIV = PK4::join('indikator_kegiatan_renstra as ikr','ikr.id','pk_eselon_4.indikator_kegiatan_id')
                        ->leftJoin('prokeg_renstra as pr', 'pr.renstra_id', 'ikr.renstra_id')
                        ->leftJoin('kegiatan', 'kegiatan.kegiatan_no', 'pr.kegiatan_no')
                        ->leftJoin('satuan', 'satuan.id','=','ikr.satuan_id')
                        ->select(
                            'kegiatan.id as kegiatan_id',
                            'kegiatan.kegiatan_nama',
                            'pk_eselon_4.id',
                            'pk_eselon_4.tahun',
                            'pk_eselon_4.target',
                            'pk_eselon_4.pagu',
                            'ikr.id as indikator_kegiatan_id',
                            'ikr.indikator_kegiatan as indikator_kegiatan_nama',
                            'satuan.satuan_nama', 
                            'ikr.sasaran_kegiatan'
                        )
                        ->where('pr.organisasi_no',Auth::user()->organisasi_no)
                        ->where('pk_eselon_4.tahun', $request->tahun)
                        ->get();




        }else{
            $opd = Organisasi::orderBy('organisasi_no')
            ->where('organisasi_jenis','=','ORG')
            ->get();
            $opds  = Organisasi::where('organisasi_no','=',$request->organisasi_no)
                ->select('organisasi_no','organisasi_nama')
                ->get();
            $sasaran = Sasaran::where('organisasi_no','=',$request->organisasi_no)->get();

            $indikator_kinerja = PK2::join('indikator_sasaran as is','is.id','pk_eselon_2.indikator_sasaran_id')
                                ->where('is.organisasi_no',$request->organisasi_no)
                                ->where('pk_eselon_2.tahun', $request->tahun )
                                ->get(['pk_eselon_2.id','pk_eselon_2.tahun','pk_eselon_2.target','pk_eselon_2.pagu','is.indikator_sasaran_nama']);

                                $eselon = PK2::join('indikator_sasaran_renstra as is','is.id','pk_eselon_2.indikator_sasaran_id')
                                ->leftJoin('sasaran_renstra as sr','sr.id','is.sasaran_id')
                                ->leftJoin('satuan', 'satuan.id','=','is.satuan_id')
                                ->leftJoin('prokeg_renstra as pr', 'pr.indikator_sasaran_id', 'is.id')
                                ->where('is.organisasi_no',$request->organisasi_no)
                                ->where('pk_eselon_2.tahun', $request->tahun)
                                ->get(['pk_eselon_2.id','pk_eselon_2.tahun','pk_eselon_2.target','pk_eselon_2.pagu','is.id as indikator_sasaran_id','is.indikator_sasaran as indikator_sasaran_nama','satuan.satuan_nama', 'sr.sasaran_nama','sr.id as sasaran_id','pr.target_t1',
                            'pr.target_t2',
                            'pr.target_t3',
                            'pr.target_t4',
                            'pr.target_t5',
                            'pr.pagu_t1',
                            'pr.pagu_t2',
                            'pr.pagu_t3',
                            'pr.pagu_t4',
                            'pr.pagu_t5',]);


        }

        $tahun = $request->tahun;
        $dinas = $request->organisasi_no;
    
        


        return view('app.perencanaan.pk.index', compact('opd','opds','sasaran','indikator_kinerja','tahun', 'eselon', 'dinas', 'eselonIII', 'eselonIV'))->with('no', 1);
    }

    public function create()
    {
        $indikator_sasaran = IndikatorSasaran::where('organisasi_no',Auth::user()->organisasi_no)
                            ->get();
        $jabatans = Jabatan::get();
        $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
        // return $indikator_sasaran;
        return view('app.perencanaan.pk.create_eselon_II', compact('indikator_sasaran', 'jabatans', 'orgs'));

    }

    public function create_eselon_III()
    {
        $indikator_program = IndikatorProgram::where('organisasi_no',Auth::user()->organisasi_no)
                            ->get();
        $jabatans = Jabatan::get();
        $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();
        // return $indikator_program;
        return view('app.perencanaan.pk.create_eselon_III', compact('indikator_program', 'jabatans', 'orgs'));

    }

    public function create_eselon_IV()
    {
        $indikator_kegiatan = IndikatorKegiatan::leftJoin('prokeg_renstra as pr', 'pr.renstra_id','indikator_kegiatan_renstra.renstra_id')
                            ->where('pr.organisasi_no',Auth::user()->organisasi_no)
                            ->get();
        $jabatans = Jabatan::get();
        $orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();

        return view('app.perencanaan.pk.create_eselon_IV', compact('indikator_kegiatan', 'jabatans', 'orgs'));

    }

    public function ajaxIndikatorProgramPkIII($organisasi_no)
    {
    	return $organisasi_no;
    }

    public function show()
    {
        //
    }

    public function store(Request $request)
    {

        try {
            $this->validate($request, [
                'indikator_sasaran_id' => 'required',
                'jabatan_id' => 'required',
                'tahun' => 'required',
                'target' => 'required',
                'pagu' => 'required',
            ]);

            $pkII = new PK2;
            $pkII->indikator_sasaran_id = $request->indikator_sasaran_id;
            $pkII->tahun = $request->tahun;
            $pkII->jabatan_id = $request->jabatan_id;
            $pkII->target = $request->target;
            $pkII->pagu = $request->pagu;
            $pkII->created_by = Auth::user()->username;
            $pkII->save();
            // Alert::success('Data Berhasil Ditambahkan.', 'Berhasil!')->persistent('Close');
            toastr()->success('Data has been Saved successfully!');

            
            return redirect('perencanaan/perjanjian-kinerja');

        } catch (\Exception $e) {
    		toastr()->error($e->getMessage());
    		return redirect('perencanaan/pk/create-eselon-II');
    	}
        
    }

    public function store_eselon_III(Request $request)
    {
    	try {
    		$this->validate($request, [
	            'indikator_program_id' => 'required',
	            'jabatan_id' => 'required',
	            'tahun' => 'required',
	            'target' => 'required',
	            'pagu' => 'required',
	        ]);

	        $pkII = new PK3;
	        $pkII->indikator_program_id = $request->indikator_program_id;
	        $pkII->tahun = $request->tahun;
	        $pkII->jabatan_id = $request->jabatan_id;
	        $pkII->target = $request->target;
	        $pkII->pagu = $request->pagu;
	        $pkII->created_by = Auth::user()->username;
	        $pkII->save();
	        // Alert::success('Data Berhasil Ditambahkan.', 'Berhasil!')->persistent('Close');
	        toastr()->success('Data has been Saved successfully!');

	        
	        return redirect('perencanaan/perjanjian-kinerja');

    	} catch (\Exception $e) {
    		toastr()->error($e->getMessage());
    		return redirect('perencanaan/pk/create-eselon-III');
    	}
        
        
    }

    public function store_eselon_IV(Request $request)
    {
    	try {
    		$this->validate($request, [
	            'indikator_kegiatan_id' => 'required',
	            'jabatan_id' => 'required',
	            'tahun' => 'required',
	            'target' => 'required',
	            'pagu' => 'required',
	        ]);

	        $pkII = new PK4;
	        $pkII->indikator_kegiatan_id = $request->indikator_kegiatan_id;
	        $pkII->tahun = $request->tahun;
	        $pkII->jabatan_id = $request->jabatan_id;
	        $pkII->target = $request->target;
	        $pkII->pagu = $request->pagu;
	        $pkII->created_by = Auth::user()->username;
	        $pkII->save();
	        // Alert::success('Data Berhasil Ditambahkan.', 'Berhasil!')->persistent('Close');
	        toastr()->success('Data has been Saved successfully!');

	        
	        return redirect('perencanaan/perjanjian-kinerja');

    	} catch (\Exception $e) {
    		toastr()->error($e->getMessage());
    		return redirect('perencanaan/pk/create-eselon-IV');
    	}
        
        
    }

    public function edit($id) 
    {
         try {

            $model = PK2::findOrFail($id);

            $jabatans = Jabatan::get();
            
            if(Auth::user()->level == 2)
            {
                $indikator_sasaran = IndikatorSasaran::where('organisasi_no',Auth::user()->organisasi_no)->get();
                
            }elseif(Auth::user()->level != 2)
            {
                $indikator_sasaran = IndikatorSasaran::get();
            }

            return view('app.perencanaan.pk.edit', compact('model', 'indikator_sasaran', 'jabatans'))->with('no', 1);
            
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect('perencanaan/perjanjian-kinerja');
        }

    }

    public function edit_eselon_III($id) 
    {
        try {

            $model = PK3::findOrFail($id);

            $jabatans = Jabatan::get();
            
            if(Auth::user()->level == 2)
            {
                $indikator_program = IndikatorProgram::where('organisasi_no',Auth::user()->organisasi_no)->get();
                
            }elseif(Auth::user()->level != 2)
            {
                $indikator_program = IndikatorProgram::get();
            }

            return view('app.perencanaan.pk.edit_eselon_III', compact('model', 'indikator_program', 'jabatans'))->with('no', 1);
            
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect('perencanaan/perjanjian-kinerja');
        }
        

            
    }


    public function edit_eselon_IV($id) 
    {
        try {
            $model = PK4::findOrFail($id);

            $jabatans = Jabatan::get();
            
            if(Auth::user()->level == 2)
            {
                $indikator_kegiatan = IndikatorKegiatan::leftJoin('prokeg_renstra as pr', 'pr.renstra_id','indikator_kegiatan_renstra.renstra_id')
                            ->where('pr.organisasi_no',Auth::user()->organisasi_no)->get();
                
            }elseif(Auth::user()->level != 2)
            {
                $indikator_kegiatan = IndikatorKegiatan::get();
            }

            return view('app.perencanaan.pk.edit_eselon_IV', compact('model', 'indikator_kegiatan', 'jabatans'))->with('no', 1);

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect('perencanaan/perjanjian-kinerja');
        }
        
       
    }

    public function update(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'indikator_sasaran_id' => 'required',
            'jabatan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required',
        ]);

        $pkII = PK2::findOrFail($id);

        $pkII->indikator_sasaran_id = $request->indikator_sasaran_id;
        $pkII->jabatan_id = $request->jabatan_id;
        $pkII->tahun = $request->tahun;
        $pkII->target = $request->target;
        $pkII->pagu = $request->pagu;
        $pkII->updated_by = Auth::user()->username;
        $pkII->save();
        // Alert::success('Data Berhasil update.', 'Berhasil!')->persistent('Close');
        toastr()->success('Data has been Updated successfully!');

        
        return redirect('perencanaan/perjanjian-kinerja');
    }


    public function update_eselon_III(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'indikator_program_id' => 'required',
            'jabatan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required',
        ]);

        $pkIII = PK3::findOrFail($id);

        $pkIII->indikator_program_id = $request->indikator_program_id;
        $pkIII->jabatan_id = $request->jabatan_id;
        $pkIII->tahun = $request->tahun;
        $pkIII->target = $request->target;
        $pkIII->pagu = $request->pagu;
        $pkIII->updated_by = Auth::user()->username;
        $pkIII->save();
        // Alert::success('Data Berhasil update.', 'Berhasil!')->persistent('Close');
        toastr()->success('Data has been Updated successfully!');

        
        return redirect('perencanaan/perjanjian-kinerja');
    }


    public function update_eselon_IV(Request $request, $id)
    {
        $this->validate($request, [
            'indikator_kegiatan_id' => 'required',
            'jabatan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required',
        ]);

        $pkII = PK4::findOrFail($id);

        $pkII->indikator_kegiatan_id = $request->indikator_kegiatan_id;
        $pkII->jabatan_id = $request->jabatan_id;
        $pkII->tahun = $request->tahun;
        $pkII->target = $request->target;
        $pkII->pagu = $request->pagu;
        $pkII->updated_by = Auth::user()->username;
        $pkII->save();
        // Alert::success('Data Berhasil update.', 'Berhasil!')->persistent('Close');
        toastr()->success('Data has been Updated successfully!');

        
        return redirect('perencanaan/perjanjian-kinerja');
    }
    

    public function destroy($id)
    {

        try {
            $pk = PK2::findOrFail($id);
            $pk->delete();

            // Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
            toastr()->success('Data has been deleted successfully!');
            return redirect('perencanaan/perjanjian-kinerja');

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect('perencanaan/perjanjian-kinerja');
        }
    }


    public function destroy_eselon_III($id)
    {

        try {
            $pk = PK3::findOrFail($id);
            $pk->delete();

            // Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
            toastr()->success('Data has been deleted successfully!');
            return redirect('perencanaan/perjanjian-kinerja');

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect('perencanaan/perjanjian-kinerja');
        }
    }

    public function destroy_eselon_IV($id)
    {

        try {
            $pk = PK4::findOrFail($id);
            $pk->delete();

            // Alert::success('Berhasil', 'Data Berhasil Di Hapus')->persistent('Close');
            toastr()->success('Data has been deleted successfully!');
            return redirect('perencanaan/perjanjian-kinerja');

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect('perencanaan/perjanjian-kinerja');
        }
    }

}
