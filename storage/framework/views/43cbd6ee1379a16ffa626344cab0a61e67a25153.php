<?php $__env->startSection('title','All '. ucfirst(app('request')->input('filter')) .' | '); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1>Authors</h1>
          </div>
            <div class="col-sm-6">
                <form action="<?php echo e(route('author.index')); ?>">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control form-control-lg" placeholder="Search Id / Name / Slug / Designation / Company" value="<?php echo e(app('request')->input('search')); ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row"> <div class="col-sm-12">
                        <!--     <div style="float: right;"><a href="#" style="color: #000;">  <button type="button" class="btn btn-tool" data-card-widget="collapse">Advance Search</div> -->
                    </div>
                </div>

            </div>
          <div class="col-sm-3">
          <a href="<?php echo e(route('author.create',['id' => 0])); ?>" class="float-right btn btn-md btn-success">
            <i class="fa fa-plus-circle"></i> Add New Author
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
          <?php if(count($authors)>0): ?>
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">#</th>
                      <th style="width: 20%">Name</th>
                      <th style="width: 30%">Company</th>
                      <th>Designation</th>
                      <th style="width: 8%" class="text-center">Status</th>
                      <th style="width: 20%"></th>
                  </tr>
              </thead>
              <tbody>

                <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                  <tr>
                      <td>#</td>
                      <td>
                          <a>
                              <?php echo e($author->name); ?>

                          </a>
                      </td>
                      <td>
                         <?php echo e($author->company); ?>

                      </td>
                      <td class="project_progress">
                          <?php echo e($author->designation); ?>

                      </td>
                      <td>
                        <?php if($author->status==1): ?>
                          <button type="button" class="btn btn-sm btn-success btn-status" data-id="<?php echo e($author->id); ?>">Active</button>
                        <?php else: ?>
                          <button type="button" class="btn btn-sm btn-danger btn-status" data-id="<?php echo e($author->id); ?>">Inactive</button>
                        <?php endif; ?>
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="<?php echo e(route('author.edit',['id' => $author->id])); ?>">
                              <i class="fas fa-pencil-alt"></i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#s<?php echo e($author->id); ?>deleteuser" >
                              <i class="fas fa-trash"></i>
                              Delete
                          </a>
                      </td>
                  </tr>

                  <div id="s<?php echo e($author->id); ?>deleteuser" class="delete-modal modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                        <p>Do you really want to delete Author <?php echo e($author->name); ?>? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                          <form method="post" action="<?php echo e(route('author.destroy',$author->id)); ?>" class="pull-right">
                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field("DELETE")); ?>


                            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
          </table>
        <?php else: ?>
            <div class="text-center col-md-12">
              <h2 class="text-primary">
                No Authors found <?php echo e(app('request')->input('q') ? 'with name '.app('request')->input('q') : ''); ?>

              </h2>
            </div>
          <?php endif; ?>

              <div class="row">
                  <div class="col-12">
                      <div class="dataTables_paginate paging_simple_numbers">
                          <?php echo e($authors->links()); ?>

                      </div>
                  </div>
              </div>


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
            $.post(baseUrl+"/admin/authors/status",{_token: "<?php echo e(csrf_token()); ?>",id:id,status:status},function(){

            });
          });
        });
      </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin/layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/author/index.blade.php ENDPATH**/ ?>