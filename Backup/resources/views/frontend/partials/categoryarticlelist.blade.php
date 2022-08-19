@foreach($article as $alist)
<li>
<div class="artimgblk">
    <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}"><img alt="{{$alist->title}}" src="{{ \App\Http\Controllers\Frontend\IndexController::createimgurl($alist->image_path); }}" alt=""></a>
</div>
<div class="artcontent">
    <div class="catname"><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($alist->getTagName->slug)}}">{{(App::getLocale() == 'en') ? ucwords($alist->getTagName->name) : ($alist->getTagName->name)}}</a></div>
<div class="haedname"><a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}">{{$alist->title}}</a></div>
<div class="authblk cot">
<div class="autimg"><img alt="" src="{{\App\Http\Controllers\Frontend\IndexController::authorImageurl($alist->getAuthorName->image_path)}}" alt="{{$alist->getAuthorName->name}}"></div>
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
                                        <a href="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}#disqus_thread"><img alt="comment" src="{{url('images/smallcomment.svg')}}" alt=""> Comment</a>
                                    </div>

                                     <div class="shrblk">
<span class="inshrblk"><a href="javascript:void();"><img alt="share" src="{{url('images/smallshare.svg')}}" class="inimg"> Share
                                            <div class="sfv">
                                                <div class="addthis_inline_share_toolbox" data-url="{{ \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article'); }}" data-title="{{ $alist->title }}" data-description="{{ $alist->title }}" data-media="{{ $alist->short_desc }}"></div>

                                            {{--<div class="innersfv" onclick=""><img src="{{url('images/facebookcard.svg')}}"></div>--}}
                                            {{--<div class="innersfv" onclick=""><img src="{{url('images/twittercard.svg')}}"></div>--}}
                                            {{--<div class="innersfv" onclick=""><img src="{{url('images/linkedincard.svg')}}"></div>--}}
                                            {{--<div class="innersfv" onclick=""><img src="{{url('images/mailcard.svg')}}"></div>--}}
                                            </div>
                                            </a>
                                        </span>
                                    </div>
                                </div>

</div>
</div>
</li>
@endforeach
