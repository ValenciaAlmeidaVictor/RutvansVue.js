<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoIntermedio extends Model
{
    use HasFactory;

    protected $table = 'intermediate_destinations';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'route_id'];

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
}