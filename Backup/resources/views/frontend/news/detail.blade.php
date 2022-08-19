@extends('frontend.layouts.master')
@section('seoTitle', $article->title)
@section('seoDesc', $article->short_desc)
@section('canonicalUrl', URL::current())
@section('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/')))
@section('url', URL::current())
@section('createTime', $article->created_at)
@section('updateTime', $article->updated_at)

@section('content')
	<div class="maininnver">

		@include("frontend.includes.topadsblk")


		<div class="contentblk">
			<div class="container">
				<div class="catlinks"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($article->getTagName->slug)}}">{{$article->getTagName->name}}</a></div>
				<h1>{{$article->title}}</h1>
				<div class="authblk">
					<div class="autimg"><img src="{{!is_null($article->getAuthorName) ? env('S3_BUCKET_URL','').'opp/authors/images/'.trim($article->getAuthorName->image_path,'/') : url('images/team-4.jpg')}}" alt=""></div>
					<div class="autinfo">
						<span><a href="{{(!is_null($article->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($article->getAuthorName->name,$article->getAuthorName->id,'author') : '#' }}">{{!is_null($article->getAuthorName) ? $article->getAuthorName->name : 'OpportunityIndia Desk'}}</a></span>

						{{date('M d Y',strtotime($article->created_at))}} - {{\App\Http\Controllers\Frontend\IndexController::calculateReadTime($article)}} min read
					</div>
				</div>
			</div>
		</div>


		<div class="contentarea">

			<div class="imgblk">
				<img src="{{!empty($article->image_path) ? \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/')) : 'https://franchiseindia.s3.ap-south-1.amazonaws.com/uploads/content/fi/int/5ff40e6aaa3da.jpeg'}}" alt="">
			</div>

			@include("frontend.includes.socailcomment")

			@if(!is_null($article->getAudioFiles))
				@include("frontend.includes.audio")
			@endif



			<div class="shortdes">
				{{$article->short_desc}}
			</div>

			<div class="articlecontent">
				{!! $article->content !!}
			</div>

		</div>

		<!-- Some content after mag sub start here  -->
		<div class="contentarea">
			<!--<div class="articlecontent">
            <p><strong>In this newly created role, Mundra will be responsible for the company's car business in India, while closely working with the co-founders to device an expansion strategy.</strong></p>

            <p>Commenting on the new appointment, Vikram Chopra, Co-Founder and CEO, CARS24 India, said, “I am delighted to have Kunal Mundra join our team at CARS24. In his new role, Kunal will help future proof the brand as we continue to grow and revolutionise the way Indians buy or sell pre-owned vehicles.”</p>
            </div>-->
			<div class="tag-block">
				<ul class="tag-list">
					@foreach($article->getAssocTags as $assoctags)
						<li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($assoctags->getTagsId->slug)}}">{{$assoctags->getTagsId->name}}</a></li>
					@endforeach
				</ul>
			</div>
			@include("frontend.includes.socailcomment")
			@include("frontend.includes.disqusCommentsBlock")
			@include("frontend.includes.subscribenewsletter")
		</div>
		@include("frontend.includes.magblock")
	<!-- Some content after mag sub start here
<div class="contentarea">  
<div class="articlecontent">
<p><strong>In this newly created role, Mundra will be responsible for the company's car business in India, while closely working with the co-founders to device an expansion strategy.</strong></p>

<p>Commenting on the new appointment, Vikram Chopra, Co-Founder and CEO, CARS24 India, said, “I am delighted to have Kunal Mundra join our team at CARS24. In his new role, Kunal will help future proof the brand as we continue to grow and revolutionise the way Indians buy or sell pre-owned vehicles.”</p>
</div>
<div class="tag-block">
<ul class="tag-list">
<li><a href="https://news.franchiseindia.com/Appointment">Appointment</a></li>
<li><a href="https://news.franchiseindia.com/pre-owned-vehicles">pre-owned vehicles</a></li>
<li><a href="https://news.franchiseindia.com/pre-owned-car-business">pre-owned car business</a></li>
<li><a href="https://news.franchiseindia.com/pre-owned-vehicles">pre-owned vehicles</a></li>
<li><a href="https://news.franchiseindia.com/pre-owned-car-business">pre-owned car business</a></li>
</ul>
</div>
{{--@include("frontend.includes.socailcomment")   
@include("frontend.includes.subscribenewsletter")--}}
			</div>-->

		<!-- Some content after mag sub end  here  -->
		<!--  -->
		@include("frontend.includes.youmaylike")
	    <!--  -->
		<!-- repeat article start here -->
        <?php //include("includes/commanrepeat.php");?>
		<!-- repeat article end here -->

		<!-- repeat article start here -->
        <?php //include("includes/commanrepeat.php");?>
		<!-- repeat article end here -->
	</div>
	@stop