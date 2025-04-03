<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'plate',
        'brand',
        'capacitance',
        'model',
        'year',
        'unit_image',
    ];
}
