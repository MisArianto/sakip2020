<?php

namespace App\Http\Controllers\API\Simpeg;

use DB;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JabatanSimpegController extends Controller
{

    public function index()
    {
        // hapus data seluruh
        DB::table('jabatan_simpeg_smt')->truncate();

        // get pegawai
        $data = Pegawai::select('jabatan')
                     ->where('jabatan', '!=', '')
                     ->distinct()
                     ->get();

        // insert
        foreach ($data as $dt) {
            DB::table('jabatan_simpeg_smt')->insert([
             'jabatan_nama' => $dt->jabatan
            ]);
        }

        // get data
        $getJ = DB::table('jabatan_simpeg_smt')->get();

        $ada = [];
        $tidak = [];
        $res = [];

        foreach ($getJ as $value) {
         $getJJ = DB::table('jabatan_simpeg')->where('jabatan_nama', $value->jabatan_nama)->first();

         if($getJJ)
         {
             $ada[] = $value;
         }else{

             $tidak[] = $value;
         }
        }

        foreach ($tidak as $key) {
         DB::table('jabatan_simpeg')->insert([
             'jabatan_nama' => $key->jabatan_nama
            ]);

         $res[] = $key;
        }

        return response([
            'message' => count($res).' Data pejabat sukses di integrasikan',
            'data' => collect($res)->take(10),
            'code' => 200
        ]);

    }
    //  --------------------------------- end if fuction -------------------------------
}
// end if class
