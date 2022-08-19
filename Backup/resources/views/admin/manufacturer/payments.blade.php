  @extends("admin/layouts.master")
  @section('content')    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Payment Package</h1>
          </div><!-- /.col -->
          <div class="col-sm-12">
            <div class="row">           
             <div class="col-sm-12">
                 

        <div class="card card-default" style="margin-top: 20px;">
          <div class="card-header">
            <h3 class="card-title">Filter</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            <form action="{{url('admin/manufacturers/payments')}}">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                <label>Manufacture Id</label>
                <input class="form-control" type="text"  name="brandId" placeholder="Manufacture Id" value="{{ app('request')->input('brandId') }}">
              </div>
            </div>

     		 	    <div class="col-md-3">
              	<div class="form-group">
              		<label>Package</label>
            			<select class="form-control select2bs4" name="package">
                    <option value="">Select package</option>
                       @foreach($packages as $package)
                       @if($package->type!='EMAIL')
                        <option {{app('request')->input('package')==$package->id?'selected':''}} value="{{$package->id}}">{{$package->type}}-{{$package->title}}</option>
                      @endif
                      @endforeach
					        </select>
                </div>
              </div>
              <div class="col-sm-3"> <div class="form-group">
                <label>End Date</label>
                <div class="input-group date" id="reservation" data-target-input="nearest">
                  <input type="text" name="endDate" class="form-control datetimepicker-input" data-target="#reservation" value="{{ app('request')->input('endDate') }}">
                  <div class="input-group-append" data-target="#reservation" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
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
              <!-- /.card-header -->
              <div class="card-body">
                @if(count($brands)>0)
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr style="background: #dfdfdf;">
                    <th>S.No.</th>
             		    <th>M Id</th>
                   	<th width="20%">M Name</th>
                    <th>Main Package</th>
                    <th>Sub Package</th>
                    <th>End Date</th>
                    <th>View Details</th>                             
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($brands as $index=>$brand)
                    <!--@php print_r($brand->activeMembership)@endphp-->
          					<tr>
          						<td>{{$index+1}}</td>
          						<td>M{{$brand->brand_id}}</td>
          						<td>{{$brand->company_name}}</td>
          						<td>{{$brand->packageType}}</td>
          						<td>{{$brand->packageTitle}}</td>
          						<td>{{date("d M Y",strtotime($brand->expiry_date))}}</td>
          						<td><a href="{{url('admin/manufacturers/payment/'.$brand->brand_id)}}" class="vlink">View Details</a></td>
          						</td>
          					</tr>
                    @endforeach 
                  </tbody>                
                </table>
                @else
                  <span>No result found</span>
                @endif
              </div>
              <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <div class="row">
                    <div class="col-12">
                      <div class="dataTables_paginate paging_simple_numbers">
                        {{$brands->links()}}
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
    <!-- /.content -->
  @endsection   
  @section('page-js-script')
  <script>
    $( document ).ready(function() { 
      $("#editform").validate();
        $('#reservation').datetimepicker({
          format: 'YYYY-MM-DD',
      });
    });
 </script>
 @endsection   