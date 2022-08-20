<?php $__env->startSection('title','All '. ucfirst(app('request')->input('filter')) .' | '); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Author</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('admin/home')); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form id="editform" method="post" action="<?php echo e(url('admin/authors/update')); ?>">
            <?php echo e(csrf_field()); ?>

            <?php echo e(method_field('POST')); ?>


            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Name</label>
                                <input type="hidden" name="id" value="<?php echo e($author->id); ?>">
                                <input type="text" name="name" id="inputName" class="form-control" value="<?php echo e($author->name); ?>" minlength="2" required>
                            </div>
                            <div class="form-group">
                                <label for="inputCompany">Company</label>
                                <input type="text" name="company" id="inputCompany" class="form-control" value="<?php echo e($author->company); ?>" minlength="2">
                            </div>
                            <div class="form-group">
                                <label for="inputDesignation">Designation</label>
                                <input type="text" name="designation" id="inputDesignation" class="form-control" value="<?php echo e($author->designation); ?>" minlength="2">
                            </div>

                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" name="status" class="form-control custom-select" required>
                                    <option disabled>Select one</option>
                                    <option value="1" <?php echo e($author->status == 1 ? 'selected' : ''); ?>>Active</option>
                                    <option value="0" <?php echo e($author->status == 0 ? 'selected' : ''); ?>>inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputAuthorImage">Author Image</label>
                                <div  class="author-image <?php echo e(empty($author->image_path) ?'dnone':''); ?>" id="image-preview">
                                    <?php if(strstr($author->image_path,"/")): ?>
                                        <img class="preview" src="<?php echo e(env('S3_BUCKET_URL','').trim($author->image_path,'/')); ?>" />
                                    <?php else: ?>
                                        <img class="preview" src="<?php echo e(env('S3_BUCKET_URL','').'opp/authors/images/'.trim($author->image_path,'/')); ?>" />
                                    <?php endif; ?>
                                    <span class="image-delete icon-delete" data-id="<?php echo e($author->id); ?>"><i class="fas fa-trash"></i></span>
                                </div>

                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="upload-image" accept="image/*" required>
                                    <label class="custom-file-label" for="customFile">Choose image</label>
                                </div>
                                Note :  * Image Size 400x400
                            </div>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Social</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="email" name="email" id="inputEmail" class="form-control" value="<?php echo e($author->email); ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputPhoneNumber">Phone Number</label>
                                <input type="number" name="phone_number" id="inputPhoneNumber" class="form-control" value="<?php echo e($author->phone_number); ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <input type="text" name="address" id="inputAddress" class="form-control" value="<?php echo e($author->address); ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputLinkedinProfile">Linkedin Profile </label>
                                <input type="text" name="linkedin_profile" id="inputLinkedinProfile" class="form-control" value="<?php echo e($author->linkedin_profile); ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputFacebookProfile">Facebook Profile</label>
                                <input type="text" name="facebook_profile" id="inputFacebookProfile" class="form-control" value="<?php echo e($author->fb_profile); ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputTwitterProfile">Twitter Profile</label>
                                <input type="text" name="twitter_profile" id="inputTwitterProfile" class="form-control" value="<?php echo e($author->twitter_profile); ?>">
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea  name="description" id="inputDescription" class="form-control" minlength="2"><?php echo e($author->intro_desc); ?></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="<?php echo e(url('admin/authors')); ?>" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Save Changes" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>

<?php $__env->startSection('page-js-script'); ?>
    <script src="<?php echo e(url('tinymce/js/tinymce/tinymce.min.js')); ?>"></script>
    <script>
        $( document ).ready(function() {
            $("#editform").validate();
            var editor_config = {
                path_absolute : "/",
                height:300,
                selector: "textarea",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor",
                relative_urls: false,
                remove_script_host: false,
                file_browser_callback : function(field_name, url, type) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type === 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    });
                }
            };
            tinymce.init(editor_config);
        });
    </script>
    <script>

        $("#upload-image").change(function () {
            let $fls = this.files[0];
            var src = URL.createObjectURL(this.files[0])
            var image = new Image();
            //Set the Base64 string return from URL as source.
            image.src = src;
            //Validate the File Height and Width.
            image.onload = function () {
                var width=this.width;
                var height=this.height;
                if(width > 400 || width < 400 || (height > 400 || height < 400))
                {
                    toastr.error("Image size 400x400 required!");
                    return false;
                }else{
                    $("#image-preview").show();
                    $("#image-preview").find('.preview').attr('src',src)
                    if (window.FormData) {
                        formdata = new FormData();
                        formdata.append("_token",'<?php echo e(csrf_token()); ?>')
                        //document.getElementById("btn").style.display = "none";
                    }
                    formdata.append("images[]", $fls);

                    upload(formdata).then((response)=>{
                        response.images.forEach(function(image) {
                            $("#image-preview").append("<input type='hidden' name='author_image' value='"+image+"'/>");
                        });
                    });
                }
            };
        })
        async function upload(formdata){
            return $.ajax({
                url: baseUrl+"/admin/authors/image/upload",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false
            });
        }
        $('body').on('click', '.image-delete', function(){
            let authorId=$(this).attr('data-id');
            $(this).parents('.author-image').hide()
            if (authorId>0) {
                $.post(baseUrl+"/admin/authors/delete/image",{authorId:authorId,_token:'<?php echo e(csrf_token()); ?>'});
            }
        });

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin/layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/author/edit.blade.php ENDPATH**/ ?>