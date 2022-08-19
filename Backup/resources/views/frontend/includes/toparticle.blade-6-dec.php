<div class="headblk">
<div class="container">
<h1 class="mainhead">Insights. ideas. Opportunities. Growth.</h1>
<div class="subtxt">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit…</div>
</div>
</div>


<div class="topblk">
<div class="container">
<div class="row">




	
	<div class="col-xs-12 col-sm-12 col-md-7 topmod1">
<div class="topimgbl"> 
	<img src="{{url('/img/602a695853d99.jpeg')}}">
	<div class="overlay">
		<div class="topcat"><a href="#">FEATURE OF THE WEEK Mar 18 2021</a></div>
		<div class="tophead"><a href="#">Top Five Edtech Trends In The Turn Of The Decade</a></div>
		<div class="toptxt">In recent years, education has evolved to incorporate more innovative technologies in the classroom. The recent COVID-19 pandemic has accelerated this digital transformation, as educators have been forced</div>
	</div>
</div>	
	 </div>




	<div class="col-xs-12 col-sm-12 col-md-5 topmod2">
		<h2 class="subhead">Top Trending Stories</h2>
<ul class="filist">

@foreach($topTrendArticle as $top)
@if($loop->index < 4)

<li>
<div class="imgbl"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}"><img src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($top->image_path); }}"></a></div>
<div class="conblk">
<div class="tagl"><a href="#">Health And Fitness Franchise</a></div>

<div class="hname"> <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article'); }}">{{(strlen($top->title) > 45) ? substr(trim($top->title),0,40)."..." : trim($top->title)}}</a></div>
<div class="aname"><a href="{{(!is_null($top->getAuthor)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($top->getAuthorName->name,$top->getAuthorName->id,'author') : '#' }}">{{!is_null($top->getAuthor) ? $top->getAuthor->name : 'Sneha Santra'}}</a></div>
</div>
</li>
@endif
@endforeach

</ul>		
</div>	
</div>
</div>
</div>