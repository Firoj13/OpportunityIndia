<div class="topeditoblk">
	<div class="container">
		<div class="comhead">{{ Lang::get('messages.TopEditorpick') }}</div>
	</div>
	<div class="container">
		<div class="row">
			@foreach($topTrendArticle as $top)
				@if($loop->index == 4 && $loop->index < 5)
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="editimgblk msedit">
							<div class="overleyt">
								<div class="cote">
									<div class="topcont"><a href="{{(!is_null($top->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($top->getAuthorName->name,$top->getAuthorName->id,'author') : '#' }}">{{!is_null($top->getAuthorName) ? $top->getAuthorName->name : 'OpportunityIndia Desk'}}</a>  <span class="h1w"></span> {{date('M d Y',strtotime($top->created_at))}}</div>
									<div class="conlist"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}">{{trim($top->title)}}</a></div>
								</div>
							</div>
							<a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}"><img alt="{{$top->title}}" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($top->image_path); }}"></a>

						</div>
					</div>
				@endif
			@endforeach

			<div class="col-xs-12 col-sm-12 col-md-6 spd">
				<ul class="editlist">
					@foreach($topTrendArticle as $top)
						@if($loop->index > 4  && $loop->index < 7)
							<li>
								<div class="imgbl"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}"><img alt="{{$top->title}}" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($top->image_path); }}"></a></div>
								<div class="conblk">
									<div class="tagl"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($top->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($top->getTagName->name) : ($top->getTagName->name)}}</a></div>

									<div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}">{{trim($top->title)}}</a></div>
									<div class="aname"><a href="{{(!is_null($top->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($top->getAuthorName->name,$top->getAuthorName->id,'author') : '#' }}">{{!is_null($top->getAuthorName) ? $top->getAuthorName->name : 'OpportunityIndia Desk'}}</a> <span class="h1w"></span>{{date('M d, Y',strtotime($top->created_at))}}</div>
								</div>
							</li>
						@endif
					@endforeach
				</ul>
			</div>
		</div>

		<!-- below list start here  -->
		<ul class="beloweditlist">
			@foreach($topTrendArticle as $top)
				@if($loop->index > 6  && $loop->index < 11)
					<li>
						<div class="imgbl"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}"><img alt="{{$top->title}}" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($top->image_path); }}"></a></div>
						<div class="conblk">
							<div class="tagl"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($top->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($top->getTagName->name) : ($top->getTagName->name)}}</a></div>
							<div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}">{{trim($top->title)}}</a></div>

							<div class="aname"><a href="{{(!is_null($top->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($top->getAuthorName->name,$top->getAuthorName->id,'author') : '#' }}">{{!is_null($top->getAuthorName) ? $top->getAuthorName->name : 'OpportunityIndia Desk'}}</a> <span class="h1w"></span>{{date('M d, Y',strtotime($top->created_at))}}</div>
						</div>
					</li>
				@endif
			@endforeach
		</ul>
		<!-- below list start here  -->
	</div>
</div>

<!--<div style="text-align: center;margin:30px auto; width:820px;max-width: 100%;">
	<a href="https://www.franchiseindia.com/brands/capsicum-kitchens.66738" target="_blank"><img src="https://opportunityindia.franchiseindia.com/img/ck-expansion.jpg" alt="Fastest Growing Industry" class="img-fluid" style="border:1px solid #f1f1f1;"></a>
</div>-->
