<?php $__env->startSection('seoTitle', $author->name); ?>
<?php $__env->startSection('seoKeywords', $author->name); ?>
<?php $__env->startSection('seoDesc', 'Author '.$author->name); ?>
<?php $__env->startSection('shortDesc', 'Author '.$author->name); ?>
<?php $__env->startSection('canonicalUrl', URL::current()); ?>
<?php $__env->startSection('url', URL::current()); ?>
<?php $__env->startSection('imagesrc', \App\Http\Controllers\Frontend\IndexController::authorImageurl($author->image_path)); ?>

<?php $__env->startSection('content'); ?>
<div class="maininnver homeh">

 <div class="authblk">
<div class="container">


<ul class="nabva">
<li><a href="<?php echo e(URL::to('/')); ?>">Home</a></li>
<li>/</li>
<li><?php echo e($author->name); ?></li>
</ul>


<div class="row">
  <div class="col-4 col-sm-4 col-md-3 artublk1">
    <div class="imgprolist"><a href="javascript:void();"><img alt="<?php echo e($author->name); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::authorImageurl($author->image_path)); ?>"></a></div>

  </div>

  <div class="col-8 col-sm-8 col-md-9 artublk2">
    <div class="authorcontent">
    <h1><?php echo e($author->name); ?></h1>
    <div class="jobprofile"><?php echo e($author->designation); ?></div>
       
        <?php if(strlen(strip_tags($author->intro_desc)) == 100): ?>
              <p><?php echo $author->intro_desc; ?></p>
        <?php endif; ?>

    <div class="usblk">
        <?php if(!empty($author->fb_profile)): ?><div class="usblkinner"><a href="<?php echo e(($author->fb_profile) ? $author->fb_profile : 'javascript:;'); ?>"><img src="<?php echo e(url('images/facebookLP.svg')); ?>"></a></div><?php endif; ?>
        <?php if(!empty($author->twitter_profile)): ?><div class="usblkinner"><a href="<?php echo e(($author->twitter_profile)? $author->twitter_profile : 'javascript:;'); ?>"><img src="<?php echo e(url('images/twitterLP.svg')); ?>"></a></div><?php endif; ?>
        <?php if(!empty($author->linkedin_profile)): ?><div class="usblkinner"><a href="<?php echo e(($author->linkedin_profile)? $author->linkedin_profile : 'javascript:;'); ?>"><img src="<?php echo e(url('images/linkedLP.svg')); ?>"></a></div><?php endif; ?>
</div>
</div>


  </div>
</div>

</div>
</div>


<?php if($articleCount > 0): ?>
<div class="listblk">
  <div class="container">
<ul class="artilsit">
<?php $__currentLoopData = $article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $art): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<li>
<div class="artimgblk">
	<a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article')); ?>"><img alt="<?php echo e(trim($art->title)); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($art->image_path)); ?>" alt=""></a>
</div>
<div class="artcontent">
<div class="catname"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($art->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($art->getTagName->name) : ($art->getTagName->name)); ?></a></div>
<div class="haedname"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article')); ?>"><?php echo e(trim($art->title)); ?></a></div>
<div class="authblk cot">
<div class="autimg"><img src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::authorImageurl($art->getAuthorName->image_path)); ?>" alt=""></div>
<div class="autinfo">
<span><a href=""><?php echo e(!is_null($art->getAuthorName) ? $art->getAuthorName->name : 'OpportunityIndia Desk'); ?></a></span>

<?php echo e(date('M d Y',strtotime($art->created_at))); ?> - <?php echo e(\App\Http\Controllers\Frontend\IndexController::calculateReadTime($art)); ?> min read
</div>

</div>
<div class="stext">
    <?php echo e(strip_tags(\Illuminate\Support\Str::words($art->content, 55 , ' ...'))); ?>

</div>
<div class="scbk">
   <div class="cmtblk"><img alt="comment" src="<?php echo e(url('images/smallcomment.svg')); ?>" alt="">
   </div>
<div class="shrblk">
<span class="inshrblk"><a href="javascript:void();"><img alt="share" src="<?php echo e(url('images/smallshare.svg')); ?>" class="inimg"> Share
                                            <div class="sfv">
                                                <div class="addthis_inline_share_toolbox" data-url="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article')); ?>" data-title="<?php echo e($art->title); ?>" data-description="<?php echo e($art->title); ?>" data-media="<?php echo e($art->short_desc); ?>"></div>

                                            
                                            
                                            
                                            
                                            </div>
                                            </a>
                                        </span>
                                    </div>
</div>
</div>
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($articleCount > 5): ?>
<?php $noofpage = round($articleCount/5) + 1; ?>
<span data-page=<?php echo e($noofpage); ?> class="readmore">Load More...</span>
<?php endif; ?>

</ul>
</div>
</div>
<?php endif; ?>
<!-- mag block strat  -->
<?php echo $__env->make("frontend.includes.magblock", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- mag block end   -->

<!-- another list start here   -->


<!-- another list end here  -->


<?php echo $__env->make("frontend.includes.brandlist", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</div>
<?php $__env->startPush('child-scripts'); ?>
<script>

$(function(){

  var page = '2';
  $('.readmore').click(function(){

          $.ajax({
          url: "/author/"+<?php echo e($author->id); ?>+"/"+page,
          method: "GET",
          }).done(function( data ) {
                  if(data){
                        page++;
                        $('.readmore').before( data );
                        if($('.readmore').attr('data-page') == page)
                        {
                            $('.readmore').hide();
                        }
                        if(typeof addthis !== 'undefined') { addthis.layers.refresh(); }
                  }

          });


  })


})

</script>
<style>
.sfv{position: absolute; right: -92px;}
.sinblk1{position: fixed; left: 263px; top: 413px;}
.at-share-btn-elements{display: flex!important;}
@media    screen and (max-width: 768px){
  .sinblk1{position: fixed; left: 0px; top:273px;}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/author.blade.php ENDPATH**/ ?>