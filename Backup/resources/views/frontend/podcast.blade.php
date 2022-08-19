@extends('frontend.layouts.master')
@section('content')
<div class="maininnver">
<div class="container">
<h1 class="cathead pd47">VIDEOS</h1>
</div>

<div class="listblk">
  <div class="container">

  	<ul class="artilsit">
        @foreach($listVideo as $lv)
        @if($loop->index < 5)
           <li>

                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=-vvLupirg8U">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="https://img.youtube.com/vi/-vvLupirg8U/hqdefault.jpg" alt="Nick Avgerinos speaks of franchising and trends present in the Indian F&amp;B market">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="https://video.franchiseindia.com/nick-avgerinos-speaks-of-franchising-and-trends-present-in-the-indian-fb-market/-vvLupirg8U">Nick Avgerinos speaks of franchising and trends present in the Indian F&amp;B market</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">November, 03 2018</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>12</span></div>
                                    </div>
                                </div>

                                <div class="stext">
                                                                            In conversation with Senior Editor Payal Gulati, Nick Avgerinos, General Manager-Franchise Development, The Cheesecake Shop (Australia) speaks of franchising and trends present in the Indian F&amp;B marke...
                                                                    </div>

                            </div>
                        </div>

                </div></li>


                     <li>
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="{{$lv['url']}}">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="{{$lv['image']}}" alt="{{$lv['title']}}">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="{{$lv['url']}}">{{$lv['title']}}</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">{{$lv['createDate']}}</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>{{$lv['views']}}</span></div>

                                    </div>
                                </div>
                                <div class="stext">{{$lv['title']}}</div>
                                </div>
                            </div>
                        </div>

                </li>
        @endif
        @endforeach

                                                                                                <li>
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=qbEtU4ZmkBk">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="https://img.youtube.com/vi/qbEtU4ZmkBk/hqdefault.jpg" alt="The Sector Startups Should Focus On ">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="https://video.franchiseindia.com/the-sector-startups-should-focus-on/qbEtU4ZmkBk">The Sector Startups Should Focus On </a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">October, 24 2018</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>46</span></div>
                                    </div>
                                </div>

                                <div class="stext">
                                                                            Our Features Editor Pooja Singh speaks to Winny Patro, CEO of Andhra Pradesh Innovation Society, to understand why founders should look beyond the urban regions and address the gaps in the rural areas...
                                                                    </div>

                            </div>
                        </div>

                </div></li>

                     <li>
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=a1oofRAaHFM">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="https://img.youtube.com/vi/a1oofRAaHFM/hqdefault.jpg" alt="Most Unique Courses To Make Your Education Business Standout By Franchise India">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="https://video.franchiseindia.com/most-unique-courses-to-make-your-education-business-standout-by-franchise-india/a1oofRAaHFM">Most Unique Courses To Make Your Education Business Standout By Franchise India</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">October, 19 2018</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>87</span></div>
                                    </div>
                                </div>

                                <div class="stext">
                                                                            Franchise India presents the most unique courses to make your education business standout.
                                                                    </div>

                            </div>
                        </div>

                </div></li>
                      <li>
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=1G50TEZbhs4">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="https://img.youtube.com/vi/1G50TEZbhs4/hqdefault.jpg" alt="Sanjeev Arora shares Franchising Tips with Franchise India">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="https://video.franchiseindia.com/sanjeev-arora-shares-franchising-tips-with-franchise-india/1G50TEZbhs4">Sanjeev Arora shares Franchising Tips with Franchise India</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">October, 18 2018</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>86</span></div>
                                    </div>
                                </div>

                                <div class="stext">
                                                                            In a conversation with Franchise India, Sanjeev Arora, Chief Operating Officer, Phonup Franchise, India shares their Franchising Tips, expansion plans and much more.
                                                                    </div>

                            </div>
                        </div>

                </div></li>
            </ul></div></div>
<!-- mag block strat  -->
@include("frontend.includes.magblock")

<div class="podcastblk">
<div class="container">

<div class="comhead"><a href="#">Podcast - Grow With Gaurav</a> <span class="slidervall"><a href="https://www.gauravmarya.com/podcast/" target="_blank">View All</a></span></div>
</div>

