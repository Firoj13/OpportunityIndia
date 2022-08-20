<div class="slidercomman">
    <div class="container">
        <div class="comhead">
            <a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.StartupURL'))))}}">{{ Lang::get('messages.Startup') }}</a>
            <span class="slidervall">
	            <a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.StartupURL'))))}}">View All</a>
            </span>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
            @foreach($localBusinessList as $lbl)
                <!-- below list start here  1-->
                    <div class="swiper-slide">
                        <div class="innerlist">
                            <div class="imgbl">
                                <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->title,$lbl->id,'article'); }}">
                                    <img alt="{{$lbl->title}}" loading="lazy" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($lbl->image_path); }}">
                                </a>
                            </div>
                            <div class="conblk">
                                <div class="tagl"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($lbl->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($lbl->getTagName->name) : ($lbl->getTagName->name)}}</a></div>
                                @if(Request::segment(1) == Config('constants.LANGUAGE_TYPE.HINDI'))
                                    <div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->title,$lbl->id,'article'); }}">{{ $lbl->title }}</a></div>
                                @else
                                    <div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->title,$lbl->id,'article'); }}">{{(strlen($lbl->title) > 60) ? substr(trim($lbl->title),0,55)."..." : trim($lbl->title)}}</a></div>
                                @endif
                                <div class="aname">
                                    <a href="{{(!is_null($lbl->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->getAuthorName->name,$lbl->getAuthorName->id,'author') : '#' }}">{{!is_null($lbl->getAuthorName) ? ucwords($lbl->getAuthorName->name) : 'OpportunityIndia Desk'}}</a>
                                    <span class="h1w"></span>{{date('M d, Y',strtotime($lbl->created_at))}}
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
