@extends("admin/layouts.master")
@section('content')

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
              <form id="editform" class="form-horizontal" method="post" action="{{url('admin/seo-tags/store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{ method_field('POST') }}
                  <div class="row">
                      <div class="col-sm-8">
                          <div class="form-group row">
                              <div class="col-sm-9">
                                  <div class="card card-primary card-outline card-outline-tabs">
                                      {{--                              <div class="card-header p-0 border-bottom-0">--}}
                                      {{--                                  <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">--}}
                                      {{--                                      @foreach($langs as $key=>$lang)--}}
                                      {{--                                          <li class="nav-item stabs">--}}
                                      {{--                                              <a class="nav-link {{$lang->code=='en'?'active':''}}" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-{{$key}}" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">{{$lang->name}}</a>--}}
                                      {{--                                          </li>--}}
                                      {{--                                      @endforeach--}}
                                      {{--                                  </ul>--}}
                                      {{--                              </div>--}}
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

@endsection

@section('page-js-script')
    <script>
        $( document ).ready(function() {
            $("#editform").validate();

        });


        $( function() {
            $( "#seoTagsAutoData" ).autocomplete({
                source: function (request, response) {
                    jQuery.get("{{route('seoTags.autoload')}}", {
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
@endsection
