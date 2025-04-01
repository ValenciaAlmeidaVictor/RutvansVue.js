<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{

    // use HasFactory;

    protected $table = "sales";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'date',
        'folio',
        'cost',
        'user_id',
        'state_id',
        'method_id',
        'origin_id',

    ];

    // Relación: Una Venta pertenece a un Usuario
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // // Relación: Una Venta tiene un Origen (Ejemplo: Tienda, Online)
    // public function origen()
    // {
    //     return $this->belongsTo(Origen::class, 'idOrigen');
    // }

    // // Relación: Una Venta tiene un Estado (Ejemplo: Pendiente, Completada)
    // public function estado()
    // {
    //     return $this->belongsTo(Estado::class, 'idEstado');
    // }

    // // Relación: Una Venta tiene un Método de Pago (Ejemplo: Tarjeta, Efectivo)
    // public function metodoPago()
    // {
    //     return $this->belongsTo(MetodoPago::class, 'idMetodo');
    // }

}