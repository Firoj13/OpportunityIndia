<?php $__env->startSection('content'); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Opportunity</b>India</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="POST" action="<?php echo e(route('admin.login')); ?>">
        <?php echo csrf_field(); ?>
        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <?php if($errors->has('email')): ?>
              <span class="invalid-feedback">
                  <strong><?php echo e($errors->first('email')); ?></strong>
              </span>
          <?php endif; ?>
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <?php if($errors->has('password')): ?>
              <span class="invalid-feedback">
                  <strong><?php echo e($errors->first('password')); ?></strong>
              </span>
          <?php endif; ?>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary">
              <?php echo e(__('Login')); ?>

            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!--<div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <!---<a class="btn btn-link" href="<?php echo e(route('forgot.password')); ?>">Forgot pasword?</a>-->
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>