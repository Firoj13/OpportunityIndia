<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTagsHi extends Model
{
    protected $table = 'seo_tags_hi';
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug','status','frequency'
    ];

    public function languageForSeoTag()
    {
        return $this->hasOne(Languages::class,'code','language_code');
    }
}