<div class="container">


<!-- below list start here  -->
<ul class="podcastlist">
<li>
<div class="imgbl">
<div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}"></div>
    <a href="https://www.gauravmarya.com/podcast/" target="_blank">
        <img src="{{url('images/gwg/gwg12.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.gauravmarya.com/podcast/" target="_blank">Steps To Achieve Operational Excellence | BEx Academy</a></div>
</div>
</li>
<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}">
    </div><a href="https://www.gauravmarya.com/podcast/" target="_blank">
        <img src="{{url('images/gwg/gwg11.jpg')}}" class="pdimg"></a>
    </div>
<div class="conblk">
<div class="hname"> <a href="https://www.gauravmarya.com/podcast/" target="_blank">Data Intelligence For Business Excellence | BEx Academy</a></div>
</div>
</li>
<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}">
    </div>
        <a href="https://www.gauravmarya.com/podcast/" target="_blank"><img src="{{url('images/gwg/gwg10.jpg')}}" class="pdimg"></a>
    </div>
<div class="conblk">
<div class="hname"> <a href="https://www.gauravmarya.com/podcast/" target="_blank">Business Transformation through Workforce Alignment | BEx Academy</a></div>
</div>
</li>
<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}"></div>
    <a href="https://www.gauravmarya.com/podcast/" target="_blank"><img src="{{url('images/gwg/gwg9.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.gauravmarya.com/podcast/" target="_blank">Developing a Customer Centric Strategy For Your Business | BEx Academy</a></div>
</div>
</li>

<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}">
    </div><a href="https://www.gauravmarya.com/podcast/" target="_blank">
        <img src="{{url('images/gwg/gwg8.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.gauravmarya.com/podcast/" target="_blank">Achieving Business Excellence through Effective Leadership | BEx Academy</a></div>
</div>
</li>


<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}"></div>
    <a href="https://www.gauravmarya.com/podcast/" target="_blank"><img src="{{url('images/gwg/gwg7.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.gauravmarya.com/podcast/" target="_blank">Fundamentals of Business Excellence | BEx Academy</a></div>

</div>
</li>

</ul>

<!-- below list start here  -->
</div>
</div>


<div class="listblk">
  <div class="container">

    <ul class="artilsit">
        @foreach($listVideo as $lv)
        @if($loop->index >4 && $loop->index <10 )
                     <li>

                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=-vvLupirg8U">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="https://img.youtube.com/vi/-vvLupirg8U/hqdefault.jpg" alt="Nick Avgerinos speaks of franchising and trends present in the Indian F&amp;B market">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="https://video.franchiseindia.com/nick-avgerinos-speaks-of-franchising-and-trends-present-in-the-indian-fb-market/-vvLupirg8U">Nick Avgerinos speaks of franchising and trends present in the Indian F&amp;B market</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">November, 03 2018</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>12</span></div>
                                    </div>
                                </div>

                                <div class="stext">
                                                                            In conversation with Senior Editor Payal Gulati, Nick Avgerinos, General Manager-Franchise Development, The Cheesecake Shop (Australia) speaks of franchising and trends present in the Indian F&amp;B marke...
                                                                    </div>

                            </div>
                        </div>

                </div></li>
                                                                                                <li>
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="{{$lv['url']}}">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="{{$lv['image']}}" alt="{{$lv['title']}}">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="{{$lv['url']}}">{{$lv['title']}}</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">{{$lv['createDate']}}</div>

                                    </div>
                                </div>
                            </div>
                                <div class="stext">{{$lv['title']}}</div>
                            </div>
                        </div>
                                                                                                </li>

                @endif
                @endforeach

                         <li>
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=a1oofRAaHFM">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="https://img.youtube.com/vi/a1oofRAaHFM/hqdefault.jpg" alt="Most Unique Courses To Make Your Education Business Standout By Franchise India">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="https://video.franchiseindia.com/most-unique-courses-to-make-your-education-business-standout-by-franchise-india/a1oofRAaHFM">Most Unique Courses To Make Your Education Business Standout By Franchise India</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">October, 19 2018</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>87</span></div>
                                    </div>
                                </div>

                                <div class="stext">
                                        Franchise India presents the most unique courses to make your education business standout.
                                </div>

                            </div>
                        </div>

                </div></li>
                                                                                                <li>
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=1G50TEZbhs4">
                                <div class="artimgblk">
                                    <span class="overnew"></span>
                                    <span class="artimgblk-yt"><img src="{{url('images/play-button.svg')}}"></span>
                                    <img src="https://img.youtube.com/vi/1G50TEZbhs4/hqdefault.jpg" alt="Sanjeev Arora shares Franchising Tips with Franchise India">
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="artcontent myartlist">
                                <div class="haedname"><a href="https://video.franchiseindia.com/sanjeev-arora-shares-franchising-tips-with-franchise-india/1G50TEZbhs4">Sanjeev Arora shares Franchising Tips with Franchise India</a></div>

                                <div class="myblk">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 myblk-lt col-sm-6 col-xs-6">October, 18 2018</div>
                                        <div class="col-lg-6 col-md-6 myblk-rt col-sm-6 col-xs-6"><img src="{{asset('images/viewnew.png')}}"> <span>86</span></div>
                                    </div>
                                </div>

                                <div class="stext">
                                                                            In a conversation with Franchise India, Sanjeev Arora, Chief Operating Officer, Phonup Franchise, India shares their Franchising Tips, expansion plans and much more.
                                                                    </div>

                            </div>
                        </div>

                </div></li></ul></div></div>


