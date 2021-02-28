<?php

namespace App\Http\Controllers\Admin;

use DB;
use Alert;
use Auth;
use App\Models\Satuan;
use App\Models\JabatanSimpeg as Jabatan;
use App\Models\Program;
use App\Models\Organisasi;
use App\Models\SasaranRenstra as Sasaran;
use App\Models\IndikatorSasaranRenstra as IndikatorSasaran;
use App\Models\IndikatorProgramRenstra as IndikatorProgram;
use App\Models\PerjanjianKinerjaEselon2 as PK2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PKEselon2Controller extends Controller
{
    public function index()
    {
        $organisasis = Organisasi::where('organisasi_jenis', 'ORG')->get();

        return view('app.admin.PKEselon2.index', compact('organisasis'));
    }

    public function fetch_indikator_sasaran($organisasi_no)
    {
        $indikator_sasarans = IndikatorSasaran::where('organisasi_no', $organisasi_no)->latest()->get();

        return response()->json([
            'indikator_sasarans' => $indikator_sasarans
        ]);
    }

    public function fetch_program()
    {
        $programs = DB::table('program90 as p')
                    ->select(
                        'p.id',
                        'p.kode_program2 as program_no',
                        'p.nama as program_nama',
                    )
                    ->get();
        // $programs = Program::latest()->get();

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
        return $this->fetch_eselon2($request->organisasi_no, $request->tahun);
    }


    public function fetch_eselon2($organisasi_no, $tahun)
    {


        $eselon2 = PK2::leftJoin('indikator_sasaran_renstra as is','is.id','pk_eselon_2.indikator_sasaran_id')
                        ->leftJoin('program as p', 'p.program_no', 'pk_eselon_2.program_no')
                        ->leftJoin('sasaran_renstra as sr','sr.id','is.sasaran_id')
                        ->leftJoin('jabatan as j','j.id','pk_eselon_2.jabatan_id')
                        ->leftJoin('satuan', 'satuan.id','is.satuan_id')
                        ->select(
                            'pk_eselon_2.id',
                            'pk_eselon_2.organisasi_no',
                            'pk_eselon_2.tahun',
                            'pk_eselon_2.target',
                            'pk_eselon_2.pagu',
                            'is.id as indikator_sasaran_id',
                            'is.indikator_sasaran as indikator_sasaran_nama',
                            'satuan.id as satuan_id', 
                            'satuan.satuan_nama', 
                            'sr.sasaran_nama',
                            'sr.id as sasaran_id',
                            'p.program_nama',
                            'p.program_no',
                            'j.jabatan_nama',
                            'j.id as jabatan_id'
                        )
                        ->where('is.organisasi_no',$organisasi_no)
                        ->where('pk_eselon_2.tahun', $tahun)
                        ->get();


        $no = 1;
        $output = '';

        foreach(collect($eselon2)->unique('sasaran_id') as $data1){
            $output .= '<tr>
                         <td align="center"></td>
                         <td colspan="8" title="sasaran"><strong>'.$data1->sasaran_nama.'</strong></td>
                       </tr>';

                foreach(collect($eselon2)->unique('indikator_sasaran_id')->where('sasaran_id', $data1->sasaran_id) as $is){
                $output .= '<tr>
                                <td></td>
                                <td></td>
                                <td colspan="7" title="indikator sasaran">'.$is->indikator_sasaran_nama.'</td>
                            </tr>';
                foreach(collect($eselon2)->where('indikator_sasaran_id', $is->indikator_sasaran_id) as $p){
                $output .= '<tr>
                                <td>
                                    <div class="btn-group"><button class="btn btn-info btn-sm" id="handleEdit" url="{{ url("admin/perjanjian-kinerja/eselon-2/edit") }}" data-id="'.$p->id.'" data-organisasi_no="'.$p->organisasi_no.'" data-indikator_sasaran_id="'.$p->indikator_sasaran_id.'" data-tahun="'.$p->tahun.'" data-program_no="'.$p->program_no.'" data-jabatan_id="'.$p->jabatan_id.'" data-satuan_id="'.$p->satuan_id.'" data-target="'.$p->target.'" data-pagu="'.$p->pagu.'" title="edit '. $p->indikator_sasaran .'"><i class="fa fa-edit cursor"></i></button>
                                    <button class="btn btn-danger btn-sm" id="handleDeletePk" data-id="'.$p->id.'" title="delete '.$p->indikator_sasaran.'"><i class="fa fa-trash cursor"></i></button></div>
                                </td>
                                <td></td>
                                <td colspan="1"></td>
                                <td title="program">'.$p->program_nama.'</td>
                                <td>'.$p->jabatan_nama.'</td>
                                <td>'.$p->satuan_nama.'</td>
                                <td>'.$p->target.'</td>
                                <td>'. number_format($p->pagu) .'</td>';
                }
            }
        }

        return $output;

    }
    

    public function store(Request $request)
    {
        $this->validate($request, [
            'indikator_sasaran_id' => 'required',
            'jabatan_id' => 'required',
            'program_no' => 'required',
            'satuan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required',
        ]);

        try {

             $cek = PK2::where('indikator_sasaran_id', $request->indikator_sasaran_id)
                    ->where('program_no', $request->program_no)
                    ->where('tahun', $request->tahun)
                    ->first();


            if($cek)
            {
                return 'warning';
            }else{

                $model = new PK2;
                $model->indikator_sasaran_id = $request->indikator_sasaran_id;
                $model->program_no = $request->program_no;
                $model->tahun = $request->tahun;
                $model->jabatan_id = $request->jabatan_id;
                $model->target = $request->target;
                $model->pagu = str_replace([',','.','Rp',' '], '', $request->pagu);
                $model->organisasi_no = $request->organisasi_no;
                $model->created_by = Auth::user()->username;
                $model->save();

                return $this->fetch_eselon2($request->organisasi_no_emit, $request->tahun_emit);
            }

        } catch (\Exception $e) {
    		return $e;
    	}
        
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'indikator_sasaran_id' => 'required',
            'program_no' => 'required',
            'jabatan_id' => 'required',
            'satuan_id' => 'required',
            'tahun' => 'required',
            'target' => 'required',
            'pagu' => 'required',
        ]);

        $cek = PK2::where('indikator_sasaran_id', $request->indikator_sasaran_id)
                    ->where('program_no', $request->program_no)
                    ->where('tahun', $request->tahun)
                    ->where('id', '!=',$id)
                    ->first();

        if($cek)
        {
            return 'warning';
        }else{

            $model = PK2::findOrFail($id);

            $model->indikator_sasaran_id = $request->indikator_sasaran_id;
            $model->program_no = $request->program_no;
            $model->jabatan_id = $request->jabatan_id;
            $model->satuan_id = $request->satuan_id;
            $model->tahun = $request->tahun;
            $model->target = $request->target;
            $model->pagu = str_replace([',','.','Rp',' '], '', $request->pagu);
            $model->organisasi_no = $request->organisasi_no;
            $model->updated_by = Auth::user()->username;
            $model->save();

            return $this->fetch_eselon2($request->organisasi_no_emit, $request->tahun_emit);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $pk = PK2::findOrFail($id);
            $pk->delete();

            return $this->fetch_eselon2($request->organisasi_no, $request->tahun);

        } catch (\Exception $e) {
            return $e;
        }
    }

}
