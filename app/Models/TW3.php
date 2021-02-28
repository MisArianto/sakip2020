<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TW3 extends Model
{
    protected $table = 'triwulan3';

    protected $fillable = [
    	'capaian_sasaran_id',
    	'target',
    	'kinerja',
    	'anggaran',
    	'rekomendasi'
    ];
}
