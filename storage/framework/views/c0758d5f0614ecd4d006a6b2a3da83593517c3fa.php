<?php $__env->startSection('content'); ?>
    <?php $langs = config('constants.languages'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Edit</h1>
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
                            <form id="editform" class="form-horizontal" method="post" action="<?php echo e(route('seoTags.update')); ?>" enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('POST')); ?>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group row">
                                            <label for="inputPassword3" class="col-sm-4 col-form-label">Name</label>
                                            <input type="hidden" name="id" value="<?php echo e($tags->id); ?>">
                                            <input type="text" name="name" id="seoTagsAutoData" class="form-control" placeholder="enter tag name" value="<?php echo e($tags->name); ?>" autocomplete="off">
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
<?php $__env->startSection('page-js-script'); ?>
    <script>
        var options=<?php echo @json_encode($sectors); ?>;
        $( document ).ready(function() {

            document.getElementById('files').onchange = function () {
                $("#preview-container").show();
                var src = URL.createObjectURL(this.files[0])
                document.getElementById('preview').src = src
            }

            $("#editform").validate();
            function add_row(){
                let select=$("<select name='sectors[]' class='form-control'/>");
                $.each(options, function (index, value) {
                    $(select).append($('<option/>', {
                        value: value.id,
                        text : value.name
                    }));
                });
                let cnt=$('#sectorTable tr').length;
                let tr=$('<tr/>');
                let td=$('<td/>');
                tr.append("<td>"+cnt+"</td>");
                td.append(select)
                tr.append(td);
                tr.append('<td><a class="delete"><i class=" fas fa-trash"></i></a></td>');
                $('#sectorTable').append(tr);
            }

            $(".add-sector").click(function(){
                add_row();
            });

            $('#sectorTable').on('click', '.delete', function(){
                console.log($(this).parents('tr'))
                $(this).parents('tr').remove();
            });

            $("#editform").validate();


        });
        $( function() {
            $( "#seoTagsAutoData" ).autocomplete({
                source: function (request, response) {
                    jQuery.get("<?php echo e(route('seoTags.autoload')); ?>", {
                        tag: request.term
                    }, function (data) {
                        // assuming data is a JavaScript array such as
                        // ["one@abc.de", "onf@abc.de","ong@abc.de"]
                        // and not a string
                        response(data);
                    });
                },
                minLength: 3
            });
        } );

    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin/layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/franchis/public_html/subdomains/opportunityindia/resources/views/admin/seo_tags_eng/edit.blade.php ENDPATH**/ ?>