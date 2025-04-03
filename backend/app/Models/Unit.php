<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';
    protected $fillable = [
        'plate', 'capacitance', 'brand', 'model', 'year', 'unit_image'
    ];

    // Relación con conductores
    public function driver()
    {
        return $this->hasOne(Driver::class, 'id_RouteUnit');
    }

    // Relación con rutas_unidades
    public function routeUnits()
    {
        return $this->hasMany(RouteUnit::class, 'unit_id');
    }

    // Relación con horarios a través de unit_schedules
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'unit_schedules', 'id_Units', 'id_Schedules');
    }
}