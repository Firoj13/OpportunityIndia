<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function (){
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::get('/optimize',function (){
    Artisan::call('route:clear');
    Artisan::call('optimize');
    Artisan::call('config:clear');
    echo '1'; die;
});



Route::get('/',                             'App\Http\Controllers\Frontend\IndexController@index')->name('enHome');
Route::get('/about', 'App\Http\Controllers\Frontend\IndexController@aboutUs');
Route::get('/contact', 'App\Http\Controllers\Frontend\IndexController@contactUsForm');
Route::post('/contactsubmit', 'App\Http\Controllers\Frontend\IndexController@contactUs');
Route::get('/feedback', 'App\Http\Controllers\Frontend\IndexController@feedbackForm');
Route::post('/feedbacksubmit', 'App\Http\Controllers\Frontend\IndexController@feedback');
Route::get('/list',                         'App\Http\Controllers\Frontend\IndexController@list');
Route::get('/article/{slug}',               'App\Http\Controllers\Frontend\IndexController@detail');
Route::get('/hindi/article/{slug}',          'App\Http\Controllers\Frontend\IndexController@detailHindi');
Route::get('/author/{slug}',                'App\Http\Controllers\Frontend\AuthorController@index');
Route::get('/author/{id}/{page}',           'App\Http\Controllers\Frontend\AuthorController@authorarticlelist');
Route::get('/english/tag/{category}',        'App\Http\Controllers\Frontend\IndexController@category');
Route::get('/hindi/tag/{category}',          'App\Http\Controllers\Frontend\IndexController@hindicategory');
Route::get('/hindi/tag/category/{id}/{page}', 'App\Http\Controllers\Frontend\IndexController@categoryarticlelist');
Route::get('/getnextarticle',                  'App\Http\Controllers\Frontend\IndexController@nextArticle');
Route::get('english/tag/category/{id}/{page}', 'App\Http\Controllers\Frontend\IndexController@categoryarticlelist');
Route::get('/podcast',                         'App\Http\Controllers\Frontend\IndexController@podcast');
Route::get('/seach-article/{term}/{page}', 'App\Http\Controllers\Frontend\IndexController@SearchPagination');
Route::get('/search/article',                             'App\Http\Controllers\Frontend\IndexController@searchArticles')->name('searchArticles');
Route::get('/videos', function () {
    return view('frontend.videos');
});




Route::prefix('admin')->group(function () {

    Route::get('migrate-kicker-data', 'App\Http\Controllers\Admin\DataMigrationController@migrateKickers' );
    Route::get('migrate-related-brands', 'App\Http\Controllers\Admin\DataMigrationController@migrateFranchisorIds' );
    Route::get('slugify-kickers', 'App\Http\Controllers\Admin\DataMigrationController@slugifyKickers' );
    Route::get('migrate-authors', 'App\Http\Controllers\Admin\DataMigrationController@migrateAuthors' );
    Route::get('migrate-assigned-tags', 'App\Http\Controllers\Admin\DataMigrationController@migrateContentAssignedTagsForNews' );

    Route::group(['middleware' => 'admin'], function() {
        Route::get('/home', 'App\Http\Controllers\Admin\HomeController@index')->name('home');
		Route::get('/users', 'App\Http\Controllers\Admin\UserController@index')->name('users');
		Route::get('/users/create/', 'App\Http\Controllers\Admin\UserController@create')->name('users.create');
		Route::get('/users/edit/{id}', 'App\Http\Controllers\Admin\UserController@edit')->name('users.edit');

		Route::delete('/user/{id}', 'App\Http\Controllers\Admin\UserController@delete');

		Route::post('/user/status', 'App\Http\Controllers\Admin\UserController@status');

		Route::post('/users/store', 'App\Http\Controllers\Admin\UserController@store');

        Route::get('/seo-tags-hi', 'App\Http\Controllers\Admin\SeoTagsHiController@index')->name('seoTagsHi');
        Route::get('/seo-tags-hi/create', 'App\Http\Controllers\Admin\SeoTagsHiController@create')->name('seoTagsHi.create');
        Route::get('/seo-tags-hi/edit/{id}', 'App\Http\Controllers\Admin\SeoTagsHiController@edit')->name('seoTagsHi.edit');
        Route::post('/seo-tags-hi/store', 'App\Http\Controllers\Admin\SeoTagsHiController@store');
        Route::post('/seo-tags-hi/update', 'App\Http\Controllers\Admin\SeoTagsHiController@update')->name('seoTagsHi.update');
        Route::post('/seo-tags-hi/delete', 'App\Http\Controllers\Admin\SeoTagsHiController@destroy')->name('seoTagsHi.destroy');
        Route::get('/seo-tags-hi/auto-load', 'App\Http\Controllers\Admin\SeoTagsHiController@autoLoadSeoTags')->name('seoTagsHi.autoload');


//		Route::get('/buyers', 'App\Http\Controllers\Admin\BuyerController@index')->name('buyers');
		Route::get('/seo-tags', 'App\Http\Controllers\Admin\SeoTagsController@index')->name('seoTags');
		Route::get('/seo-tags/create', 'App\Http\Controllers\Admin\SeoTagsController@create')->name('seoTags.create');
		Route::get('/seo-tags/edit/{id}', 'App\Http\Controllers\Admin\SeoTagsController@edit')->name('seoTags.edit');
		Route::post('/seo-tags/store', 'App\Http\Controllers\Admin\SeoTagsController@store');
		Route::post('/seo-tags/update', 'App\Http\Controllers\Admin\SeoTagsController@update')->name('seoTags.update');
		Route::post('/seo-tags/delete', 'App\Http\Controllers\Admin\SeoTagsController@destroy')->name('seoTags.destroy');
		Route::get('/seo-tags/auto-load', 'App\Http\Controllers\Admin\SeoTagsController@autoLoadSeoTags')->name('seoTags.autoload');

        Route::get('/authors', 'App\Http\Controllers\Admin\AuthorListController@index')->name('author.index');
        Route::get('/authors/create', 'App\Http\Controllers\Admin\AuthorListController@create')->name('author.create');
        Route::get('/authors/edit/{id}', 'App\Http\Controllers\Admin\AuthorListController@edit')->name('author.edit');
        Route::post('/authors/store', 'App\Http\Controllers\Admin\AuthorListController@store')->name('author.store');
        Route::post('/authors/update', 'App\Http\Controllers\Admin\AuthorListController@update')->name('author.update');
        Route::delete('/authors/delete/{id}', 'App\Http\Controllers\Admin\AuthorListController@destroy')->name('author.destroy');
        Route::post('/authors/status', 'App\Http\Controllers\Admin\AuthorListController@status')->name('author.status');
        Route::post('/authors/image/upload', 'App\Http\Controllers\Admin\AuthorListController@fileUpload')->name('author.imageUpload');
        Route::post('/authors/delete/image', 'App\Http\Controllers\Admin\AuthorListController@deleteImage')->name('author.deleteImage');

        Route::get('/permissions', 'App\Http\Controllers\Admin\PermissionController@index');
		Route::post('/permissions/update', 'App\Http\Controllers\Admin\PermissionController@update');



        Route::prefix('articles')->group(function () {
            Route::prefix('hindi')->group(function () {
                Route::get('/', 'App\Http\Controllers\Admin\HindiArticleController@index')->name('articleHindi.index');
                Route::get('/create', 'App\Http\Controllers\Admin\HindiArticleController@create')->name('articleHindi.create');
                Route::post('/store', 'App\Http\Controllers\Admin\HindiArticleController@store')->name('articleHindi.store');
                Route::get('/edit/{id}', 'App\Http\Controllers\Admin\HindiArticleController@edit')->name('articleHindi.edit');
                Route::post('/update', 'App\Http\Controllers\Admin\HindiArticleController@update')->name('articleHindi.update');
                Route::Delete('/delete', 'App\Http\Controllers\Admin\HindiArticleController@destroy')->name('articleHindi.destroy');
                Route::post('/status', 'App\Http\Controllers\Admin\HindiArticleController@status')->name('articleHindi.status');
                Route::get('/get-kickers','App\Http\Controllers\Admin\HindiArticleController@getKickersSelects')->name('articleHindi.getKickersSelects');
                Route::get('/get-authors','App\Http\Controllers\Admin\HindiArticleController@getAuthorsSelects')->name('articleHindi.getAuthorsSelects');
                Route::get('/get-audio-files','App\Http\Controllers\Admin\HindiArticleController@getAudioFiles')->name('articleHindi.getAudioFiles');
                Route::post('/image/upload', 'App\Http\Controllers\Admin\HindiArticleController@articleImageUpload')->name('articleHindi.articleImageUpload');
                Route::post('/audio/upload', 'App\Http\Controllers\Admin\HindiArticleController@articleAudioUpload')->name('articleHindi.uploadAudio');
                Route::post('/delete/image', 'App\Http\Controllers\Admin\HindiArticleController@deleteArticleImage')->name('articleHindi.deleteArticleImage');
            });

            Route::prefix('english')->group(function () {
                Route::get('/', 'App\Http\Controllers\Admin\ArticleController@index')->name('article.index');
                Route::get('/create', 'App\Http\Controllers\Admin\ArticleController@create')->name('article.create');
                Route::post('/store', 'App\Http\Controllers\Admin\ArticleController@store')->name('article.store');
                Route::get('/edit/{id}', 'App\Http\Controllers\Admin\ArticleController@edit')->name('article.edit');
                Route::post('/update', 'App\Http\Controllers\Admin\ArticleController@update')->name('article.update');
                Route::Delete('/delete', 'App\Http\Controllers\Admin\ArticleController@destroy')->name('article.destroy');
                Route::post('/status', 'App\Http\Controllers\Admin\ArticleController@status')->name('article.status');
                Route::get('/get-kickers','App\Http\Controllers\Admin\ArticleController@getKickersSelects')->name('article.getKickersSelects');
                Route::get('/get-authors','App\Http\Controllers\Admin\ArticleController@getAuthorsSelects')->name('article.getAuthorsSelects');
                Route::get('/get-audio-files','App\Http\Controllers\Admin\ArticleController@getAudioFiles')->name('article.getAudioFiles');
                Route::post('/image/upload', 'App\Http\Controllers\Admin\ArticleController@articleImageUpload')->name('article.articleImageUpload');
                Route::post('/audio/upload', 'App\Http\Controllers\Admin\ArticleController@articleAudioUpload')->name('article.uploadAudio');
                Route::post('/delete/image', 'App\Http\Controllers\Admin\ArticleController@deleteArticleImage')->name('article.deleteArticleImage');
            });
            });

        Route::prefix('news')->group(function () {
            Route::prefix('english')->group(function () {
                Route::get('/', 'App\Http\Controllers\Admin\NewsController@index')->name('news.index');
                Route::get('/create', 'App\Http\Controllers\Admin\NewsController@create')->name('news.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Admin\NewsController@edit')->name('news.edit');
                Route::get('/get-kickers','App\Http\Controllers\Admin\NewsController@getKickersSelects')->name('news.getKickersSelects');
                Route::get('/get-authors','App\Http\Controllers\Admin\NewsController@getAuthorsSelects')->name('news.getAuthorsSelects');
                Route::post('/store', 'App\Http\Controllers\Admin\NewsController@store')->name('news.store');
                Route::post('/update', 'App\Http\Controllers\Admin\NewsController@update')->name('news.update');
                Route::post('/status', 'App\Http\Controllers\Admin\NewsController@status')->name('news.status');
                Route::post('/image/upload', 'App\Http\Controllers\Admin\NewsController@newsImageUpload')->name('news.newsImageUpload');
                Route::post('/delete/image', 'App\Http\Controllers\Admin\NewsController@deleteArticleImage')->name('news.deleteNewsImage');
                Route::Delete('/delete', 'App\Http\Controllers\Admin\NewsController@destroy')->name('news.destroy');
            });

            Route::prefix('hindi')->group(function () {
                Route::get('/', 'App\Http\Controllers\Admin\HindiNewsController@index')->name('news-hi.index');
                Route::get('/create', 'App\Http\Controllers\Admin\HindiNewsController@create')->name('news-hi.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Admin\HindiNewsController@edit')->name('news-hi.edit');
                Route::get('/get-kickers','App\Http\Controllers\Admin\HindiNewsController@getKickersSelects')->name('news-hi.getKickersSelects');
                Route::get('/get-authors','App\Http\Controllers\Admin\HindiNewsController@getAuthorsSelects')->name('news-hi.getAuthorsSelects');
                Route::post('/store', 'App\Http\Controllers\Admin\HindiNewsController@store')->name('news-hi.store');
                Route::post('/update', 'App\Http\Controllers\Admin\HindiNewsController@update')->name('news-hi.update');
                Route::post('/status', 'App\Http\Controllers\Admin\HindiNewsController@status')->name('news-hi.status');
                Route::post('/image/upload', 'App\Http\Controllers\Admin\HindiNewsController@newsImageUpload')->name('news-hi.newsImageUpload');
                Route::post('/delete/image', 'App\Http\Controllers\Admin\HindiNewsController@deleteArticleImage')->name('news-hi.deleteNewsImage');
                Route::Delete('/delete', 'App\Http\Controllers\Admin\HindiNewsController@destroy')->name('news-hi.destroy');
            });
        });

        Route::get('/audios', 'App\Http\Controllers\Admin\AudioFileController@index')->name('audio.index');
        Route::get('/audios/create', 'App\Http\Controllers\Admin\AudioFileController@create')->name('audio.create');
        Route::get('/audios/edit/{id}', 'App\Http\Controllers\Admin\AudioFileController@edit')->name('audio.edit');
        Route::post('/audios/store', 'App\Http\Controllers\Admin\AudioFileController@store')->name('audio.store');
        Route::post('/audios/update', 'App\Http\Controllers\Admin\AudioFileController@update')->name('audio.update');
        Route::delete('/audios/delete/{id}', 'App\Http\Controllers\Admin\AudioFileController@destroy')->name('audio.destroy');
        Route::post('/audios/status', 'App\Http\Controllers\Admin\AudioFileController@status')->name('audio.status');
        Route::post('/audios/audio/upload', 'App\Http\Controllers\Admin\AudioFileController@audioUpload')->name('audio.audioUpload');
        Route::post('/audios/delete/audio', 'App\Http\Controllers\Admin\AudioFileController@deleteAudio')->name('audio.deleteAudio');

    });


	Route::get('/login', 'App\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('login');
	Route::post('/login', 'App\Http\Controllers\Admin\Auth\LoginController@adminLogin')->name('admin.login');
	Route::post('/logout', 'App\Http\Controllers\Admin\Auth\LoginController@logout')->name('admin.logout');
	Route::get('/forgot-password', 'App\Http\Controllers\Admin\Auth\LoginController@forgotPassword')->name('forgot.password');
	Route::get('/reset-password', 'App\Http\Controllers\Admin\Auth\LoginController@resetPassword')->name('reset.password');

});



/*Language setter*/
Route::get('/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    //print_r(request()->query());
    //dd(request()->headers->get('referer'));
    if($locale=='hi'){
        return redirect()->route('hiHome');
    }else{
    return redirect()->route('enHome');
    }
});

Route::get('/hindi',                 'App\Http\Controllers\Frontend\IndexController@hindiIndex')->name('hiHome');
Route::post('/instasubsribe',         'App\Http\Controllers\Frontend\InstaSubscribeController@instasubsribe');

Route::post('/freeadvice-home',        'App\Http\Controllers\Frontend\AdviceController@freeadviceHome');
Route::get('/thanks-advice-form',                     function() { return view('frontend.advice-form');});

 //Route::get('contact', ['as'   => 'en.contact','uses' => 'ContactController@contactUs']);
//Sitemap Route

Route::get('/sitemapgenerate',                'App\Http\Controllers\Frontend\SitemapController@index'); // Sitemap Generator routes
Route::get('/rssfeedgenerate',                'App\Http\Controllers\Frontend\SitemapController@rssfeed'); // Sitemap Generator routes
Route::post('/newslettersignup',               'App\Http\Controllers\Frontend\NewsLetterController@newsletter')->name('newsletter');
Route::prefix('news')->group(function () {
    Route::get('/',                                 'App\Http\Controllers\Frontend\NewsController@index')->name('newsEnHome');
    Route::get('/hindi',                 'App\Http\Controllers\Frontend\NewsController@hindiIndex')->name('NewsHiHome');
    Route::get('/list',                         'App\Http\Controllers\Frontend\NewsController@list');
    Route::get('/{slug}',               'App\Http\Controllers\Frontend\NewsController@detail');
    Route::get('/hindi/{slug}',          'App\Http\Controllers\Frontend\NewsController@detailHindi');
    Route::get('/author/{slug}',                'App\Http\Controllers\Frontend\AuthorController@newsIndex');
    Route::get('/author/{id}/{page}',           'App\Http\Controllers\Frontend\AuthorController@authorNewsList');
    Route::get('/english/tag/{category}',        'App\Http\Controllers\Frontend\NewsController@category');
    Route::get('/hindi/tag/{category}',          'App\Http\Controllers\Frontend\NewsController@hindicategory');
    Route::get('/hindi/tag/category/{id}/{page}',         'App\Http\Controllers\Frontend\NewsController@categoryarticlelist');
    Route::get('/english/tag/category/{id}/{page}',         'App\Http\Controllers\Frontend\NewsController@categoryarticlelist');
    /*Language setter*/
    Route::get('/language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        //print_r(request()->query());
        //dd(request()->headers->get('referer'));
        if($locale=='hi'){
            return redirect()->route('NewsHiHome');
        }else{
            return redirect()->route('newsEnHome');
        }
    });
});



