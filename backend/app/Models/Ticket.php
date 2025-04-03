<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = [
        'passenger_name', 'total', 'route_unit_id', 
        'schedule_id', 'route_id', 'intermediate_destination_id'
    ];

    // Relación con ruta_unidad
    public function routeUnit()
    {
        return $this->belongsTo(RouteUnit::class, 'route_unit_id');
    }

    // Relación con horario
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    // Relación con ruta
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    // Relación con destino intermedio
    public function intermediateDestination()
    {
        return $this->belongsTo(IntermediateDestination::class, 'intermediate_destination_id');
    }

    // Relación con detalles de ticket
    public function details()
    {
        return $this->hasMany(TicketDetail::class, 'ticket_id');
    }

    // Relación con detalles de venta
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'ticket_id');
    }
}