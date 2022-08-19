<?php
    $submitUrl = Config('constants.FranchiseIndia');
?>
<form id="update" method="post" action="<?php echo e($submitUrl.'/newslettersignup'); ?>">
    <?php echo csrf_field(); ?>
    <div class="newsletterbg">
        <div class="strbhead">Subscribe Newsletter</div>
        <div class="newstxt">Submit your email address to receive the latest updates on news & host of opportunities</div>

        <ul class="submaglsi">

            <input type="hidden" name="site_type" value="article">
            <li>
                <input type="email" name="email" id="email" placeholder="Enter Email" required>
            </li>

            <li>
                <input type="submit" value="Subscribe Now" class="stb" id="btnupdate">
            </li>

        </ul>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        // $('input[title!=""]').hint();
        // $('textarea[title!=""]').hint();
        // $('select[title!=""]').hint();
        var validator = $("#update").validate({

            rules: {

                email: {
                    required : true,
                    email    : true
                }
            },

            messages: {

                email: {
                    required : "",
                    email    : ""
                }
            }

        });
    });

</script>
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/includes/subscribenewsletter.blade.php ENDPATH**/ ?>