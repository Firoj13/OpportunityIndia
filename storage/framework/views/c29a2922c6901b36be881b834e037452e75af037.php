<div class="maycontentblk">
<div class="container">
<div class="headbh">You May Also like</div>

  <div class="swiper-container">
    <div class="swiper-wrapper">
<?php $__currentLoopData = $youmaylike; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ymk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>      
<!-- 1  -->
<div class="swiper-slide">      
<div class="mabox">
<div class="imgsec"> 
<a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($ymk->title,$ymk->id,'article')); ?>"><img alt="<?php echo e($ymk->title); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($ymk->image_path)); ?>"></a>
</div>
<div class="catblk">
<div class="catname"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($ymk->getTagName->slug)); ?>"><?php echo e($ymk->getTagName->name); ?></a></div>
<div class="artihead"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($ymk->title,$ymk->id,'article')); ?>"><?php echo e($ymk->title); ?></a></div>
</div>
</div> 
</div>
<!--1  -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
   <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

</div>
</div><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/includes/youmaylike.blade.php ENDPATH**/ ?>