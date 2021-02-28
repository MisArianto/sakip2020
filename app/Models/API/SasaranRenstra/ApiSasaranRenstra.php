<?php

namespace App\Models\API\SasaranRenstra;

use DB;
use Auth;
use App\Models\SasaranRenstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiSasaranRenstra extends Controller
{
    

    public static function api()
    {

        date_default_timezone_set('Asia/Jakarta');
            
        $url = '192.168.15.125/e-planning/api/sasaran_renstra/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        $decode = json_decode($output);

        $res_api = collect($decode->data)->where('organisasi_no', Auth::user()->organisasi_no);

        $sr = SasaranRenstra::where('organisasi_no', Auth::user()->organisasi_no)->get();

        // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
        if(count($sr) == 0)
        {
            $model = [];

            foreach($res_api as $data)
            {

                $model[] = SasaranRenstra::create([
                    "id" => $data->id,
                    "tujuan_id" => $data->tujuan_id,
                    "sasaran_id_rpjmd" => $data->sasaran_id_rpjmd,
                    "sasaran_nomor" => $data->sasaran_nomor,
                    "sasaran_nama" => $data->sasaran_nama,
                    "organisasi_no" => $data->organisasi_no
                ]);
            }

            // respone jika data sasaran renstra berhasil di tambahkan
            return Response()->json([
                'status' => 200,
                'data' => $model,
                'message' => 'Data sasaran renstra Berhasil di Tambahkan'
            ]);

        
        } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
        elseif(count($res_api) > count($sr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
        {
            // def array
            $cekapi = [];
            $cekapi2 = [];
            $no = 0;

            // get id yang sudah ada pada table
            foreach($sr as $data)
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

                    $model = new SasaranRenstra;
                    $model->id = $value->id;
                    $model->tujuan_id = $value->tujuan_id;
                    $model->sasaran_id_rpjmd = $value->sasaran_id_rpjmd;
                    $model->sasaran_nomor = $value->sasaran_nomor;
                    $model->sasaran_nama = $value->sasaran_nama;
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

            if(count($res_api) < count($sr))
            {

                foreach($sr as $datasr)
                {
                    // cek id yang terkait
                    $cekdelete = collect($res_api)->where('id', $datasr->id)->first(); 

                    if(!$cekdelete)
                    {
                        // tampung yang berubah
                        $deleted[] = $datasr;
                    }

                }


                if(count($deleted) > 0)
                {
                    foreach($deleted as $hapus)
                    {
                        $destroy = SasaranRenstra::where('id', $hapus->id)->first(); 
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
                $model = SasaranRenstra::where('id', $cekupdate->id)->first(); 

                // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                if($model->tujuan_id != $cekupdate->tujuan_id || $model->sasaran_id_rpjmd != $cekupdate->sasaran_id_rpjmd || $model->sasaran_nama != $cekupdate->sasaran_nama || $model->organisasi_no  != $cekupdate->organisasi_no) 
                {
                    // tampung yang berubah
                    $updated[] = $cekupdate;

                    // lakukan save atau update
                    $update = SasaranRenstra::where('id', $cekupdate->id)->first();
                    $update->id = $cekupdate->id;
                    $update->tujuan_id = $cekupdate->tujuan_id;
                    $update->sasaran_id_rpjmd = $cekupdate->sasaran_id_rpjmd;
                    $update->sasaran_nomor = $cekupdate->sasaran_nomor;
                    $update->sasaran_nama = $cekupdate->sasaran_nama;
                    $update->organisasi_no = $cekupdate->organisasi_no;
                    $update->save();


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
