@extends("admin/layouts.master")
@section('content')   
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-3" style="margin:auto 0px">
              <h1 class="m-0">Approve Leads</h1>
            </div><!-- /.col -->
            <div class="col-sm-9">
                <div class="row">            
                <div class="col-sm-12">
                <div class="card card-default" style="margin-top: 20px;">
                  <div class="card-body" style="display: block;">
                    <form action="{{url('/admin/leads/approved')}}">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Lead Id</label>
                          <input class="form-control" type="text"  name="leadid" placeholder="Lead Id" value="{{\Request::get('leadid')}}">
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Buyer Id</label>
                          <input class="form-control" type="text"  name="buyerid" placeholder="Buyer Id" value="{{\Request::get('buyerid')}}">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Supplier Id</label>
                          <input class="form-control" type="text"  name="supplierid" placeholder="Supplier Id" value="{{\Request::get('supplierid')}}">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                        <label>Lead Type</label>
                          <select name="leadtype" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;">
                          <option value="">All</option>
                          <option value="general" {{\Request::get('leadtype')=='general'?'selected':''}}>General</option>
                          <option value="direct" {{\Request::get('leadtype')=='direct'?'selected':''}}>Direct</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group"><label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-block btn-secondary">Search</button></div>
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
                                <th>Approval</th>               
                              </tr>
                              </thead>
                              <tbody>
                                @foreach($leads as $indx=>$lead)
                                  <tr>
                                    <td>{{$indx+1}}</td>
                                    <td>L-{{$lead->lead_id}}</td>
                                    <td>{{date("d-m-Y",strtotime($lead->created_at))}}</td>
                                    <td>{{$lead->buyer->mobile}}</td>
                                    <td>B-{{$lead->buyer->id}}</td>
                                    <td>S-678 </td>
                                    <td class="blue">{{$lead->lead_type}}</td>
                                    <td><a href="{{url('admin/lead/view/'.$lead->lead_id)}}"   style="color: #000">
                                    <i class="fas fa-edit"></i> view
                                    </a></td>
                                    <td>
                                      <a href="{{url('admin/lead/edit/'.$lead->lead_id)}}"   style="color: #000">
                                        <i class="fas fa-edit"></i> Enrich
                                      </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <select class="form-control action" style="width: 100%;" data-id={{$lead->lead_id}}>
                                          <option value="">Select</option>
                                          <option value="2">Approved</option>
                                          <option value="5">Rejected</option>
                                        </select>
                                    </td>
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
                <div class="card-footer">
                    <div class="row">
                    <div class="col-12">
                      <div class="dataTables_paginate paging_simple_numbers">
                          {{$leads->appends($_GET)->links()}}
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
          $(".action").change(function(){
            let id=$(this).attr("data-id"); 
            let value=$(this).val();
            if(value=='2'){
              $(this).parents('tr').addClass('backgreen');
            }else if(value=='5'){
              $(this).parents('tr').addClass('backred');
            }
            $.post(baseUrl+"/admin/lead/status/",{_token: "{{ csrf_token() }}",id:id,status:value},function(){

            });            
          }); 
        });        
      </script>
    @endsection        
  @endsection     