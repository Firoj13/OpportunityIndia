<?php $__currentLoopData = $article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $art): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li>
<div class="artimgblk">
  <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article')); ?>"><img src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($art->image_path)); ?>" alt="<?php echo e($art->title); ?>"></a>
</div>
<div class="artcontent">
<div class="catname"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($art->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($art->getTagName->name) : ($art->getTagName->name)); ?></a></div>
<div class="haedname"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($art->title,$art->id,'article')); ?>"><?php echo e(trim($art->title)); ?></a></div>
<div class="authblk cot">
<div class="autimg"><img alt="<?php echo e($art->getAuthorName->name); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::authorImageurl($art->getAuthorName->image_path)); ?>" alt=""></div>
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
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/partials/authorarticlelist.blade.php ENDPATH**/ ?>