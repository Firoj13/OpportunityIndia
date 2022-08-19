@extends("admin/layouts.master")
@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-sm-3" style="margin:auto 0px">
            <h1 class="m-0">Lead History</h1>
          </div><!-- /.col -->
          <div class="col-sm-9">
            <div class="row">           
              <div class="col-sm-12">
                <div class="card card-default" style="margin-top: 20px;">
                  <!-- /.card-header -->
                  <div class="card-body" style="display: block;">
                    <form action="">
                    <div class="row">
                      <div class="col-md-3">
                      <div class="form-group">
                        <label>Lead Id</label>
                        <input class="form-control" type="text"  name="leadid" placeholder="Lead Id" value="{{\Request::get('leadid')}}">
                      </div>
                      </div>
                      <div class="col-md-3">
                      <div class="form-group">
                        <label>Buyer Id</label>
                        <input class="form-control" type="text"  name="buyerid" placeholder="Buyer Id" value="{{\Request::get('buyerid')}}">
                      </div>
                      </div>
                      <div class="col-md-3">
                      <div class="form-group">
                        <label>User</label>
                        <input class="form-control" type="text"  name="user" placeholder="User" value="{{\Request::get('user')}}">
                    </div>
                    </div>
                    <div class="col-md-2"><div class="form-group"><label>&nbsp;</label><br>
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
         <!--      <div class="card-header">
                <h3 class="card-title">Display List of  Industry History</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                @if(count($revisions)>0)
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr style="background: #dfdfdf;">                  
                    <th>Lead Id</th>
                    <th>Buyer Id</th>
                    <th>Buyer No.</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>User</th>
                    <th>Action</th>                                
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($revisions as $indx=>$history)
                       @php 
                        $find = array(1,2,3,4,5,6);
                        $replace = array("Must Call","Do not Call","Enrich","Expired","Rejected");

                       if($history->detailId>0){
                          $detail=App\Models\LeadDetail::find($history->revisionable_id);
                          $lead=$detail->lead;  
                       }else{
                          $lead=App\Models\Lead::find($history->revisionable_id);
                       }
                     
                      @endphp
                      @if(!$lead)
                        @continue
                      @endif 
                      <tr>
                      <td>{{$lead->lead_id}}</td>
                      <td>B-{{$lead->user_id}}</td>
                      <td>{{$lead->buyer->mobile}}</td>
                      <td>{{date("d-m-Y",strtotime($history->updated_at))}}</td>
                      <td>{{date("H:i A",strtotime($history->updated_at))}}</td>
                      <td >{{$history->user_id}} or {{$history->userResponsible()->name}}</td>
                      @if($history->detailId>0)
                        <td >Value of {{ $detail->attribute_name}} was changed from <b>{{$history->oldValue()}}</b> to <b>{{$history->newValue()}}</b></td>
                      @else
                        @if($history->key == 'status')
                          <td >Value of {{ $history->fieldName()}} was changed from <b>{{str_replace($find,$replace,$history->oldValue())}}</b> to <b>{{str_replace($find,$replace,$history->newValue())}}</b></td>
                        @else
                          <td >Value of {{ $history->fieldName()}} was changed from <b>{{$history->oldValue()}}</b> to <b>{{$history->newValue()}}</b></td>
                        @endif
                      @endif  
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
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
@endsection 