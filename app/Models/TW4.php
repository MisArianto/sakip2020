<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TW4 extends Model
{
    protected $table = 'triwulan4';

    protected $fillable = [
    	'capaian_sasaran_id',
    	'target',
    	'kinerja',
    	'anggaran',
    	'rekomendasi'
    ];
}
