<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use HasFactory;

    protected $table = 'brand_products_media';
	
	protected $primaryKey = 'product_media_id';
	
	public $timestamps = false;
	
	protected $fillable = ['product_media_id','product_id','product_media_type','media_url','media_description'];
    
	protected $hidden = [
        'product_media_id','product_id','product_media_type','status'
    ];

	public function Product()
    {
        return $this->belongTo('App\Models\Product');
    }
}
