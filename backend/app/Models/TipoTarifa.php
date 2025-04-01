<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTarifa extends Model
{
    protected $table = 'fare_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'percentage',
        'description'
    ];
}
