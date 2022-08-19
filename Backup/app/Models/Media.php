<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'brand_media';
    
	protected $fillable = ['brand_id','media_type','media_subtype','media_url'];
}
