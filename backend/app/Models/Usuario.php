<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = [
        'nombreUsuario',
        'password',
        'idRol',
    ];

    protected $hidden = [
        'password',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol', 'idRol');
    }
}