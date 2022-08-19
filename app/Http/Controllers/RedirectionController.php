<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectionController extends Controller
{
    //
    public function redirectContentPage(Request $request)
    {
        $slug = $request->slug;

        if(str_contains($slug, '.n')) {
            $slugData = explode('.', $slug);
            $checkArticle = \App\Models\ArticleListEn::query()
                ->where('old_ref_id', str_replace('n', '', $slugData[1]))
                ->where('status', 1)
                ->first();
            if(!empty($checkArticle)) {
                return \redirect('/article/'.str_slug($checkArticle->title).'-'.$checkArticle->id, 301);
            }
            return \redirect('/', 301);
        }
    }
    public function hindiRedirectContentPage(Request $request)
    {
        $slug = $request->slug;
        if(str_contains($slug, '.n')) {
            $slugData = explode('.', $slug);
            $checkArticle = \App\Models\ArticleListHi::query()
                ->where('old_ref_id', str_replace('n', '', $slugData[1]))
                ->where('status', 1)
                ->first();
            if(!empty($checkArticle)) {
                return \redirect('/hindi/article/'.($checkArticle->title).'-'.$checkArticle->id, 301);
            }
            return \redirect('/', 301);
        }
    }

}
