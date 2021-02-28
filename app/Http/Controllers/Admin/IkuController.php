<?php

namespace App\Http\Controllers\Admin;

use Session;
use DB;
use Auth;
use Alert;
use App\Models\Misi;
use App\Models\Satuan;
use App\Models\Organisasi;
use App\Models\SasaranRenstra as Sasaran;
use App\Models\IndikatorSasaranRenstra as IndikatorSasaran;
use App\Models\IkuRenstra as Iku;
use App\Models\RencanaStrategisTargetIndikatorSasaran as TargetIS;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organisasis = Organisasi::where('organisasi_jenis', 'ORG')->get();
        return view('app.admin.iku.index', compact('organisasis'));
    }

    public function fetch(Request $request)
    {

        return $this->fecth_ikus($request->organisasi_no, $request->tahun);
    }

    public function fecth_ikus($organisasi_no, $tahun)
    {
        $ikus = Iku::leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'iku.indikator_sasaran_id')
                ->leftJoin('sasaran_renstra as sr', 'sr.id', 'isr.sasaran_id')
                ->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
                ->select(
                    'iku.*',
                    'isr.indikator_sasaran',
                    'sr.id as sasaran_id',
                    'sr.sasaran_nama',
                    's.satuan_nama'
                )
                ->where('iku.organisasi_no', $organisasi_no)
                ->where('iku.tahun', $tahun)
                ->get();

        $output = '';

        foreach(collect($ikus)->unique('sasaran_id') as $s)
        {
            $output .= '<tr style="font-weight: bold;">
                            <td></td>  
                            <td colspan="8">'.$s->sasaran_nama.'</td>
                        </tr>';

            foreach(collect($ikus)->unique('indikator_sasaran_id')->where('sasaran_id', $s->sasaran_id) as $is)
            {
                $output .= '<tr style="font-size:  12px;">
                                <td>
                                    <div class="btn-group"><button class="btn btn-info btn-sm" id="handleEdit" url="{{ url("admin/iku/edit") }}" data-id="'.$is->id.'" data-indikator_sasaran_id="'.$is->indikator_sasaran_id.'" data-organisasi_no="'.$is->organisasi_no.'" data-tahun="'.$is->tahun.'" data-alasan="'.$is->alasan.'" data-formulasi="'.$is->formulasi.'" data-sumber_data="'.$is->sumber_data.'" data-keterangan="'.$is->keterangan.'" title="edit '. $is->indikator_sasaran .'"><i class="fa fa-edit cursor"></i></button>
                                    <button class="btn btn-danger btn-sm" id="handleDeleteIku" data-id="'.$is->id.'" title="delete '.$is->indikator_sasaran.'"><i class="fa fa-trash cursor"></i></button></div>
                                </td>
                                <td></td>
                                <td>'.$is->indikator_sasaran.'</td>
                                <td style="text-align: center;">'.$is->satuan_nama.'</td>
                                <td>'.$is->alasan.'</td>
                                <td>'.$is->formulasi.'</td>
                                <td>'.$is->sumber_data.'</td>
                                <td>'.$is->keterangan.'</td>
                            </tr>';
            }
        }
                

        return $output;
    }

    public function fetch_indikator_sasaran($organisasi_no)
    {
        $isr = IndikatorSasaran::where('organisasi_no', $organisasi_no)->latest()->get();
        return response()->json([
            'isr' => $isr
        ]);
    }

    public function fetch_organisasis()
    {
        $organisasis = Organisasi::where('organisasi_jenis', 'ORG')->get();
        return response()->json([
            'organisasis' => $organisasis
        ]);
    }
   
    public function store(Request $request)
    {
        
            $this->validate($request, [
                'indikator_sasaran_id' => 'required',
                'tahun' => 'required',
                'alasan' => 'required',
                'formulasi' => 'required',
                'sumber_data' => 'required',
                'keterangan' => 'required',
            ]);

            $cek = Iku::where('indikator_sasaran_id', $request->indikator_sasaran_id)
                        ->where('iku.organisasi_no', $request->organisasi_no)
                        ->where('iku.tahun', $request->tahun)
                        ->first();

            if($cek)
            {
                return 'warning';

            }else{

                $model = new Iku;
                $model->organisasi_no        = $request->organisasi_no;
                $model->indikator_sasaran_id = $request->indikator_sasaran_id;
                $model->tahun   = $request->tahun;
                $model->alasan   = $request->alasan;
                $model->formulasi   = $request->formulasi;
                $model->sumber_data   = $request->sumber_data;
                $model->keterangan   = $request->keterangan;
                $model->save();

                return $this->fecth_ikus($request->organisasi_no_emit, $request->tahun_emit);
            }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $this->validate($request, [
                'indikator_sasaran_id' => 'required',
                'tahun' => 'required',
                'alasan' => 'required',
                'formulasi' => 'required',
                'sumber_data' => 'required',
                'keterangan' => 'required',
            ]);

            $cek = Iku::where('indikator_sasaran_id', $request->indikator_sasaran_id)
                        ->where('iku.organisasi_no', $request->organisasi_no)
                        ->where('iku.tahun', $request->tahun)
                        ->where('iku.id', '!=',  $id)
                        ->first();

            if($cek)
            {
                return 'warning';

            }else{
            
                $model = Iku::find($id);
                $model->organisasi_no        = $request->organisasi_no;
                $model->indikator_sasaran_id = $request->indikator_sasaran_id;
                $model->tahun   = $request->tahun;
                $model->alasan   = $request->alasan;
                $model->formulasi   = $request->formulasi;
                $model->sumber_data   = $request->sumber_data;
                $model->keterangan   = $request->keterangan;
                $model->save();

                return $this->fecth_ikus($request->organisasi_no_emit, $request->tahun_emit);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = Iku::findOrFail($request->id);
        $model->delete();

        return $this->fecth_ikus($request->organisasi_no_emit, $request->tahun);
    }
}
