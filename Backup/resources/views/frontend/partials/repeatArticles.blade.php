        <div class="repeatarts">
        <div class="contentblk">
            <div class="data" data-id="{{$article->id}}" data-href="{{\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article')}}"></div>
            <div class="container">
                <div class="catlinks"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($article->getTagName->slug)}}">{{$article->getTagName->name}}</a></div>
                <h1>{{$article->title}}</h1>
                <div class="authblk">
                    <div class="autimg"><img src="{{\App\Http\Controllers\Frontend\IndexController::authorImageurl($article->getAuthorName->image_path)}}" alt=""></div>
                    <div class="autinfo">
                        <span><a href="{{(!is_null($article->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($article->getAuthorName->name,$article->getAuthorName->id,'author') : '#' }}">{{!is_null($article->getAuthorName) ? $article->getAuthorName->name : 'OpportunityIndia Desk'}}</a></span>

                        {{date('M d Y',strtotime($article->created_at))}} - {{\App\Http\Controllers\Frontend\IndexController::calculateReadTime($article)}} min read
                    </div>
                </div>
            </div>
        </div>

        <div class="contentarea">
            <div class="imgblk">
                <img src="{{!empty($article->image_path) ? \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/')) : 'https://franchiseindia.s3.ap-south-1.amazonaws.com/uploads/content/fi/int/5ff40e6aaa3da.jpeg'}}" alt="">
            </div>

            @include("frontend.includes.socailcomment")

            @if(!is_null($article->getAudioFiles))
                @include("frontend.includes.audio")
            @endif

            <div class="shortdes">
                {{$article->short_desc}}
            </div>

            <div class="articlecontent">
                {!! $article->content !!}
            </div>
        </div>

        <!-- Some content after mag sub start here  -->
        <div class="contentarea">
            <div class="tag-block">
                <ul class="tag-list">
                    @foreach($article->getAssocTags as $assoctags)
                        <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($assoctags->getTagsId->slug)}}">{{$assoctags->getTagsId->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            @include("frontend.includes.socailcomment")
            @include("frontend.includes.disqusCommentsBlock")
            @include("frontend.includes.subscribenewsletter")
        </div>

        @include("frontend.includes.magblock")

        <!--  --> 
        @include("frontend.includes.youmaylike")
        <!--  -->
    </div>