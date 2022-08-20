<div class="maycontentblk">
<div class="container">
<div class="headbh">You May Also like</div>

  <div class="swiper-container">
    <div class="swiper-wrapper">
@foreach($youmaylike as $ymk)      
<!-- 1  -->
<div class="swiper-slide">      
<div class="mabox">
<div class="imgsec"> 
<a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($ymk->title,$ymk->id,'article'); }}"><img alt="{{$ymk->title}}" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($ymk->image_path); }}"></a>
</div>
<div class="catblk">
<div class="catname"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($ymk->getTagName->slug)}}">{{$ymk->getTagName->name}}</a></div>
<div class="artihead"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($ymk->title,$ymk->id,'article'); }}">{{$ymk->title}}</a></div>
</div>
</div> 
</div>
<!--1  -->
@endforeach

</div>
   <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

</div>
</div>