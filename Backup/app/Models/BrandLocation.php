<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class BrandLocation extends Model
{
    use HasFactory;

    protected $table = 'brand_locations';

	protected $fillable = ['brand_id','state_id','city_id'];

	public function State(){
        return $this->belongsTo('State');
    }
	
	public function City(){
        return $this->belongsTo('City');
    }    
}
