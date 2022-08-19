	@extends("admin/layouts.master")
	@section('content')
	    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-12" style="margin:auto 0px">
	            <h1 class="m-0">Leads</h1>
	          </div><!-- /.col -->
	          <div class="col-sm-12">
	              <div class="row">	           
	             	<div class="col-sm-12">
	         			<div class="card card-default" style="margin-top: 20px;">
				          <div class="card-body" style="display: block;">
				            <form action="{{url('/admin/leads')}}">
				            <div class="row">
				     		  <div class="col-md-2">
					              <div class="form-group">
						              <label>Lead Id</label>
						              <input class="form-control" type="text"  name="leadid" placeholder="Lead Id" value="{{\Request::get('leadid')}}">
					              </div>
				              </div>	      
				          	  <div class="col-md-2">
				                
				                <div class="form-group">
				                  <label>Date</label>
				                    <div class="input-group date" id="reservation" data-target-input="nearest">
				                        <input type="text"  name="leadDate" class="form-control datetimepicker-input" data-target="#reservation" value="{{\Request::get('leadDate')}}"/>
				                        <div class="input-group-append" data-target="#reservation" data-toggle="datetimepicker">
				                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
				                        </div>
				                    </div>
				                </div>
				                <!--<div class="form-group">
				                  <label>Date range:</label>

				                  <div class="input-group">
				                    <div class="input-group-prepend">
				                      <span class="input-group-text">
				                        <i class="far fa-calendar-alt"></i>
				                      </span>
				                    </div>
				                    <input type="text" name="leadDate" class="form-control float-right" id="reservation">
				                  </div>-->
				                  <!-- /.input group -->
				             
				                <!-- /.form group -->
				              </div>	      	
				              <div class="col-md-2">
					              <div class="form-group">
						              <label>Buyer Id</label>
						              <input class="form-control" type="text"  name="buyerid" placeholder="Buyer Id" value="{{\Request::get('buyerid')}}">
					              </div>
				              </div>
				              <div class="col-md-2">
					              <div class="form-group">
						              <label>Supplier Id</label>
						              <input class="form-control" type="text"  name="supplierid" placeholder="Supplier Id" value="{{\Request::get('supplierid')}}">
					              </div>
				              </div>
			              
								<div class="col-md-2">
									<div class="form-group">
									<label>Type</label>
										<select name="leadtype" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;">
										<option value="">All</option>
										<option value="general" {{\Request::get('leadtype')=='general'?'selected':''}}>General</option>
										<option value="direct" {{\Request::get('leadtype')=='direct'?'selected':''}}>Direct</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group"><label>&nbsp;</label><br>
									<button type="submit" class="btn btn-flat btn-block btn-secondary">Search</button></div>
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
	                	<h3 class="card-title" style="float:right">Total results found : {{$leads->total()}}</h3>
	              	</div>
	              <div class="card-body">
	              	@if(count($leads)>0)
	                <table id="example2" class="table table-bordered table-hover">
	                  <thead>
	                  <tr style="background: #dfdfdf;">
	                    <th>S.No.</th>
	                    <th>Lead</th>
	                    <th>Date</th>
	                    <th>Phone No.</th>
	                    <th>Buyer Id</th>
	                    <th>Suppier Id</th>
	                    <th>Lead Type</th>
	                    <th>View</th>    
						<th>Enrich</th>
	                    <th style="text-align: center;">Verified</th>                
	                  </tr>
	                  </thead>
	                  <tbody>
	                  	@foreach($leads as $indx=>$lead)
						<tr class="{{$lead->status=='5'?'backred':''}}">
							<td>{{$indx+1}}</td>
							<td><a href="{{url('admin/lead/view/'.$lead->lead_id)}}"   style="color: #000">L-{{$lead->lead_id}}</a></td>
							<td>{{date("d-m-Y",strtotime($lead->created_at))}}</td>
							<td>{{($lead->buyer) ? $lead->buyer->mobile : '---'}}</td>
							@if($lead->buyer)
							<td>B-{{$lead->buyer->id}}</td>
							@else
							<td>---</td>
							@endif
							@if($lead->supplier)
							<td>S-{{$lead->supplier->supplier_id}} </td>
							@else
							<td>---</td>
							@endif
							<td class="blue">{{$lead->lead_type}}</td>
							<td><a href="{{url('admin/lead/view/'.$lead->lead_id)}}"   style="color: #000">
							<i class="fas fa-edit"></i> view
							</a></td>
							<td><a href="{{url('admin/lead/edit/'.$lead->lead_id)}}"   style="color: #000">
							<i class="fas fa-edit"></i> Enrich
							</a></td>
							<td class="green" style="text-align: center;">@if($lead->status==2)<i class="fas fa-check"></i>@endif</td>
						</tr>
						@endforeach	
	                  </tbody>
	                </table>
	                @else
	                <div class="row">
	                	<div class="col-12">
	                		No results
	                	</div>
	                </div>
	                @endif	
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer">
	                  <div class="row">
	              		<div class="col-12">
	                		<div class="dataTables_paginate paging_simple_numbers">
	                  			{{$leads->appends($_GET)->links()}}
	                		</div>
	              		</div>
	            	  </div> 
            	  </div> 	              
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
	        //Date picker
	    $('#reservation').datetimepicker({
	        format: 'L'
	    });
	    /*$('#reservation').daterangepicker({
	    	autoUpdateInput:false
	    }).on('apply.daterangepicker', function(ev, picker) {
  				//do something, like clearing an input
  			$('#reservation').val(picker.startDate.format('DD/MM/YYYY')+'-'+picker.endDate.format('DD/MM/YYYY'));
		}).on('cancel.daterangepicker', function(ev, picker) {
  				//do something, like clearing an input
  			$('#reservation').val('');
		});*/
	});
    </script>
   @endsection        
