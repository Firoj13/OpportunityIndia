<?php

namespace App\Http\Controllers\Frontend;

use App\Models\NewsListEn;
use App\Models\NewsListHi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use App\Models\AuthorList;
use App\Models\ArticleListEn;
use App\Models\ArticleListHi;



class AuthorController extends Controller
{
    /**
     * function for fetching index page data
     */
    public function index(Request $request)
    {
        if(!$request->slug)
        {
           return redirect('/');
        }

        $sarr = explode('-',$request->slug);
        $id = end($sarr);
        if(!is_int($id)){
            $id = (int)$id;
            if($id==0) return redirect('/');
        }
        $author = AuthorList::find($id);//dd($author);
        if(App::getLocale() == 'hi'){
            $articleCount = ArticleListHi::where('author_id',$id)->count();
            $article = ArticleListHi::where('author_id',$id)->where('status', 1)->orderByDesc('created_at')->limit('5')->get();//dd($article);
        }else{
            $articleCount = ArticleListEn::where('author_id',$id)->count();
            $article = ArticleListEn::where('author_id',$id)->where('status', 1)->orderByDesc('created_at')->limit('5')->get();   //dd($article);
        }
        return view('frontend.author',compact('author','article','articleCount'));
    }

    public function authorarticlelist(Request $request)
    {
        if(App::getLocale() == 'hi'){
            $article = ArticleListHi::where('author_id',$request->id)->where('status', 1)->orderByDesc('created_at')->paginate(5, ['*'], 'page', $request->page);
        }else{
            $article = ArticleListEn::where('author_id',$request->id)->where('status', 1)->orderByDesc('created_at')->paginate(5, ['*'], 'page', $request->page);
        }
        return view('frontend.partials.authorarticlelist')->with(compact('article'));

    }

    public function newsIndex(Request $request)
    {
        if(!$request->slug)
        {
            return redirect('/news');
        }

        $sarr = explode('-',$request->slug);
        $id = end($sarr);
        if(!is_int($id)){
            $id = (int)$id;
            if($id==0) return redirect('/news');
        }
        $author = AuthorList::find($id);//dd($author);
        if(App::getLocale() == 'hi'){
            $articleCount = NewsListHi::where('author_id',$id)->count();
            $article = NewsListHi::where('author_id',$id)->orderByDesc('created_at')->limit('2')->get();//dd($article);
        }else{
            $articleCount = NewsListEn::where('author_id',$id)->count();
            $article = NewsListEn::where('author_id',$id)->orderByDesc('created_at')->limit('2')->get();   //dd($article);
        }
        return view('frontend.news.author',compact('author','article','articleCount'));
    }


    public function authorNewsList(Request $request)
    {
        if(App::getLocale() == 'hi'){
            $article = NewsListHi::where('author_id',$request->id)->orderByDesc('created_at')->paginate(5, ['*'], 'page', $request->page);
        }else{
            $article = NewsListEn::where('author_id',$request->id)->orderByDesc('created_at')->paginate(5, ['*'], 'page', $request->page);
        }
        return view('frontend.partials.news.authorarticlelist')->with(compact('article'));

    }

}
