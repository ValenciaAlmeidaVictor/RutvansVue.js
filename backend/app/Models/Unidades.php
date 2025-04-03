<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    use HasFactory;

    protected $table = 'units';
    
    protected $primaryKey = 'id'; // Especificar la clave primaria
    public $timestamps = true; // Indica que usa created_at y updated_at

    protected $fillable = ['plate',	'capacitance', 'brand',	'model', 'year'];
}
