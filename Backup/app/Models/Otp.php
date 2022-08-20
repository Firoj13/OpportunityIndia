<?php

namespace App\Models;

use App\textlocal\Textlocal;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{   
	protected $primaryKey = 'otp_id';
    
    protected $table = 'mobile_otps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','mobile', 'otp'
    ];
}
