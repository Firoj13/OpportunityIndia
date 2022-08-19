@extends("admin/layouts.master")
@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4" style="margin:auto 0px">
          <h1 class="m-0">Product History</h1>
        </div><!-- /.col -->
          <div class="col-sm-8">
            <div class="row">
              <div class="col-sm-12">
                <div class="card card-default" style="margin-top: 20px;">
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                  <form action="{{url('admin/products/history')}}">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Product ID</label>
                          <input class="form-control" type="text"  name="id" value="{{ app('request')->input('id') }}" placeholder="Product ID">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Date</label>
                            <div class="input-group date" id="reservation" data-target-input="nearest">
                              <input type="text"  name="date" class="form-control datetimepicker-input" data-target="#reservation" value="{{\Request::get('date')}}"/>
                              <div class="input-group-append" data-target="#reservation" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <div class="col-md-2">
                        <div class="form-group"><label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-block btn-secondary">Apply</button>
                      </div>
                    </div>
                    <!-- /.row -->
                  </form>  
                </div>            
              </div>
              <!-- /.card-body -->
            </div>
          </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->
	<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
              	@if(count($revisions)>0)
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr style="background: #dfdfdf;">
                    <th>ID</th>
                    <th width="12%">Date</th>
                    <th width="10%">Time</th>
                    <th width="10%">User</th>
                    <th>Action</th>                     
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($revisions as $indx=>$history)
  	         		      <tr>
    		                <td>{{$history->revisionable_id}}</td>
    		                <td>{{date("d-m-Y",strtotime($history->updated_at))}}</td>
    		                <td>{{date("H:i A",strtotime($history->updated_at))}}</td>
    		                <td>{{$history->user_id}} or {{$history->userResponsible()->name}}</td>
    		                <td>
    		                	@if($history->key == 'created_at' && !$history->old_value)
    		                		{{ $history->userResponsible()->name }} Created at {{ $history->newValue() }}
    		                	@else
    		                		{{ $history->userResponsible()->name }} Changed {{ $history->fieldName()}} from <b>{{ \Illuminate\Support\Str::limit(str_replace([9,10,11,12],['rejected','created','modified','approved'],$history->oldValue()), 40, $end='...') }}</b> to <b>{{ \Illuminate\Support\Str::limit(str_replace([9,10,11,12],['rejected','created','modified','approved'],$history->newValue()), 40, $end='...') }}</b>
    		                	@endif
    		                </td>	                      
	                   </tr>
	                @endforeach	
                  </tbody>
                </table>
                @else
                  <div>No Results Found</div>
                @endif

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <div class="row">
              		<div class="col-12">
                		<div class="dataTables_paginate paging_simple_numbers">
                  			{{$revisions->appends($_GET)->links()}}
                		</div>
              		</div>
            	  </div> 
        	  </div> 	              
            </div>
            </div>
            <!-- /.card -->
          </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

      </div>
      <!-- /.container-fluid -->
	</section>
 
@endsection    
@section('page-js-script')
  <script>
     $( document ).ready(function() { 
      //Date picker
      $('#reservation').datetimepicker({
          format: 'L'
      });
    });
  </script>
@endsection   