@foreach($article as $art) 
<li>
<div class="artimgblk">
  <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article'); }}"><img src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($art->image_path); }}" alt=""></a>
</div>  
<div class="artcontent">
<div class="catname"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($art->getTagName->slug)}}">{{$art->getTagName->name}}</a></div>
<div class="haedname"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article'); }}">{{trim($art->title)}}</a></div>
<div class="authblk cot">
<div class="autimg"><img src="{{\App\Http\Controllers\Frontend\IndexController::authorImageurl($art->getAuthorName->image_path)}}" alt=""></div>
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