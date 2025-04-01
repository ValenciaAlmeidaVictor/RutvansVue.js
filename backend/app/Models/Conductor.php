<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    protected $table = "drivers";

    protected $primaryKey = 'id';

    protected $fillable = [
    'name',
    'id_RouteUnit',
    'id_Schedules',

    ];





    public function schedules()
    {

        return $this->belongsTo(Horario::class, 'id_Schedules', 'id');
    }

    public function route_unit()
    {

        return $this->belongsTo(RutaUnidad::class, 'id_RouteUnit', 'id');
    }


}