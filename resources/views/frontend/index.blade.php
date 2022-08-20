@extends('frontend.layouts.master')
@section('seoTitle', Lang::get('messages.Title'))
@section('seoKeywords', Lang::get('messages.Keywords'))
@section('seoDesc', Lang::get('messages.Description'))
@section('shortDesc', Lang::get('messages.Description'))
@section('canonicalUrl', URL::current())
@section('url', URL::current())
@section('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl($sliderArticles[0]->image_path))
@section('content')
<div class="maininnver homeh">

    @include("frontend.includes.toparticle")
    @include("frontend.includes.topeditor")
    @include("frontend.includes.smallidea")
    @include("frontend.includes.magblock")
    @include("frontend.includes.localbusiness")
    @include("frontend.includes.adsblk")
    @include("frontend.includes.topfranchisecategories")
    @include("frontend.includes.emergingindia")
    @include("frontend.includes.lastestvideoblk")
    @include("frontend.includes.podcastblk")
</div>
@include('frontend.includes.adsblk2')
@stop


