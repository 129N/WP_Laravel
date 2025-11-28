<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WP_react extends Model
{
    // 'event_id' has been added to the table newly.
    protected $fillable = [
        'type', 'lat', 'lon', 'name', 'desc', 'ele', 'event_id',
    ];

    // The event has many WP_React models
    public function event() {
        return $this->belongsTo(Event::class);
    }
}
