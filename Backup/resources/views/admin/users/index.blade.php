@extends("admin/layouts.master")
@section('title','All '. ucfirst(app('request')->input('filter')) .' | ')
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
          <a href="{{ route('users.create',['id' => 0]) }}" class="float-right btn btn-md btn-success">
            <i class="fa fa-plus-circle"></i> Add New
          </a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
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
                      <th>Role</th>
                      <th style="width: 8%" class="text-center">Status</th>
                      <th style="width: 20%"></th>
                  </tr>
              </thead>
              <tbody>

                @foreach($users as $user)
                
                @if($user->roles()->first()->slug!='super-admin')
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
                            {{$user->roles()->first()->name}}
                      </td>
                      <td>
                        @if($user->status==1)
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
                          <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#s{{ $user->id }}deleteuser" >
                              <i class="fas fa-trash"></i>
                              Delete
                          </a>
                      </td>
                  </tr>

                  <div id="s{{ $user->id }}deleteuser" class="delete-modal modal fade" role="dialog">
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
                          <form method="post" action="{{url('admin/user/'.$user->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                  
                            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
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

          @slot('boxfooter')
            <div class="text-center">
              {!! $users->appends(Request::except('page'))->links() !!}
            </div>
          @endslot
        </div>
        <!-- /.card-body -->
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
