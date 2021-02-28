<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerjanjianKinerja extends Model
{
    protected $table='perjanjian_kinerja';

    protected $fillable = ['indikator_sasaran_id','tahun','target','pagu'];
}
