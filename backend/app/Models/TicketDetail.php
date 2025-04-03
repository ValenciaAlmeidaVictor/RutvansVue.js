<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    protected $table = 'ticket_details';
    protected $fillable = ['seat_number', 'seat_price', 'ticket_id', 'fare_type_id'];

    // Relación con ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relación con tipo de tarifa
    public function fareType()
    {
        return $this->belongsTo(FareType::class, 'fare_type_id');
    }
}