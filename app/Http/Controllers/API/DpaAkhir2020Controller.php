<?php

namespace App\Http\Controllers\API;

use DB;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DpaAkhir2020Controller extends Controller
{
    

    public function index()
    {
    	$orgs = Organisasi::where('organisasi_jenis', 'ORG')->get();

    	foreach ($orgs as $value) {
    		
	    	$curl = curl_init();

		    curl_setopt_array($curl, array(
		      CURLOPT_URL => "192.168.15.15/2020/api/kegiatan/".$value->organisasi_no,
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 0,
		      CURLOPT_FOLLOWLOCATION => true,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "GET",
		      // CURLOPT_HTTPHEADER => array(
		      //   "Authorization: Basic d2Vic2VydmljZV9zaW1wZWc6c2ltcGVnQG1lcmFudDE="
		      // )
		    ));

		    $response = curl_exec($curl);
		    curl_close($curl);

		    $decode = json_decode($response);

		    $jumlah_data_api = collect($decode)->count();
		    $jumlah_data_dpa = DB::table('dpa')->where('kode_organisasi', $value->organisasi_no)->get()->count();

		    if($jumlah_data_dpa < 1)
		    {
		    	foreach ($decode as $value1) {
				    DB::table('dpa')->insert([
				    	'kode_urusan' => $value1->kode_urusan,
				    	'nama_urusan' => $value1->nama_urusan,
				    	'kode_organisasi' => $value1->kode_organisasi,
				    	'nama_organisasi' => $value1->nama_organisasi,
				    	'kode_program' => $value1->kode_program,
				    	'nama_program' => $value1->nama_program,
				    	'kode_kegiatan' => $value1->kode_kegiatan,
				    	'nama_kegiatan' => $value1->nama_kegiatan,
				    	'pagu' => $value1->pagu
				    ]);
			    }
		    }

		    


		}
    }
}
