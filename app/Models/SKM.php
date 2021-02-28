<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKM extends Model
{
    protected $table = 'skm';

    protected $fillable = [
    	'email',
    	'jk',
    	'pendidikan',
    	'usia',
    	'jawaban',
    	'tgl_survei',
    	'jam_survei',
    	'jenis_layanan'
    ];
}
