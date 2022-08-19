@extends('frontend.layouts.master')
@section('seoTitle', $article->title)
@section('seoDesc', $article->short_desc)
@section('shortDesc', $article->short_desc)
@section('canonicalUrl', url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article')))
@section('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/')))
@section('url', url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article')))
@section('createTime', $article->created_at)
@section('updateTime', $article->updated_at)
@section('alturls')
@if(App::getLocale() == 'en')
<link rel="alternate" href="{{url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article'))}}" hreflang="en-IN" />
@else
<link rel="alternate" href="{{url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article'))}}" hreflang="hi-IN" />
@endif
@stop
@if($article->is_noindexnofollow == 1)
@section('noindex', 'noindex,nofollow')
@endif
@section('content')

	<div class="maininnver">
		@include("frontend.includes.topadsblk")
		<div class="repeatarts">
		<div class="contentblk">
			<div class="container">
				<div class="catlinks"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($article->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($article->getTagName->name) : ($article->getTagName->name)}}</a></div>
				<h1>{{$article->title}}</h1>
				<div class="authblk">
					<div class="autimg"><img alt="{{$article->getAuthorName->name}}" src="{{\App\Http\Controllers\Frontend\IndexController::authorImageurl($article->getAuthorName->image_path)}}" alt=""></div>
					<div class="autinfo">
						<span><a href="{{(!is_null($article->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($article->getAuthorName->name,$article->getAuthorName->id,'author') : '#' }}">{{!is_null($article->getAuthorName) ? $article->getAuthorName->name : 'OpportunityIndia Desk'}}</a></span>

						{{date('M d Y',strtotime($article->created_at))}} - {{\App\Http\Controllers\Frontend\IndexController::calculateReadTime($article)}} min read
					</div>
				</div>
			</div>
		</div>

		<div class="contentarea">
			<div class="imgblk">
				<img alt="{{$article->title}}" src="{{!empty($article->image_path) ? \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/')) : 'https://franchiseindia.s3.ap-south-1.amazonaws.com/uploads/content/fi/int/5ff40e6aaa3da.jpeg'}}" alt="">
			</div>

			@include("frontend.includes.socailcomment")

			@if(!is_null($article->getAudioFiles))
				@include("frontend.includes.audio")
			@endif

			<div class="shortdes">
				{{$article->short_desc}}
			</div>

			<div class="articlecontent">
                @php
                    $custom_data = explode("\r\n", $article->content);
                    if(count($custom_data) == 1){
                    $articleData[0] = $custom_data[0].'<div id = "v-franchiseindia"></div><script>(function(v,d,o,ai){ai=d.createElement("script");ai.defer=true;ai.async=true;ai.src=v.location.protocol+o;d.head.appendChild(ai);})(window, document, "//a.vdo.ai/core/v-franchiseindia/vdo.ai.js");</script>';
                    } else{
                    $counter = 0;
                    foreach($custom_data as $cdata){
                    if($counter == 2){
                    $articleData[] = $cdata.'<div id = "v-franchiseindia"></div><script>(function(v,d,o,ai){ai=d.createElement("script");ai.defer=true;ai.async=true;ai.src=v.location.protocol+o;d.head.appendChild(ai);})(window, document, "//a.vdo.ai/core/v-franchiseindia/vdo.ai.js");</script>';
                    } else{
                    $articleData[] = $cdata;
                    }
                    $counter++;
                    }
                    }
                    $resultArticle  = implode("\r\n", $articleData);

                @endphp
				{!! $resultArticle !!}
			</div>
		</div>

		<!-- Some content after mag sub start here  -->
		<div class="contentarea">
			<div class="tag-block">
				<ul class="tag-list">
					@foreach($article->getAssocTags as $assoctags)
						<li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($assoctags->getTagsId->slug)}}">{{$assoctags->getTagsId->name}}</a></li>
					@endforeach
				</ul>
			</div>
			@include("frontend.includes.socailcomment")
			@include("frontend.includes.subscribenewsletter")
		</div>

		@include("frontend.includes.magblock")
		<!-- Some content after mag sub end  here  -->
		<!--  -->
		@include("frontend.includes.youmaylike")
		<!--  -->
		</div>
<div class="checktocallnextarticle"></div>
	</div>

@push('child-scripts')

<style>
.sinblk1{position: fixed; right:0px!important;top: 213px; left: auto!important;}
.at-share-btn-elements{display: block!important;float: right;text-align: right;}
@media  screen and (max-width: 768px){
  .sinblk1{position: fixed; left: 0px; top:273px;}
}
</style>
@endpush
@stop
