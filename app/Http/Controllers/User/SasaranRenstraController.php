<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\SasaranRenstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\SasaranRenstra\ApiSasaranRenstra;
use App\Models\API\SasaranRenstra\ApiIndikatorSasaranRenstra;
use App\Models\API\TujuanRenstra\ApiTujuanRenstra;
use App\Models\API\TujuanRenstra\ApiSatuan;

class SasaranRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('app.user.sasaran_renstra.index');
    }

    public function fetch()
    {
      return response()->json([
            'api_sasaran_renstra' => ApiSasaranRenstra::api(),
            'api_tujuan_renstra' => ApiTujuanRenstra::api(),
            'api_indikator_sasaran_renstra' => ApiIndikatorSasaranRenstra::api(),
            'api_satuan' => ApiSatuan::api(),
            'sasaran_renstras' => $this->fetch_emit(Auth::user()->organisasi_no)
        ]);

    }

    public function fetch_emit($organisasi_no)
    {
        $sasarans = SasaranRenstra::join('tujuan_renstra', 'tujuan_renstra.id', '=','sasaran_renstra.tujuan_id')
                      ->leftJoin('indikator_sasaran_renstra as isr', 'isr.sasaran_id', '=','sasaran_renstra.id')
                      ->leftJoin('satuan', 'satuan.id', '=','isr.satuan_id')
                      ->groupBy('sasaran_renstra.id')
                      ->groupBy('isr.id')
                      ->select(
                          'tujuan_renstra.id as tujuan_id',
                          'tujuan_renstra.tujuan_nama',
                          'sasaran_renstra.id as sasaran_id', 
                          'sasaran_renstra.sasaran_nama',
                          'isr.id as indikator_sasaran_id',
                          'isr.indikator_sasaran',
                          'isr.kondisi_awal',
                          'isr.target_akhir',
                          'satuan.satuan_nama'
                            )
                      ->where('sasaran_renstra.organisasi_no', $organisasi_no)
                      ->get();

        $output = '';


        foreach(collect($sasarans)->unique('tujuan_id') as $t){
                $output .= '<tr>
                                <td colspan="8" style="font-weight: bolder;">'.$t->tujuan_nama.'</td>
                            </tr>';
                foreach(collect($sasarans)->unique('sasaran_id')->where('tujuan_id', $t->tujuan_id) as $s){
                $output .= '<tr>
                                <td></td>
                                <td colspan="6"><b>'.$s->sasaran_nama.'</b></td>
                            </tr>';
                foreach(collect($sasarans)->unique('indikator_sasaran_id')->where('sasaran_id', $s->sasaran_id) as $is){
                $output .= '<tr>
                                <td colspan="3"></td>
                                <td>'.$is->indikator_sasaran.'</td>
                                <td align="center">'.$is->satuan_nama.'</td>
                                <td align="center">'.$is->kondisi_awal.'</td>
                                <td align="center">'.$is->target_akhir.'</td>
                            </tr>';
                }
            }
        }

        return $output;
        

    }

}
