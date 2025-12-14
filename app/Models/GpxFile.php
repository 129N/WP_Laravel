<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpxFile extends Model
{
    //
    protected $fillable = [
        'route_name', 'uploaded_by',
    ];

    public function points()
    {
        //return $this->hasMany(WP_react::class, 'gpx_file_id');
        return $this->hasMany(GpxPoint::class, 'gpx_file_id');
    }
    
}
