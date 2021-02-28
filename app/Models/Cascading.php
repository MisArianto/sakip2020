<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cascading extends Model
{
    protected $table = 'cascading';

    protected $fillable = [
    	'nama_file',
    	'organisasi_no',
    	'tahun',
    	'keterangan'
    ];
}
