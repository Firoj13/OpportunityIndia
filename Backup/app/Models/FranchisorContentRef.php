<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchisorContentRef extends Model
{
    use HasFactory;
    protected $table = 'franchisor_content_ref';
    protected $fillable =
        [
            'franchisor_id',
            'content_type',
            'content_id',
            'language_code'
        ];
}
