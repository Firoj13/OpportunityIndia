@extends('frontend.layouts.master')
@section('seoTitle', $catexist->name)
@section('seoKeywords', $catexist->name)
@section('seoDesc', $catexist->name)
@section('shortDesc', $catexist->name)
@section('canonicalUrl', URL::current())
@section('url', URL::current())
@section('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl($articlesList[0]->image_path))
@section('content')
<div class="maininnver homeh">
<div class="container">
<h1 class="cathead">{{$catexist->name}}</h1>
</div>

<div class="listblk">
  <div class="container">
<ul class="artilsit">
@foreach($articlesList as $alist)    
<li>
<div class="artimgblk">
	<a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}"><img src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($alist->image_path); }}" alt=""></a>
</div>	
<div class="artcontent">
	<div class="catname"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($alist->getTagName->slug)}}">{{$alist->getTagName->name}}</a></div>
<div class="haedname"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}">{{$alist->title}}</a></div>
<div class="authblk cot">
<div class="autimg"><img src="{{(!is_null($alist->getAuthorName)) ? env('S3_BUCKET_URL','').'opp/authors/images/'.trim($alist->getAuthorName->image_path,'/'):  url('images/team-4.jpg')}}" alt=""></div>
<div class="autinfo">
<span><a href="{{(!is_null($alist->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->getAuthorName->name,$alist->getAuthorName->id,'author') : '#' }}">{{!is_null($alist->getAuthorName) ? $alist->getAuthorName->name : 'OpportunityIndia Desk'}}</a></span>

{{date('M d Y',strtotime($alist->created_at))}} - {{\App\Http\Controllers\Frontend\IndexController::calculateReadTime($alist)}} min read

</div> 
</div>
<div class="stext">
{{$alist->short_desc}}
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

<!-- mag block strat  -->
@include('frontend.includes.magblock')  
<!-- mag block end   -->

@include('frontend.includes.brandlist')
</div>
@push('child-scripts')
<script>

$(function(){

  var page = '2';
  $('.readmore').click(function(){
          $.ajax({
          url: "category/"+{{$catexist->id}}+"/"+page,
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