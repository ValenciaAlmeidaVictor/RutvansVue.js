<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

    protected $table = 'boletos';

    protected $primaryKey = 'idBoleto';

    public $timestamps = false;

    protected $fillable = [
        'nombrePasajero',
        'total',
        'idRutaUnidad',
        'idHorario',
        'idRuta',
        'fecha',
        'idDestinoIntermedio'
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'idRuta');
    }
    
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'idHorario');
    }
    
    public function destinoIntermedio()
    {
        return $this->belongsTo(DestinoIntermedio::class, 'idDestinoIntermedio');
    }    
    
}
