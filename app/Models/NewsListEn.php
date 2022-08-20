<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsListEn extends Model
{
    use HasFactory;
    protected $table = 'news_list_en';
    protected $fillable = [
                        'id',
                        'site_type',
                        'title',
                        'home_title',
                        'short_desc',
                        'content',
                        'primary_tag_id',
                        'author_id',
                        'related_brand',
                        'image_path',
                        'audio_path',
                        'total_views',
                        'status',
                       'updated_by',
                       'published_at',
                       'created_at',
                       'updated_at'
                        ];

    public function getTagName(){
       return $this->hasOne(SeoTagsEn::class,'id','primary_tag_id');
    }
    public function getAuthorName(){
        return $this->hasOne(AuthorList::class,'id','author_id');
    }
    public function getAssocTags(){
        return $this->hasMany(ContentAssignedTag::class,'content_id','id');
    }
}
