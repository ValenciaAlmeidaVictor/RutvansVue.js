<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $table = 'origins'; // Asegúrate de que la tabla se llame 'origins' si es eso lo que usas.

    // Relación inversa (si es necesario)
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'origin_id');
    }
}
