<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



// API token 
use Laravel\Sanctum\HasApiTokens;
class User_react extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $fillable = ['email', 'password', 'role'];

    protected $hidden =[
        // 'password',
        'remember_token',
    ];

}
