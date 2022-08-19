<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandMembership extends Model
{
    use HasFactory;

	protected $table = 'brand_memberships';
	
	protected $fillable = [
        'id','brand_id','company_name', 'membership_plan', 'activation_date','is_active','expiry_date','payment_id', 'created_at'];
    

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id','brand_id');
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class,'plan_id','plan_id');
    }

}
