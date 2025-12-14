<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpxPoint extends Model
{
    //
     protected $fillable = [
        'gpx_file_id',
        'type',
        'lat',
        'lon',
        'name',
        'desc',
        'ele',
    ];

    public function gpxFile()
    {
        return $this->belongsTo(GpxFile::class);
    }
}
