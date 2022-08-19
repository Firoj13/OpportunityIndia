@extends('frontend.layouts.master')
@section('seoTitle', 'Grab The Opportunity of Being a Small Business Owner in India')
@section('seoKeywords', 'best franchise, franchising, new business ideas, buy franchise, franchise information, small franchise business, best franchise business company in India')
@section('seoDesc', 'India’s digital platform for latest news, industry updates, videos, policies, schemes, investment, funding and opportunities for small medium and micro businesses and enterprises')
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


