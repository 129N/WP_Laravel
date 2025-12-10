<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WP_react extends Model
{
    // 'event_id' has been added to the table newly.
    protected $fillable = [
        'type', 'lat', 'lon', 'name', 'desc', 'ele', 'event_id',
         'gpx_file_id', // NEW 
    ];

    // The event has many WP_React models
    public function event() {
        return $this->belongsTo(Event::class);
    }

     public function gpxFile() {
        return $this->belongsTo(GpxFile::class, 'gpx_file_id');
    }
}
//2025_11_28_110216_add_event_id_to_w_p_reacts_table.php