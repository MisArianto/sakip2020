<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianSasaranOpd extends Model
{
    protected $table = 'capaian_sasaran_opd';

    protected $fillable = [
    	'indikator_sasaran_id',
    	'organisasi_no',
    	'tahun'
    ];	
}
