<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'schedules';

    // Definir los nombres de las columnas correctas
    protected $fillable = ['departure_time', 'arrival_time', 'day'];

    // Si la base de datos usa nombres de columna diferentes a las propiedades del modelo
    public function getDepartureTimeAttribute($value)
    {
        return $value;  // Puedes hacer transformaciones si es necesario
    }

    public function setDepartureTimeAttribute($value)
    {
        $this->attributes['departure_time'] = $value;
    }

    // Puedes definir otros accesores y mutadores si es necesario
}


