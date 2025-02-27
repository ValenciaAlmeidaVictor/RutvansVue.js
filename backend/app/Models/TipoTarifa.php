<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTarifa extends Model
{
    // Especificar la tabla en la base de datos
    protected $table = 'tipos_tarifas';

    // Definir la clave primaria si no es 'id'
    protected $primaryKey = 'idTipoTarifa';

    // Permitir la asignación masiva en estos campos
    protected $fillable = ['nombreTarifa', 'porcentajeTarifa', 'descripcion'];

    // Deshabilitar timestamps si la tabla no tiene 'created_at' y 'updated_at'
    public $timestamps = false;

    // Especificar el tipo de clave primaria si no es un entero
    protected $keyType = 'int';

    // Relación con otra tabla (Ejemplo: una tarifa puede pertenecer a una categoría)
    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class, 'categoria_id');
    // }

    // Mutator para asegurarse de que el porcentaje se almacene como decimal con 2 decimales
    public function setPorcentajeTarifaAttribute($value)
    {
        $this->attributes['porcentajeTarifa'] = number_format($value, 2, '.', '');
    }

    // Accessor para formatear el porcentaje al obtenerlo
    public function getPorcentajeTarifaAttribute($value)
    {
        return number_format($value, 2) ;
    }


}
