<div class="slidercomman">
	<div class="container">
		<div class="comhead">
			<a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.SmallBusiness'))))}}">{{ Lang::get('messages.SmallBusinessIdeas') }}</a>
			<span class="slidervall">
				<a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.SmallBusiness'))))}}">View All</a>
			</span>
		</div>
		<div class="swiper-container">
			<div class="swiper-wrapper">
				@foreach($smallideaList as $sil)
					<!-- below list start here  1-->
					<div class="swiper-slide">
						<div class="innerlist">
							<div class="imgbl"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($sil->title,$sil->id,'article'); }}"><img loading="lazy" alt="{{$sil->title}}" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($sil->image_path); }}"></a></div>
							<div class="conblk">
								<div class="tagl"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($sil->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($sil->getTagName->name) : ($sil->getTagName->name)}}</a></div>
								<div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($sil->title,$sil->id,'article') }}">{{$sil->title}}</a></div>
								<div class="aname"><a href="{{(!is_null($sil->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($sil->getAuthorName->name,$sil->getAuthorName->id,'author') : '#' }}">{{!is_null($sil->getAuthorName) ? $sil->getAuthorName->name : 'OpportunityIndia Desk'}}</a> <span class="h1w"></span>{{date('M d, Y',strtotime($sil->created_at))}}</div>
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

<!-- <div style="text-align: center;margin:30px auto; width:820px;max-width: 100%;">
	<a href="https://www.franchiseindia.com/brands/grocery-4-u-retail-pvt-ltd.49833" target="_blank"><img src="https://opportunityindia.franchiseindia.com/img/grocery.jpg" alt="Grocery 4 U Retail Pvt ltd" class="img-fluid" style="border:1px solid #f1f1f1;"></a>
</div> -->
