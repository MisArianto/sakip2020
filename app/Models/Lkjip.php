<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lkjip extends Model
{
    protected $table = 'dok_lkjip';

    protected $fillable = [
    	'nama_file',
    	'tahun',
    	'organisasi_no'
    ];
}
