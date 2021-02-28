<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\SasaranRenstra;
use App\Models\Renstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RktController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('app.user.rkt.index');
    }

    public function fetch(Request $request)
    {
        return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun);
    }

    public function fetch_emit($organisasi_no, $tahun)
    {
        $sasarans = SasaranRenstra::leftJoin('target_is_renstra as tisr', 'tisr.indikator_sasaran_id', 'sasaran_renstra.id')
                    ->leftJoin('tujuan_renstra as tr', 'tr.id', 'sasaran_renstra.tujuan_id')
                    ->leftJoin('indikator_sasaran_renstra as isr', 'isr.sasaran_id', 'sasaran_renstra.id')
                    ->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
                    ->select(
                      'sasaran_renstra.id as sasaran_id',
                      'sasaran_renstra.sasaran_nomor',
                      'sasaran_renstra.sasaran_nama',
                      'isr.id as indikator_sasaran_id',
                      'isr.indikator_sasaran',
                      's.satuan_nama',
                      'tr.id as tujuan_id',
                      'tr.tujuan_nama',
                      'tisr.target'
                    )
                    ->where('sasaran_renstra.organisasi_no', $organisasi_no)
                    ->where('tisr.tahun', $tahun)
                    ->get();

        $prokegs = Renstra::leftJoin('indikator_kegiatan_renstra as ikr','ikr.renstra_id', 'renstra.id')
        					->leftJoin('program as p', 'p.program_no', 'renstra.program_no')
        					->leftJoin('target_ik_renstra as tikr', 'tikr.indikator_kegiatan_id', 'ikr.id')
        					->leftJoin('kegiatan as k', 'k.kegiatan_no', 'renstra.kegiatan_no')
        					->leftJoin('satuan as s', 's.id', 'ikr.satuan_id')
        					->select(
        						'p.program_no',
        						'p.program_nama',
        						'k.kegiatan_no',
        						'k.kegiatan_nama',
        						'ikr.indikator_kegiatan',
        						's.satuan_nama',
        						'tikr.target',
        						'tikr.pagu'
        					)
        					->where('renstra.organisasi_no', $organisasi_no)
        					->where('tikr.tahun', $tahun)
        					->get();
        

        $target_sasarans = '';
        $target_prokegs = '';

        foreach(collect($sasarans)->unique('tujuan_id') as $t){
            $target_sasarans .= '<tr>
		                          <td colspan="18" style="font-weight: bolder;">'.$t->tujuan_nama.'</td>
		                        </tr>';
            foreach(collect($sasarans)->where('sasaran_id', $t->sasaran_id) as $s){
            $target_sasarans .= '<tr style="font-size: 12px;">
		                          <td></td>
		                          <td style="font-weight: bold;" colspan="17">'.$s->sasaran_nama.'</td>
		                        </tr>';
            foreach(collect($sasarans)->where('indikator_sasaran_id', $s->indikator_sasaran_id) as $is){
              $target_sasarans .= '<tr style="font-size: 11px;">
		                            <td colspan="2"></td>
		                            <td>'.$is->indikator_sasaran.'</td>
		                            <td style="text-align: center;">'.$is->satuan_nama.'</td>
		                            <td style="text-align: center;">'.$is->target.'</td>
		                          </tr>';
            }
          }
        }


        foreach(collect($prokegs)->unique('program_no') as $p){
			$target_prokegs .= '<tr style="font-weight: bold;">
									<td colspan="19" >'.$p->program_no.' &nbsp;'.$p->program_nama.'</td>
								</tr>';
			foreach(collect($prokegs)->unique('kegiatan_no')->where('program_no', $p->program_no) as $k){
				$target_prokegs .= '<tr>
										<td colspan="2"></td>
										<td>'.$k->kegiatan_nama.'</td>
										<td>'.$k->indikator_kegiatan.'</td>
										<td style="text-align: center;">'.$k->satuan_nama.'</td>
										<td style="text-align: center;">'.$k->target.'</td>
										<td style="text-align: right;">'.number_format($k->pagu).'</td>
									</tr>';
			}
		}

        return response()->json([
          'target_sasarans' => $target_sasarans,
          'target_prokegs' => $target_prokegs,
        ]);

    }

}
