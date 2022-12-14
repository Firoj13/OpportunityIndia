<meta charset="UTF-8">
<title>@yield('seoTitle', 'Opportunity India')</title>
<meta name="description" content="@yield('seoDesc', 'Opportunity India')" />
<meta name="news_keywords" content="@yield('seoKeywords', 'Opportunity India')" />
<link href="@yield('canonicalUrl', request()->get('page') ? url()->full() : url()->current())" rel="canonical">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta property="fb:pages" content="102256424572280" />
<meta itemprop="headline" content="@yield('seoTitle')" />
<meta itemprop="description" content="@yield('shortDesc')">
<meta itemprop="image" content="@yield('imagesrc')">
<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="@yield('url')" />
<meta name="original-source" content="@yield('url')" />
<meta property="article:section" itemprop="articleSection" content="" />
<meta property="article:tag" content="@yield('seoKeywords')" />
<meta property="article:published_time" itemprop="datePublished" content="@yield('createTime')" />
<meta property="article:modified_time" itemprop="dateModified" content="@yield('updateTime')" />
<meta property="og:title" content="@yield('seoTitle')">
<meta property="og:type" content="article" />
<meta property="og:url" content="@yield('url')">
<meta property="og:image:secure_url" content="@yield('imagesrc')" />
<meta property="og:image" content="@yield('imagesrc')">
<meta property="og:description" content="@yield('shortDesc')">
<meta property="og:image:width" content="1000" />
<meta property="og:image:height" content="562" />
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:title" content="@yield('seoTitle')">
<meta name="twitter:image" content="@yield('imagesrc')">
<meta name="twitter:description" content="@yield('shortDesc')">
<meta name="twitter:url" content="@yield('url')">
<meta name="twitter:image:src" content="@yield('imagesrc')">
<meta name="twitter:creator" content="@OpportunityIndia">
<meta name="twitter:site" content="@OpportunityIndia">
<meta name="twitter:domain" content="opportunityindia.franchiseindia.com">
<meta content="@yield('noindex', 'index,follow')" name="robots"/>
<link rel="shortcut icon" href="{{url('/img/favicon.ico')}}" type="image/x-icon" />
<!-- Favicons -->
<link href="{{url('/img/favicon.ico')}}" rel="icon">
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;600;700;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<!-- Vendor CSS Files -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

<link href="{{url('vendor/icofont/icofont.min.css')}}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.0.3/css/swiper.min.css" integrity="sha512-B64xavgNg8O5H36FdjDVx2oHbYPgdjPFAYfUd2JSA6QOM6Bti10WpVk0Kx2FJbGhGJ5vabsxqbybigqm1Z8gOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="{{url('css/style.css?ver=5')}}" rel="stylesheet">

<!-- Java Script -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-8863112-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-8863112-3');
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WGEY8YK6RB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-WGEY8YK6RB');
</script>

