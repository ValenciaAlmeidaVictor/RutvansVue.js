<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UnitSchedule extends Model
{
    protected $table = 'unit_schedules';
    
    protected $fillable = [
        'id_Units',
        'id_Schedules',
        'id_Driver',
        'status',
        'day'
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    // Relación con la unidad
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_Units');
    }

    // Relación con el horario
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_Schedules');
    }

    // Relación con el conductor
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'id_Driver');
    }

    // Relación con ruta_unidad (asumiendo que hay una relación)
    public function routeUnit()
    {
        return $this->hasOne(RouteUnit::class, 'unit_id', 'id_Units');
    }

    /**
     * Scope para filtrar horarios activos
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope para filtrar por día específico
     */
    public function scopeForDay(Builder $query, $date)
    {
        return $query->whereDate('day', $date);
    }

    /**
     * Scope para filtrar horarios de hoy
     */
    public function scopeToday(Builder $query)
    {
        return $query->whereDate('day', now()->toDateString());
    }

    /**
     * Verifica si el horario está activo para hoy
     */
    public function isActiveToday()
    {
        return $this->status === 'active' && 
               $this->day->isToday();
    }

    /**
     * Obtener la información completa del viaje asociado
     */
    public function getTripInfoAttribute()
    {
        return [
            'unit' => $this->unit,
            'schedule' => $this->schedule,
            'driver' => $this->driver,
            'route' => $this->routeUnit->route ?? null,
            'status' => $this->status,
            'day' => $this->day->format('Y-m-d')
        ];
    }
}