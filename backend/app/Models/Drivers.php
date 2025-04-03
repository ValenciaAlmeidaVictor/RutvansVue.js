<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
    protected $table = 'drivers';
    
    protected $primaryKey = 'id'; 

    protected $fillable = ['name', 'id_RouteUnit', 'id_Schedules'];
}
