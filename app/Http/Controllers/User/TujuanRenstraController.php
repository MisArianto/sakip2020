<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\TujuanRenstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\TujuanRenstra\ApiTujuanRenstra;
use App\Models\API\TujuanRenstra\ApiIndikatorTujuanRenstra;
use App\Models\API\TujuanRenstra\ApiSatuan;

class TujuanRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('app.user.tujuan_renstra.index');
    }

    public function fetch()
    {
        return response()->json([
            'api_tujuan_renstra' => ApiTujuanRenstra::api(),
            'api_indikator_tujuan_renstra' => ApiIndikatorTujuanRenstra::api(),
            'api_satuan' => ApiSatuan::api(),
            'tujuan_renstras' => $this->fetch_emit(Auth::user()->organisasi_no)
        ]);

    }

    public function fetch_emit($organisasi_no)
    {
        $tujuans = TujuanRenstra::leftJoin('indikator_tujuan_renstra as itr', 'itr.tujuan_id', '=','tujuan_renstra.id')
                      ->leftJoin('satuan', 'satuan.id', '=','itr.satuan_id')
                      ->join('misi', 'misi.id', '=','tujuan_renstra.misi_id')
                      ->select(
                          'misi.id as misi_id',
                          'misi.nama',
                          'misi.nomor',
                          'tujuan_renstra.id as tujuan_id', 
                          'tujuan_renstra.tujuan_nama',
                          'itr.id as indikator_tujuan_id',
                          'itr.indikator_tujuan',
                          'itr.kondisi_akhir',
                          'satuan.satuan_nama'
                            )
                      ->where('tujuan_renstra.organisasi_no', $organisasi_no)
                      ->get();

                        // return $tujuans;

        $output = '';

        foreach(collect($tujuans)->unique('misi_id') as $m){
                $output .= '<tr style="font-weight: bolder;">
                                <td colspan="6">Misi Ke : '.$m->nomor.$m->nama.'</td>
                            </tr>';
                foreach(collect($tujuans)->unique('tujuan_id')->where('misi_id', $m->misi_id) as $t){
                
                $output .= '<tr>
                                <td></td>
                                <td colspan="4">'.$t->tujuan_nama.'</td>
                            </tr>';
                foreach(collect($tujuans)->unique('indikator_tujuan_id')->where('tujuan_id', $t->tujuan_id) as $it){
                $output .= '<tr >
                                <td colspan="2"></td>
                                <td>'.$it->indikator_tujuan.'</td>
                                <td style="text-align: center;">'.$it->satuan_nama.'</td>
                                <td style="text-align: center;">'.$it->kondisi_akhir.'</td>
                            </tr>';
                }
            }
        }

        return $output;

    }

}
