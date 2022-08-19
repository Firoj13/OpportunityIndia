@extends("admin/layouts.master")
@section('content')
@php $langs = config('constants.languages'); @endphp
 <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-3">
          <h1 class="m-0">Add New Industry</h1>
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
              <form id="editform" class="form-horizontal" method="post" action="{{url('admin/industry/store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{ method_field('POST') }}
              <div class="row">
                <div class="col-sm-8">                 
                <div class="card-body">
                  <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 col-form-label">Industry Icon</label>
                  <div class="col-sm-1 dnone" id="preview-container"><img width="40" height="35" id="preview" src=""/></div>
                  <div class="col-sm-8">             
                    <div class="form-group">
                      <input type="file" class="custom-file-input" id="files" name="file" required>
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                  </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-3 col-form-label">Languages</label>
                    <div class="col-sm-9">
                      <div class="card card-primary card-outline card-outline-tabs">
                          <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                              @foreach($langs as $key=>$lang)
                              <li class="nav-item">
                                <a class="nav-link {{$key=='en'?'active':''}}" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-{{$key}}" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">{{$lang}}</a>
                              </li>
                              @endforeach
                            </ul>
                          </div>
                          <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                              @foreach($langs as $key=>$lang)
                              <div class="tab-pane fade {{$key=='en'?'show active':''}}" id="custom-tabs-four-{{$key}}" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-4 col-form-label">Industry Name</label>
                                  <div class="col-sm-8">
                                    <input type="text" name="name[{{$key}}]" class="form-control"  placeholder="Industry Name"  required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-4 col-form-label">Meta Title</label>
                                  <div class="col-sm-8">
                                    <input type="text" name="title[{{$key}}]" class="form-control"  placeholder="Meta Title" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-4 col-form-label">Meta Description</label>
                                  <div class="col-sm-8">
                                    <textarea class="form-control" name="description[{{$key}}]" rows="3" placeholder="Meta Description ..." required></textarea>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-4 col-form-label">Meta Keyword</label>
                                  <div class="col-sm-8">
                                    <textarea class="form-control" name="keywords[{{$key}}]" rows="3" placeholder="Meta Keyword ..."></textarea>
                                  </div>
                                </div>
                              </div>
                              @endforeach
                            </div>
                          </div>
                          <!-- /.card -->
                        </div>
                      </div>
                    </div>

                  <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 col-form-label">Industry Mapping</label>
                  <div class="col-sm-9">
                    <table id="sectorTable" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Sector Name</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1.</td>            
                        <td>
                          <select name="sectors[]"class="form-control" required>
                            <option value="">Select Sector Name</option>
                              @foreach($sectors as $sector)
                                <option>{{$sector->name}}</option>
                              @endforeach
                          </select>
                        </td>
                        <td></td>         
                      </tr>
                    </tbody>
                  </table>
                <div>
                  <button type="button" style="float: right;" class="btn btn-sm btn-info add-sector">Add More</button>
                </div>
                  </div>
                  </div>
                </div>      
              </div>
              <div class="col-sm-4"> 
                <div class="back">
                  <div class="heads">Status & Visibility</div>
                      <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-4 col-form-label">Visibility</label>
                    <div class="col-sm-8">
                    <select class="form-control" name="visibility">
                      <option value="public">Public (Visible to every one)</option>
                      <option value="Private">Private (Only Admin or editor)</option>
                    </select>
                </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-4 col-form-label">Publish</label>
                  <div class="col-sm-8">Immediately <br>
                    <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric">
                  </div>
                  </div>
                  </div>

              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" id="customRadio2" name="status" checked="" value="1">
                  <label for="customRadio2" class="custom-control-label">Active</label>
                </div>

                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" id="customRadio1" name="status" value="0">
                  <label for="customRadio1" class="custom-control-label">InActive</label>
                </div>

              </div>
            </div>
         <div class="form-group row">
          <div class="col-sm-6">
        <button type="submit" class="btn btn-sm btn-success btn-lg">Add Industry</button>
          </div>
          <div class="col-sm-6">
        <button type="button" class="btn btn-sm btn-secondary btn-lg">Save as Draft</button>
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
    @section('page-js-script')
      <script>
        var options={!!@json_encode($sectors)!!};
        $( document ).ready(function() {
          
          document.getElementById('files').onchange = function () {
            var src = URL.createObjectURL(this.files[0])
            $("#preview-container").show();
            $("#preview").show().attr('src',src);
          } 

          $("#editform").validate();
          function add_row(){
            let select=$("<select name='sectors[]' class='form-control'/>");
            $(select).append($('<option>Select Sector Name</option>'));
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
      </script>
    @endsection
@endsection       