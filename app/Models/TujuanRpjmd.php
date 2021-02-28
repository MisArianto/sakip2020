<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TujuanRpjmd extends Model
{
    protected $table='tujuan_rpjmd';

    public function misi() {
        return $this->belongsTo('App\Models\Misi', 'misi_id');
    }
}