<div class="podcastblk">
<div class="container">

<div class="comhead"><a href="#">Podcast - TheFranchising World</a> <span class="slidervall"><a href="https://www.thefranchisingworld.com/" target="_blank">View All</a></span></div>
</div>

<div class="container">


<!-- below list start here  -->
<ul class="podcastlist">
<li>
<div class="imgbl">
<div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}"></div>
    <a href="https://www.thefranchisingworld.com/" target="_blank">
        <img src="{{url('images/tfw/tfw12.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.thefranchisingworld.com/" target="_blank">Why Owning a Used Two Wheeler Franchise is a Profitable Opportunity</a></div>
</div>
</li>
<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}">
    </div><a href="https://www.thefranchisingworld.com/" target="_blank">
        <img src="{{url('images/tfw/tfw11.jpg')}}" class="pdimg"></a>
    </div>
<div class="conblk">
<div class="hname"> <a href="https://www.thefranchisingworld.com/" target="_blank">Why Investing in an Ed-tech Franchise Business is Fruitful?</a></div>
</div>
</li>
<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}">
    </div>
        <a href="https://www.thefranchisingworld.com/" target="_blank"><img src="{{url('images/tfw/tfw10.jpg')}}" class="pdimg"></a>
    </div>
<div class="conblk">
<div class="hname"> <a href="https://www.thefranchisingworld.com/" target="_blank">How Lenskart Transformed The Eyewear Franchise Industry</a></div>
</div>
</li>
<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}"></div>
    <a href="https://www.thefranchisingworld.com/" target="_blank"><img src="{{url('images/tfw/tfw9.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.thefranchisingworld.com/" target="_blank">How OYO Will Revitalize The Hotel And Franchise Business In The Post-Covid Era.</a></div>
</div>
</li>

<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}">
    </div><a href="https://www.thefranchisingworld.com/" target="_blank">
        <img src="{{url('images/tfw/tfw8.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.thefranchisingworld.com/" target="_blank">Do Stockbroking Franchises Make Sense As An Investment?</a></div>
</div>
</li>


<li>
<div class="imgbl"><div class="playbtn"><img src="{{url('images/play-buttongrey.svg')}}"></div>
    <a href="https://www.thefranchisingworld.com/" target="_blank"><img src="{{url('images/tfw/tfw7.jpg')}}" class="pdimg"></a></div>
<div class="conblk">
<div class="hname"> <a href="https://www.thefranchisingworld.com/" target="_blank">Re-Inventing Education: Conquering The Crisis</a></div>

</div>
</li>

</ul>

<!-- below list start here  -->
</div>
</div>


</div>
@stop
