<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTagsEn extends Model
{
    protected $table = 'seo_tags_en';
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug','language_code','frequency'
    ];

    public function languageForSeoTag()
    {
        return $this->hasOne(Languages::class,'code','language_code');
    }
}
