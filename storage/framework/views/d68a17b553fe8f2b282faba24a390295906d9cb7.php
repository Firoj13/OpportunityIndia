<div class="headblk">
	<div class="container">
		<h1 class="mainhead"><?php echo e(Lang::get('messages.Insights.ideas.Opportunities.Growth.')); ?></h1>
		<div class="subtxt"><?php echo e(Lang::get('messages.Heading1')); ?></div>
	</div>
</div>

<div class="topblk">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 topmod1">
				<div class="topslidercomman">
					<div class="container">
						<div class="swiper-container swiper-container-initialized swiper-container-horizontal">
							<div class="swiper-wrapper" style="transform: translate3d(-311.25px, 0px, 0px); transition-duration: 0ms;">
								<!-- below list start here  1-->
								<?php $__currentLoopData = $sliderArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<div class="swiper-slide swiper-slide-next" style="width: 296.25px; margin-right: 15px;">
										<div class="topimgbl">

											<img alt="<?php echo e($slide->title); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($slide->image_path)); ?>">
											<div class="overlay">

												<div class="topcat"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($slide->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($slide->getTagName->name) : ($slide->getTagName->name)); ?></a></div>

												<div class="tophead"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($slide->title,$slide->id,'article')); ?>"><?php echo e(trim($slide->title)); ?></a></div>
												<div class="toptxt"><?php echo e($slide->short_desc); ?></div>
											</div>
										</div>
									</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<!-- below list end here  1 -->
							</div>
							<div class="swiper-pagination"></div>
							<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-5 topmod2">
				<h2 class="subhead"><?php echo e(Lang::get('messages.TopTrendingStories')); ?></h2>
				<ul class="filist">
					<?php $__currentLoopData = $topTrendArticle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($loop->index < 4): ?>
							<li>
								<div class="imgbl"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article')); ?>"><img alt="<?php echo e($top->title); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($top->image_path)); ?>"></a></div>
								<div class="conblk">
									<div class="tagl"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($top->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($top->getTagName->name) : ($top->getTagName->name)); ?></a></div>

									<div class="hname">
										
											<a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($top->title,$top->id,'article')); ?>"><?php echo e(trim($top->title)); ?></a>
										
									</div>
									<!--<div class="aname"><a href="<?php echo e((!is_null($top->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($top->getAuthorName->name,$top->getAuthorName->id,'author') : '#'); ?>"><?php echo e(!is_null($top->getAuthorName) ? $top->getAuthorName->name : 'OpportunityIndia Desk'); ?></a></div>-->
								</div>
							</li>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div style="text-align: center;margin:30px auto; width:820px;max-width: 100%;">
	<a href="https://www.indiaev.org/" target="_blank"><img src="https://opportunityindia.franchiseindia.com/img/ev-mumbai-banner.jpg" alt="Electric Vehicle Confex & Awards" class="img-fluid" style="border:1px solid #f1f1f1;"></a>
</div> 
<?php /**PATH /home/swatantra/adil shared/opportunityindia.franchiseindia.com/resources/views/frontend/includes/toparticle.blade.php ENDPATH**/ ?>