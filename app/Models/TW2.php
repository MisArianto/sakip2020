<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TW2 extends Model
{
    protected $table = 'triwulan2';

    protected $fillable = [
    	'capaian_sasaran_id',
    	'target',
    	'kinerja',
    	'anggaran',
    	'rekomendasi'
    ];
}
