<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TW1 extends Model
{
    protected $table = 'triwulan1';

    protected $fillable = [
    	'capaian_sasaran_id',
    	'target',
    	'kinerja',
    	'anggaran',
    	'rekomendasi'
    ];
}
