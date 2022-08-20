<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

	protected $table = 'membership_plans';
	

    public function membership()
    {
        return $this->belongsTo(Membership::class,'parent_id','id');
    }

}
