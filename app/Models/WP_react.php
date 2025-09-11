<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WP_react extends Model
{
    //
    protected $fillable = [
        'type', 'lat', 'lon', 'name', 'desc', 'ele'
    ];
}
