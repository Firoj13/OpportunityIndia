<div class="lastestvideoblk">
<div class="container">
<div class="comhead"><a href="#">Latest Video</a> <span class="slidervall"><a href="https://video.franchiseindia.com/">View All</a></span></div>
</div>



<div class="container">
<div class="row">

@foreach($listVideo as $video)
@if($loop->index == 0)
	<div class="col-xs-12 col-sm-12 col-md-6">
		<div class="editimgblk">
					<div class="overleytnew">
						<div class="playbtnnew"><a href="{{$video['url']}}"><img src="{{url('images/play-button.svg')}}"></a></div>
						<div class="showovet">
							<div class="topcatli"><a href="https://video.franchiseindia.com/category/{{$video['category']}}">{{$video['category']}}</div>
							<div class="shownametxt"><a href="{{$video['url']}}">{{$video['title']}}</a></div>
							<div class="timeviw">{{$video['createDate']}} | <img src="{{url('images/view.svg')}}" class="viewy"> {{$video['views']}} Views</div>
						</div>
					</div>
			<a href="{{$video['url']}}"><img src="{{$video['image']}}"></a>
	
		</div>	
	</div>
	@endif
	@endforeach
		<div class="col-xs-12 col-sm-12 col-md-6">
			<ul class="editlistnew">
@foreach($listVideo as $video)
@if($loop->index > 0 && $loop->index < 3)
<li>
<div class="imgbl"><div class="playbtnnewsmal"><img src="{{url('images/play-button.svg')}}" class="v"></div><a href="{{$video['url']}}"><img src="{{$video['image']}}"></a></div>
<div class="conblk">
<div class="tagl"><a href="https://video.franchiseindia.com/category/{{$video['category']}}">{{$video['category']}}</a></div>
<div class="hname"> <a href="{{$video['url']}}">{{$video['title']}}</a></div>
<div class="aname"><a href="#">Sneha Santra</a> <span class="h1w"></span>{{$video['createDate']}}</div>
</div>
</li>
@endif
@endforeach
</ul>

	</div>
</div>



<!-- below list start here  -->
</div>	

</div>