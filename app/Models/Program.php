<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table='program';

    protected $guarded = [];
    // protected $primaryKey = ['idprgrm'];

    public function organisasiProgram() {
        return $this->belongsTo('App\Models\Organisasi', 'organisasi_no');
    }
}
