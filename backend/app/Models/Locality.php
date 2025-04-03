<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    protected $table = 'localities';
    protected $fillable = ['name'];

    // Relación con rutas como origen
    public function routesAsOrigin()
    {
        return $this->hasMany(Route::class, 'origin_locality_id');
    }

    // Relación con rutas como destino
    public function routesAsDestination()
    {
        return $this->hasMany(Route::class, 'destination_locality_id');
    }
}