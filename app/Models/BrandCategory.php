<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandCategory extends Model
{
    use HasFactory;

    protected $table = 'brand_categories';

	protected $fillable = ['brand_id','industry_id','sector_id','mapping_type'];
	
	public $timestamps = false;

	public function industry()
    {
        return $this->belongsTo(Category::class);
    }

	public function sector()
    {
        return $this->belongsTo(Category::class);
    }
}
