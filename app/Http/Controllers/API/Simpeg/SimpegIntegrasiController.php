<?php

namespace App\Http\Controllers\API\Simpeg;

use DB;
use App\Models\Organisasi;
use App\Models\Pegawai;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SimpegIntegrasiController extends Controller
{
	public static function index()
	{

	    $curl = curl_init();

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => "192.168.15.10/web-service/index.php/api/pegawai/utama?SIMPEG-KEY=simpeg@merant1",
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_HTTPHEADER => array(
	        "Authorization: Basic d2Vic2VydmljZV9zaW1wZWc6c2ltcGVnQG1lcmFudDE="
	      )
	    ));

	    $response = curl_exec($curl);
	    curl_close($curl);

	    $decode = json_decode($response);

	    $data_api = $decode->data;


	    $jumlah_data_api = count($data_api);
	    $jumlah_data_db = Pegawai::get()->count();


	    // jika table kosong
	    if ($jumlah_data_db < 1) {

	    	foreach ($data_api as $value) {
	    		$insert = new Pegawai;
	    		$insert->id_api = $value->id;
	    		$insert->nip = $value->nip;
	    		$insert->golongan = $value->nm_gol;
	    		$insert->nama = $value->nama;
	    		$insert->pangkat = $value->nm_pangkat;
	    		$insert->jabatan = $value->jabatan;
	    		$insert->organisasi_nama = $value->nm_unit;
	    		$insert->kelompok_jabatan = $value->kelompok_jbt;
	    		$insert->save();
	    	}

	    	return response()->json([
	    		'code' => 200,
	    		'message' => 'insert all success',
	    		'data' => []
	    	]);
	    }
	    // jika jumlah data api lebih besar dari data db
	    elseif ($jumlah_data_api > $jumlah_data_db) {

	    	$pegawais = Pegawai::get();

	    	// def array
	    	$res= [];
            $cekapi = [];
            $cekapi2 = [];
            $no = 0;

            // get id yang sudah ada pada table
            foreach($pegawais as $data)
            {
                $cekapi[] = $data->id_api;
            }

            // cek id yang tidak ada
            foreach($data_api as $data)
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
                $insert = collect($data_api)->where('id', $getid['id']);

                // memecah array multidimensi untuk mengambil value 
                foreach($insert as $key => $value)
                {
                    $add = new Pegawai;
		    		$add->id_api = $value->id;
		    		$add->nip = $value->nip;
		    		$add->golongan = $value->nm_gol;
		    		$add->nama = $value->nama;
		    		$add->pangkat = $value->nm_pangkat;
		    		$add->jabatan = $value->jabatan;
		    		$add->organisasi_nama = $value->nm_unit;
		    		$add->kelompok_jabatan = $value->kelompok_jbt;
		    		$add->save();

		    		$res[] = $add;
                
                }
                
                
            }


            // respone
            return response()->json([
                'status' => 200,
                'message' => count($res).' Data baru berhasil di tambahkan',
                'data' => collect($res)->take(10)
            ]);

	    }else{
	    	
	    	$res = [];

	    	foreach ($data_api as $value) {
	    		$cek = Pegawai::where('id_api', $value->id)->first();

	    		if($cek)
	    		{
	    			if($cek->id_api != $value->id 
		    			|| $cek->nip != $value->nip 
		    			|| $cek->golongan != $value->nm_gol 
		    			|| $cek->nama != $value->nama 
		    			|| $cek->jabatan != $value->jabatan 
		    			|| $cek->organisasi_nama != $value->nm_unit)
		    		{
	    				$res[] = $value;

	    				$update = Pegawai::where('id_api', $value->id)->first();;
			    		$update->id_api = $value->id;
			    		$update->nip = $value->nip;
			    		$update->golongan = $value->nm_gol;
			    		$update->nama = $value->nama;
			    		$update->pangkat = $value->nm_pangkat;
			    		$update->jabatan = $value->jabatan;
			    		$update->organisasi_nama = $value->nm_unit;
			    		$update->kelompok_jabatan = $value->kelompok_jbt;
			    		$update->save();
	    			}
	    		}
	    	}

	    	// respone
            return response()->json([
                'status' => 200,
                'message' => count($res).' Data baru berhasil di Update',
                'data' => collect($res)->take(10)
            ]);


            // return response()->json([
            //     'status' => 200,
            //     'message' => 'get all data db',
            //     'data' => Pegawai::get()
            // ]);
	    }
	}
}
