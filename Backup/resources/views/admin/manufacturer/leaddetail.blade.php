  @extends("admin/layouts.master")
  @section('content')    

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Leads - {{$brands->company_name}}</h1>
          </div><!-- /.col -->
      
          </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
   
    <!-- /.content-header -->

    <!-- Main content -->
              <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
         <!--      <div class="card-header">
                <h3 class="card-title">Display List of  Industry History</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr style="background: #ccc;">
                    <th>Leads</th>
         
                    <th>Last 1 Day</th>
                    <th>Last 7 Days</th>
                    <th>Last 1 Month</th>
                                  
                  </tr>
                  </thead>
                  <tbody>

                    <tr>
                    <td style="background: #ccc;">General Leads</td>
                    <td>{{$brands->today_general}} </td>
                    <td>{{$brands->week_general}}</td>
                    <td>{{$brands->month_general}}</td>
                    </tr>
                    <tr>
                    <td style="background: #dfdfdf;">Direct Leads</td>
                    <td>{{$brands->today_direct}} </td>
                    <td>{{$brands->week_direct}}</td>
                    <td>{{$brands->month_direct}}</td>
                    </tr>
              
                  </tbody>
                
                </table>


                <p>
                <div class="row">
                  <div class="col-md-3"><strong>Total Leads:</strong></div><div class="col-md-7">{{$brands->total}}</div>

                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                  <div class="col-md-3"><strong>Total Direct Leads:</strong></div><div class="col-md-7">{{$brands->direct}}</div>

                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                  <div class="col-md-3"><strong>Total General Leads : </strong></div><div class="col-md-7">{{$brands->general}}</div>

                </div>
                </p>


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
@endsection  