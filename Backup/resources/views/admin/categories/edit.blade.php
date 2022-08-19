
@extends("admin/layouts.master")
@section('content')
@php $langs = config('constants.languages'); @endphp
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
              <form id="editform" class="form-horizontal" method="post" action="{{url('admin/industry/store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{ method_field('POST') }}
                <input type="hidden" name="id" value="{{$data->category_id}}">
              <div class="row">
              <div class="col-sm-8">                 
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Created Date </label>
                    <div class="col-sm-9">                      
                      <input type="text" disabled class="form-control" name="date" placeholder="Auto Genrate " value="{{$data->updated_at}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-3 col-form-label">Industry Id</label>
                    <div class="col-sm-9">
                      <input type="text" disabled class="form-control" name="id" placeholder="Auto Genrate" value="{{$data->category_id}}">
                    </div>
                  </div>

                  <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 col-form-label">Industry Icon</label>
				  <div class="col-md-1 col-sm-1 {{!$data->category_icon?'dnone':''}}" id="preview-container">
                  @if(strstr($data->category_icon,'svg'))
                   <div style="background:url('{{env('S3_BUCKET_URL','').'categories/'.$data->category_icon}}');width:48px;height:32px">					
				   </div>
				  @else				   
                     <img id="preview" src="{{env('S3_BUCKET_URL','').'categories/'.$data->category_icon}}" width="48" height="32"/>                   
				  @endif	
				  </div>
                    <div class="col-md-8 col-sm-8">
                      <div class="form-group">
                        <!-- <label for="customFile">Custom File</label> -->
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="files" name="file">
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                      </div>  
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-3 col-form-label">Industry Profile Name / Slug</label>
                    <div class="col-sm-9">
                      <input type="text" name="IndustrySlug" disabled class="form-control"  placeholder="Industry Profile Name / Slug" value="{{$data->category_slug}}" required>
                    </div>
                  </div>
                  @php //print_r($data->languages); @endphp
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
                                    <input type="text" name="name[{{$key}}]" class="form-control"  placeholder="Industry Name" value="{{isset($data->languages[$key])?$data->languages[$key]->category_name:''}}" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-4 col-form-label">Meta Title</label>
                                  <div class="col-sm-8">
                                    <input type="text" name="title[{{$key}}]" class="form-control"  placeholder="Meta Title" value="{{isset($data->languages[$key])?$data->languages[$key]->meta_title:''}}" required>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-4 col-form-label">Meta Description</label>
                                  <div class="col-sm-8">
                                    <textarea class="form-control" name="description[{{$key}}]" rows="3" placeholder="Meta Description ..." required>{{isset($data->languages[$key])?$data->languages[$key]->meta_description:''}}</textarea>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-4 col-form-label">Meta Keyword</label>
                                  <div class="col-sm-8">
                                    <textarea class="form-control" name="keywords[{{$key}}]" rows="3" placeholder="Meta Keyword ...">{{isset($data->languages[$key])?$data->languages[$key]->meta_keywords:''}}</textarea>
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
                          @if(count($childs)>0)
                          @foreach($childs as $indx=>$child)
                          <tr>
                            <td>{{$indx+1}}.</td>            
                            <td>
                              <select name="sectors[]"class="form-control" required>
                                <option>Select Sector Name</option>
                                  @foreach($sectors as $sector)
                                    <option value="{{$sector->id}}" {{$child->category_id==$sector->id?"selected":""}}>{{$sector->name}}</option>
                                  @endforeach
                              </select>
                            </td>
                            <td><a class="delete"><i class=" fas fa-trash"></i></a></td>         
                          </tr>
                          @endforeach
                          @else
                          <tr>
                            <td>1.</td>            
                            <td>
                              <select name="sectors[]"class="form-control" required>
                                <option selected>Select Sector Name</option>
                                  @foreach($sectors as $sector)
                                    <option value="{{$sector->id}}">{{$sector->name}}</option>
                                  @endforeach
                              </select>
                            </td>
                            <td></td>         
                          </tr>                    
                          @endif

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
                  <input class="custom-control-input" type="radio" value="1" id="customRadio2" name="status" {{$data->status=='1'?'checked':''}}>
                  <label for="customRadio2" class="custom-control-label">Active</label>
                </div>

                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" value="0" id="customRadio1" name="status" {{$data->status=='0'?'checked':''}}>
                  <label for="customRadio1" class="custom-control-label">InActive</label>
                </div>
              </div>
            </div>
          <div class="form-group row">
            <div class="col-sm-6">
              <button type="submit" class="btn btn-sm btn-success btn-lg">Update Industry</button>
            </div>
          <div class="col-sm-6">
            <button type="button" class="btn btn-sm btn-secondary btn-lg">Save as Draft</button>
          </div>
        </div>
      </form>
      <form id="editform" class="form-horizontal" method="post" action="{{url('admin/industry/duplicate')}}">
        {{csrf_field()}}
        {{ method_field('POST') }}

        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-12 col-form-label">Duplicate Industry with</label>
           <div class="col-sm-12">
            <select class="form-control" name="duplicate" required>
              <option>Select Industry</option>
              @foreach($industries as $industry)
                <option>{{$industry->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
       <div class="form-group row">
        <div class="col-sm-6">
          <button type="submit" class="btn btn-sm btn-secondary btn-lg">Mark Duplicate</button>
        </div>
        <div class="col-sm-6">
          <button type="button" class="btn btn-sm btn-secondary btn-lg disabled">Remove</button>
        </div>
       </div>
     </form>
           </div>
              </div>
              </div>
              
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
            document.getElementById('preview').src = src
          } 

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