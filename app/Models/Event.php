<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // $registrations = $event->registrations;
    // “Give me all registration records linked to this event.”
    use HasFactory;

    protected $fillable = [
        'EventTitle',
        'description',
        'event_date',
        'created_by',
        'event_creatorName'
    ];

    public function registrations() {
        return $this->hasMany(EventRegistration::class);
    }


    public function creator(){
        return $this->belongsTo(User_react::class, 'created_by');
    }
}
