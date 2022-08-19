  @extends("admin/layouts.master")
  @section('content')   
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
            <h1 class="m-0">Payment Package - {{$brand->company_name}}</h1>
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
                <h3 class="card-title">Packages</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	@if(count($plans)>0)
                <table id="list-table" class="table table-bordered table-hover">
                  <thead>
                  <tr style="background: #dfdfdf;">
                    <th>S.No</th>
                    <th width="30%">Package Name</th>
                    <th>Live date</th>
                    <th>End Date</th>
                    <th>Payment Date</th>
                    <th>package duration</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($packages as $ndx=>$package)
	                  <tr>
	                    <td>{{$ndx+1}}</td>
	                    <td>{{$package->plan->membership->type}} - {{$package->plan->membership->title}}</td>
	                    <td>{{date("d M Y",strtotime($package->activation_date))}}</td>
	                    <td>{{date("d M Y",strtotime($package->expiry_date))}}</td>
	                    <td>{{date("d M Y",strtotime($package->activation_date))}}</td>
	                    <td>{{$package->plan->title}}</td>  
						<td><a class="delete_payment" data-id="{{$package->id}}"><i class=" fas fa-trash"></i></a></td>
	                  </tr>
                	@endforeach
                  </tbody>                
                </table>
                @else
                <span>Could not find a membership plan. You can add it by filling below form.</span>
               @endif 
            <div class="card card-default" style="margin-top: 20px;width:80%;">
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
          	<div class="row">
          		<div class="col-sm-6">
          			<h3>Add New Package</h3>
          		</div>
          	</div>	
            <form action="{{url('admin/manufacturers/payment/store')}}" id="editform" method="post">
             {{csrf_field()}}
             {{ method_field('POST') }}     
             <input type="hidden" name="brandId" value="{{$brand->brand_id}}">       	
            <div class="row">
	            <div class="col-sm-4">
	            	<div class="form-group">
		            	<label>Package</label>
                    <select class="form-control" name="packageId" required>
                       <option value="">Select package</option>
                       @foreach($plans as $plan)
                       @if($plan->type!='EMAIL')
					              <option value="{{$plan->id}}">{{$plan->type}}-{{$plan->title}}</option>
                      @endif
                      @endforeach
                    </select>
            		</div>
            	</div>	
	            <div class="col-sm-4">
	            	<div class="form-group">
		            	<label>Term</label>
                  <select class="form-control" name="packageTerm" required> 
                     <option value="">Select term</option>
					 <option value="Monthly">Monthly</option>
					 <option value="Quarterly">Quarterly</option>
					 <option value="Half Yearly">Half Yearly</option>
					 <option value="Annually">Annually</option>
                  </select>
            		</div>
            	</div>	            	
	            <div class="col-sm-4"> <div class="form-group">
	            	<label>Start Date</label>
	            	<div class="input-group date" id="reservation" data-target-input="nearest">
	            		<input type="text" name="activationDate" class="form-control datetimepicker-input" data-target="#reservation" value="{{date('Y-mm-dd')}}" required>
	            		<div class="input-group-append" data-target="#reservation" data-toggle="datetimepicker">
	            			<div class="input-group-text"><i class="fa fa-calendar"></i></div>
	            		</div>
	            	</div>
	            </div>
        	</div>
	        <div class="row">
	            <div class="col-md-12">
	            	<button type="submit" class="btn btn-flat btn-secondary" style="width: 250px;">Add Package</button>
	        	</div>
	        </div>
            <!-- /.row -->
          </form>
          </div>
          <!-- /.card-body -->         
        </div>
		    <!--  -->
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

  @endsection   
@section('page-js-script')
  <script>
    $( document ).ready(function() { 
		$("#editform").validate();
      	$('#reservation').datetimepicker({
	        format: 'YYYY-MM-DD',
	    });

		$('#list-table').on('click', '.delete_payment', function(e){

		  var r = confirm("Are You Sure?");
        if (r == true) {

              e.preventDefault();
              $(this).parents('tr').remove();
              let id =$(this).attr('data-id');
              $.ajax({
                url: baseUrl+"/admin/manufacturers/delete/payment",
                type: "POST",
                data: {_token: "{{ csrf_token() }}",id:id},
              });
               // $.post(baseUrl+"/admin/manufacturers/delete/payment/",{_token: "{{ csrf_token() }}",id:id},function(){
               // });
        } else {
                    return false;
        }

    });
    });
 </script>
 @endsection   