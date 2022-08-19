<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentAssignedTag extends Model
{
    use HasFactory;
    protected $table = 'content_assigned_tags_en';
    protected $fillable =
        [
            'content_id',
            'tag_id',
            'sequence_order',
            'content_type'
        ];
    public function getTagsID(){
        return $this->hasOne(SeoTagsEn::class,'id','tag_id');
    }
}
