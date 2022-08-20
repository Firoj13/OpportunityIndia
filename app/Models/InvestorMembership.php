<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorMembership extends Model
{
    use HasFactory;

	protected $table = 'inverstor_memberships';
	
	protected $fillable = [
        'id','user_id','membership_plan', 'activation_date','is_active','expiry_date','payment_id', 'created_at'];
    

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class,'plan_id','plan_id');
    }

}
