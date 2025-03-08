<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoIntermedio extends Model
{
    use HasFactory;
    protected $table = 'destinos_intermedios';
    protected $primaryKey = 'idDestinoIntermedio'; 
    public $incrementing = false;
    protected $keyType = 'string'; 
}


