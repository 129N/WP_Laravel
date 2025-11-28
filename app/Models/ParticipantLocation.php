<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantLocation extends Model
{
    //
    use HasFactory;

    public $timestamps = false; // we manually use created_at

    protected $fillable = [
        'event_id',
        'user_id',
        'lat',
        'lon',
        'speed',
        'heading',
        'created_at'
    ];

    public function user() {
        return $this->belongsTo(User_react::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
