<?php

namespace App\Http\Controller\API;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Permen90Controller extends Controller
{

    public function mapping_all()
    {
        $url = '192.168.3.125/e-planning/api-permen90/all';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        return $res_api;
        
    }
    
}

