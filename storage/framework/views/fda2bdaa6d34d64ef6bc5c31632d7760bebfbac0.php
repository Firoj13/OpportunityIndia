<?php $__env->startSection('title','All '. ucfirst(app('request')->input('filter')) .' | '); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
          <a href="<?php echo e(route('users.create',['id' => 0])); ?>" class="float-right btn btn-md btn-success">
            <i class="fa fa-plus-circle"></i> Add New
          </a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-body p-0">
          <?php if(count($users)>0): ?>
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">#</th>
                      <th style="width: 20%">Name</th>
                      <th style="width: 30%">Email</th>
                      <th>Role</th>
                      <th style="width: 8%" class="text-center">Status</th>
                      <th style="width: 20%"></th>
                  </tr>
              </thead>
              <tbody>

                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($user->roles()->first()->slug!='super-admin'): ?>
                  <tr>
                      <td>#</td>
                      <td>
                          <a>
                              <?php echo e($user->name); ?>

                          </a>
                      </td>
                      <td>
                         <?php echo e($user->email); ?> 
                      </td>
                      <td class="project_progress">
                            <?php echo e($user->roles()->first()->name); ?>

                      </td>
                      <td>
                        <?php if($user->status==1): ?>
                          <button type="button" class="btn btn-sm btn-success btn-status" data-id="<?php echo e($user->id); ?>">Active</button>
                        <?php else: ?>
                          <button type="button" class="btn btn-sm btn-danger btn-status" data-id="<?php echo e($user->id); ?>">Inactive</button>
                        <?php endif; ?>
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="<?php echo e(route('users.edit',['id' => $user->id])); ?>">
                              <i class="fas fa-pencil-alt"></i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#s<?php echo e($user->id); ?>deleteuser" >
                              <i class="fas fa-trash"></i>
                              Delete
                          </a>
                      </td>
                  </tr>

                  <div id="s<?php echo e($user->id); ?>deleteuser" class="delete-modal modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                        <p>Do you really want to delete user <?php echo e($user->name); ?>? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                          <form method="post" action="<?php echo e(url('admin/user/'.$user->id)); ?>" class="pull-right">
                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field("DELETE")); ?>

                  
                            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
          </table>
        <?php else: ?>
            <div class="text-center col-md-12">
              <h2 class="text-primary">
                No Users found <?php echo e(app('request')->input('q') ? 'with name '.app('request')->input('q') : ''); ?>

              </h2>
            </div>
          <?php endif; ?>

          <?php $__env->slot('boxfooter'); ?>
            <div class="text-center">
              <?php echo $users->appends(Request::except('page'))->links(); ?>

            </div>
          <?php $__env->endSlot(); ?>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
    <?php $__env->startSection('page-js-script'); ?>
      <script>
        $( document ).ready(function() {
          $(".btn-status").click(function(){
            let id=$(this).attr("data-id");            
            let status;
            if($(this).hasClass("btn-success")){
              $(this).addClass("btn-danger").removeClass("btn-success").text("Inactive");
               status=0
            }else{
              $(this).addClass("btn-success").removeClass("btn-danger").text("Inactive");
              $(this).text("Active");
              status=1
            }
            $.post(baseUrl+"/admin/user/status/",{_token: "<?php echo e(csrf_token()); ?>",id:id,status:status},function(){

            });
          });
        });        
      </script>
    <?php $__env->stopSection(); ?>  
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin/layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/users/index.blade.php ENDPATH**/ ?>