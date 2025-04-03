<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteUnit extends Model
{
    protected $table = 'route_unit';
    protected $fillable = ['date', 'route_id', 'unit_id', 'schedule_id'];

    // Relación con ruta
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    // Relación con unidad
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    // Relación con horario
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    // Relación con tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'route_unit_id');
    }

    // Relación con envíos
    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'route_unit_id');
    }
}