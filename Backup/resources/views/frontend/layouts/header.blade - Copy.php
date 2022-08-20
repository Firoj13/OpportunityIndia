<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
<div class="topmenu">
<div class="container-fluid">
<div class="row">
  <div class="col-lg-3 col-md-3 col-xl-2 offset-xl-1">
<span class="top1">#ApneBrandsKiNayiMarket</span>
  </div>
   <div class="col-lg-5 col-xl-5 col-md-5 text-right">
<ul class="top-ul">
  <li><a data-toggle="modal" data-target="#myModal">EXPAND YOUR BUSINESS</a> <span>|</span> </li>
  <li><a href="https://www.franchiseindia.com/" target="_blank">GET FRANCHISE</a> <span>|</span> </li>
  <li><a href="https://dealer.franchiseindia.com/" target="_blank">GET DISTRIBUTORSHIP</a></li>
</ul>
  </div>
<div class="col-lg-2 col-xl-2 col-md-2">
<span class="call">1800 102 2007 <span class="tel-img"><img src="{{url('img/tel.png')}}" alt="tel.png"></span> </span>
</div>
  <div class="col-lg-2 col-md-2">
<div class="topright">
  <ul class="togl">
    @yield('alturls')
    <li @if(App::getLocale() == 'en') class="active" @endif><a href="{{url('language/en')}}">English</a></li>
    <li @if(App::getLocale() == 'hi') class="active" @endif><a href="{{url('language/hi')}}">Hindi</a></li>
  </ul>
</div>
</div>
</div>
</div>
</div>
<div class="logobar">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-12 d-flex align-items-center">

          <!-- Uncomment below if you prefer to use an image logo -->
          @php
          if(App::getLocale() == 'en'){
          $murl = '/';
          }else{
          $murl = '/hindi';
          }
          @endphp
           <a href="{{url($murl)}}" class="logo mr-auto"><img src="{{url('img/logo.png')}}" alt="Franchise India"></a>

          <nav class="nav-menu d-none d-lg-block">
            <ul>

<!--               <li class="active"><a href="#">Home</a></li> -->
                @if(App::getLocale() == 'en') <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.SmallBusiness'))))}}">{{ Lang::get('messages.SmallBusiness') }}</a></li> @else  <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', (Lang::get('messages.SmallBusiness'))))}}">{{ Lang::get('messages.SmallBusiness') }}</a></li> @endif
                @if(App::getLocale() == 'en')   <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',strtolower(Lang::get('messages.StartupURL'))))}}" target="_blank">{{ Lang::get('messages.Startup') }}</a></li> @else <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',strtolower(Lang::get('messages.StartupURL'))))}}" target="_blank">{{ Lang::get('messages.Startup') }}</a></li> @endif
                @if(App::getLocale() == 'en') <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',  strtolower(Lang::get('messages.Franchise'))))}}">{{ Lang::get('messages.Franchise') }}</a></li> @else <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',  (Lang::get('messages.Franchise'))))}}">{{ Lang::get('messages.Franchise') }}</a></li> @endif
                @if(App::getLocale() == 'en') <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.EmergingIndia'))))}}">{{ Lang::get('messages.EmergingIndia') }}</a></li> @else <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', (Lang::get('messages.EmergingIndia'))))}}">{{ Lang::get('messages.EmergingIndia') }}</a></li> @endif
                @if(App::getLocale() == 'en')  <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',strtolower(Lang::get('messages.RealEstateURL'))))}}">{{ Lang::get('messages.RealEstate') }}</a></li> @else <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',(Lang::get('messages.RealEstateURL'))))}}">{{ Lang::get('messages.RealEstate') }}</a></li> @endif
                <li><a href="{{url('/podcast')}}">{{ Lang::get('messages.Video&Podcast') }}</a></li>

            </ul>
          </nav><!-- .nav-menu -->
          
           <div class="search-main mx-auto">
                           <div class="ev-spk-icon">
                    <span id="tog1">
   <img src="{{asset('images/search.svg')}}" style="">
   <img src="{{asset('images/cross.png')}}" style="display: none;">
</span>
                </div>

          <div id="searchbar" style="display: none;">
            <form action="{{url('/search/article')}}" method="get">
                  <div class="input-group">
  <div class="form-outline">
    <input type="search" name="search" id="form1" class="form-control1" placeholder="Search here">
  </div>
  <button type="submit" class="btn1 btn-primary" value="Search">Search
  </button>

</div></form>
                </div>
    

        </div>
      </div>
    </div>
   </div>
  </header><!-- End Header -->
