@extends('frontend.layouts.master')

@section('canonicalUrl', url(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($articlesList[0]->getTagName->slug)))
@section('url', url(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($articlesList[0]->getTagName->slug)))
@section('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl($articlesList[0]->image_path))
@section('alturls')

@stop
@section('content')
    <div class="maininnver homeh">
        <div class="container">
            <h1 class="cathead">Search for {{Illuminate\Support\Str::limit($search, 10,'...')}}</h1>
        </div>

        <div class="listblk">
            <div class="container">
                <ul class="artilsit">
                    @foreach($articlesList as $alist)
                        <li>
                            <div class="artimgblk">
                                <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}"><img src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($alist->image_path); }}" alt=""></a>
                            </div>
                            <div class="artcontent">
                                <div class="catname">
                                    <a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($alist->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($alist->getTagName->name) : ($alist->getTagName->name)}}</a></div>
                                <div class="haedname">
                                    <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}">{{$alist->title}}</a></div>
                                <div class="authblk cot">
                                    <div class="autimg">
                                        <img src="{{\App\Http\Controllers\Frontend\IndexController::authorImageurl($alist->getAuthorName->image_path)}}" alt=""></div>
                                    <div class="autinfo">
                                        <span><a href="{{(!is_null($alist->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->getAuthorName->name,$alist->getAuthorName->id,'author') : '#' }}">{{!is_null($alist->getAuthorName) ? $alist->getAuthorName->name : 'OpportunityIndia Desk'}}</a></span>
                                        {{date('M d Y',strtotime($alist->created_at))}} - {{\App\Http\Controllers\Frontend\IndexController::calculateReadTime($alist)}} min read

                                    </div>
                                </div>
                                <div class="stext">
                                    {{strip_tags(\Illuminate\Support\Str::words($alist->content, 55 , ' ...'))}}
                                </div>

                                <div class="scbk myscbk">
                                    <div class="cmtblk">
                                        <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}#disqus_thread"><img src="{{url('images/smallcomment.svg')}}" alt=""> Comment</a>
                                    </div>

                                     <div class="shrblk">
<span class="inshrblk"><a href="javascript:void();"><img src="{{url('images/smallshare.svg')}}" class="inimg"> Share
                                            <div class="sfv">
                                                <div class="addthis_inline_share_toolbox" data-url="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}" data-title="{{ $alist->title }}" data-description="{{ $alist->title }}" data-media="{{ $alist->short_desc }}"></div>
                                            </div>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    @if($articleCount > 5)
                        @php $noofpage = round($articleCount/5) + 1; @endphp
                        <span data-page={{$noofpage}} class="readmore">Load More...</span>
                    @endif
                </ul>
            </div>
        </div>

        <!-- mag block strat  -->
    @include('frontend.includes.magblock')
    <!-- mag block end   -->

        @include('frontend.includes.brandlist')
    </div>
    @push('child-scripts')
    <script>

        $(function(){

             var page = '2';
             $('.readmore').click(function(){
                 $.ajax({
                     url: "/seach-article/{{$search}}/"+page,
                     method: "GET",
                 }).done(function( data ) {
                     if(data){
                         page++;
                         $('.readmore').before( data );
                         if($('.readmore').attr('data-page') == page)
                         {
                             $('.readmore').hide();
                         }
                        if(typeof addthis !== 'undefined') { addthis.layers.refresh(); }
                    }

                });

            })


        })

    </script>
    @endpush

@stop
