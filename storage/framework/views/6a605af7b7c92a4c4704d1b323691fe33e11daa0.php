<?php $__env->startSection('content'); ?>

 <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-3">
          <h1 class="m-0">Add New Tag</h1>
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
              <form id="editform" class="form-horizontal" method="post" action="<?php echo e(url('admin/seo-tags/store')); ?>" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('POST')); ?>

                  <div class="row">
                      <div class="col-sm-8">
                          <div class="form-group row">
                              <div class="col-sm-9">
                                  <div class="card card-primary card-outline card-outline-tabs">
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      <div class="card-body">
                                          <div class="tab-content" id="custom-tabs-four-tabContent">

                                              <div class="tab-pane fade show active" id="custom-tabs-four" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                  <div class="form-group row">
                                                      <div class="col-sm-8">
                                                          <label for="inputPassword3" class="col-sm-4 col-form-label">Name</label>
                                                          <input type="text" name="name" id="seoTagsAutoData" class="form-control seoTagsAutoData" placeholder="enter tag name" autocomplete="off">

                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- /.card -->
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-8">
                          <div class="form-group row">
                              <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                      </div>
                  </div>
    </div>
    </div>
    </form>
            </div>
              <!-- /.card-header -->
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js-script'); ?>
    <script>
        $( document ).ready(function() {
            $("#editform").validate();

        });


        $( function() {
            $( "#seoTagsAutoData" ).autocomplete({
                source: function (request, response) {
                    jQuery.get("<?php echo e(route('seoTags.autoload')); ?>", {
                        tag: request.term,
                    }, function (data) {
                        // assuming data is a JavaScript array such as
                        // ["one@abc.de", "onf@abc.de","ong@abc.de"]
                        // and not a string
                        response(data);
                    });
                },
                minLength: 3
            });
            $('div.active').find(':input:last').attr('required',true)

            $('.stabs .nav-link').click(function(){
                $('.seoTagsAutoData').attr({'required':false,});
                $('.langcl').attr('disabled',true);
                $($(this).attr("href")).find(':input:first').attr({'required':true,'disabled' : false});
                $($(this).attr("href")).find(':input:last').attr({'required':true,'disabled' : false});

            })
        } );



    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin/layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/seo_tags_eng/create.blade.php ENDPATH**/ ?>