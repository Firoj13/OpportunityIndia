<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsListHi;
use App\Models\NewsListEn;
use App\Models\SeoTagsEn;
use App\Models\SeoTagsHi;
use App\Http\Controllers\Admin\SeoTagsHiController;


class NewsController extends Controller
{

    /**
     * Instantiate a new IndexController instance.
     */
    public function __construct()
    {
        //$this->locale = App::currentLocale();
    }


    /**
     * function for fetching index page data
     */
    public function index()
    {//echo 'LOCALLANG:--'.App::currentLocale();
        //dd('sandeep!');
        //return view('welcome');
         if(App::getLocale() == 'hi')
         {
            return redirect('/hindi');
         }

        $topTrendArticle = NewsListEn::select('id','title','image_path','created_at','author_id','primary_tag_id')->orderByDesc('created_at')->limit(11)->get();//dd($topTrendArticle);
//dd($topTrendArticle);
        $response = Http::get('https://master.franchiseindia.com/oppalert/News-Videos.php?page=videosAll&limit=40');
        if($response->ok())
        {
            $listVideo = $response->json();
        }

        $catexist = SeoTagsEn::where('slug','small-business')->first();  //dd($catexist);
        $smallideaList = NewsListEn::where('primary_tag_id',$catexist->id)
                                    ->orderByDesc('created_at')
                                    ->take(5)
                                    ->get();
        $catexist1 = SeoTagsEn::where('slug','emerging')->first();  //dd($catexist);
        $emergingIndiaList = NewsListEn::where('primary_tag_id',$catexist1->id)
                                    ->orderByDesc('created_at')
                                    ->take(5)
                                    ->get();
        $catexist2 = SeoTagsEn::where('slug','local-businesses')->first();  //dd($catexist);
        $localBusinessList = NewsListEn::where('primary_tag_id',$catexist2->id)
                                    ->orderByDesc('created_at')
                                    ->take(5)
                                    ->get();
        $sliderArticles = NewsListEn::select('id','title','short_desc','image_path','created_at','author_id','primary_tag_id')->whereNotNull('created_at')->orderByDesc('created_at')->limit(5)->get();//dd($sliderArticles);

        return view('frontend.news.index',compact('listVideo','topTrendArticle','smallideaList','emergingIndiaList','localBusinessList','sliderArticles'));
    }


    public function hindiIndex()
    {//echo 'LOCALLANG:--'.App::currentLocale();
        //return view('welcome');

        $topTrendArticle = NewsListHi::select('id','title','image_path','created_at','author_id','primary_tag_id')->orderByDesc('created_at')->limit(11)->get();//dd($topTrendArticle);

        $response = Http::get('https://master.franchiseindia.com/oppalert/News-Videos.php?page=videosAll&limit=40');
        if($response->ok())
        {
            $listVideo = $response->json();
        }

        $catexist = SeoTagsHi::where('slug','छोटा-व्यवसाय')->first();  //dd($catexist);
        $smallideaList = NewsListHi::where('primary_tag_id',$catexist->id)
                                    ->orderByDesc('created_at')
                                    ->take(5)
                                    ->get();
        $catexist1 = SeoTagsHi::where('slug','उभरता-हुआ-भारत')->first();  //dd($catexist);
        $emergingIndiaList = NewsListHi::where('primary_tag_id',$catexist1->id)
                                    ->orderByDesc('created_at')
                                    ->take(5)
                                    ->get();
        $catexist2 = SeoTagsHi::where('slug','स्थानीय-व्यापार')->first();  //dd($catexist);
        $localBusinessList = NewsListHi::where('primary_tag_id',$catexist2->id)
                                    ->orderByDesc('created_at')
                                    ->take(5)
                                    ->get();
        $sliderArticles = NewsListHi::select('id','title','short_desc','image_path','created_at','author_id','primary_tag_id')->whereNotNull('created_at')->orderByDesc('created_at')->limit(5)->get();//dd($sliderArticles);

        return view('frontend.news.index',compact('listVideo','topTrendArticle','smallideaList','emergingIndiaList','localBusinessList','sliderArticles'));
    }


    public function detail(Request $request)
    {
        //dd('sandeep!');
        //return view('welcome');
        if(!$request->slug)
        {
           return redirect('/');
        }

        $urltitle = preg_replace('/-[^-]*$/', '', $request->slug);
        $title = preg_replace("/[-]/", ' ', $urltitle);
        $articleexist = NewsListEn::where('title',$title)->first();//dd($articleexist);
        if(is_null($articleexist)) return redirect($request->slug, 301);
        $sarr = explode('-',$request->slug);
        $id = end($sarr);
        if(!is_int($id)){ $id = (int)$id; if($id==0) return redirect($request->slug, 301);};
        $article = NewsListEn::where('id',$id)->first();//dd($article);
        $youmaylike = NewsListEn::where('primary_tag_id',$article->primary_tag_id)->whereNotIn('id',[$id])->orderByDesc('created_at')->limit('7')->get();
        return view('frontend.news.detail',compact('article','youmaylike'));
    }

