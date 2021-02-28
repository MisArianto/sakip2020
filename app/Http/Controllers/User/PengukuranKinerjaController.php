<?php

namespace App\Http\Controllers\User;

use DB;
use Auth;
use App\Models\Satuan;
use App\Models\Jabatan;
use App\Models\Kegiatan;
use App\Models\Capaian;
use App\Models\CapaianSasaranOpd;
use App\Models\TW1;
use App\Models\TW2;
use App\Models\TW3;
use App\Models\TW4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengukuranKinerjaController extends Controller
{
    public function index()
    {

    	// $url = 'http://192.168.15.125/e-planning/api/indikator_sasaran_renstra/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK';

     //    $ch = curl_init(); 
     //    curl_setopt($ch, CURLOPT_URL, $url);
     //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
     //    $output = curl_exec($ch); 
     //    curl_close($ch);      
     //    $res_api = $output;

     //   $decode = json_decode($res_api);

     //   foreach ($decode->data as $value) {

     //   	$capaian = CapaianSasaranOpd::create([
     //   		'indikator_sasaran_id' => $value->id,
     //   		'tahun' => '2019',
     //   		'organisasi_no' => $value->organisasi_no,
     //   	]);

     //   	TW1::create([
     //   		'capaian_sasaran_id' => $capaian->id,
     //   		'target' => 0,
     //   		'kinerja' => 0,
     //   		'anggaran' => 0,
     //   		'rekomendasi' => 0
     //   	]);

     //   	TW2::create([
     //   		'capaian_sasaran_id' => $capaian->id,
     //   		'target' => 0,
     //   		'kinerja' => 0,
     //   		'anggaran' => 0,
     //   		'rekomendasi' => 0
     //   	]);

     //   	TW3::create([
     //   		'capaian_sasaran_id' => $capaian->id,
     //   		'target' => 0,
     //   		'kinerja' => 0,
     //   		'anggaran' => 0,
     //   		'rekomendasi' => 0
     //   	]);

     //   	TW4::create([
     //   		'capaian_sasaran_id' => $capaian->id,
     //   		'target' => 0,
     //   		'kinerja' => 0,
     //   		'anggaran' => 0,
     //   		'rekomendasi' => 0
     //   	]);

     //   }

        return view('app.user.pengukuran-kinerja.index');
    }

    public function fetch(Request $request)
    {
        return $this->fetch_emit($request->organisasi_no, $request->tahun);
    }


    public function fetch_emit($organisasi_no, $tahun)
    {

    	$capaians = DB::table('capaian_sasaran_opd as cso')
    				->leftJoin('triwulan1 as tw1', 'tw1.capaian_sasaran_id', 'cso.id')
    				->leftJoin('triwulan2 as tw2', 'tw2.capaian_sasaran_id', 'cso.id')
    				->leftJoin('triwulan3 as tw3', 'tw3.capaian_sasaran_id', 'cso.id')
    				->leftJoin('triwulan4 as tw4', 'tw4.capaian_sasaran_id', 'cso.id')
    				->leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'cso.indikator_sasaran_id')
    				->leftJoin('organisasi as o', 'o.organisasi_no', 'cso.organisasi_no')
    				->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
    				->select(
    					'cso.id',
    					'cso.indikator_sasaran_id',
    					'cso.tahun',
    					'cso.organisasi_no',
    					'tw1.id as id_tw1',
    					'tw1.target as target1',
    					'tw1.kinerja as kinerja1',
    					'tw1.anggaran as anggaran1',
    					'tw1.rekomendasi as rekomendasi1',
    					'tw2.id as id_tw2',
    					'tw2.target as target2',
    					'tw2.kinerja as kinerja2',
    					'tw2.anggaran as anggaran2',
    					'tw2.rekomendasi as rekomendasi2',
    					'tw3.id as id_tw3',
    					'tw3.target as target3',
    					'tw3.kinerja as kinerja3',
    					'tw3.anggaran as anggaran3',
    					'tw3.rekomendasi as rekomendasi3',
    					'tw4.id as id_tw4',
    					'tw4.target as target4',
    					'tw4.kinerja as kinerja4',
    					'tw4.anggaran as anggaran4',
    					'tw4.rekomendasi as rekomendasi4',
    					'isr.indikator_sasaran',
    					'isr.satuan_id',
    					'o.organisasi_nama',
    					's.satuan_nama'
    				)
    				->where('cso.tahun', $tahun)
    				->where('cso.organisasi_no', $organisasi_no)
    				->groupBy('cso.indikator_sasaran_id')
    				->get();

    				// return $capaians;

       // $capaians = DB::table('capaian_sasaran_opd as cso')->join('indikator_sasaran_renstra as isr', 'isr.id', 'cso.indikator_sasaran_id')
       //                ->leftJoin('prokeg_renstra as renstra', 'renstra.indikator_sasaran_id', '=', 'isr.id')
       //          ->leftJoin('program as p', 'p.program_no', '=', 'renstra.program_no')
       //          ->leftJoin('organisasi as org','org.organisasi_no','=','isr.organisasi_no')
       //          ->join('iku', 'iku.indikator_sasaran_id', 'isr.id')
       //          ->join('satuan', 'satuan.id', '=', 'isr.satuan_id')
       //          ->select(
       //              'isr.indikator_sasaran',
       //              'iku.formulasi',
       //              'satuan.satuan_nama',
       //              'renstra.target_t1 as target_t',
       //              'renstra.pagu_t1 as pagu_t', 
       //              'tw_1',
       //              'a_1',
       //              'rkmn_1',
       //              'real_1',
       //              'tw_2',
       //              'a_2',
       //              'rkmn_2',
       //              'real_2',
       //              'tw_3', 
       //              'a_3',
       //              'rkmn_3',
       //              'real_3',
       //              'tw_4', 
       //              'a_4',
       //              'rkmn_4',
       //              'real_4',
       //              'renstra.target_t1 as target_tw1',
       //              'renstra.target_t2 as target_tw2',
       //              'renstra.target_t3 as target_tw3',
       //              'renstra.target_t4 as target_tw4',
       //              'renstra.target_t5 as target_tw5',
       //              'cso.id',
       //              'cso.indikator_sasaran_id',
       //              'cso.pagu',
       //              'cso.target1',
       //              'cso.target2',
       //              'cso.target3',
       //              'cso.target4',
       //              'cso.kinerja_1',
       //              'cso.kinerja_2',
       //              'cso.kinerja_3',
       //              'cso.kinerja_4',
       //              'p.program_nama', 
       //              'p.program_no'

       //           )
       //          ->where('cso.tahun', $tahun)
       //          ->groupBy('cso.indikator_sasaran_id')
       //          ->groupBy('iku.formulasi')
       //          ->groupBy('p.program_nama')
       //          ->where('isr.organisasi_no', $organisasi_no)
       //          ->where('iku.tahun', $tahun)
       //          ->get();


        $no = 1;
        $output = '';


        foreach (collect($capaians)->unique('indikator_sasaran_id') as $value) {
        	
        $output .= '<tr>
	        <td rowspan="5" align="center">
	            <div class="btn-group btn-group-sm">
	                <button class="btn btn-warning" title="detail indikator" id="handleDetailCapaianAll" data-id="'.$value->id.'" data-indikator_sasaran_id="'.$value->indikator_sasaran_id.'">
	                    <i class="fa fa-eye"></i>
	                </button>
	            </div>
	        </td>
	        <td colspan="7">'.$value->indikator_sasaran.'</td>
	    </tr>
	    <tr>
	        <td rowspan="4"></td>
	        <td class="text-center">TW I</td>
	        <td>'.$value->target1.'</td>
	        <td>'.$value->kinerja1.'</td>
	        <td>'.$value->anggaran1.'</td>
	        <td>'.$value->rekomendasi1.'</td>
	        <td align="center">
	            <div class="btn-group btn-group-sm">
	                <button class="btn btn-warning" title="detail pertriwulan I" id="handleDetailCapaian" data-id="'.$value->id.'" data-indikator_sasaran="'.$value->indikator_sasaran.'" data-target="'.$value->target1.'" data-kinerja="'.$value->kinerja1.'" data-anggaran="'.$value->anggaran1.'" data-rekomendasi="'.$value->rekomendasi1.'" data-name="tw1" data-name_detail="Triwulan I">
	                    <i class="fa fa-eye"></i>
	                </button>
	                <button class="btn btn-info" title="edit pertriwulan I" id="handleEditCapaian" data-id="'.$value->id.'" data-id_tw="'.$value->id_tw1.'" data-target="'.$value->target1.'" data-kinerja="'.$value->kinerja1.'" data-anggaran="'.$value->anggaran1.'" data-rekomendasi="'.$value->rekomendasi1.'" data-name="tw1" data-name_detail="Triwulan I">
	                    <i class="fa fa-edit"></i>
	                </button>
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td class="text-center">TW II</td>
	        <td>'.$value->target2.'</td>
	        <td>'.$value->kinerja2.'</td>
	        <td>'.$value->anggaran2.'</td>
	        <td>'.$value->rekomendasi2.'</td>
	        <td align="center">
	            <div class="btn-group btn-group-sm">
	                <button class="btn btn-warning" title="detail pertriwulan II" id="handleDetailCapaian" data-id="'.$value->id.'" data-indikator_sasaran="'.$value->indikator_sasaran.'" data-target="'.$value->target2.'" data-kinerja="'.$value->kinerja2.'" data-anggaran="'.$value->anggaran2.'" data-rekomendasi="'.$value->rekomendasi2.'" data-name="tw2" data-name_detail="Triwulan II">
	                    <i class="fa fa-eye"></i>
	                </button>
	                <button class="btn btn-info" title="edit pertriwulan II" id="handleEditCapaian" data-id="'.$value->id.'" data-id_tw="'.$value->id_tw2.'" data-target="'.$value->target2.'" data-kinerja="'.$value->kinerja2.'" data-anggaran="'.$value->anggaran2.'" data-rekomendasi="'.$value->rekomendasi2.'" data-name="tw2" data-name_detail="Triwulan II">
	                    <i class="fa fa-edit"></i>
	                </button>
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td class="text-center">TW III</td>
	        <td>'.$value->target3.'</td>
	        <td>'.$value->kinerja3.'</td>
	        <td>'.$value->anggaran3.'</td>
	        <td>'.$value->rekomendasi3.'</td>
	        <td align="center">
	            <div class="btn-group btn-group-sm">
	                <button class="btn btn-warning" title="detail pertriwulan III" id="handleDetailCapaian" data-id="'.$value->id.'" data-indikator_sasaran="'.$value->indikator_sasaran.'" data-target="'.$value->target3.'" data-kinerja="'.$value->kinerja3.'" data-anggaran="'.$value->anggaran3.'" data-rekomendasi="'.$value->rekomendasi3.'" data-name="tw3" data-name_detail="Triwulan III">
	                    <i class="fa fa-eye"></i>
	                </button>
	                <button class="btn btn-info" title="edit pertriwulan III" id="handleEditCapaian" data-id="'.$value->id.'" data-id_tw="'.$value->id_tw3.'" data-target="'.$value->target3.'" data-kinerja="'.$value->kinerja3.'" data-anggaran="'.$value->anggaran3.'" data-rekomendasi="'.$value->rekomendasi3.'" data-name="tw3" data-name_detail="Triwulan III">
	                    <i class="fa fa-edit"></i>
	                </button>
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td class="text-center">TW IV</td>
	        <td>'.$value->target4.'</td>
	        <td>'.$value->kinerja4.'</td>
	        <td>'.$value->anggaran4.'</td>
	        <td>'.$value->rekomendasi4.'</td>
	        <td align="center">
	            <div class="btn-group btn-group-sm">
	                <button class="btn btn-warning" title="detail pertriwulan IV" id="handleDetailCapaian" data-id="'.$value->id.'" data-indikator_sasaran="'.$value->indikator_sasaran.'" data-target="'.$value->target4.'" data-kinerja="'.$value->kinerja4.'" data-anggaran="'.$value->anggaran4.'" data-rekomendasi="'.$value->rekomendasi4.'" data-name="tw4" data-name_detail="Triwulan IV">
	                    <i class="fa fa-eye"></i>
	                </button>
	                <button class="btn btn-info" title="edit pertriwulan IV" id="handleEditCapaian" data-id="'.$value->id.'" data-id_tw="'.$value->id_tw4.'" data-target="'.$value->target4.'" data-kinerja="'.$value->kinerja4.'" data-anggaran="'.$value->anggaran4.'" data-rekomendasi="'.$value->rekomendasi4.'" data-name="tw4" data-name_detail="Triwulan IV">
	                    <i class="fa fa-edit"></i>
	                </button>
	            </div>
	        </td>
	    </tr>';
		}

	    return $output;

    }

    public function detail(Request $request)
    {

    	// $capaians = DB::table('capaian_sasaran_opd as cso')->join('indikator_sasaran_renstra as isr', 'isr.id', 'cso.indikator_sasaran_id')
     //                  ->leftJoin('prokeg_renstra as renstra', 'renstra.indikator_sasaran_id', '=', 'isr.id')
     //            ->leftJoin('program as p', 'p.program_no', '=', 'renstra.program_no')
     //            ->leftJoin('organisasi as org','org.organisasi_no','=','isr.organisasi_no')
     //            ->join('iku', 'iku.indikator_sasaran_id', 'isr.id')
     //            ->join('satuan', 'satuan.id', '=', 'isr.satuan_id')
     //            ->select(
     //                'isr.indikator_sasaran',
     //                'iku.formulasi',
     //                'satuan.satuan_nama',
     //                'renstra.target_t1 as target_t' ,
     //                'renstra.pagu_t1 as pagu_t', 
     //                'tw_1',
     //                'a_1',
     //                'rkmn_1',
     //                'real_1',
     //                'tw_2',
     //                'a_2',
     //                'rkmn_2',
     //                'real_2',
     //                'tw_3', 
     //                'a_3',
     //                'rkmn_3',
     //                'real_3',
     //                'tw_4', 
     //                'a_4',
     //                'rkmn_4',
     //                'real_4',
     //                'renstra.target_t1 as target_tw1',
     //                'renstra.target_t2 as target_tw2',
     //                'renstra.target_t3 as target_tw3',
     //                'renstra.target_t4 as target_tw4',
     //                'renstra.target_t5 as target_tw5',
     //                'cso.id',
     //                'cso.indikator_sasaran_id',
     //                'cso.pagu',
     //                'cso.target1',
     //                'cso.target2',
     //                'cso.target3',
     //                'cso.target4',
     //                'cso.kinerja_1',
     //                'cso.kinerja_2',
     //                'cso.kinerja_3',
     //                'cso.kinerja_4',
     //                'p.program_nama', 
     //                'p.program_no'

     //             )
     //            ->where('cso.tahun', $request->tahun)
     //            ->where('cso.indikator_sasaran_id', $request->indikator_sasaran_id)
     //            ->where('isr.organisasi_no', $request->organisasi_no)
     //            ->where('iku.tahun', $request->tahun)
     //            ->groupBy('cso.indikator_sasaran_id')
     //            ->groupBy('iku.formulasi')
     //            ->groupBy('p.program_nama')
     //            ->get();


    	$capaians = DB::table('capaian_sasaran_opd as cso')
    				->leftJoin('triwulan1 as tw1', 'tw1.capaian_sasaran_id', 'cso.id')
    				->leftJoin('triwulan2 as tw2', 'tw2.capaian_sasaran_id', 'cso.id')
    				->leftJoin('triwulan3 as tw3', 'tw3.capaian_sasaran_id', 'cso.id')
    				->leftJoin('triwulan4 as tw4', 'tw4.capaian_sasaran_id', 'cso.id')
    				->leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'cso.indikator_sasaran_id')
    				->leftJoin('organisasi as o', 'o.organisasi_no', 'cso.organisasi_no')
    				->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
    				->select(
    					'cso.id',
    					'cso.indikator_sasaran_id',
    					'cso.tahun',
    					'cso.organisasi_no',
    					'tw1.target as target1',
    					'tw1.kinerja as kinerja1',
    					'tw1.anggaran as anggaran1',
    					'tw1.rekomendasi as rekomendasi1',
    					'tw2.target as target2',
    					'tw2.kinerja as kinerja2',
    					'tw2.anggaran as anggaran2',
    					'tw2.rekomendasi as rekomendasi2',
    					'tw3.target as target3',
    					'tw3.kinerja as kinerja3',
    					'tw3.anggaran as anggaran3',
    					'tw3.rekomendasi as rekomendasi3',
    					'tw4.target as target4',
    					'tw4.kinerja as kinerja4',
    					'tw4.anggaran as anggaran4',
    					'tw4.rekomendasi as rekomendasi4',
    					'isr.indikator_sasaran',
    					'isr.satuan_id',
    					'o.organisasi_nama',
    					's.satuan_nama'
    				)
    				->where('cso.tahun', $request->tahun)
    				->where('cso.organisasi_no', $request->organisasi_no)
    				->where('cso.indikator_sasaran_id', $request->indikator_sasaran_id)
    				->groupBy('cso.indikator_sasaran_id')
    				->get();

                $output = '';



                foreach (collect($capaians)->unique('indikator_sasaran_id') as $value) {
        	
		        $output .= '<tr>
			        <td colspan="7">'.$value->indikator_sasaran.'</td>
			    </tr>
			    <tr>
			        <td rowspan="4"></td>
			        <td class="text-center">TW I</td>
			        <td>'.$value->target1.'</td>
			        <td>'.$value->kinerja1.'</td>
			        <td>'.$value->anggaran1.'</td>
			        <td>'.$value->rekomendasi1.'</td>
			    </tr>
			    <tr>
			        <td class="text-center">TW II</td>
			        <td>'.$value->target2.'</td>
			        <td>'.$value->kinerja2.'</td>
			        <td>'.$value->anggaran2.'</td>
			        <td>'.$value->rekomendasi2.'</td>
			    </tr>
			    <tr>
			        <td class="text-center">TW III</td>
			        <td>'.$value->target3.'</td>
			        <td>'.$value->kinerja3.'</td>
			        <td>'.$value->anggaran3.'</td>
			        <td>'.$value->rekomendasi3.'</td>
			    </tr>
			    <tr>
			        <td class="text-center">TW IV</td>
			        <td>'.$value->target4.'</td>
			        <td>'.$value->kinerja4.'</td>
			        <td>'.$value->anggaran4.'</td>
			        <td>'.$value->rekomendasi4.'</td>
			    </tr>';
				}

                return response()->json([
                	'detail' => $output 
                ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'target' => 'required',
            'kinerja' => 'required',
            'anggaran' => 'required',
            'rekomendasi' => 'required'
        ]);


        if($request->name == 'tw1')
        {
        	$tw1 = TW1::findOrFail($id);
        	$tw1->update([
        		'target' => $request->target,
        		'kinerja' => $request->kinerja,
        		'anggaran' => $request->anggaran,
        		'rekomendasi' => $request->rekomendasi
        	]);
        }else if($request->name == 'tw2')
        {
        	$tw2 = TW2::findOrFail($id);
        	$tw2->update([
        		'target' => $request->target,
        		'kinerja' => $request->kinerja,
        		'anggaran' => $request->anggaran,
        		'rekomendasi' => $request->rekomendasi
        	]);
        }else if($request->name == 'tw3')
        {
        	$tw3 = TW3::findOrFail($id);
        	$tw3->update([
        		'target' => $request->target,
        		'kinerja' => $request->kinerja,
        		'anggaran' => $request->anggaran,
        		'rekomendasi' => $request->rekomendasi
        	]);
        }else if($request->name == 'tw4')
        {
        	$tw4 = TW4::findOrFail($id);
        	$tw4->update([
        		'target' => $request->target,
        		'kinerja' => $request->kinerja,
        		'anggaran' => $request->anggaran,
        		'rekomendasi' => $request->rekomendasi
        	]);
        }

        return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun_emit);

    }

    public function cetak(Request $request)
    {

      $tahun = $request->tahun;

      $csos = DB::table('capaian_sasaran_opd as cso')
            ->leftJoin('triwulan1 as tw1', 'tw1.capaian_sasaran_id', 'cso.id')
            ->leftJoin('triwulan2 as tw2', 'tw2.capaian_sasaran_id', 'cso.id')
            ->leftJoin('triwulan3 as tw3', 'tw3.capaian_sasaran_id', 'cso.id')
            ->leftJoin('triwulan4 as tw4', 'tw4.capaian_sasaran_id', 'cso.id')
            ->leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'cso.indikator_sasaran_id')
            ->leftJoin('organisasi as o', 'o.organisasi_no', 'cso.organisasi_no')
            ->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
            ->select(
              'cso.id',
              'cso.indikator_sasaran_id',
              'cso.tahun',
              'cso.organisasi_no',
              'tw1.id as id_tw1',
              'tw1.target as target1',
              'tw1.kinerja as kinerja1',
              'tw1.anggaran as anggaran1',
              'tw1.rekomendasi as rekomendasi1',
              'tw2.id as id_tw2',
              'tw2.target as target2',
              'tw2.kinerja as kinerja2',
              'tw2.anggaran as anggaran2',
              'tw2.rekomendasi as rekomendasi2',
              'tw3.id as id_tw3',
              'tw3.target as target3',
              'tw3.kinerja as kinerja3',
              'tw3.anggaran as anggaran3',
              'tw3.rekomendasi as rekomendasi3',
              'tw4.id as id_tw4',
              'tw4.target as target4',
              'tw4.kinerja as kinerja4',
              'tw4.anggaran as anggaran4',
              'tw4.rekomendasi as rekomendasi4',
              'isr.indikator_sasaran as indikator_sasaran_nama',
              'isr.satuan_id',
              'o.organisasi_nama',
              's.satuan_nama'
            )
            ->where('cso.tahun', $request->tahun)
            ->where('cso.organisasi_no', Auth::user()->organisasi_no)
            ->groupBy('cso.indikator_sasaran_id')
            ->get();

    //         return $capaians;


    // 	$csos = \DB::table('capaian_sasaran_opd as cso')
    // 			->leftJoin('indikator_sasaran_renstra as isr', 'isr.id', 'cso.indikator_sasaran_id')
				// ->leftJoin('organisasi as o', 'o.organisasi_no', 'cso.organisasi_no')
				// ->leftJoin('satuan as s', 's.id', 'isr.satuan_id')
				// ->leftJoin('triwulan1 as tw1', 'tw1.capaian_sasaran_id', 'cso.id')
				// ->leftJoin('triwulan2 as tw2', 'tw2.capaian_sasaran_id', 'cso.id')
				// ->leftJoin('triwulan3 as tw3', 'tw3.capaian_sasaran_id', 'cso.id')
				// ->leftJoin('triwulan4 as tw4', 'tw4.capaian_sasaran_id', 'cso.id')
				// ->select(
				// 	'isr.indikator_sasaran as indikator_sasaran_nama',
				// 	's.satuan_nama',
				// 	'cso.tahun',
				// 	'tw1.target as target1',
				// 	'tw1.kinerja as kinerja1',
				// 	'tw1.anggaran as anggaran1',
				// 	'tw1.rekomendasi as rekomendasi1',
				// 	'tw2.target as target2',
				// 	'tw2.kinerja as kinerja2',
				// 	'tw2.anggaran as anggaran2',
				// 	'tw2.rekomendasi as rekomendasi2',
				// 	'tw3.target as target3',
				// 	'tw3.kinerja as kinerja3',
				// 	'tw3.anggaran as anggaran3',
				// 	'tw3.rekomendasi as rekomendasi3',
				// 	'tw4.target as target3',
				// 	'tw4.kinerja as kinerja3',
				// 	'tw4.anggaran as anggaran3',
				// 	'tw4.rekomendasi as rekomendasi3',
				// 	'o.organisasi_no',
				// 	'o.organisasi_nama'
				// )
				// ->where('o.organisasi_no', Auth::user()->organisasi_no)
				// ->groupBy('cso.indikator_sasaran_id')
				// ->get();



				return view('app.user.pengukuran-kinerja.cetak_pdf', compact('csos', 'tahun'))->with('no', 1);

    	// $pdf = PDF::loadView('app.user.cetak.cetak_pk_pdf', $model);
     //    return $pdf->download('Perjanjian Kinerja '.get_name_opd(Auth::user()->organisasi_no).'.pdf');
    }

}
