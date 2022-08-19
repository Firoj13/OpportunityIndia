<div class="lastestvideoblk">
	<div class="container">
		<div class="comhead"><a href="https://video.franchiseindia.com/">{{ Lang::get('messages.LatestVideo') }}</a> <span class="slidervall"><a href="https://video.franchiseindia.com/">View All</a></span></div>
	</div>
	<div class="container">
		<div class="row">
			@foreach($listVideo as $video)
				@if($loop->index == 0)
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="editimgblk">
							<div class="overleytnew">
								<div class="playbtnnew"><a class="popup-youtube" href="{{$video['url']}}"><img alt="Play Button" src="{{url('images/play-button.svg')}}"></a></div>
								<div class="showovet">
									<div class="topcatli">
										<a href="{{$video['url']}}">{{$video['category']}}
										</a>
									</div>
									<div class="shownametxt"><a class="popup-youtube" href="">{{$video['title']}}</a></div>
									<div class="timeviw">{{$video['createDate']}} | <img src="{{url('images/view.svg')}}" alt="View" class="viewy"> {{$video['views']}} Views</div>
								</div>
							</div>
							<a href="{{$video['url']}}"><img alt="{{$video['title']}}" src="{{$video['image']}}"></a>

						</div>
					</div>
				@endif
			@endforeach
			<div class="col-xs-12 col-sm-12 col-md-6 spd">
				<ul class="editlistnew">
					@foreach($listVideo as $video)
						@if($loop->index > 0 && $loop->index < 3)
							<li>
								<div class="imgbl"><div class="playbtnnewsmal"><a class="popup-youtube" href="{{$video['url']}}"><img alt="Play" src="{{url('images/play-button.svg')}}" class="v"></a></div><a class="popup-youtube" href="{{$video['url']}}"><img alt="{{$video['title']}}" src="{{$video['image']}}"></a></div>
								<div class="conblk">
									<div class="tagl"><a href="https://video.franchiseindia.com/category/{{$video['category']}}">{{$video['category']}}</a></div>
									<div class="hname"><a class="popup-youtube" href="{{$video['url']}}">{{$video['title']}}</a></div>
									<div class="aname"><a href="#">OpportunityIndia Desk</a> <span class="h1w"></span>{{$video['createDate']}}</div>
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