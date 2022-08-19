@extends("admin/layouts.master")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Manufactures Approval</h1>
      </div><!-- /.col -->
  	</div>
  	<div class="row mb-2">
      <div class="col-sm-12">
        <div class="row">           
          <div class="col-sm-12">
            <div class="card card-default" style="margin-top: 20px;">
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            <form action="{{url('/admin/manufacturers/approval')}}">
            <div class="row">
              <div class="col-md-4">
              	<div class="form-group">
              	<label>Manufacturer Id / Name</label>
              <input class="form-control" type="text"  name="search" placeholder="Manufacturer Id / Name" value="{{\Request::get('search')}}">
              </div>
              </div>
     			<div class="col-md-4">
              	<div class="form-group">
              		<label>Manufacturer Status</label>
            		<select class="form-control select2bs4" name="status">
						<option value="">Select status</option>
						<option value="10" {{\Request::get('status')=='10'?'selected':''}}>New</option>
						<option value="11" {{\Request::get('status')=='11'?'selected':''}}>Modified</option>
					</select>
              </div>
            </div>
			<div class="col-md-2"><div class="form-group"><label>&nbsp;</label><br>
				<button type="submit" class="btn btn-block btn-secondary">Apply</button></div>
			</div>
    	</div>
        <!-- /.row -->
          </form>
          </div>
          <!-- /.card-body -->
         
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
                  <h3 class="card-title" style="float:right">Total results found : {{$brands->total()}}</h3>
                </div> 
              <div class="card-body">
              	@if(count($brands)>0)
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr style="background: #dfdfdf;">
                    <th>ID</th>         
                    <th>Date</th>
                    <th width="20%">Manufacture Name</th>
                    <th>Details</th>
                  	<th>Current Status</th>
                    <th>Approval</th>                
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($brands as $index=>$brand)
          					<tr>
          						<td>{{$brand->brand_id}}</td>
          						<td>{{date('d-m-Y',strtotime($brand->created_at))}}</td>
          						<td>{{$brand->company_name}}</td>
          						<td><a href="{{url('admin/manufacturer/edit/'.$brand->brand_id)}}" class="vlink">Edit</a></td>
          						<td class="orange">{{$brand->profile_status==10?'New':'Modified'}}</td>
          						<td style="text-align: center;">
          							<select class="form-control select-status select2bs4 select2-hidden-accessible"
          							data-id="{{$brand->brand_id}}">
          								<option value="" value="">Select status</option>
          								<option value="12" value="">Approve</option>
          								<option value="9" value="">Reject</option>
          							</select>
          						</td>
          					</tr>
          					@endforeach              
                  </tbody>                
                </table>
                @else
                	<span>No result found</span>
              	@endif
                <div class="card-footer clearfix">
                <div class="row">
                  <div class="col-12">
                    <div class="dataTables_paginate paging_simple_numbers">
                      {{$brands->appends($_GET)->links()}}
                    </div>
                  </div>
                </div>  
              </div>
              </div>
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
        $( document ).ready(function() {

          $(".select-status").change(function(){
          
            if($(this).val()!=''){
                var r = confirm("Are You Sure?");
                if (r == true) {
                  
                    let brandId=$(this).attr("data-id"); 
                    let value=$(this).val();
                    if(value=='12'){
                    $(this).parents('tr').addClass('backgreen');
                    }else if(value=='9'){
                    $(this).parents('tr').addClass('backred');
                    }
                    $.post(baseUrl+"/admin/manufacturer/status/",{_token: "{{ csrf_token() }}",brandId:brandId,status:value});

                } else {
                    $(this).val('');
                    return false;
                }
          }
          })
        });        
      </script>
    @endsection       
@endsection       