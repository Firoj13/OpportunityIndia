<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class CategoryLanguage extends Model
{
    use HasFactory;    

    use RevisionableTrait;

    protected $table = 'category_language';
    
    protected $primaryKey = 'id';

    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name','meta_title','meta_description', 'meta_keywords' 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','category_id');
    }

}
