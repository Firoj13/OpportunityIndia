<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorList extends Model
{
    use HasFactory;
    protected $table = 'authors';
    protected $fillable =
        [
            'name',
            'company',
            'designation',
            'address',
            'image_path',
            'phone_number',
            'linkedin_profile',
            'fb_profile',
            'twitter_profile',
            'intro_desc',
            'email',
            'slug',
            'status'
        ];
}
