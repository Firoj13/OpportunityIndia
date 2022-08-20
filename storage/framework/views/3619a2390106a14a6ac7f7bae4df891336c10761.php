<?php $__env->startSection('seoTitle', $article->title); ?>
<?php $__env->startSection('seoDesc', $article->short_desc); ?>
<?php $__env->startSection('shortDesc', $article->short_desc); ?>
<?php $__env->startSection('canonicalUrl', url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article'))); ?>
<?php $__env->startSection('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/'))); ?>
<?php $__env->startSection('url', url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article'))); ?>
<?php $__env->startSection('createTime', $article->created_at); ?>
<?php $__env->startSection('updateTime', $article->updated_at); ?>
<?php $__env->startSection('alturls'); ?>
<?php if(App::getLocale() == 'en'): ?>
<link rel="alternate" href="<?php echo e(url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article'))); ?>" hreflang="en-IN" />
<?php else: ?>
<link rel="alternate" href="<?php echo e(url(\App\Http\Controllers\Frontend\IndexController::createslugurl($article->title,$article->id,'article'))); ?>" hreflang="hi-IN" />
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php if($article->is_noindexnofollow == 1): ?>
<?php $__env->startSection('noindex', 'noindex,nofollow'); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>

	<div class="maininnver">
		<?php echo $__env->make("frontend.includes.topadsblk", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="repeatarts">
		<div class="contentblk">
			<div class="container">
				<div class="catlinks"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($article->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($article->getTagName->name) : ($article->getTagName->name)); ?></a></div>
				<h1><?php echo e($article->title); ?></h1>
				<div class="authblk">
					<div class="autimg"><img alt="<?php echo e($article->getAuthorName->name); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::authorImageurl($article->getAuthorName->image_path)); ?>" alt=""></div>
					<div class="autinfo">
						<span><a href="<?php echo e((!is_null($article->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($article->getAuthorName->name,$article->getAuthorName->id,'author') : '#'); ?>"><?php echo e(!is_null($article->getAuthorName) ? $article->getAuthorName->name : 'OpportunityIndia Desk'); ?></a></span>

						<?php echo e(date('M d Y',strtotime($article->created_at))); ?> - <?php echo e(\App\Http\Controllers\Frontend\IndexController::calculateReadTime($article)); ?> min read
					</div>
				</div>
			</div>
		</div>

		<div class="contentarea">
			<div class="imgblk">
				<img alt="<?php echo e($article->title); ?>" src="<?php echo e(!empty($article->image_path) ? \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/')) : 'https://franchiseindia.s3.ap-south-1.amazonaws.com/uploads/content/fi/int/5ff40e6aaa3da.jpeg'); ?>" alt="">
			</div>

			<?php echo $__env->make("frontend.includes.socailcomment", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if(!is_null($article->getAudioFiles)): ?>
				<?php echo $__env->make("frontend.includes.audio", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>

			<div class="shortdes">
				<?php echo e($article->short_desc); ?>

			</div>

			<div class="articlecontent">
                <?php
                    $custom_data = explode("\r\n", $article->content);
                    if(count($custom_data) == 1){
                    $articleData[0] = $custom_data[0].'<div id = "v-franchiseindia"></div><script>(function(v,d,o,ai){ai=d.createElement("script");ai.defer=true;ai.async=true;ai.src=v.location.protocol+o;d.head.appendChild(ai);})(window, document, "//a.vdo.ai/core/v-franchiseindia/vdo.ai.js");</script>';
                    } else{
                    $counter = 0;
                    foreach($custom_data as $cdata){
                    if($counter == 2){
                    $articleData[] = $cdata.'<div id = "v-franchiseindia"></div><script>(function(v,d,o,ai){ai=d.createElement("script");ai.defer=true;ai.async=true;ai.src=v.location.protocol+o;d.head.appendChild(ai);})(window, document, "//a.vdo.ai/core/v-franchiseindia/vdo.ai.js");</script>';
                    } else{
                    $articleData[] = $cdata;
                    }
                    $counter++;
                    }
                    }
                    $resultArticle  = implode("\r\n", $articleData);

                ?>
				<?php echo $resultArticle; ?>

			</div>
		</div>

		<!-- Some content after mag sub start here  -->
		<div class="contentarea">
			<div class="tag-block">
				<ul class="tag-list">
					<?php $__currentLoopData = $article->getAssocTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assoctags): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($assoctags->getTagsId->slug)); ?>"><?php echo e($assoctags->getTagsId->name); ?></a></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
			<?php echo $__env->make("frontend.includes.socailcomment", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php echo $__env->make("frontend.includes.subscribenewsletter", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>

		<?php echo $__env->make("frontend.includes.magblock", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<!-- Some content after mag sub end  here  -->
		<!--  -->
		<?php echo $__env->make("frontend.includes.youmaylike", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<!--  -->
		</div>
<div class="checktocallnextarticle"></div>
	</div>

<?php $__env->startPush('child-scripts'); ?>

<style>
.sinblk1{position: fixed; right:0px!important;top: 213px; left: auto!important;}
.at-share-btn-elements{display: block!important;float: right;text-align: right;}
@media    screen and (max-width: 768px){
  .sinblk1{position: fixed; left: 0px; top:273px;}
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/detail.blade.php ENDPATH**/ ?>