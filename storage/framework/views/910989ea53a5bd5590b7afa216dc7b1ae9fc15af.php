<div class="lastestvideoblk">
	<div class="container">
		<div class="comhead"><a href="https://video.franchiseindia.com/"><?php echo e(Lang::get('messages.LatestVideo')); ?></a> <span class="slidervall"><a href="https://video.franchiseindia.com/">View All</a></span></div>
	</div>
	<div class="container">
		<div class="row">
			<?php $__currentLoopData = $listVideo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($loop->index == 0): ?>
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="editimgblk">
							<div class="overleytnew">
								<div class="playbtnnew"><a class="popup-youtube" href="<?php echo e($video['url']); ?>"><img alt="Play Button" src="<?php echo e(url('images/play-button.svg')); ?>"></a></div>
								<div class="showovet">
									<div class="topcatli">
										<a href="<?php echo e($video['url']); ?>"><?php echo e($video['category']); ?>

										</a>
									</div>
									<div class="shownametxt"><a class="popup-youtube" href=""><?php echo e($video['title']); ?></a></div>
									<div class="timeviw"><?php echo e($video['createDate']); ?> | <img src="<?php echo e(url('images/view.svg')); ?>" alt="View" class="viewy"> <?php echo e($video['views']); ?> Views</div>
								</div>
							</div>
							<a href="<?php echo e($video['url']); ?>"><img alt="<?php echo e($video['title']); ?>" src="<?php echo e($video['image']); ?>"></a>

						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<div class="col-xs-12 col-sm-12 col-md-6 spd">
				<ul class="editlistnew">
					<?php $__currentLoopData = $listVideo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($loop->index > 0 && $loop->index < 3): ?>
							<li>
								<div class="imgbl"><div class="playbtnnewsmal"><a class="popup-youtube" href="<?php echo e($video['url']); ?>"><img alt="Play" src="<?php echo e(url('images/play-button.svg')); ?>" class="v"></a></div><a class="popup-youtube" href="<?php echo e($video['url']); ?>"><img alt="<?php echo e($video['title']); ?>" src="<?php echo e($video['image']); ?>"></a></div>
								<div class="conblk">
									<div class="tagl"><a href="https://video.franchiseindia.com/category/<?php echo e($video['category']); ?>"><?php echo e($video['category']); ?></a></div>
									<div class="hname"><a class="popup-youtube" href="<?php echo e($video['url']); ?>"><?php echo e($video['title']); ?></a></div>
									<div class="aname"><a href="#">OpportunityIndia Desk</a> <span class="h1w"></span><?php echo e($video['createDate']); ?></div>
								</div>
							</li>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		</div>
		<!-- below list start here  -->
	</div>
</div><?php /**PATH /home/swatantra/adil shared/opportunityindia.franchiseindia.com (1)/opportunityindia.franchiseindia.com/resources/views/frontend/includes/lastestvideoblk.blade.php ENDPATH**/ ?>