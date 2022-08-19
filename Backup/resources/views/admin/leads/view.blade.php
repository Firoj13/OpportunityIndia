@extends("admin/layouts.master")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
   <div class="row mb-2">
      <div class="col-sm-2">
        <h1 class="m-0">Lead</h1>
      </div><!-- /.col -->
      <div class="col-sm-10 pull-right" style="text-align: right">   
      	<a href="{{url('admin/lead/edit/'.$lead->lead_id)}}" class="btn btn-flat btn-secondary"  
			style="width: 160px;">Edit
		</a>

	    <a href="{{url('admin/lead/history/'.$lead->lead_id)}}" class="btn btn-flat btn-secondary"  
			style="width: 160px;f">View History
		</a>
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
			<form>
				<div class="card-body">
					<div class="row">
						<div class="col-8">
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Lead Id</label>
								<div class="col-sm-8">
									{{$lead->lead_id}}
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-4 col-form-label">Phone No.</label>
								<div class="col-sm-8">
									{{$lead->buyer->mobile}}
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPassword3" class="col-sm-4 col-form-label">OPT Verification</label>
								<div class="col-sm-8">
									<div  class="lineval">
							    		Yes
									</div>
								</div>
							</div>

							<div class="form-group row">
							<label for="inputPassword3" class="col-sm-4 col-form-label">Email</label>
							<div class="col-sm-8">
								{{$lead->buyer->email}}
							</div>
							</div>



							<div class="form-group row">
								<label for="inputPassword3" class="col-sm-4 col-form-label">Name</label>
								<div class="col-sm-8">
									{{$lead->buyer->name}}
								</div>
							</div>


							<div class="form-group row">
								<h5 style="color: #000; text-decoration: underline;">Additional Details</h5>
							</div>
							@foreach($fields as $field=>$value)
							<div class="form-group row">
								<label for="inputPassword3" class="col-sm-4 col-form-label">{{$field}}</label>
								<div class="col-sm-8">
									{{$value}}
								</div>
							</div>
							@endforeach

							</div>
						</div>

					</div>
					<!-- /.card-body -->
				</form>
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