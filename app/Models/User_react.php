<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


// API token 
use Laravel\Sanctum\HasApiTokens;
class User_react extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $fillable = ['email', 'password', 'role'];

    protected $hidden =[
        'password',
        'remeber_token',
    ];

}
