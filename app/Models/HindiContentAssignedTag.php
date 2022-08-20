<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HindiContentAssignedTag extends Model
{
    use HasFactory;
    protected $table =  'content_assigned_tags_hi';
    protected $fillable =
        [
            'content_id',
            'tag_id',
            'sequence_order',
            'content_type'
        ];
    public function getTagsID(){
        return $this->hasOne(SeoTagsHi::class,'id','tag_id');
    }
}
