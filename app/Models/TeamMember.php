<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    //
    use HasFactory;

    protected $fillable = ['team_registration_id', 'member_name', 'member_email', 'role', 'member_id'];

    public function team(){
        return $this-> belongsTo(TeamRegistration::class, 'team_registration_id' );
    }

        public function member(){
        return $this-> belongsTo(User_react::class, 'member_id' );
    }
}

