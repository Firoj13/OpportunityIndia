<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('frontend.layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>
<?php echo $__env->make('frontend.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->make('frontend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-61b891cbfd202d0a"></script>

<script id="dsq-count-scr" src="//opportunityindia.disqus.com/count.js" async></script>

</body>
</html>
<?php /**PATH /home/swatantra/adil shared/opportunityindia.franchiseindia.com (1)/opportunityindia.franchiseindia.com/resources/views/frontend/layouts/master.blade.php ENDPATH**/ ?>