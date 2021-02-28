<?php

namespace App\Http\Controllers\User;

use DB;
use Auth;
use App\Models\Dpa;
use App\Models\Satuan;
use App\Models\JabatanSimpeg as Jabatan;
use App\Models\Kegiatan;
use App\Models\PerjanjianKinerjaEselon4 as PK4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PKEselon4Controller extends Controller
{
    public function index()
    {
        return view('app.user.PKEselon4.index');
    }

    public function fetch_kegiatan($tahun)
    {
    	if($tahun == '2021'){
    		$kegiatans = DB::table('kegiatan90 as k')
    					->select(
    						'k.kode_kegiatan_2 as kegiatan_no',
    						'k.nama as kegiatan_nama'
    					)
    					->get();
    	}else{
        	$kegiatans = Kegiatan::latest()->get();
    	}

        return response()->json([
            'kegiatans' => $kegiatans
        ]);
    }


    public function fetch_jabatan()
    {
        $jabatans = Jabatan::get();

        return response()->json([
            'jabatans' => $jabatans
        ]);
    }


    public function fetch_satuan()
    {
        $satuans = Satuan::latest()->get();

        return response()->json([
            'satuans' => $satuans
        ]);
    }

    public function fetch(Request $request)
    {
        return $this->fetch_eselon4($request->organisasi_no, $request->tahun);
    }

    public function dpa(Request $request)
    {

        if($request->tahun == '2021')
        {

            $mapping = DB::table('mapping_13_90')->where('kode_kegiatan90', $request->kegiatan_no)->where('organisasi_no', Auth::user()->organisasi_no)->first();

            $dpa = Dpa::where('kode_kegiatan', $mapping->kegiatan_no13)->where('kode_organisasi', Auth::user()->organisasi_no)->first();

            if(!empty($dpa))
            {
                return $dpa->pagu;
            }else{
                // jika hasilnya 0 berarti program yang di pilih bukan milik OPD mereka
                return '0';
            }


        }else{

            $dpa = Dpa::where('kode_kegiatan', $request->kegiatan_no)->where('kode_organisasi', Auth::user()->organisasi_no)->first();

            if(!empty($dpa))
            {
                return $dpa->pagu;
            }else{
                // jika hasilnya 0 berarti program yang di pilih bukan milik OPD mereka
                return '0';
            }

        }

    }


    public function fetch_eselon4($organisasi_no, $tahun)
    {

    	if($tahun == '2021')
    	{
    		$eselonIV = PK4::leftJoin('kegiatan90 as kegiatan', 'kegiatan.kode_kegiatan_2', 'pk_eselon_4.kegiatan_no')
                        ->leftJoin('jabatan_simpeg as j', 'j.id', 'pk_eselon_4.jabatan_id')
                        ->leftJoin('satuan as s', 's.id','=','pk_eselon_4.satuan_id')
                        ->select(
                            'pk_eselon_4.id',
                            'kegiatan.kode_kegiatan_2 as kegiatan_no',
                            'kegiatan.nama as kegiatan_nama',
                            'pk_eselon_4.id',
                            'pk_eselon_4.tahun',
                            'pk_eselon_4.target',
                            'pk_eselon_4.pagu',
                            's.id as satuan_id',
                            's.satuan_nama',
                            'pk_eselon_4.indikator_sasaran as indikator_sasaran_nama',
                            'pk_eselon_4.sasaran as sasaran_nama',
                            'j.id as jabatan_id',
                            'j.jabatan_nama'
                        )
                        ->where('pk_eselon_4.organisasi_no', $organisasi_no)
                        ->where('pk_eselon_4.tahun', $tahun)
                        ->get();
    	}
    	else
    	{
    		$eselonIV = PK4::leftJoin('kegiatan as kegiatan', 'kegiatan.kegiatan_no', 'pk_eselon_4.kegiatan_no')
                        ->leftJoin('jabatan_simpeg as j', 'j.id', 'pk_eselon_4.jabatan_id')
                        ->leftJoin('satuan as s', 's.id','=','pk_eselon_4.satuan_id')
                        ->select(
                            'pk_eselon_4.id',
                            'kegiatan.kegiatan_no',
                            'kegiatan.kegiatan_nama',
                            'pk_eselon_4.id',
                            'pk_eselon_4.tahun',
                            'pk_eselon_4.target',
                            'pk_eselon_4.pagu',
                            's.id as satuan_id',
                            's.satuan_nama',
                            'pk_eselon_4.indikator_sasaran as indikator_sasaran_nama',
                            'pk_eselon_4.sasaran as sasaran_nama',
                            'j.id as jabatan_id',
                            'j.jabatan_nama'
                        )
                        ->where('pk_eselon_4.organisasi_no', $organisasi_no)
                        ->where('pk_eselon_4.tahun', $tahun)
                        ->get();

    	}

        
        $no = 1;
        $output = '';

        foreach(collect($eselonIV)->unique('sasaran_nama') as $data1){
            $output .= '<tr>
                         <td align="center"></td>
                         <td colspan="7" title="sasaran"><strong>'.$data1->sasaran_nama.'</strong></td>
                       </tr>';

                foreach(collect($eselonIV)->unique('indikator_sasaran_nama')->where('sasaran_nama', $data1->sasaran_nama) as $is){
                $output .= '<tr>
                                <td></td>
                                <td></td>
                                <td>'.$is->indikator_sasaran_nama.'</td>
                                <td></td>
                                <td></td>
                                <td align="center"></td>
                                <td align="center"></td>
                                <td></td>
                            </tr>';
                foreach(collect($eselonIV)->where('indikator_sasaran_nama', $is->indikator_sasaran_nama)->unique('kegiatan_no') as $p){
                $output .= '<tr>
                                <td>
                                    <div class="btn-group"><button class="btn btn-info btn-sm" id="handleEdit" url="{{ url("user/perjanjian-kinerja/eselon-4/edit") }}" data-id="'.$p->id.'" data-indikator_sasaran="'.$p->indikator_sasaran_nama.'" data-sasaran="'.$p->sasaran_nama.'" data-tahun="'.$p->tahun.'" data-kegiatan_no="'.$p->kegiatan_no.'" data-jabatan_id="'.$p->jabatan_id.'" data-satuan_id="'.$p->satuan_id.'" data-target="'.$p->target.'" data-pagu="'.$p->pagu.'" title="edit '. $p->indikator_sasaran .'"><i class="fa fa-edit cursor"></i></button>
                                    <button class="btn btn-danger btn-sm" id="handleDeletePk" data-id="'.$p->id.'" title="delete '.$p->indikator_sasaran.'"><i class="fa fa-trash cursor"></i></button></div>
                                </td>
                                <td></td>
                                <td colspan="1"></td>
                                <td>'.$p->kegiatan_nama.'</td>
                                <td>'.$p->jabatan_nama.'</td>
                                <td>'.$p->satuan_nama.'</td>
                                <td>'.$p->target.'</td>
                                <td>'.$p->pagu .'</td>';
                }
            }
        }

        return $output;

    }
    

    public function store(Request $request)
    {

        $this->validate($request, [
            'sasaran' => 'required',
            'indikator_sasaran' => 'required',
            'kegiatan_no' => 'required',
            'jabatan_id' => 'required',
            'satuan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required'
        ]);

        try {

            $cek = PK4::where('sasaran', $request->sasaran)
                    ->where('indikator_sasaran', $request->indikator_sasaran)
                    ->where('kegiatan_no', $request->kegiatan_no)
                    ->where('tahun', $request->tahun)
                    ->first();


            if($cek)
            {
                return 'warning';
            }else{

                $pkII = new PK4;
                $pkII->sasaran = $request->sasaran;
                $pkII->indikator_sasaran = $request->indikator_sasaran;
                $pkII->kegiatan_no = $request->kegiatan_no;
                $pkII->tahun = $request->tahun;
                $pkII->jabatan_id = $request->jabatan_id;
                $pkII->satuan_id = $request->satuan_id;
                $pkII->target = $request->target;
                $pkII->pagu = str_replace([',','.','Rp',' '], '', $request->pagu);
                $pkII->organisasi_no = Auth::user()->organisasi_no;
                $pkII->created_by = Auth::user()->username;
                $pkII->save();

                return $this->fetch_eselon4(Auth::user()->organisasi_no, $request->tahun_emit);
            }

        } catch (\Exception $e) {
    		return $e;
    	}
        
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sasaran' => 'required',
            'indikator_sasaran' => 'required',
            // 'kegiatan_no' => 'required',
            'jabatan_id' => 'required',
            'satuan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required'
        ]);

        $cek = PK4::where('sasaran', $request->sasaran)
                    ->where('indikator_sasaran', $request->indikator_sasaran)
                    ->where('kegiatan_no', $request->kegiatan_no)
                    // ->where('jabatan_id', $request->jabatan_id)
                    // ->where('satuan_id', $request->satuan_id)
                    ->where('tahun', $request->tahun)
                    ->where('id', '!=',$id)
                    ->first();

        if($cek)
        {
            return 'warning';
        }else{

            $model = PK4::findOrFail($id);
            $model->sasaran = $request->sasaran;
            $model->indikator_sasaran = $request->indikator_sasaran;
            $model->kegiatan_no = $request->kegiatan_no ? $request->kegiatan_no : $model->kegiatan_no;
            $model->jabatan_id = $request->jabatan_id;
            $model->satuan_id = $request->satuan_id;
            $model->tahun = $request->tahun;
            $model->target = $request->target;
            $model->pagu = str_replace([',','.','Rp',' '], '', $request->pagu);
            $model->organisasi_no = Auth::user()->organisasi_no;
            $model->updated_by = Auth::user()->username;
            $model->save();

            return $this->fetch_eselon4(Auth::user()->organisasi_no, $request->tahun_emit);

        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $pk = PK4::findOrFail($id);
            $pk->delete();

            return $this->fetch_eselon4(Auth::user()->organisasi_no, $request->tahun_filter);

        } catch (\Exception $e) {
            return $e;
        }
    }

}
