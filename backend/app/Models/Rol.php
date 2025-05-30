<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'idRol';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'idRol', 'idRol');
    }
}