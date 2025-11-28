<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Notification extends Model
{
    //migrations\2025_05_14_200958_create_notifications_table.php
      use HasFactory;

    protected $fillable = [
      'event_id',
      'participant_id',
      'type',
      'message'
    ];

    public function event() {
      return $this -> belongsTo(Event::class);
    }

    public function participant(){
      return $this -> belongsTo(User_react::class);
    }
}