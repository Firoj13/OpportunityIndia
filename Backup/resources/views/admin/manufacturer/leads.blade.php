  @extends("admin/layouts.master")
  @section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1 class="m-0">Manufactures Leads</h1>
          </div><!-- /.col -->
            <div class="col-sm-8">
              <div class="row">
                <div class="col-sm-3">           
                </div>
                  <div class="col-sm-9"><form action="{{url('admin/manufacturers/leads')}}">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control form-control-lg" placeholder="Search Manufactures Id" value="{{ app('request')->input('search') }}">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i></button>
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
                    <th>S.no</th>
                    <th>Manufactures ID</th>                
                    <th width="30%">Manufactures Name</th>
                    <th>Genral Leads</th>
                    <th>Direct Leads</th>
                    <th>View Detail</th>                     
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($brands as $indx=>$brand) 
                    <tr>
                      <td>{{$indx+1}}</td>
                      <td>M{{$brand->brand_id}}</td>
                      <td>{{$brand->company_name}}</td>
                      <td>{{$brand->general}}</td>
                      <td>{{$brand->direct}}</td>
                      <td><a href="{{url('/admin/manufacturers/leads/'.$brand->brand_id)}}" class="vlink">View Details</a></td>
                    </tr>
                    @endforeach
                  </tbody>                
                </table>
                @else
                <span>No results</span>
                @endif
              </div>
              <!-- /.card-body -->
            </div>
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
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  @endsection        
