@extends("admin/layouts.master")
@section('content')
    @php $langs = config('constants.languages'); @endphp
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Edit Article</h1>
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
                            <form id="editform" method="post" class="form-horizontal" action="{{url('admin/articles/english/update')}}">
                                {{csrf_field()}}
                                {{ method_field('POST') }}
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Select Tags</label>
                                                <div class="col-sm-8">
                                                    <div>
                                                        <select name="tags" id="tagId" class="form-control customError" required>
                                                            <option value="{{$article->primary_tag_id}}" selected>{{$article->getTagName->name}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputPassword3" class="col-sm-3 col-form-label">Select Image</label>
                                                <div class="col-sm-8">

                                                    <div style="margin-bottom: 10px" class="article-image {{empty($article->image_path) ?'dnone':''}}" id="image-preview">
                                                        @if(strstr($article->image_path,"/"))

                                                            <img class="preview" src="  {{ env('S3_BUCKET_URL2','').trim($article->image_path,'/') }}" />
                                                        @else
                                                            <img class="preview" src="{{env('S3_BUCKET_URL','').Config('constants.ARTICLE_UPLOAD_PATH').trim($article->image_path,'/')}}" />
                                                        @endif
                                                        <span class="article-delete icon-delete" data-id="{{$article->id}}"><i class="fas fa-trash"></i></span>
                                                    </div>

                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input" id="upload-image" accept="image/*">
                                                        <label class="custom-file-label" for="customFile">Choose image</label>
                                                    </div>
                                                    Note :  * Image Size 1000x562
                                                </div>
                                            </div>

                                                    <div class="form-group row">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Select Audio</label>
                                                        <div class="col-sm-8">

                                                            <select name="audio" id="audioId" class="form-control">
                                                                @if(!empty($article->audio_id))
                                                                <option value="{{$article->audio_id}}" selected>{{$article->getAudioFiles->name}}</option>
                                                                @else
                                                                    <option value="" selected disabled>Choose Audio Files..</option>
                                                                    @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Title</label>
                                                        <div class="col-sm-8">
                                                            <input type="hidden" name="id" id="articleId" value="{{$article->id}}">
                                                            <input type="text" name="title" class="form-control" value="{{$article->title}}"  placeholder="Title"  required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Home Title</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="home_title" class="form-control" value="{{$article->home_title}}" placeholder="Home Title"  required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Short Description</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="short_description" class="form-control"  value="{{$article->short_desc}}"  placeholder="Short Description"  required>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Select Publisher</label>
                                                        <div class="col-sm-8">
                                                            <div>
                                                            <select class="form-control customError" name="author" id="authorId" required>
                                                                <option value="{{$article->author_id}}" selected>{{$article->getAuthorName->name}}</option>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Select Associated Tags</label>
                                                        <div class="col-sm-8">
                                                            <div>
                                                            <select class="form-control customError" name="associated_tags[]" id="associatedTags" multiple required>
                                                                @foreach($article->getAssocTags as $tags)
                                                                <option value="{{$tags->getTagsID->id}}" selected>{{$tags->getTagsID->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputStatus"  class="col-sm-3 col-form-label">Status</label>
                                                        <div class="col-sm-8">
                                                            <select id="inputStatus" name="status" class="form-control custom-select" required>
                                                                <option disabled>Select one</option>
                                                                <option value="1" {{$article->status == 1 ? 'selected' : ''}}>Active</option>
                                                                <option value="0" {{$article->status == 0 ? 'selected' : ''}}>inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="inputStatus"  class="col-sm-3 col-form-label">For Slider</label>
                                                        <div class="col-sm-8">
                                                            <input type="hidden" name="slider_timestamp" value="{{$article->is_slider}}">
                                                            <input type="radio" id="slider2" name="slider" {{ (empty($article->is_slider) && ($article->is_slider == null)) ? 'checked="checked"' : ''  }}  value="no">
                                                            <label for="slider2" >No</label><br>
                                                            <input type="radio" id="slider1" name="slider"  {{ (!empty($article->is_slider) && ($article->is_slider != null)) ? 'checked="checked"' : ''  }}  value="yes">
                                                            <label for="slider1">Yes</label><br>

                                                        </div>
                                                    </div>
                                            <div class="form-group row">
                                                <label for="inputStatus"  class="col-sm-3 col-form-label">No-Index No-Follow</label>
                                                <div class="col-sm-5" style="padding-top: 9px;">
                                                    <input type="checkbox"   id="noIndexNoFollow" name="noindexnofollow"  {{($article->is_noindexnofollow == 1) ? 'checked' : ''}}>
                                                </div>
                                            </div>
                                                    <div class="form-group row">
                                                        <label for="inputStatus"  class="col-sm-3 col-form-label">Description</label>
                                                        <div class="col-sm-11">
                                                                        <textarea  name="description" id="inputDescription" class="form-control" minlength="2" required>{{$article->content}}</textarea>
                                                                    </div>
                                                                </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit" id="submitButton" class="btn btn-large btn-success btn-lg">Update Article</button>
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

@endsection
@section('page-js-script')
    <script src="{{url('tinymce/js/tinymce/tinymce.min.js')}}"></script>
    <script>

        $( document ).ready(function() {
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

            $("#editform").validate(
            {
                rules: {
                    title: {
                        maxlength: 100,
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
                    url: '{{url("admin/articles/english/get-authors")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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
                    url: '{{url("admin/articles/english/get-kickers")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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
                    url: '{{url("admin/articles/english/get-kickers")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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
            $('#audioId').select2({
                placeholder: "Choose Audio Files...",
                minimumInputLength: 2,

                ajax: {
                    url: '{{url("admin/articles/english/get-audio-files")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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
                if(width > 1000 || width < 562 || (height > 1000 || height < 562))
                {
                    toastr.error("Image size 1000x562 required!");
                    return false;
                }else{console.log('Done');
                    $("#image-preview").show();console.log($("#image-preview"));
                    $("#image-preview").find('.preview').attr('src',src)
                    if (window.FormData) {
                        formdata = new FormData();
                        formdata.append("_token",'{{ csrf_token() }}')
                        formdata.append("tag_id",$("#tagId").val())
                        formdata.append("associatedTags",$("#associatedTags").val())
                        formdata.append("authorId",$("#authorId").val())
                        formdata.append("id",$("#articleId").val())
                        //document.getElementById("btn").style.display = "none";
                    }
                    formdata.append("images[]", $fls);

                    upload(formdata).then((response)=>{
                        response.images.forEach(function(image) {
                            $("#image-preview").append("<input type='hidden' name='article_image' value='"+image+"'/>");
                        });
                    });
                }
            };
        })
        async function upload(formdata){
            return $.ajax({
                url: baseUrl+"/admin/articles/english/image/upload",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false
            });
        }
        $('body').on('click', '.article-delete', function(){
            let imageId=$(this).attr('data-id');
            $(this).prev('img').attr('src','');
            $(this).parent().hide();
            $(this).remove();
            //$(this).parents('.article-image').remove()
            if (imageId>0) {
                $.post("{{route('article.deleteArticleImage')}}",{imageId:imageId,_token:'{{ csrf_token() }}'});
            }
        });


    </script>

@endsection
