<div class="slidercomman">
    <div class="container">
        <div class="comhead">
            <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.StartupURL'))))); ?>"><?php echo e(Lang::get('messages.Startup')); ?></a>
            <span class="slidervall">
	            <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.StartupURL'))))); ?>">View All</a>
            </span>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
            <?php $__currentLoopData = $localBusinessList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- below list start here  1-->
                    <div class="swiper-slide">
                        <div class="innerlist">
                            <div class="imgbl">
                                <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->title,$lbl->id,'article')); ?>">
                                    <img alt="<?php echo e($lbl->title); ?>" loading="lazy" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($lbl->image_path)); ?>">
                                </a>
                            </div>
                            <div class="conblk">
                                <div class="tagl"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($lbl->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($lbl->getTagName->name) : ($lbl->getTagName->name)); ?></a></div>
                                <?php if(Request::segment(1) == Config('constants.LANGUAGE_TYPE.HINDI')): ?>
                                    <div class="hname"> <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->title,$lbl->id,'article')); ?>"><?php echo e($lbl->title); ?></a></div>
                                <?php else: ?>
                                    <div class="hname"> <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->title,$lbl->id,'article')); ?>"><?php echo e((strlen($lbl->title) > 60) ? substr(trim($lbl->title),0,55)."..." : trim($lbl->title)); ?></a></div>
                                <?php endif; ?>
                                <div class="aname">
                                    <a href="<?php echo e((!is_null($lbl->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($lbl->getAuthorName->name,$lbl->getAuthorName->id,'author') : '#'); ?>"><?php echo e(!is_null($lbl->getAuthorName) ? ucwords($lbl->getAuthorName->name) : 'OpportunityIndia Desk'); ?></a>
                                    <span class="h1w"></span><?php echo e(date('M d, Y',strtotime($lbl->created_at))); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <!-- below list end here  1 -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/includes/localbusiness.blade.php ENDPATH**/ ?>