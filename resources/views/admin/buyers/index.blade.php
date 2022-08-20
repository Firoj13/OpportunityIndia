@extends("admin/layouts.master")
@section('title','All '. ucfirst(app('request')->input('filter')) .' | ')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1 class="m-0">Buyers</h1>
          </div><!-- /.col -->
          <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-3">
                <a href="{{url('admin/buyer/create')}}"  class="btn btn-block btn-primary btn-flat">Add Buyer</a>
              </div>
              <div class="col-sm-9">
                <form action="{{url('admin/industries')}}">
                  <div class="input-group">
                    <input type="search" name="search" class="form-control form-control-lg" placeholder="Search Buyer Id / Buyer Name / Buyer Phone" value="{{ app('request')->input('search') }}">
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

    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-body p-0">
          @if(count($users)>0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">#</th>
                      <th style="width: 20%">Name</th>
                      <th style="width: 30%">Email</th>
                      <th>Phone</th>
                      <th style="width: 8%" class="text-center">Verified</th>
                      <th style="width: 8%" class="text-center">Status</th>
                      <th style="width: 20%"></th>
                  </tr>
              </thead>
              <tbody>

                @foreach($users as $user)
                  <tr>
                      <td>#</td>
                      <td>
                          <a>
                              {{ $user->name }}
                          </a>
                      </td>
                      <td>
                         {{ $user->email }} 
                      </td>
                      <td class="project_progress">
                            {{$user->mobile}}
                      </td>
                      <td align="center">@if($user->is_verified==1)<i class="fas fa-check"></i>@endif</td>
                      <td align="center">
                        @if($user->is_active==1)
                          <button type="button" class="btn btn-sm btn-success btn-status" data-id="{{$user->id}}">Active</button>
                        @else
                          <button type="button" class="btn btn-sm btn-danger btn-status" data-id="{{$user->id}}">Inactive</button>
                        @endif
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="{{ route('users.edit',['id' => $user->id]) }}">
                              <i class="fas fa-pencil-alt"></i>
                              Edit
                          </a>
                      </td>
                  </tr>
                  <div id="{{ $user->id }}deleteuser" class="delete-modal modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                        <p>Do you really want to delete user {{ $user->name }}? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                          <form method="post" action="{{url('admin/users/'.$user->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                  
                            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </tbody>
          </table>
        @else
            <div class="text-center col-md-12">
              <h2 class="text-primary">
                No Users found {{ app('request')->input('q') ? 'with name '.app('request')->input('q') : '' }}
              </h2>
            </div>
          @endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="row">
            <div class="col-12">
              <div class="dataTables_paginate paging_simple_numbers">
                  {{$users->appends($_GET)->links()}}
              </div>
            </div>
          </div> 
        </div>         
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
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
            $.post(baseUrl+"/admin/user/status/",{_token: "{{ csrf_token() }}",id:id,status:status},function(){

            });
          });
        });        
      </script>
    @endsection  
@endsection
