<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


// API token 
use Laravel\Sanctum\HasApiTokens;
class User_react extends Model
{
    //
    protected $fillable = ['email', 'password', 'role'];

    use HasApiTokens, Notifiable;

    protected $hidden =[
        'password',
        'remeber_token',
    ];

}
