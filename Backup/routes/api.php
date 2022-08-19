<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\LeadMail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/article/apidata',              'App\Http\Controllers\Frontend\IndexController@apiData');
Route::get('/article/hindiapidata',         'App\Http\Controllers\Frontend\IndexController@hindiApiData');
Route::get('/article/apidataforfi',              'App\Http\Controllers\Frontend\IndexController@apiDataForFIRevamp');
Route::get('/article/cat/{slug}', 'App\Http\Controllers\Frontend\IndexAPIController@getCategoryArticlesList'); 

