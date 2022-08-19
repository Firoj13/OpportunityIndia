<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class BrandLanguage extends Model
{
    use HasFactory;    

    use RevisionableTrait;

    protected $table = 'brand_language';
    
    protected $primaryKey = 'id';

    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language','company_name','brand_name','comp_desc', 'comp_detail' 
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id','brand_id');
    }

}
