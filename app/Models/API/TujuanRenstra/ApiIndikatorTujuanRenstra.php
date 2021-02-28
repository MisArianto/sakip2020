<?php

namespace App\Models\API\TujuanRenstra;

use DB;
use Auth;
use App\Models\RencanaStrategisIndikatorTujuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiIndikatorTujuanRenstra extends Controller
{
    

    public static function api()
    {

        date_default_timezone_set('Asia/Jakarta');
            
        $url = '192.168.15.125/e-planning/api/indikator_tujuan_renstra/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        $decode = json_decode($output);


        $res_api = collect($decode->data)->where('organisasi_no', Auth::user()->organisasi_no);
        
        
        $itr = RencanaStrategisIndikatorTujuan::where('organisasi_no', Auth::user()->organisasi_no)->get();
            
            // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
        if(count($itr) == 0)
        {
            $model = [];

            foreach($res_api as $data)
            {

                $model[] = RencanaStrategisIndikatorTujuan::create([
                    "id" => $data->id,
                    "tujuan_id" => $data->tujuan_id,
                    "indikator_tujuan_rpjmd_id" => $data->indikator_tujuan_rpjmd_id,
                    "indikator_tujuan" => $data->indikator_tujuan_nama,
                    "satuan_id" => $data->satuan_id,
                    "kondisi_akhir" => $data->kondisi_akhir,
                    "kondisi_awal" => $data->kondisi_awal,
                    "organisasi_no" => $data->organisasi_no
                ]);
            }

            // respone jika data indikator tujuan renstra renstra berhasil di tambahkan
            return Response()->json([
                'status' => 200,
                'data' => $model,
                'message' => 'Data indikator tujuan renstra renstra Berhasil di Tambahkan'
            ]);

        
        } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
        elseif(count($res_api) > count($itr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
        {
            // def array
            $cekapi = [];
            $cekapi2 = [];
            $no = 0;

            // get id yang sudah ada pada table
            foreach($iku as $data)
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

                // memecah array multidimensi untuk mengambil value 
                foreach($insert as $key => $value)
                {

                    $model = new RencanaStrategisIndikatorTujuan;
                    $model->id = $value->id;
                    $model->tujuan_id = $value->tujuan_id;
                    $model->indikator_tujuan_rpjmd_id = $value->indikator_tujuan_rpjmd_id;
                    $model->indikator_tujuan = $value->indikator_tujuan_nama;
                    $model->satuan_id = $value->satuan_id;
                    $model->kondisi_akhir = $value->kondisi_akhir;
                    $model->kondisi_awal = $value->kondisi_awal;
                    $model->organisasi_no = $value->organisasi_no;
                    $model->save();
                
                }
                
                
            }

            // respone
            return Response()->json([
                'status' => 200,
                'message' => 'Data baru berhasil di tambahkan'
            ]);

        } // ---------------------------------- end kondisi if jika jumlah data api ada penambahan ---------------------------
        else
        { // ---------------------------------- kondisi jika tidak ada penambahan di cek update dan cek jika tidak ada penghapusan data di api ----------------------------

            //  ********************* jika data api ada yang di hapus ************************ 
            $deleted = [];

            if(count($res_api) < count($itr))
            {

                foreach($itr as $dataitr)
                {
                    // cek id yang terkait
                    $cekdelete = collect($res_api)->where('id', $dataitr->id)->first(); 

                    if(!$cekdelete)
                    {
                        // tampung yang berubah
                        $deleted[] = $dataitr;
                    }

                }


                if(count($deleted) > 0)
                {
                    foreach($deleted as $hapus)
                    {
                        $destroy = RencanaStrategisIndikatorTujuan::where('id', $hapus->id)->first(); 
                        $destroy->delete();
                    }
                }
            
            }

            // ************************************ end jika ada data api yang di hapus *************************


            // ************************************ cek updated data api ***************************
            $updated = [];

            foreach($res_api as $cekupdate)
            {
                // cek id yang terkait
                $model = RencanaStrategisIndikatorTujuan::where('id', $cekupdate->id)->first(); 

                // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                if($model->tujuan_id != $cekupdate->tujuan_id || $model->indikator_tujuan_rpjmd_id != $cekupdate->indikator_tujuan_rpjmd_id || $model->indikator_tujuan != $cekupdate->indikator_tujuan || $model->satuan_id  != $cekupdate->satuan_id || $model->kondisi_akhir  != $cekupdate->kondisi_akhir || $model->kondisi_awal  != $cekupdate->organisasi_no || $model->organisasi_no  != $cekupdate->kondisi_awal) 
                {
                    // tampung yang berubah
                    $updated[] = $cekupdate;

                    // lakukan save atau update
                    $update = RencanaStrategisIndikatorTujuan::where('id', $cekupdate->id)->first();
                    $model->id = $cekupdate->id;
                    $model->tujuan_id = $cekupdate->tujuan_id;
                    $model->indikator_tujuan_rpjmd_id = $cekupdate->indikator_tujuan_rpjmd_id;
                    $model->indikator_tujuan = $cekupdate->indikator_tujuan_nama;
                    $model->satuan_id = $cekupdate->satuan_id;
                    $model->kondisi_akhir = $cekupdate->kondisi_akhir;
                    $model->kondisi_awal = $cekupdate->kondisi_awal;
                    $model->organisasi_no = $cekupdate->organisasi_no;
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
