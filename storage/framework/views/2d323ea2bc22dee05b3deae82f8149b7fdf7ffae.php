<div class="slidercomman">
	<div class="container">
		<div class="comhead">
			<a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.SmallBusiness'))))); ?>"><?php echo e(Lang::get('messages.SmallBusinessIdeas')); ?></a>
			<span class="slidervall">
				<a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl(preg_replace("/[\s]/", '-', strtolower(Lang::get('messages.SmallBusiness'))))); ?>">View All</a>
			</span>
		</div>
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<?php $__currentLoopData = $smallideaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<!-- below list start here  1-->
					<div class="swiper-slide">
						<div class="innerlist">
							<div class="imgbl"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($sil->title,$sil->id,'article')); ?>"><img loading="lazy" alt="<?php echo e($sil->title); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($sil->image_path)); ?>"></a></div>
							<div class="conblk">
								<div class="tagl"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($sil->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($sil->getTagName->name) : ($sil->getTagName->name)); ?></a></div>
								<div class="hname"> <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($sil->title,$sil->id,'article')); ?>"><?php echo e($sil->title); ?></a></div>
								<div class="aname"><a href="<?php echo e((!is_null($sil->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($sil->getAuthorName->name,$sil->getAuthorName->id,'author') : '#'); ?>"><?php echo e(!is_null($sil->getAuthorName) ? $sil->getAuthorName->name : 'OpportunityIndia Desk'); ?></a> <span class="h1w"></span><?php echo e(date('M d, Y',strtotime($sil->created_at))); ?></div>
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

<!-- <div style="text-align: center;margin:30px auto; width:820px;max-width: 100%;">
	<a href="https://www.franchiseindia.com/brands/grocery-4-u-retail-pvt-ltd.49833" target="_blank"><img src="https://opportunityindia.franchiseindia.com/img/grocery.jpg" alt="Grocery 4 U Retail Pvt ltd" class="img-fluid" style="border:1px solid #f1f1f1;"></a>
</div> -->
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/includes/smallidea.blade.php ENDPATH**/ ?>