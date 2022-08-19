<div class="newcontentblk">
    <div class="container">
        <div class="magblk">
            <img src="https://www.franchiseindia.com/images/magazine/sme-321x349.png" alt="" class="imgstd">
        </div>
        <form id="magsubscribe">
            <?php echo e(csrf_field()); ?>

            <div class="magfrm">
                <div class="haedstg">Entrepreneur Magazine</div>
                <p class="magtxt">For hassle free instant subscription, just give your number and email id and our customer care agent will get in touch with you</p>
                <ul class="maglsi">
                    <li class="wid180"><label>Enter Email</label>
                        <input type="email" id="magemail" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="test@test.com" required>
                    </li>
                    <li class="wid180"><label>Enter No. </label>
                        <div class="flis">
                            <select class="code"><option> + 91 </option> </select>
                            <input type="text" id="magtel" name="mobile" class="telcode" pattern="[0-9]{10}" title="Must Contain 10 Number" required>
                        </div>
                    </li>
                    <li>
                        <label class="hide">&nbsp;</label>
                        <input type="submit" value="Subscribe Now" class="stb">
                    </li>
                </ul>
                <p class="mbtmtxt">or <a href="https://master.franchiseindia.com/emagazine/">Click here to Subscribe Online</a></p>
            </div>
        </form>
    </div>
</div>

<?php /**PATH /home/swatantra/adil shared/opportunityindia.franchiseindia.com (1)/opportunityindia.franchiseindia.com/resources/views/frontend/includes/magblock.blade.php ENDPATH**/ ?>