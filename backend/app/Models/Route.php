<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'routes';
    protected $fillable = ['fare_id', 'origin_locality_id', 'destination_locality_id'];

    // Relación con localidad origen
    public function originLocality()
    {
        return $this->belongsTo(Locality::class, 'origin_locality_id');
    }

    // Relación con localidad destino
    public function destinationLocality()
    {
        return $this->belongsTo(Locality::class, 'destination_locality_id');
    }

    // Relación con destinos intermedios
    public function intermediateDestinations()
    {
        return $this->hasMany(IntermediateDestination::class, 'route_id');
    }

    // Relación con rutas_unidades
    public function routeUnits()
    {
        return $this->hasMany(RouteUnit::class, 'route_id');
    }

    // Relación con tarifa (asumiendo que existe un modelo Fare)
    public function fare()
    {
        return $this->belongsTo(Fare::class, 'fare_id');
    }
}