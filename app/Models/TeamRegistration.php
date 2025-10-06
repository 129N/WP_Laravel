<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamRegistration extends Model
{
    //
    use HasFactory;

    protected $fillable = ['team_code','event_id', 'leader_id', 'team_name', 'status'];

    protected static function boot(){

        parent::boot();

        static::creating( function ($team){
            //generare code with string TEAM001
            $latest = TeamRegistration::latest('id')->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $team-> team_code = 'TEAM'. str_pad($nextId, 3, '0', STR_PAD_LEFT);
        });

    }

    //Foreing ID decalration
    public function event(){
        return $this-> belongsTo(Event::class, 'event_id');
    }

    public function leader(){
        return $this->belongsTo(User_react::class, 'leader_id');
    }

    public function members(){
        return $this-> belongsTo(TeamMember::class, 'team_registration_id' );
    }
}
