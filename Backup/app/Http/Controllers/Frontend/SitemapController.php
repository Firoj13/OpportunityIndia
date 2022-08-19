<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ArticleListHi;
use App\Models\ArticleListEn;
use App\Models\SeoTagsEn;
use App\Models\SeoTagsHi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class SitemapController extends Controller
{
    public function index()
    {
        $host = request()->getSchemeAndHttpHost();
       
        ini_set('memory_limit', '-1');

        $siteMapInitializer = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        $siteMapTerminator  = "</urlset>";

        /* Articles Site map Generation Start */
        $siteMapData = "";
        $articles    = ArticleListEn::query()->where('status', 1)->orderBy('created_at', 'desc')->limit('20000')->get();
        foreach ($articles as $article) {
            $siteMapData .= "<url>
                                <loc>".$host.$this->createslugurl($article->title,$article->id,'article','en')."</loc>
                                <lastmod>".substr($article->created_at, 0, 10)."</lastmod>
                            </url>";
        }
       // dd(Storage::disk('public'));
        Storage::disk('sitemap')->put( "sitemap_articles.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* Articles Site map Generation End */


        /*Hindi Articles Site map Generation Start */
        $siteMapData = "";
        $articles    = ArticleListHi::query()->where('status', 1)->orderBy('created_at', 'desc')->limit('20000')->get();
        foreach ($articles as $article) {
            $siteMapData .= "<url>
                                <loc>".$host.$this->createslugurl($article->title,$article->id,'article','hi')."</loc>
                                <lastmod>".substr($article->created_at, 0, 10)."</lastmod>
                            </url>";
        }
        Storage::disk('sitemap')->put( "sitemap_hindi_articles.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /*Hindi Articles Site map Generation End */


        /* Article English Tag Site map Generation Start */
        $siteMapData = "";
        $kickers     = SeoTagsEn::select('slug')->get();
        foreach ($kickers as $kicker) {
            $siteMapData .= "<url>
                                <loc>".$host.$this->createTagSlugUrl($kicker->slug,'en')."</loc>
                                <lastmod>".date('Y-m-d')."</lastmod>
                            </url>";
        }
        Storage::disk('sitemap')->put( "sitemap_tag.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* Article English Tag Site map Generation End */

        /* Article Hindi Tag Site map Generation Start */
        $siteMapData  = '';
        $kickers     = SeoTagsHi::select('slug')->get();
        foreach ($kickers as $kicker) {
            $siteMapData .= "<url>
                                <loc>".$host.$this->createTagSlugUrl($kicker->slug,'en')."</loc>
                                <lastmod>".date('Y-m-d')."</lastmod>
                            </url>";
        }
        Storage::disk('sitemap')->put( "sitemap_hindi_tag.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* Article Hindi Tag Site map Generation End */

        

        echo "Sitemap Generated..."; 


    }

    //to create articles url//
    public function createslugurl($slug,$id,$for,$lang)
    {
        $url = '';
        if($lang == 'hi')  $url.= "/hindi";
        if($lang == 'en')
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

    //to create tags url//
    public function createTagSlugUrl($slug,$lang)
    {
        $url = '';
        if($lang == 'hi')  $url.= "/hindi/tag";
        if($lang == 'en')  $url.= "/english/tag";
        $url.="/".$slug;
        return $url;
    }

    public function rssfeed()
    {
        $host = request()->getSchemeAndHttpHost();
        ini_set('memory_limit', '-1');

        $siteMapInitializer = '<?xml version="1.0" encoding="UTF-8" ?>
                                <rss version="2.0">
                                <channel>
                                <title>Grab The Opportunity of Being a Small Business Owner in India</title>
                                <link>'.$host.'</link>
                                <description>India’s digital platform for latest news, industry updates, videos, policies, schemes, investment, funding and opportunities for small medium and micro businesses and enterprises</description>';
        $siteMapTerminator  = "</channel>
                                </rss>";

        /* Articles rssfeed Generation Start */
        $siteMapData = "";
       

         $articlesTemp     = ArticleListEn::query()->select('created_at')->orderBy('id', 'desc')->where('status', 1)->first();
        $lastNewsDate = new \DateTime($articlesTemp->created_at. ' -5 day');
        $articles     = ArticleListEn::query()->where('created_at', '>', $lastNewsDate->format('Y-m-d 00:00:00'))
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
     
        foreach ($articles as $article) {
            $siteMapData .= "<item>
                            <title>".$article->title."</title>
                            <link>".$host.$this->createslugurl($article->title,$article->id,'article','en')."</link>
                            <description>".$article->short_desc."</description>
                            <image>".$this->createimgurl($article->image_path,'en')."</image>
                            <pubDate>".$article->created_at."</pubDate>
                          </item>";
        }
       // dd(Storage::disk('public'));
        Storage::disk('sitemap')->put( "rssfeed.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* Articles rssfeed Generation End */


        $siteMapInitializer = '<?xml version="1.0" encoding="UTF-8" ?>
                                <rss version="2.0">
                                <channel>
                                <title>भारत में एक छोटे व्यवसाय के मालिक होने का अवसर प्राप्त करें</title>
                                <link>'.$host.'/hindi/</link>
                                <description>भारत का डिजिटल प्लेटफॉर्म ताजा ख़बरों, उद्योग अपडेट, वीडियो, नीतियों, योजनाओं और लघु मध्यम व्यवसाय के लिए निवेश और फंडिंग</description>';
        /*Hindi Articles rssfeed Generation Start */
        $siteMapData = "";
        
        $articlesTemp     = ArticleListHi::query()->select('created_at')->orderBy('id', 'desc')->where('status', 1)->first();
        $lastNewsDate = new \DateTime($articlesTemp->created_at. ' -5 day');
        $articles     = ArticleListHi::query()->where('created_at', '>', $lastNewsDate->format('Y-m-d 00:00:00'))
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($articles as $article) {
            $siteMapData .= "<item>
                            <title>".$article->title."</title>
                            <link>".$host.$this->createslugurl($article->title,$article->id,'article','hi')."</link>
                            <description>".$article->short_desc."</description>
                            <image>".$this->createimgurl($article->image_path,'hi')."</image>
                            <pubDate>".$article->created_at."</pubDate>
                          </item>";
        }
        Storage::disk('sitemap')->put( "rssfeed_hindi.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /*Hindi Articles rssfeed Generation End */

        echo "RssFeed Generated..."; 
    }

    //to create image urls//
    public function createimgurl($image,$lang)
    {
        if ($image) {
            $iscont = strstr($image, "/");
            if ($iscont) {
                $url = env('S3_BUCKET_URL2', '') . trim($image, '/');
            } else {
                if ($lang == 'hi') {
                    $url = env('S3_BUCKET_URL', '') . Config('constants.ARTICLE_HINDI_UPLOAD_PATH') . trim($image);
                } else {
                    $url = env('S3_BUCKET_URL', '') . Config('constants.ARTICLE_UPLOAD_PATH') . trim($image);
                }
            }

        } else {
            $url = '';
        }

        return $url;
    }
     public function upArticleInSiteRSS()
    {
        $host = request()->getSchemeAndHttpHost();        
        ini_set('memory_limit', '-1');

        $siteMapInitializer = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        $siteMapTerminator  = "</urlset>";

        /* Articles Site map Generation Start */
        $siteMapData = "";
        $articles    = ArticleListEn::query()->where('status', 1)->orderBy('created_at', 'desc')->limit('20000')->get();
        foreach ($articles as $article) {
            $siteMapData .= "<url>
                                <loc>".$host.$this->createslugurl($article->title,$article->id,'article','en')."</loc>
                                <lastmod>".substr($article->created_at, 0, 10)."</lastmod>
                            </url>";
        }
       // dd(Storage::disk('public'));
        Storage::disk('sitemap')->put( "sitemap_articles.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* Articles Site map Generation End */

        $siteMapInitializer1 = '<?xml version="1.0" encoding="UTF-8" ?>
                                <rss version="2.0">
                                <channel>
                                <title>Grab The Opportunity of Being a Small Business Owner in India</title>
                                <link>'.$host.'</link>
                                <description>India’s digital platform for latest news, industry updates, videos, policies, schemes, investment, funding and opportunities for small medium and micro businesses and enterprises</description>';
        $siteMapTerminator1  = "</channel>
                                </rss>";

        /* Articles rssfeed Generation Start */
        $siteMapData = "";
        $articlesTemp     = ArticleListEn::query()->select('created_at')->orderBy('id', 'desc')->where('status', 1)->first();
        $lastNewsDate = new \DateTime($articlesTemp->created_at. ' -5 day');
        $articles     = ArticleListEn::query()->where('created_at', '>', $lastNewsDate->format('Y-m-d 00:00:00'))
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
     
        foreach ($articles as $article) {
            $siteMapData .= "<item>
                            <title>".$article->title."</title>
                            <link>".$host.$this->createslugurl($article->title,$article->id,'article','en')."</link>
                            <description>".$article->short_desc."</description>
                            <image>".$this->createimgurl($article->image_path,'en')."</image>
                            <pubDate>".$article->created_at."</pubDate>
                          </item>";
        }
       // dd(Storage::disk('public'));
        Storage::disk('sitemap')->put( "rssfeed.xml", $siteMapInitializer1.$siteMapData.$siteMapTerminator1);
        /* Articles rssfeed Generation End */
    }

    public function upHindiArticleInSiteRSS()
    {
        $host = request()->getSchemeAndHttpHost();        
        ini_set('memory_limit', '-1');

        $siteMapInitializer = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        $siteMapTerminator  = "</urlset>";

        /*Hindi Articles Site map Generation Start */
        $siteMapData = "";
        $articles    = ArticleListHi::query()->where('status', 1)->orderBy('created_at', 'desc')->limit('20000')->get();
        foreach ($articles as $article) {
            $siteMapData .= "<url>
                                <loc>".$host.$this->createslugurl($article->title,$article->id,'article','hi')."</loc>
                                <lastmod>".substr($article->created_at, 0, 10)."</lastmod>
                            </url>";
        }
        Storage::disk('sitemap')->put( "sitemap_hindi_articles.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /*Hindi Articles Site map Generation End */


        $siteMapInitializer1 = '<?xml version="1.0" encoding="UTF-8" ?>
                                <rss version="2.0">
                                <channel>
                                <title>भारत में एक छोटे व्यवसाय के मालिक होने का अवसर प्राप्त करें</title>
                                <link>'.$host.'/hindi/</link>
                                <description>भारत का डिजिटल प्लेटफॉर्म ताजा ख़बरों, उद्योग अपडेट, वीडियो, नीतियों, योजनाओं और लघु मध्यम व्यवसाय के लिए निवेश और फंडिंग</description>';
         $siteMapTerminator1  = "</channel>
                                </rss>";

        /*Hindi Articles rssfeed Generation Start */
        $siteMapData = "";
        $articlesTemp     = ArticleListHi::query()->select('created_at')->orderBy('id', 'desc')->where('status', 1)->first();
        $lastNewsDate = new \DateTime($articlesTemp->created_at. ' -5 day');
        $articles     = ArticleListHi::query()->where('created_at', '>', $lastNewsDate->format('Y-m-d 00:00:00'))
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($articles as $article) {
            $siteMapData .= "<item>
                            <title>".$article->title."</title>
                            <link>".$host.$this->createslugurl($article->title,$article->id,'article','hi')."</link>
                            <description>".$article->short_desc."</description>
                            <image>".$this->createimgurl($article->image_path,'hi')."</image>
                            <pubDate>".$article->created_at."</pubDate>
                          </item>";
        }
        Storage::disk('sitemap')->put( "rssfeed_hindi.xml", $siteMapInitializer1.$siteMapData.$siteMapTerminator1);
        /*Hindi Articles rssfeed Generation End */
    }
}
