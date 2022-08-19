<?php $__env->startSection('seoTitle', $catexist->name.Lang::get('messages.TagTitle')); ?>
<?php $__env->startSection('seoKeywords', $catexist->name.Lang::get('messages.TagTitle')); ?>
<?php $__env->startSection('seoDesc', $catexist->name.Lang::get('messages.TagTitle')); ?>
<?php $__env->startSection('shortDesc', $catexist->name.Lang::get('messages.TagTitle')); ?>
<?php $__env->startSection('canonicalUrl', url(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($articlesList[0]->getTagName->slug))); ?>
<?php $__env->startSection('url', url(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($articlesList[0]->getTagName->slug))); ?>
<?php $__env->startSection('imagesrc', \App\Http\Controllers\Frontend\IndexController::createimgurl($articlesList[0]->image_path)); ?>
<?php $__env->startSection('alturls'); ?>
<?php if(App::getLocale() == 'en'): ?>
<link rel="alternate" href="<?php echo e(url(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($catexist->slug))); ?>" hreflang="en-IN" />
<?php else: ?>
<link rel="alternate" href="<?php echo e(url(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($catexist->slug))); ?>" hreflang="hi-IN" />
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="maininnver homeh">
        <div class="container">
            <h1 class="cathead"><?php echo e($catexist->name); ?></h1>
        </div>

        <div class="listblk">
            <div class="container">
                <ul class="artilsit">
                    <?php $__currentLoopData = $articlesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="artimgblk">
                                <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>"><img src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($alist->image_path)); ?>" alt=""></a>
                            </div>
                            <div class="artcontent">
                                <div class="catname">
                                    <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($alist->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($alist->getTagName->name) : ($alist->getTagName->name)); ?></a></div>
                                <div class="haedname">
                                    <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>"><?php echo e($alist->title); ?></a></div>
                                <div class="authblk cot">
                                    <div class="autimg">
                                        <img src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::authorImageurl($alist->getAuthorName->image_path)); ?>" alt=""></div>
                                    <div class="autinfo">
                                        <span><a href="<?php echo e((!is_null($alist->getAuthorName)) ?  \App\Http\Controllers\Frontend\IndexController::createslugurl($alist->getAuthorName->name,$alist->getAuthorName->id,'author') : '#'); ?>"><?php echo e(!is_null($alist->getAuthorName) ? $alist->getAuthorName->name : 'OpportunityIndia Desk'); ?></a></span>
                                        <?php echo e(date('M d Y',strtotime($alist->created_at))); ?> - <?php echo e(\App\Http\Controllers\Frontend\IndexController::calculateReadTime($alist)); ?> min read

                                    </div>
                                </div>
                                <div class="stext">
                                    <?php echo e(strip_tags(\Illuminate\Support\Str::words($alist->content, 55 , ' ...'))); ?>

                                </div>

                                <div class="scbk myscbk">
                                    <div class="cmtblk">
                                        <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>#disqus_thread"><img src="<?php echo e(url('images/smallcomment.svg')); ?>" alt=""> Comment</a>
                                    </div>

                                     <div class="shrblk">
<span class="inshrblk"><a href="javascript:void();"><img src="<?php echo e(url('images/smallshare.svg')); ?>" class="inimg"> Share
                                            <div class="sfv">
                                                <div class="addthis_inline_share_toolbox" data-url="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>" data-title="<?php echo e($alist->title); ?>" data-description="<?php echo e($alist->title); ?>" data-media="<?php echo e($alist->short_desc); ?>"></div>
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

        <!-- mag block strat  -->
    <?php echo $__env->make('frontend.includes.magblock', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- mag block end   -->

        <?php echo $__env->make('frontend.includes.brandlist', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php $__env->startPush('child-scripts'); ?>
    <script>

        $(function(){

            var page = '2';
            $('.readmore').click(function(){
                $.ajax({
                    url: "category/"+<?php echo e($catexist->id); ?>+"/"+page,
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
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/list.blade.php ENDPATH**/ ?>