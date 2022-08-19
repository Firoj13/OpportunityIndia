<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    use HasFactory;
    
    protected $table = 'brand_locations';

    protected $fillable = [
        'brand_id','state_id', 'city_id'
    ];

    public function Brand(){
        return $this->belongsTo(Brand::class);
    }
	
	public function State()
    {
        return $this->belongsTo(State::class);
    }

	public function City()
    {
        return $this->belongsTo(City::class);
    }
	
	public function brandLocations($brandId)
    {
		return DB::table('brand_locations')
        ->join('states', 'states.id', '=', 'brand_locations.state_id')
        ->select('states.name','states.region')
        ->where('brand_id',$brandId)
        ->get();
    }
}