    public function detailHindi(Request $request)
    {
        //return view('welcome');
        if(!$request->slug)
        {
           return redirect('/hindi');
        }

        $urltitle = preg_replace('/-[^-]*$/', '', $request->slug);
        $title = preg_replace("/[-]/", ' ', $urltitle);
        $articleexist = NewsListHi::where('title',$title)->first();//dd($article);
        if(is_null($articleexist)) return redirect($title, 301);
        $sarr = explode('-',$request->slug);
        $id = end($sarr);
        if(!is_int($id)){ $id = (int)$id; if($id==0) return redirect('/');};
        $article = NewsListHi::where('id',$id)->first();
        $youmaylike = NewsListHi::where('primary_tag_id',$article->primary_tag_id)->whereNotIn('id',[$id])->orderByDesc('created_at')->limit('7')->get();
        return view('frontend.news.detail',compact('article','youmaylike'));
    }

    public function createslugurl($slug,$id,$for)
    {
        $url = '';
        if(App::getLocale() == 'hi')  $url.= "/hindi";
        if(App::currentLocale() == 'en')
        {
        $title = preg_replace( "/[:’]/", "", $slug);
        $slug = \Str::slug($title);
        }else{
        $title = preg_replace( "/[:?]/", "", $slug);
        $slug = preg_replace("/[\s]/", '-', $title);
        }
        if($for == 'article') $url.="/article/".$slug."-".$id;
        if($for == 'author')  $url = "/author/".$slug."-".$id;

        return $url;
    }

    public function createimgurl($image)
    {
        $url = '';
        if($image)
        {
            $iscont = strstr($image,"/");
            if($iscont)
            {
                $url = env('S3_BUCKET_URL2','').trim($image,'/');
            }else{
                if(App::getLocale() == 'hi')
                {
                    $url = env('S3_BUCKET_URL','').Config('constants.NEWS_HINDI_UPLOAD_PATH').trim($image);
                }else{
                    $url = env('S3_BUCKET_URL','').Config('constants.NEWS_UPLOAD_PATH').trim($image);
                }
            }

        }else{
            $url = url('/img/602a695853d99.jpeg');
        }

        return $url;
    }

    public function category(Request $request){

        if($request->category)
        {
            $catexist = SeoTagsEn::where('slug',$request->category)->first();  //dd($catexist);
            if(is_null($catexist)) return redirect('/');
        }

        $articleCount = NewsListEn::where('primary_tag_id',$catexist->id)->count();
        if(($articleCount=='0')) return redirect('/');
        $articlesList = NewsListEn::where('primary_tag_id',$catexist->id)
                                    ->orderByDesc('created_at')
                                    ->take(2)
                                    ->get();
        return view('frontend.news.list',compact('articleCount','articlesList','catexist'));
    }

    public function hindicategory(Request $request){

        if($request->category)
        {
            $catexist = SeoTagsHi::where('slug',$request->category)->first();
            if(is_null($catexist)) return redirect('/hindi');
        }

        $articleCount = NewsListHi::where('primary_tag_id',$catexist->id)->count();
        if(($articleCount=='0')) return redirect('/hindi');
        $articlesList = NewsListHi::where('primary_tag_id',$catexist->id)
                                    ->orderByDesc('created_at')
                                    ->take(2)
                                    ->get();
        return view('frontend.news.list',compact('articleCount','articlesList','catexist'));
    }

    public function categoryarticlelist(Request $request)
    {
        if(App::getLocale() == 'hi'){
        $article = NewsListHi::where('primary_tag_id',$request->id)->orderByDesc('created_at')->paginate(2, ['*'], 'page', $request->page);
        }else{
        $article = NewsListEn::where('primary_tag_id',$request->id)->orderByDesc('created_at')->paginate(2, ['*'], 'page', $request->page);
        }
        return view('frontend.partials.news.categoryarticlelist')->with(compact('article'));

    }

    public function createTagSlugUrl($slug)
    {
        $url = '';
        if(App::getLocale() == 'hi')  $url.= "/hindi/tag";
        if(App::getLocale() == 'en')  $url.= "/english/tag";
        $url.="/".$slug;
        return $url;
    }

    public function calculateReadTime($obj)
    {
        /*Calculating length of total words*/
        $totaltext = $obj->title.' '.$obj->content;
        $articlelen = str_word_count($totaltext);
        $time = round($articlelen/200);
        return $time;
    }

}
