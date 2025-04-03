<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioUnidad extends Model
{
    protected $table = 'unit_schedules';
    
    protected $primaryKey = 'id'; 

    public $timestamps = false;

    protected $fillable = ['id_Units', 'id_Schedules', 'id_Driver', 'status', 'day'];

    public function unit()
    {
        return $this->belongsTo(Unidades::class, 'id_Units');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_Schedules');
    }

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'id_Driver');
    }
}
