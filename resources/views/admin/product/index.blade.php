    
@extends("admin/layouts.master")
@section('content')
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
            <h1 class="m-0">Product List - {{$brand->company_name}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-2">
            <a href="{{url('/admin/product/add/'.$brand->brand_id)}}">
              <button class="btn btn-primary">Add Product</button>
            </a>
          </div>
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-12">
                <div class="card card-default" style="margin-top: 20px;">
                  <div class="card-header">
                    <h3 class="card-title">Product  Search</h3>
                  </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                  <form action="{{url('admin/products/'.$brand->brand_id)}}">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Product Id</label>
                        <input class="form-control" type="text"  name="productId" value="{{ app('request')->input('productId') }}" placeholder="Product Id">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                      <label>Product name</label>
                      <input class="form-control" type="text"  name="productName" value="{{ app('request')->input('productName') }}" placeholder="Product name">
                    </div>
                  </div>
                  <div class="col-md-2"><div class="form-group"><label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-block btn-secondary">Apply</button>
                  </div>
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
                  <h3 class="card-title" style="float:right">Total results found : {{$products->total()}}</h3>
                </div>   
              <div class="card-body">
                @if(count($products)>0)
                <table id="example2" class="table table-bordered table-hover">                  
                  <thead>
                  <tr style="background: #dfdfdf;">
                    <th>Date</th>
                    <th>Product ID</th>
                    <th width="20%">Product Name</th>
                    <th>Status</th>
                    <th>Edit</th>    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $index=>$product)
                    <tr>
                      <td>{{date('d-m-Y',strtotime($product->created_at))}}</td>
                      <td>P{{$product->product_id}}</td>
                      <td>{{$product->product_name}}</td>
                      <td ><button type="button" class="btn btn-flat btn-primary">Approved</button></td>
                      <td><a href="{{url('/admin/product/edit/'.$product->product_id)}}" style="color: #000">
                      <i class="fas fa-edit"></i> Edit
                      </a></td>
                    </tr>
                    @endforeach
                  </tbody>                
                </table>
                @else
                  <span>No result found</span>
                @endif
              </div>
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