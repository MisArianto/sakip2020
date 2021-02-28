<?php

namespace App\Http\Controller\API;

use DB;
use Hash;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\TujuanRenstra;
use App\Models\SasaranRenstra;
use App\Models\IkuRenstra;
use App\Models\RencanaStrategisIndikatorTujuan;
// use App\Models\RencanaStrategisIndikatorSasaran;
use App\Models\IndikatorSasaranRenstra;
use App\Models\Renstra;
use App\Models\ProgKegRenstra;
use App\Models\RencanaStrategisIndikatorProgram;
use App\Models\RencanaStrategisIndikatorKegiatan;
use App\Models\TargetIkRenstra;
use App\Models\TargetIpRenstra;
use App\Models\TargetIsRenstra;
use App\Models\CapaianSasaranOpd;
use App\Models\IndikatorProgramRpjmd;
use App\Models\IndikatorSasaranRpjmd;
use App\Models\IndikatorTujuanRpjmd;
use App\Models\TujuanRpjmd;
use App\Models\ProgramRpjmd;
use App\Models\SasaranRpjmd;
use App\Models\IkuRpjmd;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Satuan;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;

class GetApiController extends Controller
{
    

    public static function get_api($param, $token)
    {
        return 'test';

        // return Hash::make('rahasianegara');
        // /rian/$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK

        date_default_timezone_set('Asia/Jakarta');

        // $api_url = $this->api_url($param, $token);
        // dd($api_url);
        // dd(count($res_api));
        try{
            
            if($token == '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK')
            {
                

                $url = '192.168.15.125/e-planning/api/'.$param.'/'.'eplanning'.'/'.$token;

                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                $output = curl_exec($ch); 
                curl_close($ch);      
                $res_api = $output;


            }elseif($token != '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK')
            {
                return Response()->json([
                    'status' => 500,
                    'message' => 'Token Not Register',
                ]);
            }

        
            //  --------------------------------- if kondisi organisasi -------------------------------------
            if($param == 'organisasi')
            {
                $org = Organisasi::get();

                // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($org) == 0)
                {
                    foreach($res_api as $data)
                    {

                        $model = new Organisasi;
                        $model->id = $data->id;
                        $model->daerah_id = $data->daerah_id;
                        $model->grup_organisasi = $data->grup_organisasi;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->organisasi_nama = $data->organisasi_nama;
                        $model->organisasi_jenis = $data->organisasi_jenis;
                        $model->organisasi_induk_id = $data->organisasi_induk_id;
                        $model->level = $data->level;
                        $model->save();
                    }

                    // respone jika data organisasi berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
                        'message' => 'Data Organisasi Berhasil di Tambahkan'
                    ]);

                
                } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                elseif(count($res_api) > count($org)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                {
                    // def array
                    $cekapi = [];
                    $cekapi2 = [];
                    $no = 0;

                    // get id yang sudah ada pada table
                    foreach($org as $data)
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
                            $model = new Organisasi;
                            $model->id = $value->id;
                            $model->daerah_id = $value->daerah_id;
                            $model->grup_organisasi = $value->grup_organisasi;
                            $model->organisasi_no = $value->organisasi_no;
                            $model->organisasi_nama = $value->organisasi_nama;
                            $model->organisasi_jenis = $value->organisasi_jenis;
                            $model->organisasi_induk_id = $value->organisasi_induk_id;
                            $model->level = $value->level;
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

                    if(count($res_api) < count($org))
                    {

                        foreach($org as $dataorg)
                        {
                            // cek id yang terkait
                            $cekdelete = collect($res_api)->where('id', $dataorg->id)->first(); 

                            if(!$cekdelete)
                            {
                                // tampung yang berubah
                                $deleted[] = $dataorg;
                            }

                        }


                        if(count($deleted) > 0)
                        {
                            foreach($deleted as $hapus)
                            {
                                $destroy = Organisasi::where('id', $hapus->id)->first(); 
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
                        $model = Organisasi::where('id', $cekupdate->id)->first(); 

                        // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                        if($model->daerah_id != $cekupdate->daerah_id || $model->grup_organisasi != $cekupdate->grup_organisasi || $model->organisasi_no != $cekupdate->organisasi_no || $model->organisasi_nama != $cekupdate->organisasi_nama || $model->organisasi_jenis != $cekupdate->organisasi_jenis || $model->organisasi_induk_id != $cekupdate->organisasi_induk_id || $model->level != $cekupdate->level)
                        {
                            // tampung yang berubah
                            $updated[] = $cekupdate;

                            // lakukan save atau update
                            $update = Organisasi::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->daerah_id = $cekupdate->daerah_id;
                            $update->grup_organisasi = $cekupdate->grup_organisasi;
                            $update->organisasi_no = $cekupdate->organisasi_no;
                            $update->organisasi_nama = $cekupdate->organisasi_nama;
                            $update->organisasi_jenis = $cekupdate->organisasi_jenis;
                            $update->organisasi_induk_id = $cekupdate->organisasi_induk_id;
                            $update->level = $cekupdate->level;
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

            } // ------------------------------------------ end if kondisi organisasi ----------------------
            elseif($param == 'satuan') // --------------------------- if satuan ----------------------
            {
                $satuan = Satuan::get();

                // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($satuan) == 0)
                {
                    foreach($res_api as $data)
                    {

                        $model = new Satuan;
                        $model->id = $data->id;
                        $model->satuan_id = $data->satuan_id;
                        $model->satuan_nama = $data->satuan_nama;
                        $model->save();
                    }

                    // respone jika data organisasi berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
                        'message' => 'Data Satuan Berhasil di Tambahkan'
                    ]);

                
                } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                elseif(count($res_api) > count($satuan)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                {
                    // def array
                    $cekapi = [];
                    $cekapi2 = [];
                    $no = 0;

                    // get id yang sudah ada pada table
                    foreach($satuan as $data)
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

                            $model = new Satuan;
                            $model->id = $value->id;
                            $model->satuan_id = $value->satuan_id;
                            $model->satuan_nama = $value->satuan_nama;
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

                    if(count($res_api) < count($satuan))
                    {

                        foreach($satuan as $datasatuan)
                        {
                            // cek id yang terkait
                            $cekdelete = collect($res_api)->where('id', $datasatuan->id)->first(); 

                            if(!$cekdelete)
                            {
                                // tampung yang berubah
                                $deleted[] = $datasatuan;
                            }

                        }


                        if(count($deleted) > 0)
                        {
                            foreach($deleted as $hapus)
                            {
                                $destroy = Satuan::where('id', $hapus->id)->first(); 
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
                        $model = Satuan::where('id', $cekupdate->id)->first(); 

                        // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                        if($model->satuan_id != $cekupdate->satuan_id || $model->satuan_nama != $cekupdate->satuan_nama)
                        {
                            // tampung yang berubah
                            $updated[] = $cekupdate;

                            // lakukan save atau update
                            $update = Satuan::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->satuan_id = $cekupdate->satuan_id;
                            $update->satuan_nama = $cekupdate->satuan_nama;
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


            } // ------------------------------------------ end if satuan ---------------------------------
            elseif($param == 'program') // --------------------------------------if program ------------------------------------------
            {
                $prog = Program::get();

                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                    if(count($prog) == 0)
                    {
                        foreach($res_api as $data)
                        {
    
                            $model = new Program;
                            $model->id = $data->id;
                            $model->organisasi_no = $data->organisasi_no;
                            $model->program_no = $data->program_no;
                            $model->program_nama = $data->program_nama;
                            $model->save();
                        }
    
                        // respone jika data organisasi berhasil di tambahkan
                        return Response()->json([
                            'status' => 200,
                            'message' => 'Data Program Berhasil di Tambahkan'
                        ]);
    
                    
                    } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                    elseif(count($res_api) > count($prog)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                    {
                        // def array
                        $cekapi = [];
                        $cekapi2 = [];
                        $no = 0;
    
                        // get id yang sudah ada pada table
                        foreach($prog as $data)
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
    
                                $model = new Program;
                                $model->id = $value->id;
                                $model->organisasi_no = $value->organisasi_no;
                                $model->program_no = $value->program_no;
                                $model->program_nama = $value->program_nama;
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
    
                        if(count($res_api) < count($prog))
                        {
    
                            foreach($prog as $dataprog)
                            {
                                // cek id yang terkait
                                $cekdelete = collect($res_api)->where('id', $dataprog->id)->first(); 
    
                                if(!$cekdelete)
                                {
                                    // tampung yang berubah
                                    $deleted[] = $dataprog;
                                }
    
                            }
    
    
                            if(count($deleted) > 0)
                            {
                                foreach($deleted as $hapus)
                                {
                                    $destroy = Program::where('id', $hapus->id)->first(); 
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
                            $model = Program::where('id', $cekupdate->id)->first(); 
    
                            // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                            if($model->organisasi_no != $cekupdate->organisasi_no || $model->program_no != $cekupdate->program_no || $model->program_nama != $cekupdate->program_nama)
                            {
                                // tampung yang berubah
                                $updated[] = $cekupdate;
    
                                // lakukan save atau update
                                $update = Program::where('id', $cekupdate->id)->first();
                                $update->id = $cekupdate->id;
                                $update->organisasi_no = $cekupdate->organisasi_no;
                                $update->program_no = $cekupdate->program_no;
                                $update->program_nama = $cekupdate->program_nama;
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


            } // --------------------------------------------------- end if program -------------------------------------------
            elseif($param == 'kegiatan') // ---------------------------------- if kegiatan ------------------------------
            {
                $keg = Kegiatan::get();
                
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                    if(count($keg) == 0)
                    {
                        foreach($res_api as $data)
                        {

                            $model = new Kegiatan;
                            $model->id = $data->id;
                            $model->kegiatan_no = $data->kegiatan_no;
                            $model->kegiatan_nama = $data->kegiatan_nama;
                            $model->program_no = $data->program_no;
                            $model->save();
                        }
    
                        // respone jika data kegiatan berhasil di tambahkan
                        return Response()->json([
                            'status' => 200,
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


            } // ------------------------------------------------------------ end if kegiatan ----------------------------------------
            elseif($param == 'tujuan_renstra') // --------------------------------------- if tujuan renstra -----------------------------------
            {
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
                   

            } // --------------------------------------------- end if tujuan renstra -----------------------------------------
            elseif($param == 'sasaran_renstra') // ------------------------------- if sasaran renstra ----------------------------
            {

                $sr = SasaranRenstra::get();

                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                    if(count($sr) == 0)
                    {
                        foreach($res_api as $data)
                        {

                            $model = new SasaranRenstra;
                            $model->id = $data->id;
                            $model->tujuan_id = $data->tujuan_id;
                            $model->sasaran_id_rpjmd = $data->sasaran_id_rpjmd;
                            $model->sasaran_nomor = $data->sasaran_nomor;
                            $model->sasaran_nama = $data->sasaran_nama;
                            $model->organisasi_no = $data->organisasi_no;
                            $model->save();
                        }
    
                        // respone jika data sasaran renstra berhasil di tambahkan
                        return Response()->json([
                            'status' => 200,
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

            } // -------------------------------------------------------------- end if sasaran renstra ----------------------------------
            elseif($param == 'target_indikator_kegiatan') // ---------------------------------------- if target indikator sasaran --------------------------------------
            {
                $tik = TargetIkRenstra::get();

                // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($tik) == 0)
                {
                    foreach($res_api as $data)
                    {

                        $model = new TargetIkRenstra;
                        $model->id = $data->id;
                        $model->indikator_kegiatan_id = $data->indikator_kegiatan_id;
                        $model->tahun = $data->tahun;
                        $model->target = $data->target;
                        $model->pagu = $data->pagu;
                        $model->save();
                        
                    }
                    

                    // respone jika data sasaran renstra berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
                        'message' => 'Data sasaran renstra Berhasil di Tambahkan'
                    ]);

                
                } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                elseif(count($res_api) > count($tik)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                {
                    // def array
                    $cekapi = [];
                    $cekapi2 = [];
                    $no = 0;

                    // get id yang sudah ada pada table
                    foreach($tik as $data)
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


                            $model = new TargetIkRenstra;
                            $model->id = $value->id;
                            $model->indikator_kegiatan_id = $value->indikator_kegiatan_id;
                            $model->tahun = $value->tahun;
                            $model->target = $value->target;
                            $model->pagu = $value->pagu;
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

                    if(count($res_api) < count($tik))
                    {

                        foreach($tik as $datatik)
                        {
                            // cek id yang terkait
                            $cekdelete = collect($res_api)->where('id', $datatik->id)->first(); 

                            if(!$cekdelete)
                            {
                                // tampung yang berubah
                                $deleted[] = $datatik;
                            }

                        }


                        if(count($deleted) > 0)
                        {
                            foreach($deleted as $hapus)
                            {
                                $destroy = TargetIkRenstra::where('id', $hapus->id)->first(); 
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
                        $model = TargetIkRenstra::where('id', $cekupdate->id)->first(); 

                        // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                        if($model->indikator_kegiatan_id != $cekupdate->indikator_kegiatan_id || $model->tahun != $cekupdate->tahun || $model->target != $cekupdate->target || $model->pagu  != $cekupdate->pagu) 
                        {
                            // tampung yang berubah
                            $updated[] = $cekupdate;

                            // lakukan save atau update
                            $update = TargetIkRenstra::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->indikator_kegiatan_id = $cekupdate->indikator_kegiatan_id;
                            $update->tahun = $cekupdate->tahun;
                            $update->target = $cekupdate->target;
                            $update->pagu = $cekupdate->pagu;
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
               
            }// ----------------------------- end if target indikator sasaran ----------------------------
            elseif($param == 'target_program_renstra') // ---------------------------------------- if target indikator program --------------------------------------
            {
                $tipr = TargetIpRenstra::get();
                // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($tipr) == 0)
                {
                    foreach($res_api as $data)
                    {
                        $model = new TargetIpRenstra;
                        $model->id = $data->id;
                        $model->indikator_program_id = $data->indikator_program_id;
                        $model->tahun = $data->tahun;
                        $model->target = $data->target;
                        $model->save();
                        
                    }
                    

                    // respone jika data target indikator program renstra berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
                        'message' => 'Data target indikator program renstra Berhasil di Tambahkan'
                    ]);

                
                } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                elseif(count($res_api) > count($tipr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                {
                    // def array
                    $cekapi = [];
                    $cekapi2 = [];
                    $no = 0;

                    // get id yang sudah ada pada table
                    foreach($tipr as $data)
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


                            $model = new TargetIpRenstra;
                            $model->id = $value->id;
                            $model->indikator_program_id = $value->indikator_program_id;
                            $model->tahun = $value->tahun;
                            $model->target = $value->target;
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

                    if(count($res_api) < count($tipr))
                    {

                        foreach($tipr as $datatipr)
                        {
                            // cek id yang terkait
                            $cekdelete = collect($res_api)->where('id', $datatipr->id)->first(); 

                            if(!$cekdelete)
                            {
                                // tampung yang berubah
                                $deleted[] = $datatipr;
                            }

                        }


                        if(count($deleted) > 0)
                        {
                            foreach($deleted as $hapus)
                            {
                                $destroy = TargetIpRenstra::where('id', $hapus->id)->first(); 
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
                        $model = TargetIpRenstra::where('id', $cekupdate->id)->first(); 

                        // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                        if($model->id != $cekupdate->id || $model->indikator_program_id != $cekupdate->indikator_program_id || $model->tahun != $cekupdate->tahun || $model->target  != $cekupdate->target) 
                        {
                            // tampung yang berubah
                            $updated[] = $cekupdate;

                            // lakukan save atau update
                            $update = TargetIpRenstra::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->indikator_program_id = $cekupdate->indikator_program_id;
                            $update->tahun = $cekupdate->tahun;
                            $update->target = $cekupdate->target;
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
               
            }// ----------------------------- end if target indikator program ----------------------------
            elseif($param == 'target_sasaran_renstra') // ---------------------------------------- if target indikator sasaran --------------------------------------
            {
                $tisr = TargetIsRenstra::get();

                // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($tisr) == 0)
                {
                    foreach($res_api as $data)
                    {
                        $model = new TargetIsRenstra;
                        $model->id = $data->id;
                        $model->indikator_sasaran_id = $data->indikator_sasaran_id;
                        $model->tahun = $data->tahun;
                        $model->target = $data->target;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->save();
                        
                    }
                    

                    // respone jika data target indikator sasaran renstra berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
                        'message' => 'Data target indikator sasaran renstra Berhasil di Tambahkan'
                    ]);

                
                } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                elseif(count($res_api) > count($tisr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                {
                    // def array
                    $cekapi = [];
                    $cekapi2 = [];
                    $no = 0;

                    // get id yang sudah ada pada table
                    foreach($tisr as $data)
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

                            $model = new TargetIsRenstra;
                            $model->id = $value->id;
                            $model->indikator_sasaran_id = $value->indikator_sasaran_id;
                            $model->tahun = $value->tahun;
                            $model->target = $value->target;
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

                    if(count($res_api) < count($tisr))
                    {

                        foreach($tisr as $datatisr)
                        {
                            // cek id yang terkait
                            $cekdelete = collect($res_api)->where('id', $datatisr->id)->first(); 

                            if(!$cekdelete)
                            {
                                // tampung yang berubah
                                $deleted[] = $datatisr;
                            }

                        }


                        if(count($deleted) > 0)
                        {
                            foreach($deleted as $hapus)
                            {
                                $destroy = TargetIsRenstra::where('id', $hapus->id)->first(); 
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
                        $model = TargetIsRenstra::where('id', $cekupdate->id)->first(); 

                        // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                        if($model->id != $cekupdate->id || $model->indikator_sasaran_id != $cekupdate->indikator_sasaran_id || $model->tahun != $cekupdate->tahun || $model->target  != $cekupdate->target || $model->organisasi_no  != $cekupdate->organisasi_no) 
                        {
                            // tampung yang berubah
                            $updated[] = $cekupdate;

                            // lakukan save atau update
                            $update = TargetIsRenstra::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->indikator_sasaran_id = $cekupdate->indikator_sasaran_id;
                            $update->tahun = $cekupdate->tahun;
                            $update->target = $cekupdate->target;
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
               
            }// ----------------------------- end if target indikator sasaran ----------------------------
            elseif($param == 'iku_renstra') // -------------------------------- iku renstra--------------------------------
            {
                $iku = IkuRenstra::get();


                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($iku) == 0)
                {
                    foreach($res_api as $data)
                    {

                        $model = new IkuRenstra;
                        $model->id = $data->id;
                        $model->indikator_sasaran_id = $data->indikator_sasaran_id;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->tahun = 0;
                        $model->alasan = $data->alasan;
                        $model->formulasi = $data->formulasi;
                        $model->sumber_data = $data->sumber_data;
                        $model->keterangan = $data->keterangan;
                        $model->save();
                    }

                    // respone jika data iku renstra berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
                        'message' => 'Data iku renstra Berhasil di Tambahkan'
                    ]);

                
                } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                elseif(count($res_api) > count($iku)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
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

                            $model = new IkuRenstra;
                            $model->id = $value->id;
                            $model->indikator_sasaran_id = $value->indikator_sasaran_id;
                            $model->organisasi_no = $value->organisasi_no;
                            $model->tahun = 0;
                            $model->alasan = $value->alasan;
                            $model->formulasi = $value->formulasi;
                            $model->sumber_dana = $value->sumber_dana;
                            $model->keterangan = $value->keterangan;
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

                    if(count($res_api) < count($iku))
                    {

                        foreach($iku as $dataiku)
                        {
                            // cek id yang terkait
                            $cekdelete = collect($res_api)->where('id', $dataiku->id)->first(); 

                            if(!$cekdelete)
                            {
                                // tampung yang berubah
                                $deleted[] = $dataiku;
                            }

                        }


                        if(count($deleted) > 0)
                        {
                            foreach($deleted as $hapus)
                            {
                                $destroy = IkuRenstra::where('id', $hapus->id)->first(); 
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
                        $model = IkuRenstra::where('id', $cekupdate->id)->first(); 

                        // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                        if($model->id != $cekupdate->id || $model->indikator_sasaran_id != $cekupdate->indikator_sasaran_id || $model->organisasi_no != $cekupdate->organisasi_no || $model->alasan  != $cekupdate->alasan || $model->formulasi  != $cekupdate->formulasi || $model->sumber_dana  != $cekupdate->sumber_dana || $model->keterangan  != $cekupdate->keterangan) 
                        {
                            // tampung yang berubah
                            $updated[] = $cekupdate;

                            // lakukan save atau update
                            $update = IkuRenstra::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->indikator_sasaran_id = $cekupdate->indikator_sasaran_id;
                            $update->organisasi_no = $cekupdate->organisasi_no;
                            $update->tahun = 0;
                            $update->alasan = $cekupdate->alasan;
                            $update->formulasi = $cekupdate->formulasi;
                            $update->sumber_dana = $cekupdate->sumber_dana;
                            $update->keterangan = $cekupdate->keterangan;
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



            }// ----------------------------------end iku renstra --------------------------------
            elseif($param == 'indikator_tujuan_renstra')// --------------------- if indikator_tujuan_renstra ---------------
            {
                $itr = RencanaStrategisIndikatorTujuan::get();

                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($itr) == 0)
                {
                    foreach($res_api as $data)
                    {

                        $model = new RencanaStrategisIndikatorTujuan;
                        $model->id = $data->id;
                        $model->tujuan_id = $data->tujuan_id;
                        $model->indikator_tujuan_rpjmd_id = $data->indikator_tujuan_rpjmd_id;
                        $model->indikator_tujuan = $data->indikator_tujuan_nama;
                        $model->satuan_id = $data->satuan_id;
                        $model->kondisi_akhir = $data->kondisi_akhir;
                        $model->kondisi_awal = $data->kondisi_awal;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->save();
                    }

                    // respone jika data indikator tujuan renstra renstra berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
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

            } // ---------------------------------------------------end if indikator_tujuan_renstra -------------------------
            elseif($param == 'indikator_sasaran_renstra') // --------------------------------------------------- if indikator sasaran renstra --------------------------
            {
                $isr = IndikatorSasaranRenstra::get();
                    
                // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($isr) == 0)
                {
                    foreach($res_api as $data)
                    {
                        $model = new IndikatorSasaranRenstra;
                        $model->id = $data->id;
                        $model->indikator_sasaran_rpjmd_id = $data->indikator_sasaran_rpjmd_id;
                        $model->sasaran_id = $data->sasaran_id;
                        $model->indikator_sasaran = $data->indikator_sasaran_nama;
                        $model->kondisi_awal = $data->kondisi_awal;
                        $model->target_akhir = $data->kondisi_akhir;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->satuan_id = $data->satuan_id;
                        $model->save();

                        $capaian = new CapaianSasaranOpd;
                        $capaian->indikator_sasaran_id = $model->id;
                        $capaian->save();
                    }

                    // respone jika data indikator sasaran renstra berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
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

                        // memecah array multidimensi untuk mengambil value 
                        foreach($insert as $key => $value)
                        {


                            $model = new IndikatorSasaranRenstra;
                            $model->id = $value->id;
                            $model->indikator_sasaran_rpjmd_id = $value->indikator_sasaran_rpjmd_id;
                            $model->sasaran_id = $value->sasaran_id;
                            $model->indikator_sasaran = $value->indikator_sasaran_nama;
                            $model->kondisi_awal = $value->kondisi_awal;
                            $model->target_akhir = $value->kondisi_akhir;
                            $model->organisasi_no = $value->organisasi_no;
                            $model->satuan_id = $value->satuan_id;
                            $model->save();

                            $capaian = new CapaianSasaranOpd;
                            $capaian->indikator_sasaran_id = $model->id;
                            $capaian->save();
                        
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
                        if($model->indikator_sasaran_rpjmd_id != $cekupdate->indikator_sasaran_rpjmd_id || $model->sasaran_id != $cekupdate->sasaran_id || $model->indikator_sasaran != $cekupdate->indikator_sasaran || $model->kondisi_awal  != $cekupdate->kondisi_awal || $model->target_akhir  != $cekupdate->target_akhir || $model->organisasi_no  != $cekupdate->organisasi_no || $model->satuan_id  != $cekupdate->satuan_id) 
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

                
            } // -------------------------------------------------- endi id indikator sasaran renstra ---------------------------------
            elseif($param == 'renstra')
            {
                $renstra = Renstra::get();

                     // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                if(count($renstra) == 0)
                {
                    foreach($res_api as $data)
                    {

                        $model = new Renstra;
                        $model->id = $data->id;
                        $model->indikator_sasaran_id = $data->indikator_sasaran_id;
                        $model->program_no = $data->program_no;
                        $model->kegiatan_no = $data->kegiatan_no;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->lokasi = $data->lokasi;
                        $model->save();
                    }

                    // respone jika data renstra berhasil di tambahkan
                    return Response()->json([
                        'status' => 200,
                        'message' => 'Data renstra Berhasil di Tambahkan'
                    ]);

                
                } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                elseif(count($res_api) > count($renstra)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                {
                    // def array
                    $cekapi = [];
                    $cekapi2 = [];
                    $no = 0;

                    // get id yang sudah ada pada table
                    foreach($renstra as $data)
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

                            $model = new Renstra;
                            $model->id = $value->id;
                            $model->indikator_sasaran_id = $value->indikator_sasaran_id;
                            $model->program_no = $value->program_no;
                            $model->kegiatan_no = $value->kegiatan_no;
                            $model->organisasi_no = $value->organisasi_no;
                            $model->lokasi = $value->lokasi;
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

                    if(count($res_api) < count($renstra))
                    {

                        foreach($renstra as $datarenstra)
                        {
                            // cek id yang terkait
                            $cekdelete = collect($res_api)->where('id', $datarenstra->id)->first(); 

                            if(!$cekdelete)
                            {
                                // tampung yang berubah
                                $deleted[] = $datarenstra;
                            }

                        }


                        if(count($deleted) > 0)
                        {
                            foreach($deleted as $hapus)
                            {
                                $destroy = Renstra::where('id', $hapus->id)->first(); 
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
                        $model = Renstra::where('id', $cekupdate->id)->first(); 

                        // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                        if($model->indikator_sasaran_id != $cekupdate->indikator_sasaran_id || $model->program_no != $cekupdate->program_no || $model->kegiatan_no != $cekupdate->kegiatan_no || $model->organisasi_no  != $cekupdate->organisasi_no || $model->lokasi  != $cekupdate->lokasi) 
                        {
                            // tampung yang berubah
                            $updated[] = $cekupdate;

                            // lakukan save atau update
                            $update = Renstra::where('id', $cekupdate->id)->first();
                            $model->id = $cekupdate->id;
                            $model->indikator_sasaran_id = $cekupdate->indikator_sasaran_id;
                            $model->program_no = $cekupdate->program_no;
                            $model->kegiatan_no = $cekupdate->kegiatan_no;
                            $model->organisasi_no = $cekupdate->organisasi_no;
                            $model->lokasi = $cekupdate->lokasi;
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


            } // ----------------------------------------- end if renstra ------------------------------
            elseif($param == 'prokeg_renstra')//------------------------------ if prokeg renstra -----------------------------------
            {
                $prokeg = ProgKegRenstra::get();
                
                 // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($prokeg) == 0)
                 {
                     foreach($res_api as $data)
                     {
                         $model = new ProgKegRenstra;
                         $model->id_api = $data->id;
                         $model->indikator_sasaran_id = $data->indikator_sasaran_id;
                         $model->indikator_kegiatan = $data->indikator_kegiatan;
                         $model->program_no = $data->program_no;
                         $model->kegiatan_no = $data->kegiatan_no;
                         $model->organisasi_no = $data->organisasi_no;
                         $model->lokasi = $data->lokasi;
                         $model->satuan_id = $data->satuan_id;
                         $model->perencanaan_awal = $data->kondisi_awal_kegiatan;
                         $model->target_t1 = $data->target_ik_2017;
                         $model->target_t2 = $data->target_ik_2018;
                         $model->target_t3 = $data->target_ik_2019;
                         $model->target_t4 = $data->target_ik_2020;
                         $model->target_t5 = $data->target_ik_2021;
                         $model->pagu_t1 = $data->pagu_ik_2017;
                         $model->pagu_t2 = $data->pagu_ik_2018;
                         $model->pagu_t3 = $data->pagu_ik_2019;
                         $model->pagu_t4 = $data->pagu_ik_2020;
                         $model->pagu_t5 = $data->pagu_ik_2021;
                         $model->target_kondisi_akhir = $data->target_akhir_kegiatan;
                         $model->pagu_kondisi_akhir = $data->pagu_akhir_kegiatan;
                         $model->save();
                     }
 
                     // respone jika data prokeg_renstra berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data prokeg_renstra Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($prokeg)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($prokeg as $data)
                     {
                         $cekapi[] = $data->id_api;
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
 
                            $model = new ProgKegRenstra;
                            $model->id_api = $value->id;
                            $model->indikator_sasaran_id = $value->indikator_sasaran_id;
                            $model->indikator_kegiatan = $value->indikator_kegiatan;
                            $model->program_no = $value->program_no;
                            $model->kegiatan_no = $value->kegiatan_no;
                            $model->organisasi_no = $value->organisasi_no;
                            $model->lokasi = $value->lokasi;
                            $model->satuan_id = $value->satuan_id;
                            $model->perencanaan_awal = $value->kondisi_awal_kegiatan;
                            $model->target_t1 = $value->target_ik_2017;
                            $model->target_t2 = $value->target_ik_2018;
                            $model->target_t3 = $value->target_ik_2019;
                            $model->target_t4 = $value->target_ik_2020;
                            $model->target_t5 = $value->target_ik_2021;
                            $model->pagu_t1 = $value->pagu_ik_2017;
                            $model->pagu_t2 = $value->pagu_ik_2018;
                            $model->pagu_t3 = $value->pagu_ik_2019;
                            $model->pagu_t4 = $value->pagu_ik_2020;
                            $model->pagu_t5 = $value->pagu_ik_2021;
                            $model->target_kondisi_akhir = $value->target_akhir_kegiatan;
                            $model->pagu_kondisi_akhir = $value->pagu_akhir_kegiatan;
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
 
                     if(count($res_api) < count($prokeg))
                     {
 
                         foreach($prokeg as $dataprokeg)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $dataprokeg->id_api)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $dataprokeg;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = ProgKegRenstra::where('id', $hapus->id)->first(); 
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
                         $model = ProgKegRenstra::where('id_api', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->indikator_sasaran_id != $cekupdate->indikator_sasaran_id || $model->indikator_kegiatan != $cekupdate->indikator_kegiatan || $model->program_no != $cekupdate->program_no || $model->kegiatan_no  != $cekupdate->kegiatan_no || $model->organisasi_no  != $cekupdate->organisasi_no || $model->lokasi  != $cekupdate->lokasi || $model->satuan_id  != $cekupdate->satuan_id || $model->perencanaan_awal  != $cekupdate->kondisi_awal_kegiatan || $model->target_t1  != $cekupdate->target_ik_2017 || $model->target_t2  != $cekupdate->target_ik_2018 || $model->target_t3  != $cekupdate->target_ik_2019 || $model->target_t4  != $cekupdate->target_ik_2020 || $model->target_t5  != $cekupdate->target_ik_2021 || $model->pagu_t1  != $cekupdate->pagu_ik_2017 || $model->pagu_t2  != $cekupdate->pagu_ik_2018 || $model->pagu_t3  != $cekupdate->pagu_ik_2019 || $model->pagu_t4  != $cekupdate->pagu_ik_2020 || $model->pagu_t5  != $cekupdate->pagu_ik_2021 || $model->target_kondisi_akhir  != $cekupdate->target_akhir_kegiatan || $model->pagu_kondisi_akhir  != $cekupdate->pagu_akhir_kegiatan) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = ProgKegRenstra::where('id_api', $cekupdate->id)->first();
                             $update->id_api = $cekupdate->id;
                            $update->indikator_sasaran_id = $cekupdate->indikator_sasaran_id;
                            $update->indikator_kegiatan = $cekupdate->indikator_kegiatan;
                            $update->program_no = $cekupdate->program_no;
                            $update->kegiatan_no = $cekupdate->kegiatan_no;
                            $update->organisasi_no = $cekupdate->organisasi_no;
                            $update->lokasi = $cekupdate->lokasi;
                            $update->satuan_id = $cekupdate->satuan_id;
                            $update->perencanaan_awal = $cekupdate->kondisi_awal_kegiatan;
                            $update->target_t1 = $cekupdate->target_ik_2017;
                            $update->target_t2 = $cekupdate->target_ik_2018;
                            $update->target_t3 = $cekupdate->target_ik_2019;
                            $update->target_t4 = $cekupdate->target_ik_2020;
                            $update->target_t5 = $cekupdate->target_ik_2021;
                            $update->pagu_t1 = $cekupdate->pagu_ik_2017;
                            $update->pagu_t2 = $cekupdate->pagu_ik_2018;
                            $update->pagu_t3 = $cekupdate->pagu_ik_2019;
                            $update->pagu_t4 = $cekupdate->pagu_ik_2020;
                            $update->pagu_t5 = $cekupdate->pagu_ik_2021;
                            $update->target_kondisi_akhir = $cekupdate->target_akhir_kegiatan;
                            $update->pagu_kondisi_akhir = $cekupdate->pagu_akhir_kegiatan;
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

            } // ---------------------------------------end if prokeg renstra -------------------------------------------
            elseif($param == 'indikator_program_renstra')// ---------------------------------if indikator program renstra -----------------------------
            {
                $ipr = RencanaStrategisIndikatorProgram::get();

                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($ipr) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new RencanaStrategisIndikatorProgram;
                        $model->id = $data->id;
                        $model->program_renstra_id = $data->program_renstra_id;
                        $model->indikator_program_nama = $data->indikator_program;
                        $model->sasaran_program = $data->sasaran_program;
                        $model->program_no = $data->program_no;
                        $model->kondisi_awal = $data->kondisi_awal;
                        $model->target_akhir = $data->target_akhir;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->satuan_id = $data->satuan_id;
                        $model->save();
                    }
 
                     // respone jika data indikator program renstra berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data indikator program renstra Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($ipr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($ipr as $data)
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
 
                            $model = new RencanaStrategisIndikatorProgram;
                            $model->id = $value->id;
                            $model->program_renstra_id = $value->program_renstra_id;
                            $model->indikator_program_nama = $value->indikator_program;
                            $model->sasaran_program = $value->sasaran_program;
                            $model->program_no = $value->program_no;
                            $model->kondisi_awal = $value->kondisi_awal;
                            $model->target_akhir = $value->target_akhir;
                            $model->organisasi_no = $value->organisasi_no;
                            $model->satuan_id = $value->satuan_id;
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
 
                     if(count($res_api) < count($ipr))
                     {
 
                         foreach($ipr as $dataipr)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $dataipr->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $dataipr;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = RencanaStrategisIndikatorProgram::where('id', $hapus->id)->first(); 
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
                         $model = RencanaStrategisIndikatorProgram::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->program_renstra_id != $cekupdate->program_renstra_id || $model->indikator_program_nama != $cekupdate->indikator_program || $model->sasaran_program != $cekupdate->sasaran_program || $model->program_no  != $cekupdate->program_no || $model->kondisi_awal  != $cekupdate->kondisi_awal || $model->target_akhir  != $cekupdate->target_akhir || $model->organisasi_no  != $cekupdate->organisasi_no || $model->satuan_id  != $cekupdate->satuan_id) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                            $update = RencanaStrategisIndikatorProgram::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->program_renstra_id = $cekupdate->program_renstra_id;
                            $update->indikator_program_nama = $cekupdate->indikator_program;
                            $update->sasaran_program = $cekupdate->sasaran_program;
                            $update->program_no = $cekupdate->program_no;
                            $update->kondisi_awal = $cekupdate->kondisi_awal;
                            $update->target_akhir = $cekupdate->target_akhir;
                            $update->organisasi_no = $cekupdate->organisasi_no;
                            $update->satuan_id = $cekupdate->satuan_id;
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

            } // ---------------------------------------------------------end if indikator program renstra -----------------------------------------
            elseif($param == 'indikator_kegiatan_renstra') // -------------------------------------- if indikator kegiatan renstra --------------------------
            {
                $ikr = RencanaStrategisIndikatorKegiatan::get();
                    

                // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($ikr) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new RencanaStrategisIndikatorKegiatan;
                        $model->id = $data->id;
                        $model->renstra_id = $data->renstra_id;
                        $model->indikator_kegiatan = $data->indikator_kegiatan;
                        $model->sasaran_kegiatan = $data->sasaran_kegiatan;
                        $model->kondisi_awal = $data->kondisi_awal;
                        $model->target_akhir = $data->target_akhir;
                        $model->pagu_akhir = $data->pagu_akhir;
                        $model->satuan_id = $data->satuan_id;
                        $model->save();
                    }
 
                     // respone jika data indikator kegiatan renstra berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data indikator kegiatan renstra Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($ikr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($ikr as $data)
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
 
                            $model = new RencanaStrategisIndikatorKegiatan;
                            $model->id = $value->id;
                            $model->renstra_id = $value->renstra_id;
                            $model->indikator_kegiatan = $value->indikator_kegiatan;
                            $model->sasaran_kegiatan = $value->sasaran_kegiatan;
                            $model->kondisi_awal = $value->kondisi_awal;
                            $model->target_akhir = $value->target_akhir;
                            $model->pagu_akhir = $value->pagu_akhir;
                            $model->satuan_id = $value->satuan_id;
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
 
                     if(count($res_api) < count($ikr))
                     {
 
                         foreach($ikr as $dataikr)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $dataikr->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $dataikr;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = RencanaStrategisIndikatorKegiatan::where('id', $hapus->id)->first(); 
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
                         $model = RencanaStrategisIndikatorKegiatan::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->renstra_id != $cekupdate->renstra_id || $model->indikator_kegiatan != $cekupdate->indikator_kegiatan || $model->sasaran_kegiatan != $cekupdate->sasaran_kegiatan || $model->kondisi_awal  != $cekupdate->kondisi_awal || $model->target_akhir  != $cekupdate->target_akhir || $model->pagu_akhir  != $cekupdate->pagu_akhir || $model->satuan_id  != $cekupdate->satuan_id) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = RencanaStrategisIndikatorKegiatan::where('id', $cekupdate->id)->first();
                            $update->id = $cekupdate->id;
                            $update->renstra_id = $cekupdate->renstra_id;
                            $update->indikator_kegiatan = $cekupdate->indikator_kegiatan;
                            $update->sasaran_kegiatan = $cekupdate->sasaran_kegiatan;
                            $update->kondisi_awal = $cekupdate->kondisi_awal;
                            $update->target_akhir = $cekupdate->target_akhir;
                            $update->pagu_akhir = $cekupdate->pagu_akhir;
                            $update->satuan_id = $cekupdate->satuan_id;
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

            } // -------------------------------------------- end if indikator kegiatan renstra -----------------------
            elseif($param == 'tujuan_rpjmd') // -----------------------------------if tujuan rpjmd -----------------------------------
            {
                $tujuan_rpjmd = TujuanRpjmd::get();
                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($tujuan_rpjmd) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new TujuanRpjmd;
                        $model->id = $data->id;
                        $model->misi_id = $data->misi_id;
                        $model->tujuan_no = $data->tujuan_nomor;
                        $model->tujuan_nama = $data->tujuan_nama;
                        $model->save();
                    }
 
                     // respone jika data tujuan rpjmd berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data tujuan rpjmd Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($tujuan_rpjmd)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($tujuan_rpjmd as $data)
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
 
                            $model = new TujuanRpjmd;
                            $model->id = $value->id;
                            $model->misi_id = $value->misi_id;
                            $model->tujuan_no = $value->tujuan_nomor;
                            $model->tujuan_nama = $value->tujuan_nama;
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
 
                     if(count($res_api) < count($tujuan_rpjmd))
                     {
 
                         foreach($tujuan_rpjmd as $datatujuan_rpjmd)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $datatujuan_rpjmd->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $datatujuan_rpjmd;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = TujuanRpjmd::where('id', $hapus->id)->first(); 
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
                         $model = TujuanRpjmd::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->misi_id != $cekupdate->misi_id || $model->tujuan_no != $cekupdate->tujuan_no || $model->tujuan_nama != $cekupdate->tujuan_nama) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = TujuanRpjmd::where('id', $cekupdate->id)->first();
                             $update->id = $cekupdate->id;
                             $update->misi_id = $cekupdate->misi_id;
                             $update->tujuan_no = $cekupdate->tujuan_nomor;
                             $update->tujuan_nama = $cekupdate->tujuan_nama;
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
                    
            } // ---------------------------------------- end if tujuan rpjmd --------------------------------------------------
            elseif($param == 'sasaran_rpjmd') //------------------------------------- if sasaran rpjmd ---------------------------------
            {
                $sasaran_rpjmd = SasaranRpjmd::get();
                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($sasaran_rpjmd) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new SasaranRpjmd;
                        $model->id = $data->id;
                        $model->tujuan_id = $data->tujuan_id;
                        $model->sasaran_nomor = $data->sasaran_nomor;
                        $model->sasaran_nama = $data->sasaran_nama;
                        $model->save();
                    }
 
                     // respone jika data sasaran rpjmd berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data sasaran rpjmd Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($sasaran_rpjmd)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($sasaran_rpjmd as $data)
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
 
                            $model = new SasaranRpjmd;
                            $model->id = $value->id;
                            $model->tujuan_id = $value->tujuan_id;
                            $model->sasaran_nomor = $value->sasaran_nomor;
                            $model->sasaran_nama = $value->sasaran_nama;
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
 
                     if(count($res_api) < count($sasaran_rpjmd))
                     {
 
                         foreach($sasaran_rpjmd as $datasasaran_rpjmd)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $datasasaran_rpjmd->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $datasasaran_rpjmd;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = SasaranRpjmd::where('id', $hapus->id)->first(); 
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
                         $model = SasaranRpjmd::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->tujuan_id != $cekupdate->tujuan_id || $model->sasaran_nomor != $cekupdate->sasaran_nomor || $model->sasaran_nama != $cekupdate->sasaran_nama) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = SasaranRpjmd::where('id', $cekupdate->id)->first();
                             $update->id = $cekupdate->id;
                             $update->tujuan_id = $cekupdate->tujuan_id;
                             $update->sasaran_nomor = $cekupdate->sasaran_nomor;
                             $update->sasaran_nama = $cekupdate->sasaran_nama;
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

            }//------------------------------------- end if sasaran rpjmd ---------------------------------
            elseif($param == 'iku_rpjmd') // ------------------------------ if iku rpjmd --------------------------
            {
                $iku_rpjmd = IkuRpjmd::get();
                    
                    foreach($isr as $data)
                    {

                        $model = new CapaianSasaranOpd;
                        $model->indikator_sasaran_id = $data->id;
                        $model->save();
                    }
                    
            } // -------------------------------------------- end if iku rpjmd -------------------------------------
            elseif($param == 'program_rpjmd') // ------------------------------ if iku rpjmd --------------------------
            {
                $program_rpjmd = ProgramRpjmd::get();
                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($program_rpjmd) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new ProgramRpjmd;
                        $model->id = $data->id;
                        $model->indikator_sasaran_id = $data->indikator_sasaran_id;
                        $model->program_no = $data->program_no;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->save();
                    }
 
                     // respone jika data program rpjmd berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data program rpjmd Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($program_rpjmd)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($program_rpjmd as $data)
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
 
                            $model = new ProgramRpjmd;
                            $model->id = $value->id;
                            $model->indikator_sasaran_id = $value->indikator_sasaran_id;
                            $model->program_no = $value->program_no;
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
 
                     if(count($res_api) < count($program_rpjmd))
                     {
 
                         foreach($program_rpjmd as $dataprogram_rpjmd)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $dataprogram_rpjmd->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $dataprogram_rpjmd;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = ProgramRpjmd::where('id', $hapus->id)->first(); 
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
                         $model = ProgramRpjmd::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->indikator_sasaran_id != $cekupdate->indikator_sasaran_id || $model->program_no != $cekupdate->program_no || $model->organisasi_no != $cekupdate->organisasi_no) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = ProgramRpjmd::where('id', $cekupdate->id)->first();
                             $update->id = $cekupdate->id;
                            $update->indikator_sasaran_id = $cekupdate->indikator_sasaran_id;
                            $update->program_no = $cekupdate->program_no;
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
                    
            } // -------------------------------------------- end if program rpjmd -------------------------------------
            elseif($param == 'indikator_program_rpjmd') // ------------------------------ if indikator program rpjmd --------------------------
            {
                $ipr = IndikatorProgramRpjmd::get();
                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($ipr) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new IndikatorProgramRpjmd;
                        $model->id = $data->id;
                        $model->program_rpjmd_id = $data->program_rpjmd_id;
                        $model->indikator_program_nama = $data->indikator_program;
                        $model->sasaran_program = $data->sasaran_program;
                        $model->satuan_id = $data->satuan_id;
                        $model->kondisi_awal = $data->kondisi_awal;
                        $model->target_akhir = $data->target_akhir;
                        $model->pagu_akhir = $data->pagu_akhir;
                        $model->organisasi_no = $data->organisasi_no;
                        $model->save();
                    }
 
                     // respone jika data indikator program rpjmd berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data indikator program rpjmd Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($ipr)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($ipr as $data)
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
 
                            $model = new IndikatorProgramRpjmd;
                            $model->id = $value->id;
                            $model->program_rpjmd_id = $value->program_rpjmd_id;
                            $model->indikator_program_nama = $value->indikator_program;
                            $model->sasaran_program = $value->sasaran_program;
                            $model->satuan_id = $value->satuan_id;
                            $model->kondisi_awal = $value->kondisi_awal;
                            $model->target_akhir = $value->target_akhir;
                            $model->pagu_akhir = $value->pagu_akhir;
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
 
                     if(count($res_api) < count($ipr))
                     {
 
                         foreach($ipr as $dataipr)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $dataipr->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $dataipr;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = IndikatorProgramRpjmd::where('id', $hapus->id)->first(); 
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
                         $model = IndikatorProgramRpjmd::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->program_rpjmd_id != $cekupdate->program_rpjmd_id || $model->indikator_program_nama != $cekupdate->indikator_program_nama || $model->sasaran_program != $cekupdate->sasaran_program || $model->satuan_id != $cekupdate->satuan_id || $model->kondisi_awal != $cekupdate->kondisi_awal || $model->target_akhir != $cekupdate->target_akhir || $model->pagu_akhir != $cekupdate->pagu_akhir || $model->organisasi_no != $cekupdate->organisasi_no) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = IndikatorProgramRpjmd::where('id', $cekupdate->id)->first();
                             $update->id = $cekupdate->id;
                            $update->program_rpjmd_id = $cekupdate->program_rpjmd_id;
                            $update->indikator_program_nama = $cekupdate->indikator_program;
                            $update->sasaran_program = $cekupdate->sasaran_program;
                            $update->satuan_id = $cekupdate->satuan_id;
                            $update->kondisi_awal = $cekupdate->kondisi_awal;
                            $update->target_akhir = $cekupdate->target_akhir;
                            $update->pagu_akhir = $cekupdate->pagu_akhir;
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
                    
            } // -------------------------------------------- end if indikator program rpjmd -------------------------------------
            elseif($param == 'indikator_sasaran_rpjmd') // ------------------------------ if indikator program rpjmd --------------------------
            {
                $isd = IndikatorSasaranRpjmd::get();
                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($isd) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new IndikatorSasaranRpjmd;
                        $model->id = $data->id;
                        $model->sasaran_id = $data->sasaran_id;
                        $model->indikator_sasaran = $data->indikator_sasaran_nama;
                        $model->satuan_id = $data->satuan_id;
                        $model->kondisi_awal = $data->kondisi_awal;
                        $model->kondisi_akhir = $data->kondisi_akhir;
                        $model->save();
                    }
 
                     // respone jika data indikator sasaran rpjmd berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data indikator sasaran rpjmd Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($isd)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($isd as $data)
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
 
                            $model = new IndikatorSasaranRpjmd;
                            $model->id = $value->id;
                            $model->sasaran_id = $value->sasaran_id;
                            $model->indikator_sasaran = $value->indikator_sasaran_nama;
                            $model->satuan_id = $value->satuan_id;
                            $model->kondisi_awal = $value->kondisi_awal;
                            $model->kondisi_akhir = $value->kondisi_akhir;
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
 
                     if(count($res_api) < count($isd))
                     {
 
                         foreach($isd as $dataisd)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $dataisd->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $dataisd;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = IndikatorSasaranRpjmd::where('id', $hapus->id)->first(); 
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
                         $model = IndikatorSasaranRpjmd::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->sasaran_id != $cekupdate->sasaran_id || $model->indikator_sasaran != $cekupdate->indikator_sasaran || $model->satuan_id != $cekupdate->satuan_id || $model->kondisi_awal != $cekupdate->kondisi_awal || $model->kondisi_akhir != $cekupdate->kondisi_akhir) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = IndikatorSasaranRpjmd::where('id', $cekupdate->id)->first();
                             $update->id = $cekupdate->id;
                            $update->sasaran_id = $cekupdate->sasaran_id;
                            $update->indikator_sasaran = $cekupdate->indikator_sasaran_nama;
                            $update->satuan_id = $cekupdate->satuan_id;
                            $update->kondisi_awal = $cekupdate->kondisi_awal;
                            $update->kondisi_akhir = $cekupdate->kondisi_akhir;
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
                    
            } // -------------------------------------------- end if indikator sasaran rpjmd -------------------------------------
            elseif($param == 'visi') // ------------------------------ if visi --------------------------
            {
                $visi = Visi::get();
                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($visi) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new Visi;
                        $model->id = $data->id;
                        $model->nama = $data->nama;
                        $model->periode = $data->periode;
                        $model->save();
                    }
 
                     // respone jika data visi berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data visi Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($visi)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($visi as $data)
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
 
                            $model = new Visi;
                            $model->id = $value->id;
                            $model->nama = $value->nama;
                            $model->periode = $value->periode;
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
 
                     if(count($res_api) < count($visi))
                     {
 
                         foreach($visi as $datavisi)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $datavisi->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $datavisi;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = Visi::where('id', $hapus->id)->first(); 
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
                         $model = Visi::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->nama != $cekupdate->nama || $model->periode != $cekupdate->periode) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = Visi::where('id', $cekupdate->id)->first();
                             $update->id = $cekupdate->id;
                            $update->nama = $cekupdate->nama;
                            $update->periode = $cekupdate->periode;
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
                    
            } // -------------------------------------------- end if visi -------------------------------------
            elseif($param == 'misi') // ------------------------------ ii misi --------------------------
            {
                $misi = Misi::get();
                    
                    // --------------------- kondisi jika di table masih kosong akan di insert -------------------------
                 if(count($misi) == 0)
                 {
                    foreach($res_api as $data)
                    {

                        $model = new Misi;
                        $model->id = $data->id;
                        $model->nama = $data->nama;
                        $model->nomor = $data->nomor;
                        $model->visi_id = $data->visi_id;
                        $model->save();
                    }
 
                     // respone jika data misi berhasil di tambahkan
                     return Response()->json([
                         'status' => 200,
                         'message' => 'Data misi Berhasil di Tambahkan'
                     ]);
 
                 
                 } // -------------------- end kondisi if jika di table masih kosong akan di insert --------------------
                 elseif(count($res_api) > count($misi)) // ---------- kondisi jika jumlah data api ada penambahan --------------------
                 {
                     // def array
                     $cekapi = [];
                     $cekapi2 = [];
                     $no = 0;
 
                     // get id yang sudah ada pada table
                     foreach($misi as $data)
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
 
                            $model = new Misi;
                            $model->id = $value->id;
                            $model->nama = $value->nama;
                            $model->nomor = $value->nomor;
                            $model->visi_id = $value->visi_id;
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
 
                     if(count($res_api) < count($misi))
                     {
 
                         foreach($misi as $datamisi)
                         {
                             // cek id yang terkait
                             $cekdelete = collect($res_api)->where('id', $datamisi->id)->first(); 
 
                             if(!$cekdelete)
                             {
                                 // tampung yang berubah
                                 $deleted[] = $datamisi;
                             }
 
                         }
 
 
                         if(count($deleted) > 0)
                         {
                             foreach($deleted as $hapus)
                             {
                                 $destroy = Misi::where('id', $hapus->id)->first(); 
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
                         $model = Misi::where('id', $cekupdate->id)->first(); 
 
                         // cek apakah ada yang berbeda atau ada perubahan di data api atau data di table
                         if($model->nama != $cekupdate->nama || $model->nomor != $cekupdate->nomor || $model->visi_id != $cekupdate->visi_id) 
                         {
                             // tampung yang berubah
                             $updated[] = $cekupdate;
 
                             // lakukan save atau update
                             $update = Misi::where('id', $cekupdate->id)->first();
                             $update->id = $cekupdate->id;
                            $update->nama = $cekupdate->nama;
                            $update->nomor = $cekupdate->nomor;
                            $update->visi_id = $cekupdate->visi_id;
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
                    
            } // -------------------------------------------- end if Misi -------------------------------------
            else
            {
                return Response()->json([
                    'kode' => 500,
                    'message' => 'Parameter Salah'
                ]);
            }


        }catch(\Exception $e)
        {
            return $e->getMessage();
        }


        
    }
    //  --------------------------------- end if fuction -------------------------------
}
// end if class
