<!DOCTYPE html>
<html>
<head>
    @include('frontend.layouts.head')
</head>
<body>
@include('frontend.layouts.header')
@yield('content')
@include('frontend.layouts.footer')
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-61b891cbfd202d0a"></script>

<script id="dsq-count-scr" src="//opportunityindia.disqus.com/count.js" async></script>

</body>
</html>
