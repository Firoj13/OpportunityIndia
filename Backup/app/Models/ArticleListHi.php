<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleListHi extends Model
{
    use HasFactory;
    protected $table = 'article_list_hi';
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
        'total_views',
        'audio_id',
        'status',
        'is_slider',
        'is_noindexnofollow',
        'updated_by',
        'published_at',
        'created_at',
        'updated_at'
    ];

    public function getTagName(){
        return $this->hasOne(SeoTagsHi::class,'id','primary_tag_id');
    }
    public function getAuthorName(){
        return $this->hasOne(AuthorList::class,'id','author_id');
    }
    public function getAudioFiles(){
        return $this->hasOne(AudioFile::class,'id','audio_id');
    }
    public function getAssocTags(){
        return $this->hasMany(HindiContentAssignedTag::class,'content_id','id');
    }


}
