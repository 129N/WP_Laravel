<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    // echo $registration->event->EventTitle; // event title 
    // echo $registration->user->email; // participant email

    use HasFactory;
// \2025_09_28_142455_create_event_registrations_table.php
    protected $fillable = [
        'event_id',
        'user_id',
        'group_name',
        'participant_name',
        'email',
        'status'
    ];


    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function user(){
        return $this->belongsTo(User_react::class);
    }
}
