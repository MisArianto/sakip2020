<?php

namespace App\Http\Controller\API;

use DB;
use App\Models\TujuanRenstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiTujuanRenstra extends Controller
{
    

    public static function test()
    {

        date_default_timezone_set('Asia/Jakarta');
            
        $url = '192.168.15.125/e-planning/api/tujuan_renstra/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        $res_api = $output;

        return $res_api;

        
        $tr = TujuanRenstra::get();

        // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
        if(count($tr) == 0)
        {
            foreach($res_api as $data)
            {

                $tujuan = new TujuanRenstra;
                $tujuan->id = $data->id;
                $tujuan->misi_id = $data->misi_id;
                $tujuan->tujuan_id_rpjmd = $data->tujuan_id_rpjmd;
                $tujuan->tujuan_nama = $data->tujuan_nama;
                $tujuan->organisasi_no = $data->organisasi_no;
                $tujuan->created_by = $data->created_by;
                $tujuan->updated_by = $data->updated_by;
                $tujuan->save();
            }

            // respone jika data tujuan renstra berhasil di tambahkan
            return Response()->json([
                'status' => 200,
                'message' => 'Data tujuan renstra Berhasil di Tambahkan'
            ]);

        
        } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
        elseif(count($res_api) > count($tr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
        {
            // def array
            $cekapi = [];
            $cekapi2 = [];
            $no = 0;

            // get id yang sudah ada pada table
            foreach($tr as $data)
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

                    $tujuan = new TujuanRenstra;
                    $tujuan->id = $value->id;
                    $tujuan->misi_id = $value->misi_id;
                    $tujuan->tujuan_id_rpjmd = $value->tujuan_id_rpjmd;
                    $tujuan->tujuan_nama = $value->tujuan_nama;
                    $tujuan->organisasi_no = $value->organisasi_no;
                    $tujuan->created_by = $value->created_by;
                    $tujuan->updated_by = $value->updated_by;
                    $tujuan->save();
                
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

            if(count($res_api) < count($tr))
            {

                foreach($tr as $datatr)
                {
                    // cek id yang terkait
                    $cekdelete = collect($res_api)->where('id', $datatr->id)->first(); 

                    if(!$cekdelete)
                    {
                        // tampung yang berubah
                        $deleted[] = $datatr;
                    }

                }


                if(count($deleted) > 0)
                {
                    foreach($deleted as $hapus)
                    {
                        $destroy = TujuanRenstra::where('id', $hapus->id)->first(); 
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
                $model = TujuanRenstra::where('id', $cekupdate->id)->first(); 

                // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                if($model->misi_id != $cekupdate->misi_id || $model->tujuan_id_rpjmd != $cekupdate->tujuan_id_rpjmd || $model->tujuan_nama != $cekupdate->tujuan_nama || $model->organisasi_no  != $cekupdate->organisasi_no || $model->created_by  != $cekupdate->created_by || $model->updated_by  != $cekupdate->updated_by) 
                {
                    // tampung yang berubah
                    $updated[] = $cekupdate;

                    // lakukan save atau update
                    $update = TujuanRenstra::where('id', $cekupdate->id)->first();
                    $update->id = $cekupdate->id;
                    $update->misi_id = $cekupdate->misi_id;
                    $update->tujuan_id_rpjmd = $cekupdate->tujuan_id_rpjmd;
                    $update->tujuan_nama = $cekupdate->tujuan_nama;
                    $update->organisasi_no = $cekupdate->organisasi_no;
                    $update->created_by = $cekupdate->created_by;
                    $update->updated_by = $cekupdate->updated_by;
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

            }
            elseif(count($updated) < 1) // respone jika tidak ada perubahan data return message
            {
            
                return Response()->json([
                    'status' => 200,
                    'message' => 'Tidak Ada Perubahan atau Penambahan data'
                ]);

            }
            else
            { 
            // response jika ada data api yang di rubah
                
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
