<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntermediateDestination extends Model
{
    // Define table, primary key, and other properties if necessary
    protected $table = 'intermediate_destinations'; // Example: change this to your actual table name
    protected $primaryKey = 'id';
    public $timestamps = true;

    // You can define fillable or guarded attributes here
    protected $fillable = ['column1', 'column2']; // Update with your column names
}
