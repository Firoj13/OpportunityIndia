<?php $__currentLoopData = $article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li>
<div class="artimgblk">
    <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>"><img alt="<?php echo e($alist->title); ?>" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createimgurl($alist->image_path)); ?>" alt=""></a>
</div>
<div class="artcontent">
    <div class="catname"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createTagSlugUrl($alist->getTagName->slug)); ?>"><?php echo e((App::getLocale() == 'en') ? ucwords($alist->getTagName->name) : ($alist->getTagName->name)); ?></a></div>
<div class="haedname"><a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>"><?php echo e($alist->title); ?></a></div>
<div class="authblk cot">
<div class="autimg"><img alt="" src="<?php echo e(\App\Http\Controllers\Frontend\IndexController::authorImageurl($alist->getAuthorName->image_path)); ?>" alt="<?php echo e($alist->getAuthorName->name); ?>"></div>
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
                                        <a href="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>#disqus_thread"><img alt="comment" src="<?php echo e(url('images/smallcomment.svg')); ?>" alt=""> Comment</a>
                                    </div>

                                     <div class="shrblk">
<span class="inshrblk"><a href="javascript:void();"><img alt="share" src="<?php echo e(url('images/smallshare.svg')); ?>" class="inimg"> Share
                                            <div class="sfv">
                                                <div class="addthis_inline_share_toolbox" data-url="<?php echo e(\App\Http\Controllers\Frontend\IndexController::createslugurl($alist->title,$alist->id,'article')); ?>" data-title="<?php echo e($alist->title); ?>" data-description="<?php echo e($alist->title); ?>" data-media="<?php echo e($alist->short_desc); ?>"></div>

                                            
                                            
                                            
                                            
                                            </div>
                                            </a>
                                        </span>
                                    </div>
                                </div>

</div>
</div>
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/partials/categoryarticlelist.blade.php ENDPATH**/ ?>