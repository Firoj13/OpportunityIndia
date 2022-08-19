<?php

namespace App\Http\Controllers\Apidata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Models\ArticleListHi;
use App\Models\ArticleListEn;
use App\Models\SeoTagsEn;
use App\Models\SeoTagsHi;
use Illuminate\Support\Facades\Session;
use App\Models\ContactUs;
use App\Models\FeedbackList;
use App\Mail\ContactUsMail;
use App\Mail\SiteFeedbackMail;

class Homedata extends Controller
{
    public function getslider()
    {
        $sliderArticles = ArticleListEn::query()->select('id', 'title', 'short_desc', 'image_path', 'created_at', 'author_id', 'primary_tag_id')->where('status', 1)->whereNotNull('is_slider')->orderByDesc('is_slider')->limit(5)->get();
        return $sliderArticles;
    }
}
