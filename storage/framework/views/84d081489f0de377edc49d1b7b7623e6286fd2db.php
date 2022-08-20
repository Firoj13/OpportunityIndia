<?php $__env->startSection('content'); ?>
    <div class="maininnver">
        <div class="container text-center"><br><br><br>
            <h2>Thank You</h2><br>
            For Submitting information for Free Advice!
            <br><br><br>
        </div>

       <!--  <div class="listblk">
            <div class="container">
                <p>Our customer care executives will get in touch with you shortly.</p>
            </div>
        </div> -->

        <?php echo $__env->make("frontend.includes.topfranchisecategories", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- mag block strat  -->
        <?php echo $__env->make("frontend.includes.magblock", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/advice-form.blade.php ENDPATH**/ ?>