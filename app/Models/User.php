<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;
    


    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','mobile', 'email', 'first_name','last_name','name','password','user_type', 'is_active','is_verified','activated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id','password','api_token','verified_at','activated_at','last_logged_in','created_at','updated_at','deleted_at','brand'
    ];
    
    /**
     * Get the phone record associated with the user.
     */
    public function brand()
    {
        return $this->hasOne('App\Models\Brand');
    }	
    
	/*public function membership()
    {
		$date=date('Y-m-d');	
        return $this->hasOne('App\Models\InvestorMembership')->where('expiry_date','>',$date);
    }*/	

}