<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \Venturecraft\Revisionable\RevisionableTrait;

class Lead extends Model
{
    use HasFactory;
    use RevisionableTrait;

    protected $primaryKey = 'lead_id';

    protected $fillable = ['user_id','lead_type','status','created_at'];

    public function detail() {

        return $this->hasMany(LeadDetail::class,'lead_id', 'lead_id');
            
    }

    public function buyer()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function supplier()
    {
        return $this->hasOne(LeadSupplier::class,'lead_id', 'lead_id');
    }

	public function getFreeLeadCount($brandId){
		$currentMonth = date('m');
		$count = $this->where('MONTH(created_at)', '=', $currentMonth)->count();
		
	}
}
