<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackPoint extends Model
{
    //
    
    protected $fillable = [
    'latitude',
    'longitude',
    'waypoint_order', // or similar
    'participant_id', // if linked to a participant
    'passed_at',      // timestamp if needed
];
}
