<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';
    
    protected $fillable = [
        'name',
        'id_RouteUnit',
        'id_Schedules',
        'id_Units' // Agregado para relación directa con unidad
    ];

    // Relación con la unidad asignada
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_Units');
    }

    // Relación con la ruta_unidad
    public function routeUnit()
    {
        return $this->belongsTo(RouteUnit::class, 'id_RouteUnit');
    }

    // Relación con el horario
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_Schedules');
    }

    // Relación con los horarios de unidad (a través de unit_schedules)
    public function unitSchedules()
    {
        return $this->hasMany(UnitSchedule::class, 'id_Driver');
    }

    /**
     * Obtener los horarios activos del conductor para hoy
     */
    public function activeSchedulesToday()
    {
        return $this->unitSchedules()
            ->where('status', 'active')
            ->whereDate('day', now()->toDateString())
            ->with('schedule');
    }
}