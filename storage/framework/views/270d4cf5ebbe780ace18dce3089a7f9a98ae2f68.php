<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Opportunity India</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        .tbli{padding-left:10px;}
        .tbli img{margin-right:10px;margin-bottom:1px; line-height:40px;}

        /*@import  url(https://fonts.google.com/specimen/Lato?selection.family=Lato:300);*/ /*Calling our web font*/
        /*Calling our web font*/
        .list-head{color:#ffffff; text-align:center; padding: 29px 0px 20px 0px; font-size:16px; font-weight:bold;}
        @media  screen and (max-width: 767px) {
            #mainTbl {
                width: 100% !important;
            }
            .mhide{display: none !important;}
            .mshow{display: block !important;}

            .social-img{width:100%;}
            img{max-width: 100%;margin-left: auto;margin-right: auto;}
            .td-business{padding:0px 20px 26px 20px!important;}
            .td-eligible{padding:30px 20px 26px 20px!important;}
            .menu-list{width:90%; padding-bottom:7px!important;padding-left:0px!important;}
            .menu-list td.menu-item{ display:block; text-align:center; width:100%;padding-bottom:5px;}
            .view-btn{width:50%!important;}
            .content-list{width:90%!important; padding:10px!important;}
            .pad-mo{padding:10px 0 10px 10px!important;}
            .td-content{width:40%!important;}
            .logo-mo{width:75%; max-width:200px;}
            .activate-so{width:90%;}
        }

    </style>
</head>
<body style="margin:0; padding:0; background-color:#ffffff" bgcolor="">
<table width="698" border="0" cellpadding="0" bgcolor="#fbfbfb" cellspacing="0" align="center" style="margin:0 auto;border:1px solid #eaeaea" id="mainTbl">
    <!-- header -->
    <tr>
        <td valign="top"><table width="100%" cellspacing="0" cellpadding="0">
                <tbody><tr>
                    <td valign="top" class="td-business" style="padding:0px 76px 40px 76px; line-height:22px; text-align:center; font-size:18px; color:#666666;"></td>
                </tr>
                </tbody></table></td>
    </tr>
    <tr>
        <td valign="top" style="padding-bottom:60px;"><table width="89%" class="tbl-main" cellpadding="0" align="center" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666;text-align:left; border:1px solid #eaeaea; ">
                <tbody><tr>
                    <td valign="top" class="mt-tbl"><table width="100%" class="tbl-mo" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td width="25%" class="td-name" valign="top" style="background:#f4f4f4;padding:10px 0px 10px 20px;">Name</td>
                                <td width="5%" class="td-dot" valign="top" style="background:#f4f4f4;padding:10px 20px 10px 0px;">:</td>
                                <td width="70%" class="td-value" valign="top" style="background:#f4f4f4; color:#333333;line-height:21px;padding:10px 0;"><?php echo e($name); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" valign="top" height="1" bgcolor="#eaeaea"></td>
                            </tr>
                            <tr>
                                <td width="25%" class="td-name" valign="top" style="background:#f9f9f9;padding:10px 0px 10px 20px;">Phone</td>
                                <td width="5%" class="td-dot" valign="top" style="background:#f9f9f9;padding:10px 20px 10px 0px;">:</td>
                                <td width="70%" class="td-value" valign="top" style="background:#f9f9f9; color:#333333;line-height:21px;padding:10px 0;"><?php echo e($phone); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" valign="top" height="1" bgcolor="#eaeaea"></td>
                            </tr>
                            <tr>
                                <td width="25%" valign="top" class="td-name" style="background:#f4f4f4;padding:10px 0px 10px 20px;">Email</td>
                                <td width="5%" valign="top" class="td-dot" style="background:#f4f4f4;padding:10px 20px 10px 0px;">:</td>
                                <td width="70%" valign="top" class="td-value" style="background:#f4f4f4; color:#333333;line-height:21px;padding:10px 0; word-wrap:break-word; max-width:180px;"><a href="mailto:<?php echo e($email); ?>" style=" text-decoration:none; color:#333333;"><?php echo e($email); ?></a></td>
                            </tr>


                            <tr>
                                <td colspan="3" valign="top" height="1" bgcolor="#eaeaea"></td>
                            </tr>
                            <tr>
                                <td width="25%" valign="top" class="td-name" style="background:#f9f9f9;padding:10px 0px 10px 20px;">Contact Reason</td>
                                <td width="5%" valign="top" class="td-dot" style="background:#f9f9f9;padding:10px 20px 10px 0px;">:</td>
                                <td width="70%" valign="top" class="td-value" style="background:#f9f9f9; color:#333333;line-height:21px;padding:10px 0;"><?php echo e($contreason); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" valign="top" height="1" bgcolor="#eaeaea"></td>
                            </tr>

                            <tr>
                                <td colspan="3" valign="top" height="1" bgcolor="#eaeaea"></td>
                            </tr>

                            </tbody></table>
                    </td>
                </tr>




                </tbody></table></td>
    </tr>

</table>
</body>
</html>
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/frontend/mail/ContactUs.blade.php ENDPATH**/ ?>