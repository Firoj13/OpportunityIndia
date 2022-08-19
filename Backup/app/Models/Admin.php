<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

use App\Permissions\HasPermissionsTrait;

use Illuminate\Foundation\Auth\User as Model;

class Admin extends Model
{
    use HasFactory;
    
    use HasPermissionsTrait; //Import The Trait
 	
 	protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
