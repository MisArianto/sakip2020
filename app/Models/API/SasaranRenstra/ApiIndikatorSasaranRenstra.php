<?php

namespace App\Models\API\SasaranRenstra;

use DB;
use Auth;
use App\Models\IndikatorSasaranRenstra;
use App\Models\TW1;
use App\Models\TW2;
use App\Models\TW3;
use App\Models\TW4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiIndikatorSasaranRenstra extends Controller
{
    

    public static function api()
    {

        date_default_timezone_set('Asia/Jakarta');
            
        $url = '192.168.15.125/e-planning/api/indikator_sasaran_renstra/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        $decode = json_decode($output);

        $res_api = collect($decode->data)->where('organisasi_no', Auth::user()->organisasi_no);

        $isr = IndikatorSasaranRenstra::where('organisasi_no', Auth::user()->organisasi_no)->get();
                    
        // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
        if(count($isr) == 0)
        {
            $model = [];

            foreach($res_api as $data)
            {

                $model[] = IndikatorSasaranRenstra::create([
                    "id" => $data->id,
                    "indikator_sasaran_rpjmd_id" => $data->indikator_sasaran_rpjmd_id,
                    "sasaran_id" => $data->sasaran_id,
                    "indikator_sasaran" => $data->indikator_sasaran_nama,
                    "kondisi_awal" => $data->kondisi_awal,
                    "target_akhir" => $data->kondisi_akhir,
                    "organisasi_no" => $data->organisasi_no,
                    "satuan_id" => $data->satuan_id
                ]);


                 $capaian = CapaianSasaranOpd::create([
                     'indikator_sasaran_id' => $model->id,
                     'tahun' => date('Y'),
                     'organisasi_no' => $model->organisasi_no,
                 ]);

                 TW1::create([
                     'capaian_sasaran_id' => $capaian->id,
                     'target' => 0,
                     'kinerja' => 0,
                     'anggaran' => 0,
                     'rekomendasi' => 0
                 ]);

                 TW2::create([
                     'capaian_sasaran_id' => $capaian->id,
                     'target' => 0,
                     'kinerja' => 0,
                     'anggaran' => 0,
                     'rekomendasi' => 0
                 ]);

                 TW3::create([
                     'capaian_sasaran_id' => $capaian->id,
                     'target' => 0,
                     'kinerja' => 0,
                     'anggaran' => 0,
                     'rekomendasi' => 0
                 ]);

                 TW4::create([
                     'capaian_sasaran_id' => $capaian->id,
                     'target' => 0,
                     'kinerja' => 0,
                     'anggaran' => 0,
                     'rekomendasi' => 0
                 ]);


            }

            // respone jika data indikator sasaran renstra berhasil di tambahkan
            return Response()->json([
                'status' => 200,
                'data' => $model,
                'message' => 'Data indikator sasaran renstra Berhasil di Tambahkan'
            ]);

        
        } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
        elseif(count($res_api) > count($isr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
        {
            // def array
            $cekapi = [];
            $cekapi2 = [];
            $no = 0;

            // get id yang sudah ada pada table
            foreach($isr as $data)
            {
                $cekapi[] = $data->id;
            }

            // cek id yang tidak ada
            foreach($res_api as $data)
            {
                if(!in_array($data->id, $cekapi))
                {
                    $cekapi2[] = ['id' => $data->id];
                }
            }

            // insert data yang tidak ada
            foreach($cekapi2 as $getid)
            {
                // mencari id yang tidak ada pada api
                $insert = collect($res_api)->where('id', $getid['id']);

                $model = [];

                // memecah array multidimensi untuk mengambil value 
                foreach($insert as $key => $value)
                {

                    $model[] = IndikatorSasaranRenstra::create([
                        "id" => $value->id,
                        "indikator_sasaran_rpjmd_id" => $value->indikator_sasaran_rpjmd_id,
                        "sasaran_id" => $value->sasaran_id,
                        "indikator_sasaran" => $value->indikator_sasaran_nama,
                        "kondisi_awal" => $value->kondisi_awal,
                        "target_akhir" => $value->kondisi_akhir,
                        "organisasi_no" => $value->organisasi_no,
                        "satuan_id" => $value->satuan_id
                    ]);

                    $capaian = CapaianSasaranOpd::create([
                         'indikator_sasaran_id' => $model->id,
                         'tahun' => date('Y'),
                         'organisasi_no' => $model->organisasi_no,
                     ]);

                     TW1::create([
                         'capaian_sasaran_id' => $capaian->id,
                         'target' => 0,
                         'kinerja' => 0,
                         'anggaran' => 0,
                         'rekomendasi' => 0
                     ]);

                     TW2::create([
                         'capaian_sasaran_id' => $capaian->id,
                         'target' => 0,
                         'kinerja' => 0,
                         'anggaran' => 0,
                         'rekomendasi' => 0
                     ]);

                     TW3::create([
                         'capaian_sasaran_id' => $capaian->id,
                         'target' => 0,
                         'kinerja' => 0,
                         'anggaran' => 0,
                         'rekomendasi' => 0
                     ]);

                     TW4::create([
                         'capaian_sasaran_id' => $capaian->id,
                         'target' => 0,
                         'kinerja' => 0,
                         'anggaran' => 0,
                         'rekomendasi' => 0
                     ]);
                
                }
                
                
            }

            // respone
            return Response()->json([
                'status' => 200,
                'data' => $model,
                'message' => 'Data baru berhasil di tambahkan'
            ]);

        } // ---------------------------------- end kondisi if jika jumlah data api ada penambahan ---------------------------
        else
        { // ---------------------------------- kondisi jika tidak ada penambahan di cek update dan cek jika tidak ada penghapusan data di api ----------------------------

            //  ********************* jika data api ada yang di hapus ************************ 
            $deleted = [];

            if(count($res_api) < count($isr))
            {

                foreach($isr as $dataisr)
                {
                    // cek id yang terkait
                    $cekdelete = collect($res_api)->where('id', $dataisr->id)->first(); 

                    if(!$cekdelete)
                    {
                        // tampung yang berubah
                        $deleted[] = $dataisr;
                    }

                }


                if(count($deleted) > 0)
                {
                    foreach($deleted as $hapus)
                    {
                        $destroy = IndikatorSasaranRenstra::where('id', $hapus->id)->first(); 
                        $destroy->delete();

                        $capaian = CapaianSasaranOpd::where('indikator_sasaran_id', $hapus->id)->first();
                        $tw1 = TW1::where('capaian_sasaran_id', $capaian->id)->first();
                        $tw1->delete();
                        $tw2 = TW2::where('capaian_sasaran_id', $capaian->id)->first();
                        $tw2->delete();
                        $tw3 = TW3::where('capaian_sasaran_id', $capaian->id)->first();
                        $tw3->delete();
                        $tw4 = TW4::where('capaian_sasaran_id', $capaian->id)->first();
                        $tw4->delete();
                        $capaian->delet();
                    }
                }
            
            }

            // ************************************ end jika ada data api yang di hapus *************************


            // ************************************ cek updated data api ***************************
            $updated = [];

            foreach($res_api as $cekupdate)
            {
                // cek id yang terkait
                $model = IndikatorSasaranRenstra::where('id', $cekupdate->id)->first(); 

                // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                if($model->indikator_sasaran_rpjmd_id != $cekupdate->indikator_sasaran_rpjmd_id || $model->sasaran_id != $cekupdate->sasaran_id || $model->indikator_sasaran != $cekupdate->indikator_sasaran_nama || $model->kondisi_awal  != $cekupdate->kondisi_awal || $model->target_akhir  != $cekupdate->kondisi_akhir || $model->organisasi_no  != $cekupdate->organisasi_no || $model->satuan_id  != $cekupdate->satuan_id) 
                {
                    // tampung yang berubah
                    $updated[] = $cekupdate;

                    // lakukan save atau update
                    $update = IndikatorSasaranRenstra::where('id', $cekupdate->id)->first();
                    $model->id = $cekupdate->id;
                    $model->indikator_sasaran_rpjmd_id = $cekupdate->indikator_sasaran_rpjmd_id;
                    $model->sasaran_id = $cekupdate->sasaran_id;
                    $model->indikator_sasaran = $cekupdate->indikator_sasaran_nama;
                    $model->kondisi_awal = $cekupdate->kondisi_awal;
                    $model->target_akhir = $cekupdate->kondisi_akhir;
                    $model->organisasi_no = $cekupdate->organisasi_no;
                    $model->satuan_id = $cekupdate->satuan_id;
                    $model->save();

                }
            }

            //  *********************************** end updated data api *****************************************

            // respone jika ada data api yang di hapus dan ada api yang di rubah
            if(count($updated) > 0 && count($deleted) > 0)
            {
            
                return Response()->json([
                    'updated' => $updated,
                    'deleted' => $deleted,
                    'status' => 200,
                    'message' => count($updated).' data berhasil di update dan ' .count($deleted) .' Data berhasil di hapus'
                ]);

            }elseif(count($updated) < 1) // respone jika tidak ada perubahan data return message
            {
            
                return Response()->json([
                    'status' => 200,
                    'message' => 'Tidak Ada Perubahan atau Penambahan data'
                ]);

            }else{ // response jika ada data api yang di rubah
                
                return Response()->json([
                    'updated' => $updated,
                    'status' => 200,
                    'message' => count($updated).' data berhasil di update'
                ]);
            }

            
        } // ------------------------------------------ end kondisi if jika tidak ada penambahan di cek update -------------------------------
            
    }
}
// end if class
