<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Seo Tags Hindi List</h1>
                </div><!-- /.col -->
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="<?php echo e(url('admin/seo-tags-hi/create')); ?>"  class="btn btn-block btn-primary btn-flat">Add New Tag</a>
                        </div>
                        <div class="col-sm-9">
                            <form action="<?php echo e(url('admin/seo-tags-hi')); ?>">
                                <div class="input-group">
                                    <input type="search" name="search" class="form-control form-control-lg" placeholder="Search Tag Id / Tag Name / Tag Slug" value="<?php echo e(app('request')->input('search')); ?>">
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
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="float:right">Total results found : <?php echo e($items->total()); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body dataTables_wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <?php if(count($items)>0): ?>
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>

                                            <tr style="background: #dfdfdf;">
                                                <th>Tag ID</th>
                                                <th>Tag Name</th>
                                                <th>Slug</th>
                                                <th>Date</th>
                                                <th>Edit</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($item->id); ?></td>
                                                    <td><?php echo e($item->name); ?></td>
                                                    <td><?php echo e($item->slug); ?></td>
                                                    <td><?php echo e($item->updated_at->toFormattedDateString()); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(url('admin/seo-tags-hi/edit/'.$item->id)); ?>" style="color: #000">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <span>No result found</span>
                                    <?php endif; ?>
                                </div></div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        <?php echo e($items->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("admin/layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/seo_tags_hi/index.blade.php ENDPATH**/ ?>