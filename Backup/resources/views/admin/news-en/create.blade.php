@extends("admin/layouts.master")
@section('content')
    @php $langs = config('constants.languages'); @endphp
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Add New News</h1>
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
                            <form id="editform" method="post" class="form-horizontal" action="{{url('admin/news/english/store')}}">
                                {{csrf_field()}}
                                {{ method_field('POST') }}
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Select
                                                    Tags</label>
                                                <div class="col-sm-8">
                                                    <div>
                                                    <select name="tags" id="tagId" class="form-control customError" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Select
                                                    Image</label>
                                                <div class="col-sm-8">

                                                    <div style="margin-bottom: 10px" class="dnone" id="image-preview">
                                                        <img class="preview" src=""/>
                                                    </div>

                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input" id="upload-image" accept="image/*" required>
                                                        <label class="custom-file-label" for="customFile">Choose image</label>
                                                    </div>
                                                    Note : * Image Size 400x400
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Title</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Home Title</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="home_title" class="form-control" placeholder="Home Title" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Short Description</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="short_description" class="form-control" placeholder="Short Description" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Select Publisher</label>
                                                <div class="col-sm-8">
                                                    <div>
                                                    <select class="form-control customError" name="author" id="authorId" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Select
                                                    Associated Tags</label>
                                                <div class="col-sm-8">
                                                    <div>
                                                    <select  class="form-control customError" name="associated_tags[]" id="associatedTags" multiple required>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputStatus"
                                                       class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-8">
                                                    <select id="inputStatus" name="status" class="form-control custom-select" required>
                                                        <option disabled>Select one</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                                <label for="inputStatus"
                                                                       class="col-sm-3 col-form-label">Description</label>
                                                                <div class="col-sm-11">
                                                                <textarea name="description" id="inputDescription" class="form-control" minlength="2" required></textarea>
                                                                </div>
                                                                </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit" id="submitButton" class="btn btn-large btn-success btn-lg">Add News</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                        </div>
                    </div>
                </div>

        </form>

    </section>

@endsection
@section('page-js-script')
    <script src="{{url('tinymce/js/tinymce/tinymce.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var editor_config = {
                path_absolute: "/",
                height: 300,
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
                file_browser_callback: function (field_name, url, type) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type === 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no"
                    });
                }
            };

            tinymce.init(editor_config);

            $("#editform").validate(
                {
                    rules: {
                        title: {
                            maxlength: 75,
                            minlength: 3
                        },
                        home_title: {
                            maxlength: 65,
                        },
                        short_description: {
                            minlength: 120,
                            maxlength: 350
                        }
                    },
                errorPlacement : function( error, element ) {
                    if ( element.hasClass( 'customError' )) {
                        // custom error placement
                        element.parent().after( error );
                    }
                    else {
                        element.after( error ); // default error placement
                    }
                }
            });

            $('#authorId').select2({
                placeholder: "Choose Publisher...",
                minimumInputLength: 2,
                ajax: {
                    url: '{{url("admin/news/english/get-authors")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#associatedTags').select2({
                placeholder: "Choose Associated Tags...",
                minimumInputLength: 2,
                ajax: {
                    url: '{{url("admin/news/english/get-kickers")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#tagId').select2({
                placeholder: "Choose Associated Tags...",
                minimumInputLength: 2,
                ajax: {
                    url: '{{url("admin/news/english/get-kickers")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });

        $("#upload-image").change(function () {
            var $fls = this.files[0];
            var src = URL.createObjectURL(this.files[0]);
            var image = new Image();

            //Set the Base64 string return from URL as source.
            image.src = src;

            //Validate the File Height and Width.
            image.onload = function () {
                var width = this.width;
                var height = this.height;
                if (width > 1000 || width < 562 || (height > 1000 || height < 562)) {
                    toastr.error("Image size 1000x562 required!");
                    return false;
                } else {
                    $("#image-preview").show();
                    $("#image-preview").find('.preview').attr('src', src);
                    if (window.FormData) {
                        formdata = new FormData();
                        formdata.append("_token", '{{ csrf_token() }}');
                        formdata.append("tag_id", $("#tagId").val());
                        formdata.append("associatedTags", $("#associatedTags").val());
                        formdata.append("authorId", $("#authorId").val())
                        //document.getElementById("btn").style.display = "none";
                    }

                    formdata.append("images[]", $fls);

                    upload(formdata).then((response) => {
                        response.images.forEach(function (image) {
                            $("#image-preview").append("<input type='hidden' name='news_image' value='" + image + "'/>");
                        });
                    });
                }
            };
        });

        async function upload(formdata) {
            return $.ajax({
                url: baseUrl + "/admin/news/english/image/upload",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false
            });
        }
    </script>

@endsection
