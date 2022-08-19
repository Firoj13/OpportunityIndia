<div class="slidercomman">
	<div class="container">
		<div class="comhead">
			<a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.Franchise'))))); ?>"><?php echo e(Lang::get('messages.Franchise')); ?></a>
			<span class="slidervall">
				<a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.Franchise'))))); ?>">View All</a>
			</span>
		</div>
		<div class="swiper-container">
			<div class="swiper-wrapper">
			<?php $__currentLoopData = $emergingIndiaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<!-- below list start here  1-->
                    <div class="swiper-slide">
                        <div class="innerlist">
                            <div class="imgbl">
                                <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($emil->title,$emil->id,'article')); ?>">
                                    <img loading="lazy" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($emil->image_path)); ?>" alt="<?php echo e($emil->title); ?>">
                                </a>
                            </div>
                            <div class="conblk">
                                <div class="tagl"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($emil->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($emil->getTagName->name) : ($emil->getTagName->name)); ?></a></div>
                                <?php if(Request::segment(1) == Config('constants.LANGUAGE_TYPE.HINDI')): ?>
                                    <div class="hname"> <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($emil->title,$emil->id,'article')); ?>"><?php echo e($emil->title); ?></a></div>
                                <?php else: ?>
                                    <div class="hname"> <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($emil->title,$emil->id,'article')); ?>"><?php echo e((strlen($emil->title) > 60) ? substr(trim($emil->title),0,55)."..." : trim($emil->title)); ?></a></div>
                                <?php endif; ?>
                                <div class="aname">
                                    <a href="<?php echo e((!is_null($emil->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($emil->getAuthorName->name,$emil->getAuthorName->id,'author') : '#'); ?>"><?php echo e(!is_null($emil->getAuthorName) ? ucwords($emil->getAuthorName->name) : 'OpportunityIndia Desk'); ?></a>
                                    <span class="h1w"></span><?php echo e(date('M d, Y',strtotime($emil->created_at))); ?>

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
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/includes/emergingindia.blade.php ENDPATH**/ ?>