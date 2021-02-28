<?php

namespace App\Models\API\ProkegRenstra;

use DB;
use Auth;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiKegiatanRenstra extends Controller
{
    

    public static function api()
    {

        date_default_timezone_set('Asia/Jakarta');
            
        $url = '192.168.15.125/e-planning/api/kegiatan/eplanning/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        $decode = json_decode($output);

        // $res_api = collect($decode->data)->where('organisasi_no', Auth::user()->organisasi_no);

        // $keg = Kegiatan::where('organisasi_no', Auth::user()->organisasi_no)->get();

        $res_api = $decode->data;

        $keg = Kegiatan::get();
                
        // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
        if(count($keg) == 0)
        {

            $model = [];

            foreach($res_api as $data)
            {

                $model[] = Kegiatan::create([
                    "id" => $data->id,
                    "kegiatan_no" => $data->kegiatan_no,
                    "kegiatan_nama" => $data->kegiatan_nama,
                    "program_no" => $data->program_no
                ]);
            }

            // respone jika data kegiatan berhasil di tambahkan
            return Response()->json([
                'status' => 200,
                'data' => $model,
                'message' => 'Data Kegiatan Berhasil di Tambahkan'
            ]);

        
        } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
        elseif(count($res_api) > count($keg)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
        {
            // def array
            $cekapi = [];
            $cekapi2 = [];
            $no = 0;

            // get id yang sudah ada pada table
            foreach($keg as $data)
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

                    $model = new Kegiatan;
                    $model->id = $value->id;
                    $model->kegiatan_no = $value->kegiatan_no;
                    $model->kegiatan_nama = $value->kegiatan_nama;
                    $model->program_no = $value->program_no;
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

            if(count($res_api) < count($keg))
            {

                foreach($keg as $datakeg)
                {
                    // cek id yang terkait
                    $cekdelete = collect($res_api)->where('id', $datakeg->id)->first(); 

                    if(!$cekdelete)
                    {
                        // tampung yang berubah
                        $deleted[] = $datakeg;
                    }

                }


                if(count($deleted) > 0)
                {
                    foreach($deleted as $hapus)
                    {
                        $destroy = Kegiatan::where('id', $hapus->id)->first(); 
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
                $model = Kegiatan::where('id', $cekupdate->id)->first(); 

                // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                if($model->kegiatan_no != $cekupdate->kegiatan_no || $model->kegiatan_nama != $cekupdate->kegiatan_nama || $model->program_no != $cekupdate->program_no)
                {
                    // tampung yang berubah
                    $updated[] = $cekupdate;

                    // lakukan save atau update
                    $update = Kegiatan::where('id', $cekupdate->id)->first();
                    $update->id = $cekupdate->id;
                    $update->kegiatan_no = $cekupdate->kegiatan_no;
                    $update->kegiatan_nama = $cekupdate->kegiatan_nama;
                    $update->program_no = $cekupdate->program_no;
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
