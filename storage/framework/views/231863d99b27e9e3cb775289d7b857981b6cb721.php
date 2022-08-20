
<?php $__env->startSection('seoTitle', Lang::get('messages.Title')); ?>
<?php $__env->startSection('seoKeywords', Lang::get('messages.Keywords')); ?>
<?php $__env->startSection('seoDesc', Lang::get('messages.Description')); ?>
<?php $__env->startSection('shortDesc', Lang::get('messages.Description')); ?>
<?php $__env->startSection('canonicalUrl', URL::current()); ?>
<?php $__env->startSection('url', URL::current()); ?>
<?php $__env->startSection('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl($sliderArticles[0]->image_path)); ?>
<?php $__env->startSection('content'); ?>
<div class="maininnver homeh">

    <?php echo $__env->make("frontend.includes.toparticle", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.topeditor", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.smallidea", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.magblock", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.localbusiness", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.adsblk", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.topfranchisecategories", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.emergingindia", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.lastestvideoblk", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("frontend.includes.podcastblk", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php echo $__env->make('frontend.includes.adsblk2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swatantra/adil shared/opportunityindia.franchiseindia.com/resources/views/frontend/index.blade.php ENDPATH**/ ?>