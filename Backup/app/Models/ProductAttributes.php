<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory;

    protected $table = 'brand_products_attributes';

	protected $hidden = [
        'product_attr_id', 'created_at', 'updated_at', 'status'
    ];
	
	protected $fillable = ['product_attr_id','product_id','attribute_column','attribute_value'];

}
