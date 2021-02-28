<?php

namespace App\Http\Controllers\Admin;

use DB;
use Alert;
use Auth;
use App\Models\Satuan;
use App\Models\JabatanSimpeg as Jabatan;
use App\Models\Program;
use App\Models\Organisasi;
use App\Models\IndikatorProgramRenstra as IndikatorProgram;
use App\Models\PerjanjianKinerjaEselon3 as PK3;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PKEselon3Controller extends Controller
{
    public function index()
    {
        $organisasis = Organisasi::where('organisasi_jenis', 'ORG')->get();
        return view('app.admin.PKEselon3.index' ,compact('organisasis'));
    }

    public function fetch_program()
    {
        $programs = Program::latest()->get();

        return response()->json([
            'programs' => $programs
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
        return $this->fetch_eselon3($request->organisasi_no, $request->tahun);
    }


    public function fetch_eselon3($organisasi_no, $tahun)
    {


        $eselon3 = PK3::leftJoin('program', 'program.program_no', 'pk_eselon_3.program_no')
                        ->leftJoin('jabatan as j', 'j.id', 'pk_eselon_3.jabatan_id')
                        ->leftJoin('satuan as s', 's.id','=','pk_eselon_3.satuan_id')
                        ->select(
                            'pk_eselon_3.id',
                            'program.program_no',
                            'program.program_nama',
                            'pk_eselon_3.id',
                            'pk_eselon_3.tahun',
                            'pk_eselon_3.target',
                            'pk_eselon_3.pagu',
                            'pk_eselon_3.organisasi_no',
                            's.id as satuan_id',
                            's.satuan_nama',
                            'pk_eselon_3.indikator_sasaran as indikator_sasaran_nama',
                            'pk_eselon_3.sasaran as sasaran_nama',
                            'j.jabatan_nama',
                            'j.id as jabatan_id'

                        )
                        ->where('pk_eselon_3.organisasi_no',$organisasi_no)
                        ->where('pk_eselon_3.tahun', $tahun)
                        ->get();


        $no = 1;
        $output = '';

        foreach(collect($eselon3)->unique('sasaran_nama') as $data1){
            $output .= '<tr>
                         <td align="center"></td>
                         <td colspan="7" title="sasaran"><strong>'.$data1->sasaran_nama.'</strong></td>
                       </tr>';

                foreach(collect($eselon3)->unique('indikator_sasaran_nama')->where('sasaran_nama', $data1->sasaran_nama) as $is){
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
                foreach(collect($eselon3)->where('indikator_sasaran_nama', $is->indikator_sasaran_nama)->unique('program_no') as $p){
                $output .= '<tr>
                                <td>
                                    <div class="btn-group"><button class="btn btn-info btn-sm" id="handleEdit" url="{{ url("admin/perjanjian-kinerja/eselon-3/edit") }}" data-id="'.$p->id.'" data-organisasi_no="'.$p->organisasi_no.'" data-indikator_sasaran="'.$p->indikator_sasaran_nama.'" data-sasaran="'.$p->sasaran_nama.'" data-tahun="'.$p->tahun.'" data-program_no="'.$p->program_no.'" data-jabatan_id="'.$p->jabatan_id.'" data-satuan_id="'.$p->satuan_id.'" data-target="'.$p->target.'" data-pagu="'.$p->pagu.'" title="edit '. $p->indikator_sasaran .'"><i class="fa fa-edit cursor"></i></button>
                                    <button class="btn btn-danger btn-sm" id="handleDeletePk" data-id="'.$p->id.'" title="delete '.$p->indikator_sasaran.'"><i class="fa fa-trash cursor"></i></button></div>
                                </td>
                                <td></td>
                                <td colspan="1"></td>
                                <td>'.$p->program_nama.'</td>
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
            'program_no' => 'required',
            'jabatan_id' => 'required',
            'satuan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required'
        ]);

        try {

            $cek = PK3::where('sasaran', $request->sasaran)
                    ->where('indikator_sasaran', $request->indikator_sasaran)
                    ->where('program_no', $request->program_no)
                    ->where('tahun', $request->tahun)
                    ->first();


            if($cek)
            {
                return 'warning';
            }else{

                $pkII = new PK3;
                $pkII->sasaran = $request->sasaran;
                $pkII->indikator_sasaran = $request->indikator_sasaran;
                $pkII->program_no = $request->program_no;
                $pkII->tahun = $request->tahun;
                $pkII->jabatan_id = $request->jabatan_id;
                $pkII->satuan_id = $request->satuan_id;
                $pkII->target = $request->target;
                $pkII->pagu = str_replace([',','.','Rp',' '], '', $request->pagu);
                $pkII->organisasi_no = Auth::user()->organisasi_no;
                $pkII->created_by = Auth::user()->username;
                $pkII->save();

                return $this->fetch_eselon3($request->organisasi_no_emit, $request->tahun_emit);
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
            'program_no' => 'required',
            'jabatan_id' => 'required',
            'satuan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required'
        ]);

        $cek = PK3::where('sasaran', $request->sasaran)
                    ->where('indikator_sasaran', $request->indikator_sasaran)
                    ->where('program_no', $request->program_no)
                    ->where('jabatan_id', $request->jabatan_id)
                    ->where('satuan_id', $request->satuan_id)
                    ->where('tahun', $request->tahun)
                    ->first();

        if($cek)
        {
            return 'warning';
        }else{

            $model = PK3::findOrFail($id);
            $model->sasaran = $request->sasaran;
            $model->indikator_sasaran = $request->indikator_sasaran;
            $model->program_no = $request->program_no;
            $model->jabatan_id = $request->jabatan_id;
            $model->satuan_id = $request->satuan_id;
            $model->tahun = $request->tahun;
            $model->target = $request->target;
            $model->pagu = str_replace([',','.','Rp',' '], '', $request->pagu);
            $model->organisasi_no = Auth::user()->organisasi_no;
            $model->updated_by = Auth::user()->username;
            $model->save();

            return $this->fetch_eselon3($request->organisasi_no_emit, $request->tahun_emit);

        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $pk = PK3::findOrFail($id);
            $pk->delete();

            return $this->fetch_eselon3($request->organisasi_no_emit, $request->tahun_filter);

        } catch (\Exception $e) {
            return $e;
        }
    }

}
