@extends("admin/layouts.master")

@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Roles & Permissions</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <!-- /.row -->
        <div class="card card-primary card-outline">
          <div class="card-body">
            <h4>Roles</h4>
            <div class="row">
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  @if(count($roles)>0)
	                  @foreach($roles as $index => $role)
	                  	<a class="nav-link {{$index ==0?'show active':''}}" id="vert-tabs-{{$role->slug}}-tab" data-toggle="pill" href="#vert-tabs-{{$role->slug}}" role="tab" aria-controls="vert-tabs-{{$role->slug}}" aria-selected="true">{{$role->name}}</a>
	                  @endforeach
                  @endif
                </div>
              </div>
              <div class="col-7 col-sm-9">
              	@if(count($roles)>0)
              	<div class="tab-content" id="vert-tabs-tabContent">
	            @foreach($roles as $index => $role)                	
	                <div role-id="{{$role->id}}" class="tab-pane text-left fade {{$index ==0?'show active':''}}" id="vert-tabs-{{$role->slug}}" role="tabpanel" aria-labelledby="vert-tabs-{{$role->slug}}-tab">
							<div class="card">
				              <div class="card-body p-0">
							  	@if(count($permissions)>0)
							    <table class="table table-striped">
							      <thead>
							        <tr>
							          <th style="width: 10px">#</th>
							          <th width="80%">Action</th>
							          <th width="20%">Permission</th>
							        </tr>
							      </thead>
							      <tbody>
							      	@foreach($permissions as $index => $permission)
							        <tr>
							          <td>{{$index+1}}.</td>
							          <td>{{$permission->name}}</td>
							          <td><input type="checkbox" class="permisssion-checkbox" name="permisssion-checkbox" {{$role->hasPermission($permission)?'checked':''}} value="{{$permission->id}}" data-bootstrap-switch></td>
							        </tr>
							        @endforeach
							      </tbody>
							    </table>
							    @endif
				              </div>
		              		  <!-- /.card-body -->
		                    </div>
	                    	<!-- /.card -->
	                	</div>	                
	            	@endforeach
	            </div>	
                @endif
        		<!-- /.card -->
              </div>
            </div>
          </div>
        </div>
      <!-- /.card -->
    </div>
  </section>

@endsection

@section('page-js-script')
<script src="{{ asset('admin/js/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script>
	$("input[data-bootstrap-switch]").each(function(){
		let _this=$(this);
		$(this).bootstrapSwitch({
			onSwitchChange:function(event, state){
				let role=$(_this).parents('.tab-pane').attr('role-id');
				let searchIDs = $(_this).parents('.tab-pane').find(".permisssion-checkbox:checked").map(function(){
						return $(this).val();
					});
				 //console.log(searchIDs.get());
				_call(role,searchIDs.get());
			}
		});
    })
	function _call(role,permissions){	

		$.ajax({
	         type:'POST',
	         url:baseUrl+'/admin/permissions/update',
	         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	         data: { role: role, permissions: permissions },
	         success:function(data){
	            console.log("0000")
	        }
	    });
	}

	$( document ).ready(function() {
	    $("input[data-bootstrap-switch]").click(function(){
	    	
	    })
	});
</script>

@endsection
