@extends("admin/layouts.master")
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1 class="m-0">Industry List</h1>
          </div><!-- /.col -->
          <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-3">
                <a href="{{url('admin/industry/add')}}"  class="btn btn-block btn-primary btn-flat">Add New Industry</a>
              </div>
              <div class="col-sm-9">
                <form action="{{url('admin/industries')}}">
                  <div class="input-group">
                    <input type="search" name="search" class="form-control form-control-lg" placeholder="Search Industry Id / Industry Name / Industry Slug" value="{{ app('request')->input('search') }}">
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
                <h3 class="card-title" style="float:right">Total results found : {{$industries->total()}}</h3>
              </div>
              <div class="card-body dataTables_wrapper">
                <div class="row">
                  <div class="col-12 ">
                  @if(count($industries)>0)
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>

                    <tr style="background: #dfdfdf;">
                      <th>ID</th>
                      <th>Date</th>
                      <th width="20%">Industry Name</th>
                      <th width="20%">Industry Profile name</th>
                      <th>Brands</th>
                      <th>Status</th>
                      <th>View Detail</th>
                      <th>Edit</th>
                    </tr>
                    </thead>
                      <tbody>
                        @foreach($industries as $index=>$industry)
                        <tr>
                          <td>{{$industry->id}}</td>
                          <td>{{$industry->updatedAt}}</td>
                          <td>{{$industry->name}}</td>
                          <td>{{$industry->slug}}</td>
                          <td align="center">{{$industry->getIndustryCount()}}</td>
                          <td>
                            @if($industry->status==1)
                              <button type="button" class="btn btn-sm btn-success btn-status" data-id="{{$industry->id}}">Active</button>
                            @else
                              <button type="button" class="btn btn-sm btn-danger btn-status" data-id="{{$industry->id}}">Inactive</button>
                            @endif
                          </td>
                          <td><a target="_blank" href="https://dealer.franchiseindia.com/dir/{{$industry->slug}}">View Detail</a></td>
                          <td>
                            <a href="{{url('admin/industry/edit/'.$industry->id)}}" style="color: #000">
                              <i class="fas fa-edit"></i> Edit
                            </a>
                          </td>
                        </tr>    
                      @endforeach          
                    </tbody>                
                  </table>
                  @else
                  <span>No result found</span>
                  @endif
              </div>
            </div>
          </div>
          <!-- /.card-body -->
              <div class="card-footer">
                  <div class="row">
                  <div class="col-12">
                    <div class="dataTables_paginate paging_simple_numbers">
                        {{$industries->appends($_GET)->links()}}
                    </div>
                  </div>
                </div> 
              </div> 

            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    @section('page-js-script')
      <script>
        $( document ).ready(function() {
          $(".btn-status").click(function(){
            let id=$(this).attr("data-id");            
            let status;
            if($(this).hasClass("btn-success")){
              $(this).addClass("btn-danger").removeClass("btn-success").text("Inactive");
               status=0
            }else{
              $(this).addClass("btn-success").removeClass("btn-danger").text("Inactive");
              $(this).text("Active");
              status=1
            }
            $(this).toggleClass(function(){
              return $(this).is('btn-success') ? '' : '';
            })
            $.post(baseUrl+"/admin/industry/status",{_token: "{{ csrf_token() }}",id:id,status:status},function(){

            });

          });
        });        
      </script>
    @endsection    
@endsection    

