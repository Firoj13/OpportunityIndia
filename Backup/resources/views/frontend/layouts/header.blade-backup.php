<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
<div class="topmenu">
<div class="container-fluid">
<div class="row">
  <div class="col-lg-3">
<span class="top1">#ApneBrandsKiNayiMarket</span>
  </div>
  <div class="col-lg-5 text-right">
<ul class="top-ul">
  <li><a href="" target="_blank">EXPAND YOUR BUSINESS</a> | </li> 
  <li><a href="" target="_blank">GET FRANCHISE</a></li>
</ul>
  </div>
<div class="col-lg-2">
<span class="call">1800 102 2007 <span class="tel-img"><img src="{{url('img/tel.png')}}"></span> </span>
</div>
  <div class="col-lg-2">
<div class="topright">
  <ul class="togl">
    @yield('alturls')
    <li @if(App::getLocale() == 'en') class="active" @endif><a href="{{url('language/en')}}">English</a></li>
    <li @if(App::getLocale() == 'hi') class="active" @endif><a href="{{url('language/hi')}}">Hindi</a></li>    
  </ul>
  <!--<div class="tuser"><img src="{{url('images/profile-user.svg')}}" alt=""></div>-->
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
           <a href="{{url($murl)}}" class="logo mr-auto"><img src="{{url('img/logo.svg')}}" alt="Franchise India"></a>

          <nav class="nav-menu d-none d-lg-block">
            <ul>
             
<!--               <li class="active"><a href="#">Home</a></li> -->
              <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.SmallBusiness'))))}}">{{ Lang::get('messages.SmallBusiness') }}</a></li>
              <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl( preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.StartupURL'))))}}">{{ Lang::get('messages.Startup') }}</a></li>
              <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',  strtolower(Lang::get('messages.Franchise'))))}}">{{ Lang::get('messages.Franchise') }}</a></li>
              <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.EmergingIndia'))))}}">{{ Lang::get('messages.EmergingIndia') }}</a></li>
              <li><a href="{{\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-',strtolower(Lang::get('messages.RealEstate'))))}}">{{ Lang::get('messages.RealEstate') }}</a></li>
              <li><a href="{{url('/podcast')}}">{{ Lang::get('messages.Podcast') }}</a></li>
             
            </ul>
          </nav><!-- .nav-menu -->
                                               
        </div>
      </div>
    </div>
   </div> 
  </header><!-- End Header -->
