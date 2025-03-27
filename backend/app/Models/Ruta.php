<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = "routes";

    protected $primaryKey = 'id';

    protected $fillable = [
    'fare_id',
    'origin_locality_id',
    'destination_locality_id',

    ];



    public function origin_locality()
    {

        return $this->belongsTo(Localidad::class, 'origin_locality_id', 'id');
    }


    public function destination_locality()
    {

        return $this->belongsTo(Localidad::class, 'fare_id', 'id');
    }

    public function shipment()
    {

        return $this->HasMany(Envio::class, 'id');
    }

    // public function fare()
    // {

    //     return $this->belongsTo(Tarifa::class, 'origin_locality_id', 'id');
    // }

}