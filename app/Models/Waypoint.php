<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waypoint extends Model
{
    //

    protected $fillable = [
      'name', 'latitude', 'longitude', 'elevation', 'time',
    ];
}
