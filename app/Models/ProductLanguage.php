<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class productLanguage extends Model
{
    use HasFactory;    

    use RevisionableTrait;

    protected $table = 'brand_product_language';
    
    protected $primaryKey = 'id';

    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language','product_name','description' 
    ];

    public function product()
    {
        return $this->belongsTo(product::class,'product_id','product_id');
    }

}
