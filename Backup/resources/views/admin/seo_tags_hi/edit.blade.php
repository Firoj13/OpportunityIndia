@extends("admin/layouts.master")
@section('content')
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
                            <form id="editform" class="form-horizontal" method="post" action="{{route('seoTagsHi.update')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                {{ method_field('POST') }}
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group row">
                                            <label for="inputPassword3" class="col-sm-4 col-form-label">Name</label>
                                            <input type="hidden" name="id" value="{{$tags->id}}">
                                            <input type="text" name="name" id="seoTagsAutoData" class="form-control" placeholder="enter tag name" value="{{$tags->name}}" autocomplete="off">
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

@endsection
@section('page-js-script')
    <script>

        $( document ).ready(function() {

            $("#editform").validate();
        });


        $( function() {
            $( "#seoTagsAutoData" ).autocomplete({
                source: function (request, response) {
                    jQuery.get("{{route('seoTagsHi.autoload')}}", {
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
@endsection
