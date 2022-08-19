@extends('frontend.layouts.master')
@section('seoTitle', $author->name)
@section('seoKeywords', $author->name)
@section('seoDesc', 'Author '.$author->name)
@section('canonicalUrl', URL::current())
@section('url', URL::current())
@section('imagesrc', env('S3_BUCKET_URL','').'opp/authors/images/'.trim($author->image_path,'/'))

@section('content')
<div class="maininnver homeh">

 <div class="authblk">
<div class="container">


<ul class="nabva">
<li><a href="{{URL::to('/')}}">Home</a></li>
<li>/</li>
<li>{{$author->name}}</li>
</ul>


<div class="row">
  <div class="col-4 col-sm-4 col-md-3 artublk1">
    <div class="imgprolist"><a href="#"><img src="{{env('S3_BUCKET_URL','').'opp/authors/images/'.trim($author->image_path,'/')}}"></a></div>

  </div>

  <div class="col-8 col-sm-8 col-md-9 artublk2">
    <div class="authorcontent">
    <h1>{{$author->name}}</h1>
    <div class="jobprofile">{{$author->designation}}</div>
    <p>{{$author->intro_desc}}</p>

    <div class="usblk">
  <div class="usblkinner"><a href="{{($author->fb_profile)? $author->fb_profile : 'javascript:;'}}"><img src="{{url('images/facebookLP.svg')}}"></a></div>
  <div class="usblkinner"><a href="{{($author->twitter_profile)? $author->twitter_profile : 'javascript:;' }}"><img src="{{url('images/twitterLP.svg')}}"></a></div>
  <div class="usblkinner"><a href="{{($author->linkedin_profile)? $author->linkedin_profile : 'javascript:;' }}"><img src="{{url('images/linkedLP.svg')}}"></a></div>
</div>
</div>


  </div>
</div>

</div>
</div>

{{--@if($article->isNotEmpty() === true)--}}
@if($articleCount > 0)
<div class="listblk">
  <div class="container">
<ul class="artilsit">
@foreach($article as $art)

<li>
<div class="artimgblk">
	<a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article'); }}"><img src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($art->image_path); }}" alt=""></a>
</div>
<div class="artcontent">
<div class="catname"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($art->getTagName->slug)}}">{{$art->getTagName->name}}</a></div>
<div class="haedname"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article'); }}">{{trim($art->title)}}</a></div>
<div class="authblk cot">
<div class="autimg"><img src="{{!is_null($art->getAuthorName) ? env('S3_BUCKET_URL','').'opp/authors/images/'.trim($art->getAuthorName->image_path,'/') : url('images/team-4.jpg')}}" alt=""></div>
<div class="autinfo">
<span><a href="">{{!is_null($art->getAuthorName) ? $art->getAuthorName->name : 'OpportunityIndia Desk'}}</a></span>

{{date('M d Y',strtotime($art->created_at))}} - {{\App\Http\Controllers\Frontend\IndexController::calculateReadTime($art)}} min read
</div> 

</div>
<div class="stext">
{{$art->short_desc}}
</div>
<div class="scbk">
   <div class="cmtblk"><img src="{{url('images/smallcomment.svg')}}" alt="">
   </div>
     <div class="shrblk">

        <span class="inshrblk"><a href="#"><img src="{{url('images/smallshare.svg')}}" class="inimg"> 0 Share
            <div class="sfv">
            <div class="innersfv" onclick=""><img src="{{url('images/facebookcard.svg')}}"></div>
            <div class="innersfv" onclick=""><img src="{{url('images/twittercard.svg')}}"></div>
            <div class="innersfv" onclick=""><img src="{{url('images/linkedincard.svg')}}"></div>
            <div class="innersfv" onclick=""><img src="{{url('images/mailcard.svg')}}"></div>
            </div>   </a>
        </span>

       </div>
</div>
</div>
</li>
@endforeach

@if($articleCount > 2)
@php $noofpage = round($articleCount/2) + 1; @endphp
<span data-page={{$noofpage}} class="readmore">Read More...</span>
@endif

</ul>
</div>
</div>
@endif
<!-- mag block strat  -->
@include("frontend.includes.magblock")
<!-- mag block end   -->

<!-- another list start here   -->


<!-- another list end here  -->


@include("frontend.includes.brandlist")


</div>
@push('child-scripts')
<script>

$(function(){

  var page = '2';
  $('.readmore').click(function(){

          $.ajax({
          url: "/author/"+{{$author->id}}+"/"+page,
          method: "GET",
          }).done(function( data ) {
                  if(data){
                        page++;
                        $('.readmore').before( data );
                        if($('.readmore').attr('data-page') == page)
                        {
                            $('.readmore').hide();
                        }
                  }

          });


  })


})

</script>
@endpush

@stop