Route::get('/hi',                  function(){
    return \redirect('/hindi', 301);
});
Route::get('/content/{slug}',                          "App\Http\Controllers\RedirectionController@redirectContentPage");
Route::get('/education/{slug}',                          "App\Http\Controllers\RedirectionController@redirectContentPage");
Route::get('/wellness/{slug}',                          "App\Http\Controllers\RedirectionController@redirectContentPage");
Route::get('/hi/content/{slug}',                       "App\Http\Controllers\RedirectionController@hindiRedirectContentPage");
Route::get('/hi/education/{slug}',                          "App\Http\Controllers\RedirectionController@hindiRedirectContentPage");
Route::get('/hi/wellness/{slug}',                          "App\Http\Controllers\RedirectionController@hindiRedirectContentPage");
Route::get('/amp/{site}/{slug}',                       "App\Http\Controllers\RedirectionController@redirectContentPage");
Route::get('/amp/hi/{site}/{slug}',                    "App\Http\Controllers\RedirectionController@hindiRedirectContentPage");

Route::get('/{kicker}',                  function(){
    $kicker =  request()->kicker;
    if($kicker) {
        $checkTag = \App\Models\SeoTagsEn::query()
            ->where('slug', $kicker)
            ->first();
        if(!empty($checkTag)) {
            return \redirect('/english/tag/'.$checkTag->slug, 301);
        }
        return \redirect('/', 301);
    }
});
Route::get('/hi/{kicker}/{kickerId}',                  function(){
    $kicker =  request()->kicker;
    $kickerID =  request()->kickerId;
    if($kickerID) {
        return \redirect('/hindi/tag/' . $kicker, 301);
    }else{
        return \redirect('/', 301);
    }
});

Route::get('/amp/hi/{kicker}/{kickerId}',                  function(){
    $kicker =  request()->kicker;
    $kickerID =  request()->kickerId;
    if($kickerID) {
        return \redirect('/hindi/tag/' . $kicker, 301);
    }else{
        return \redirect('/', 301);
    }
});
Route::get('/amp/{kicker}',                  function(){
    $kicker =  request()->kicker;
    if($kicker) {
        $checkTag = \App\Models\SeoTagsEn::query()
            ->where('slug', $kicker)
            ->first();
        if(!empty($checkTag)) {
            return \redirect('/english/tag/'.$checkTag->slug, 301);
        }
        return \redirect('/', 301);
    }
});



