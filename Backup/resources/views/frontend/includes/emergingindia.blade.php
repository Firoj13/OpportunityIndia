<div class="slidercomman">
	<div class="container">
		<div class="comhead">
			<a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.Franchise'))))}}">{{Lang::get('messages.Franchise')}}</a>
			<span class="slidervall">
				<a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.Franchise'))))}}">View All</a>
			</span>
		</div>
		<div class="swiper-container">
			<div class="swiper-wrapper">
			@foreach($emergingIndiaList as $emil)
				<!-- below list start here  1-->
                    <div class="swiper-slide">
                        <div class="innerlist">
                            <div class="imgbl">
                                <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($emil->title,$emil->id,'article'); }}">
                                    <img loading="lazy" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($emil->image_path); }}" alt="{{ $emil->title }}">
                                </a>
                            </div>
                            <div class="conblk">
                                <div class="tagl"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($emil->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($emil->getTagName->name) : ($emil->getTagName->name)}}</a></div>
                                @if(Request::segment(1) == Config('constants.LANGUAGE_TYPE.HINDI'))
                                    <div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($emil->title,$emil->id,'article'); }}">{{ $emil->title }}</a></div>
                                @else
                                    <div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($emil->title,$emil->id,'article'); }}">{{(strlen($emil->title) > 60) ? substr(trim($emil->title),0,55)."..." : trim($emil->title)}}</a></div>
                                @endif
                                <div class="aname">
                                    <a href="{{(!is_null($emil->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($emil->getAuthorName->name,$emil->getAuthorName->id,'author') : '#' }}">{{!is_null($emil->getAuthorName) ? ucwords($emil->getAuthorName->name) : 'OpportunityIndia Desk'}}</a>
                                    <span class="h1w"></span>{{date('M d, Y',strtotime($emil->created_at))}}
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- below list end here  1 -->
            @endforeach
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
	</div>
</div>
