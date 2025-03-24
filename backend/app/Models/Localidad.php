<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla
    protected $table = 'localities';

    // Define las columnas que pueden ser asignadas masivamente
    protected $fillable = ['name'];

    // Especifica que 'id' es la clave primaria en lugar de 'idLocalidad'
    protected $primaryKey = 'id';
}
