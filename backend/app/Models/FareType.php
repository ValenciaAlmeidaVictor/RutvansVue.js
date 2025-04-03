<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FareType extends Model
{
    protected $table = 'fare_types';
    protected $fillable = ['name', 'percentage', 'description'];

    // Relación con detalles de ticket
    public function ticketDetails()
    {
        return $this->hasMany(TicketDetail::class, 'fare_type_id');
    }
}