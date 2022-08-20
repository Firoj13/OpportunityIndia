<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\ArticleListHi;
use App\Models\ArticleListEn;
use App\Models\SeoTagsEn;
use App\Models\SeoTagsHi;



class IndexAPIController extends Controller
{  

    /**
     * @param Request $request
     * @return category wise articles list
     */
    public function getCategoryArticlesList(Request $request)
    {
        if ($request->slug) {
            $slug = filter_var($request->slug, FILTER_SANITIZE_STRING);
            $catexist = SeoTagsEn::query()->where('slug', str_slug($slug))->first();
            if (is_null($catexist))  return response($this->status(404, true, __('Category not found')), 404);
        }

        $articlesList = ArticleListEn::query()->select('title','id','image_path','short_desc','author_id')->where('primary_tag_id', $catexist->id)->where('status', 1)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
//dd($articlesList);
        foreach($articlesList as $key => $article){
         
      $response[] = [
              "title"=> $article->title,
              "url"=> 'https://opportunityindia.franchiseindia.com/article/'.str_slug($article->title).'-'.$article->id,
              "image"=> IndexController::createimgurl($article->image_path),
              "description"=> strip_tags(str_limit($article->short_desc, 65 , ' ..')),
              "author"=> ($article->author_id!=null) ? $article->getAuthorName->name : "",
              "authorDesignation"=> ($article->author_id!=null) ? $article->getAuthorName->designation : "",
            ];
        }    

        if(!empty($response))
        {
            return response()->json(array_merge($this->status(), ['articles' => $response]));
        }else{
               return response($this->status(404,true,__('Article not found')),404);
        }
       
    }


     public function status($code=200,$error=false,$message=""){
        return array(
          'code'=>$code,
          'error'=>$error,
          'message'=>$message
        );
    }

}
