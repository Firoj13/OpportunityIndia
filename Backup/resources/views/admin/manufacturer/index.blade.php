@extends("admin/layouts.master")
@section('content')
@php
if(Auth::user()->getRole() == 'Data Executive'){
    $disabled="disabled"; 
}else{
   $disabled = '';
} 
@endphp

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1 class="m-0">Manufactures List</h1>
          </div><!-- /.col -->
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-3">
                <a href="{{url('admin/manufacturer/add')}}"  class="btn btn-primary btn-sm btn-flat">Add New Manufacturer</a>
              </div>
            <div class="col-sm-9">              
              <form action="{{url('admin/manufacturers')}}">
                  <div class="input-group">
                    <input type="search" name="search" class="form-control form-control" placeholder="Search Manufacturers Id / Manufacturers Name / Manufacturers Slug" value="{{ app('request')->input('search') }}">
                      <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fa fa-search"></i>
                          </button>
                      </div>
                  </div>
              </form>

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
                    <th width="20%">Manufacturers Name</th>
                    <th width="15%">Slug</th>
                    <th>Products</th>
                    <th>Is Paid</th>
                    <th>Status</th>
                    <th>Edit</th>
                  </tr>
                  </thead>
                  <tbody>
                 @foreach($brands as $index=>$brand)
                  <tr>
                    <td>{{$brand->brand_id}}</td>
                    <td>{{date('d-m-Y',strtotime($brand->created_at))}}</td>
                    <td>{{$brand->company_name}}</td>
                    <td>{{$brand->profile_name}}</td>
                    <td align="center">
                      @if($brand->getProductCount()>0)
                        <a title="Products" href="{{($disabled) ? 'javascript:;' : ('/admin/products/'.$brand->brand_id)}}" > {{$brand->getProductCount()>0?$brand->getProductCount():'+'}}</a>
                      @else
                        <a title="Add Product"  href="{{($disabled) ? 'javascript:;' : ('/admin/product/add/'.$brand->brand_id)}}" > {{$brand->getProductCount()>0?$brand->getProductCount():'+'}}</a>
                      @endif
                    </td>
                    <td><a href="{{($disabled) ? 'javascript:;' : url('admin/manufacturers/payment/'.$brand->brand_id)}}"  >{{$brand->weightage<899?'Paid':'Free' }}</a></td>
                    @if($brand->profile_status=='7')
                      <td><button {{ $disabled }} type="button" class="btn btn-block btn-secondry btn-status btn-flat btn-sm" data-id="{{$brand->brand_id}}">BlackList</button></td>
                    @elseif($brand->profile_status=='8' || $brand->profile_status=='9')
                      <td><button {{ $disabled }} type="button" class="btn btn-block btn-danger btn-status btn-flat btn-sm" data-id="{{$brand->brand_id}}">Rejected</button></td>
                    @elseif($brand->profile_status=='12')    
                      <td><button {{ $disabled }} type="button" class="btn btn-block btn-success btn-status btn-flat btn-sm" data-id="{{$brand->brand_id}}">Approved</button></td>
                    @else
                      <td><button {{ $disabled }} type="button" class="btn btn-block btn-primary btn-status btn-flat btn-sm" data-id="{{$brand->brand_id}}">Modified</button></td>
                    @endif
                    <td>
						<a href="{{url('admin/manufacturer/edit/'.$brand->brand_id)}}" style="color: #000">
							<i class="fas fa-edit"></i>
						</a>
						@if(!empty($brand->user_id))
						<a class ="btn-otp" data-id="{{$brand->brand_id}}" href="{{($disabled) ? 'javascript:;' : '#'}}" style="color: #000">
							<i class="fas fa-lock"></i>
						</a>
						@endif
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
            </div>
            <!-- /.card -->
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
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    @section('page-js-script')
      <script>
        let disable = '@php echo ($disabled) ? $disabled : ''; @endphp';
        $( document ).ready(function() {

          
          $(".btn-status").click(function(){

            if(disable) return false;

            let brandId=$(this).attr("data-id");            
            let status;
            if($(this).hasClass("btn-success")){
              $(this).addClass("btn-primary").removeClass("btn-success").text("Pending");
               status=11
            }else{
              $(this).addClass("btn-success").removeClass("btn-primary").text("Approved");
              status=12
            }

            $.post(baseUrl+"/admin/manufacturer/status",{_token: "{{ csrf_token() }}",brandId:brandId,status:status},function(){

            });

          });

		  $(".btn-otp").click(function(){

         if(disable) return false;

			let brandId=$(this).attr('data-id');			  
			  $.post(baseUrl+"/admin/manufacturer/otp",{_token: "{{ csrf_token() }}",brandId:brandId},function(response){
				PNotify.success({
				  title: 'OTP For Manufacture : '+brandId,
				  text: response.mobile+' : '+response.otp,
				  icon: 'fas fa-check-circle-o',
				});				
			  });
		  });
        });        
      </script>
    @endsection    

@endsection    