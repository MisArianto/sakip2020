<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\ProgKegRenstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\ProkegRenstra\ApiProgramRenstra;
use App\Models\API\ProkegRenstra\ApiKegiatanRenstra;
use App\Models\API\TujuanRenstra\ApiSatuan;

class ProgramKegiatanRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('app.user.prokeg_renstra.index');
    }

    public function fetch()
    {
        return $this->fetch_emit(Auth::user()->organisasi_no);
    }

    public function fetch_emit($organisasi_no)
    {
        $programs = ProgKegRenstra::join('program','program.program_no','prokeg_renstra.program_no')
                    ->join('kegiatan','kegiatan.kegiatan_no','=','prokeg_renstra.kegiatan_no')
                    ->join('satuan','satuan.id','=','prokeg_renstra.satuan_id')
                    ->where('prokeg_renstra.organisasi_no','=',$organisasi_no)
                    ->groupBy('program.program_no')
                    ->groupBy('kegiatan.kegiatan_no')
                    ->get();


        $output = '';


        foreach(collect($programs)->unique('program_no') as $p){
          $output .= '<tr style="font-weight: bold;" title="Program">
                        <td colspan="18" >'.$p->program_no.' &nbsp; '.$p->program_nama.'</td>
                      </tr>';
          foreach(collect($programs)->unique('kegiatan_no')->where('program_no', $p->program_no) as $k){

          $output .= '<tr>
                        <td colspan="2"></td>
                        <td title="Kegiatan">'.$k->kegiatan_nama.'</td>
                        <td title="Indikator Kegiatan">'.$k->indikator_kegiatan.'</td>
                        <td style="text-align: center;" title="Satuan">'.$k->satuan_nama.'</td>
                        <td style="text-align: center;" title="Capaian Awal">'.$k->perencanaan_awal.'</td>
                        <td style="text-align: center;" title="Target Tahun 2017">'.$k->target_t1.'</td>
                        <td style="text-align: right;" title="Pagu Tahun 2017">'.$k->pagu_t1.'</td>
                        <td style="text-align: center;" title="Target Tahun 2018">'.$k->target_t2.'</td>
                        <td style="text-align: right;" title="Pagu Tahun 2018">'.$k->pagu_t2.'</td>
                        <td style="text-align: center;" title="Target Tahun 2019">'.$k->target_t3.'</td>
                        <td style="text-align: right;" title="Pagu Tahun 2019">'.$k->pagu_t3.'</td>
                        <td style="text-align: center;" title="Target Tahun 2020">'.$k->target_t4.'</td>
                        <td style="text-align: right;" title="Pagu Tahun 2020">'.$k->pagu_t4.'</td>
                        <td style="text-align: center;" title="Target Tahun 2021">'.$k->target_t5.'</td>
                        <td style="text-align: right;" title="Pagu Tahun 2021">'.$k->pagu_t5.'</td>
                        <td style="text-align: center;" title="Target Akhir">'.$k->target_kondisi_akhir.'</td>
                        <td style="text-align: right;" title="Pagu Akhir">'.$k->pagu_kondisi_akhir.'</td>
                        
                          
                      </tr>';
        }
      }

      return $output;

       

    }

}
