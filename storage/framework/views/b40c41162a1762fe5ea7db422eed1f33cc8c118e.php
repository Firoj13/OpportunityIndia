<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo e($pageTitle ?? config('app.name', 'Admin')); ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/fontawesome-free/css/all.min.css')); ?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/css/adminlte.min.css')); ?>">
    
  <link type="text/css" rel="stylesheet" href="<?php echo e(url('admin/css/alert.css')); ?>">

  <script src="<?php echo e(asset('admin/js/plugins/pNotify/PNotify.js')); ?>"></script>
   <script>
    var addedmsg = "<?=Session::get('added')?>";
    var updatedmsg = "<?=Session::get('updated')?>";
    var deletedmsg = "<?=Session::get('deleted')?>";
    var warningmsg = "<?=Session::get('warning')?>";
  </script>
  <!-- Custom alert -->
  <script src="<?php echo e(asset('admin/js/alert.js')); ?>"></script> 
</head>
<body class="hold-transition login-page">
  <?php if(Session::has('added')): ?>
    <script>
      success();
    </script>
    <?php elseif(Session::has('updated')): ?>
    <script>
      update();
    </script>
    <?php elseif(Session::has('deleted')): ?>
    <script>
      deleted();
    </script>

    <?php elseif(Session::has('warning')): ?>
    <script>
      warning();
    </script>
  <?php endif; ?>  
  <?php echo $__env->yieldContent('content'); ?>
<!-- jQuery -->
<script src="<?php echo e(asset('admin/plugins/jquery/jquery.min.js')); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('admin/js/adminlte.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/layouts/blank.blade.php ENDPATH**/ ?>