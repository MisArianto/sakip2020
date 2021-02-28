<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    protected $table='misi';
    
    public function tujuan() {
         return $this->hasMany('App\Models\TujuanRpjmd','misi_id','id');
    }

    // public function visi() {
    //     return $this->belongsTo('App\Models\Visi', 'visi_id');
    // }
}
