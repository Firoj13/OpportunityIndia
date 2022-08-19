<?php

namespace App\Http\Controllers\Frontend;

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



class IndexController extends Controller
{

     var $status=array(
        "code"=>200,
        "error"=>false,
        "message"=>"",
    );


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
    {
        if (App::getLocale() == 'hi') {
            return redirect('/hindi');
        }

        $sliderArticles = ArticleListEn::query()->select('id', 'title', 'short_desc', 'image_path', 'created_at', 'author_id', 'primary_tag_id')->where('status', 1)->whereNotNull('is_slider')->orderByDesc('is_slider')->limit(5)->get();

        $topTrendArticle = ArticleListEn::query()->select('id', 'title', 'image_path', 'created_at', 'author_id', 'primary_tag_id')->whereNotIn('id',$sliderArticles->pluck('id')->toArray())->where('status', 1)->orderByDesc('created_at')->limit(11)->get();

        $response = Http::get('https://master.franchiseindia.com/oppalert/News-Videos.php?page=videosAll&limit=40');
        if ($response->ok()) {
            $listVideo = $response->json();
        }

        $catexist = SeoTagsEn::query()->where('slug', 'small-business')->first();
        $smallideaList = ArticleListEn::query()->where('primary_tag_id', $catexist->id)
            ->orderByDesc('created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $catexist1 = SeoTagsEn::query()->where('slug', 'franchise')->first();
        $emergingIndiaList = ArticleListEn::query()->where('primary_tag_id', $catexist1->id)
            ->orderByDesc('created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $catexist2 = SeoTagsEn::query()->where('slug', 'startup')->first();
        $localBusinessList = ArticleListEn::query()->where('primary_tag_id', $catexist2->id)
            ->orderByDesc('created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        
        return view('frontend.index', compact('listVideo', 'topTrendArticle', 'smallideaList', 'emergingIndiaList', 'localBusinessList', 'sliderArticles'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function hindiIndex()
    {
        if (App::getLocale() == 'en') {
            return redirect('/');
        }

        $sliderArticles = ArticleListHi::query()->select('id', 'title', 'short_desc', 'image_path', 'created_at', 'author_id', 'primary_tag_id')->where('status', 1)->whereNotNull('is_slider')->orderByDesc('is_slider')->limit(5)->get();

        $topTrendArticle = ArticleListHi::query()->select('id', 'title', 'image_path', 'created_at', 'author_id', 'primary_tag_id')->whereNotIn('id',$sliderArticles->pluck('id')->toArray())->where('status', 1)->orderByDesc('created_at')->limit(11)->get();

        $response = Http::get('https://master.franchiseindia.com/oppalert/News-Videos.php?page=videosAll&limit=40');
        if ($response->ok()) {
            $listVideo = $response->json();
        }

        $catexist = SeoTagsHi::query()->where('slug', 'फ्रैंचाइज़-100')->first();
        $smallideaList = ArticleListHi::query()->where('primary_tag_id', $catexist->id)
            ->orderByDesc('created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $catexist1 = SeoTagsHi::query()->where('slug', 'फ्रेंचाइजी')->first();
        $emergingIndiaList = ArticleListHi::query()->where('primary_tag_id', $catexist1->id)
            ->orderByDesc('created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $catexist2 = SeoTagsHi::query()->where('slug', 'फ्रैंचाइज़-व्यापार')->first();
        $localBusinessList = ArticleListHi::query()->where('primary_tag_id', $catexist2->id)
            ->orderByDesc('created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('frontend.index', compact('listVideo', 'topTrendArticle', 'smallideaList', 'emergingIndiaList', 'localBusinessList', 'sliderArticles'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function detail(Request $request)
    {

         App::setLocale('en');
        session()->put('locale', 'en');

        $articleId = last(explode('-', $request->slug));

        $article = ArticleListEn::query()->where('id', $articleId)->where('status',1)->first();

        if (empty($article)) {
            return redirect('/', 301);
        }

        $articleTitleSlug = str_replace('-'.$articleId, '', $request->slug);

        if(str_slug($article->title) != $articleTitleSlug) {
            return redirect('/article/'.str_slug($article->title).'-'.$articleId, 301);
        }

        $youmaylike = ArticleListEn::query()
            ->where('primary_tag_id', $article->primary_tag_id)
            ->where('id', '!=',$articleId)
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->limit('7')
            ->get();

             if($youmaylike->count() == 0){
                $youmaylike = ArticleListEn::query()
                ->where('id', '!=',$articleId)
                ->where('status', 1)
                ->orderByDesc('created_at')
                ->limit('7')
                ->get();
            }

        ArticleListEn::query()->where('id', $articleId)
            ->update([
                'total_views' => DB::raw('total_views + 1')
            ]);

        return view('frontend.detail', compact('article', 'youmaylike'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function detailHindi(Request $request)
    {
        App::setLocale('hi');
        session()->put('locale', 'hi');

        if ($request->slug) {
            $exist = preg_match('/\s/', $request->slug);
            if ($exist) {
                $request->slug = preg_replace('/\s+/', '-', $request->slug);
                return redirect('/hindi/article/' . $request->slug);
            }
        }

        $articleId = last(explode('-', $request->slug));

        $article = ArticleListHi::query()->where('id', $articleId)->where('status', 1)->first();

        if (empty($article)) {
            return redirect('/', 301);
        }

        if(!empty($article->eng_title) && $request->slug != str_slug($article->eng_title).'-'.$articleId) {
            return redirect('/hindi/article/' . str_slug($article->eng_title).'-'.$articleId);
        }

        $youmaylike = ArticleListHi::query()
            ->where('primary_tag_id', $article->primary_tag_id)
            ->where('id', '!=', $articleId)
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->limit('7')
            ->get();

        if ($youmaylike->count() == 0) {
            $youmaylike = ArticleListHi::query()
                ->where('id', '!=', $articleId)
                ->where('status', 1)
                ->orderByDesc('created_at')
                ->limit('7')
                ->get();
        }

        ArticleListHi::query()->where('id', $articleId)
            ->update([
                'total_views' => DB::raw('total_views + 1')
            ]);

        return view('frontend.detail', compact('article', 'youmaylike'));

    }

    /**
     * @param $slug
     * @param $id
     * @param $for
     * @return string
     */
    public static function createslugurl($slug, $id, $for)
    {
        $url = '';
        if (App::getLocale() == 'hi') {
            $url .= "/hindi";
        }

        if (App::currentLocale() == 'en') {
            $title = preg_replace("/[:’]/", "", $slug);
            $slug = \Str::slug($title);
        } else {
            $title = preg_replace("/[:?]/", "", $slug);
            $slug = preg_replace("/[\s]/", '-', $title);

            if($for == 'article') {
                $article = ArticleListHi::query()->find($id);
                if(!empty($article)) {
                    $title = $article->eng_title;
                    if(!empty($title)) {
                        $slug = str_slug($title);
                    }
                }
            }
        }

        if ($for == 'article') {
            $url .= "/article/" . $slug . "-" . $id;
        }

        if ($for == 'author') {
            $url = "/author/" . $slug . "-" . $id;
        }

        return $url;
    }

    /**
     * @param $image
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public static function createimgurl($image)
    {
        if ($image) {
            $iscont = strstr($image, "/");
            $isHttps = strstr($image,'https');
           if($isHttps){
                  $url =  trim($image, '/');
           }else{
            if ($iscont) {
                $url = env('S3_BUCKET_URL2', '') . trim($image, '/');
            } else {
                if (App::getLocale() == 'hi') {
                    $url = env('S3_BUCKET_URL2', '') . Config('constants.ARTICLE_HINDI_UPLOAD_PATH') . trim($image);
                } else {
                    $url = env('S3_BUCKET_URL2', '') . Config('constants.ARTICLE_UPLOAD_PATH') . trim($image);
                }
            }
        }

        } else {
            $url = url('/img/602a695853d99.jpeg');
        }

        return $url;
    }

    /**
     * @param $image
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public static function authorImageurl($image)
    {
        if($image) {
            $iscont = strstr($image,"/");
            if($iscont) {
                $url = env('S3_BUCKET_URL2','').trim($image,'/');
            } else {
                $info = @getimagesize('https://franchiseindia.s3.ap-south-1.amazonaws.com/opp/authors/images/'.$image);
                if($info === false)
                {
                    $url = url('images/defaultuser.png');
                }
                else
                {
                    $url = env('S3_BUCKET_URL2','').'opp/authors/images/'.trim($image);
                    
                }
                
            }

        } else {
            $url = url('images/defaultuser.png');
        }

        return $url;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function category(Request $request)
    {
          App::setLocale('en');
        session()->put('locale', 'en');

        if ($request->category) {
            $catexist = SeoTagsEn::query()->where('slug', $request->category)->first();
            if (is_null($catexist)) return redirect('/');
        }

        $articleCount = ArticleListEn::query()->where('primary_tag_id', $catexist->id)->where('status', 1)->count();
    

        if (($articleCount == '0')) {
            return redirect('/');
        }
         if(request()->category != $catexist->slug)
        return redirect('/english/tag/'.$catexist->slug);

        $articlesList = ArticleListEn::query()->where('primary_tag_id', $catexist->id)->where('status', 1)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('frontend.list', compact('articleCount', 'articlesList', 'catexist'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function hindicategory(Request $request)
    {
    
   	  App::setLocale('hi');
         session()->put('locale', 'hi');
        if ($request->category) 
        {
            $exist = preg_match('/\s/',$request->category);
            if($exist)
            {
                $reqslug = explode(' ',$request->category);
                $request->category = preg_replace('/\s+/', '-',$request->category);
            }

            $catexist = SeoTagsHi::query()->where('slug', $request->category)->first();
            if (is_null($catexist)) {
                return redirect('/hindi');
            }
        }

        $articleCount = ArticleListHi::query()->where('primary_tag_id', $catexist->id)->where('status', 1)->count();

        if (($articleCount == '0')) {
            return redirect('/hindi');
        }

        $articlesList = ArticleListHi::query()->where('primary_tag_id', $catexist->id)->where('status', 1)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        return view('frontend.list', compact('articleCount', 'articlesList', 'catexist'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function categoryarticlelist(Request $request)
    {
        if (App::getLocale() == 'hi') {
            $article = ArticleListHi::query()->where('primary_tag_id', $request->id)->where('status', 1)->orderByDesc('created_at')->paginate(5, ['*'], 'page', $request->page);
        } else {
            $article = ArticleListEn::query()->where('primary_tag_id', $request->id)->where('status', 1)->orderByDesc('created_at')->paginate(5, ['*'], 'page', $request->page);
        }
        return view('frontend.partials.categoryarticlelist')->with(compact('article'));

    }

    /**
     * @param $slug
     * @return string
     */
    public static function createTagSlugUrl($slug)
    {
        $url = '';
        if (App::getLocale() == 'hi') $url .= "/hindi/tag";
        if (App::getLocale() == 'en') $url .= "/english/tag";
        $url .= "/" . $slug;
        return $url;
    }

    /**
     * @param $obj
     * @return float
     */
    public static function calculateReadTime($obj)
    {
        /*Calculating length of total words*/
        $totaltext = $obj->title . ' ' . $obj->content;
        if (App::getLocale() == 'en'){
            $articlelen = str_word_count($totaltext);
        }else{
            $articlelen = count(explode(' ',$totaltext));
        }
        return round($articlelen / 200);
    }

    public function podcast()
    {
        $response = Http::get('https://master.franchiseindia.com/oppalert/News-Videos.php?page=videosAll&limit=40');
        if ($response->ok()) {
            $listVideo = $response->json();
        }
        return view('frontend/podcast', compact('listVideo'));
    }
    public function apiData(){

        $tagName = null;
        $authorName = null;

        $topTrendArticle = ArticleListEn::query()->where('status', 1)->orderByDesc('created_at')->limit(10)->get();

           foreach($topTrendArticle as $article){
            $tagName[] = $article->getTagName->name; 
            $authorName[] = $article->getAuthorName->name;
        }

        if(!empty($topTrendArticle))
        {
            return response()->json(array_merge($this->status(),['article'=>$topTrendArticle]));
        }else{
               return response($this->status(404,true,__('Article not found')),404);
        }
    }
        public function hindiApiData(){

        $tagName = null;
        $authorName = null;

        $topTrendArticle = ArticleListHi::query()->where('status', 1)->orderByDesc('created_at')->limit(10)->get();

           foreach($topTrendArticle as $article){
            $tagName[] = $article->getTagName->name; 
            $authorName[] = $article->getAuthorName->name;
        }

        if(!empty($topTrendArticle))
        {
            return response()->json(array_merge($this->status(),['article'=>$topTrendArticle]));
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
    
     public function searchArticles(Request $request){
         //dd($request->search);
         $search = $request->search;

     if (App::getLocale() == 'hi') {
         $articleCount = ArticleListHi::query()->where('title','LIKE','%'.$search.'%')->where('status', 1)->count();
    

        if (($articleCount == '0')) {
            return redirect('/hindi');
        }
        
        $articlesList = ArticleListHi::query()
            ->where('title','LIKE','%'.$search.'%')
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

     }else{
        $articleCount = ArticleListEn::query()->where('title','LIKE','%'.$search.'%')->where('status', 1)->count();
    

        if (($articleCount == '0')) {
            return redirect('/');
        }
        
        $articlesList = ArticleListEn::query()
            ->where('title','LIKE','%'.$search.'%')
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
          
           
        }
         return view('frontend.search', compact('articleCount','articlesList','search'));
    }
     public function SearchPagination(Request $request)
    {
        if (App::getLocale() == 'hi') {
            $article = ArticleListHi::query()
            ->where('title','LIKE','%'.$request->term.'%')
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(5, ['*'], 'page', $request->page);
        } else {
            $article = ArticleListEn::query()
            ->where('title','LIKE','%'.$request->term.'%')
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(5, ['*'], 'page', $request->page);
        }
        return view('frontend.partials.search_pagination')->with(compact('article'));

    }
    
       public function aboutUs(){
        return view('frontend.about');
    }

    public function contactUsForm()
    {
     return view('frontend.contact');
    }

    public function contactUs(Request $request)
    {

//        dd($request->all());

        $this->validate(request(), array(
            'name'         => 'required|max:30',
            'email'        => 'required|email|max:255',
            'mobile'       => 'required|min:10|max:10',
            'contreason'   => 'required'));

        $name       = $request->name;
        $email      = $request->email;
        $mobile     = $request->mobile;
        $contreason = $request->contreason;
        $userIp     = $request->ip();

        $source = "OPPORTUNITYINDIA";

        $contactData = ContactUs::query()->insertGetId([
            'want'      => $contreason,
            'name'      => $name,
            'email'     => $email,
            'mobile'    => $mobile,
            'user_ip'   => $userIp,
            'source'    => $source
        ]);


        if ($contactData) {
            $details['name']           = $request->name;
            $details['email']          = $request->email;
            $details['mobile']         = $request->mobile;
            $details['contreason']     = $request->contreason;



            if($contreason == "Advertise with www.franchiseindia.com")
                Mail::getFacadeRoot()->to(["advertise@franchiseindia.com"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Advertise in Magazine")
                Mail::getFacadeRoot()->to(["advertise@franchiseindia.com"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Exhibit in Shows")
                Mail::getFacadeRoot()->to(["advertise@franchiseindia.com"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Expand my Company through Franchising")
                Mail::getFacadeRoot()->to(["ashita@franchiseindia.com"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Buy a Franchise (Business)")
                Mail::getFacadeRoot()->to(["dharmendra@franchiseindia.net"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Sell my Existing Business")
                Mail::getFacadeRoot()->to(["dharmendra@franchiseindia.net"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Subscribe to the Magazine")
                Mail::getFacadeRoot()->to(["dharmendra@franchiseindia.net"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Feedback")
                Mail::getFacadeRoot()->to(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));

            if($contreason == "Others")
                Mail::getFacadeRoot()->to(["ashita@franchiseindia.com"])->bcc(["techsupport@franchiseindia.com"])->send(new ContactUsMail($details));
        }

//        $ch     = curl_init();
//        curl_setopt($ch,CURLOPT_URL, url('dotcom-api/contact-us-salescrm-leads.php?contact_id='.$contactData));
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//        curl_exec($ch);

//        if(curl_errno($ch))
//            Log::getFacadeRoot()->alert('SMS Sending in Curl Failed  : ' . curl_error($ch));
//
//        curl_close($ch);  // Close the curl connection

        $message = "Contact form submitted successfully...";
        if(!$contactData)
            $message = "Contact form submission failed...";

        return view('frontend.thanks', compact('message'));
    }
    
     public function feedbackForm(Request $request)
    {

        return view('frontend.feedback');
    }

    /**
     * function to insertfeedback data
     */
    public function feedback(Request $request)
    {
        $this->validate($request, array(
            'name'     => 'required|max:32',
            'email'    => 'required|email|max:255',
            'mobile'   => 'required|min:10|max:10',
            'ftopic'   => 'required',
            'feedback' => 'required'));

        $sitetype = 'OI';

        FeedbackList::insert([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->mobile,
            'text'          => $request->feedback,
            'feedback_type' => $request->ftopic,
            'ip'            => $request->ip(),
            'site_type'     => $sitetype
        ]);

        $details['name']           = $request->name;
        $details['email']          = $request->email;
        $details['mobile']         = $request->mobile;
        $details['feedback_topic'] = $request->ftopic;
        $details['feedback']       = $request->feedback;
        $details['site']           = $sitetype;

        Mail::to(["ashita@franchiseindia.com"])->send(new SiteFeedbackMail($details));

        return view('frontend.thanks');

    }
    
     public function apiDataForFIRevamp(){

     

        $topTrendArticle = ArticleListEn::query()->where('status', 1)->orderByDesc('created_at')->limit(4)->get();
      $response = [];
         foreach($topTrendArticle as $key => $article){
         
      $response['news'][] = [
              "title"=> $article->title,
              "url"=> 'https://opportunityindia.franchiseindia.com/article/'.str_slug($article->title).'-'.$article->id,
              "image"=> $this->createimgurl($article->image_path),
              "description"=> strip_tags(str_limit($article->short_desc, 65 , ' ..')),
              "author"=> $article->getAuthorName->name,
              "authorDesignation"=> $article->getAuthorName->designation,
            ];
        }

        if(!empty($response))
        {
            return response()->json($response);
        }else{
               return response($this->status(404,true,__('Article not found')),404);
        }
    }

}
