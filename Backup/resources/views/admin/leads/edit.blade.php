@extends("admin/layouts.master")
@section('content')
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-2">
			<h1 class="m-0">Enrich Lead</h1>
			</div><!-- /.col -->
			<div class="col-sm-10 pull-right"  style="float: right;">   <a href="{{url('admin/lead/history/'.$lead->lead_id)}}" class="btn btn-flat btn-block btn-secondary"  
			style="width: 160px;float: right;">View History</a>

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
				<form action="{{url('/admin/lead/store')}}" method="post">
					<input type="hidden" name="id" value="{{$lead->lead_id}}">
					{{csrf_field()}}
		            {{ method_field('POST') }}
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

							<input type="text" class="form-control" name="mobile" value="{{$lead->buyer->mobile}}"  readonly="">
						</div>
					</div>

					<div class="form-group row">
					<label for="inputPassword3" class="col-sm-4 col-form-label">OPT Verification</label>
					<div class="col-sm-8">
					<div  class="lineval">
					  <div  class="radio-item "><input  type="radio" id="ritemb1" checked="" value="yes" >
					    <label  for="ritemb1">Yes</label></div>
					  <div  class="radio-item "><input  type="radio" id="ritemb7" value="no" ><label  for="ritemb7">No</label></div>

					<!----></div>
					</div>
					</div>

					<div class="form-group row">
					<label for="inputPassword3" class="col-sm-4 col-form-label">Email</label>
					<div class="col-sm-8">
					<input type="email" name="email" class="form-control" value="{{$lead->buyer->email}}"  placeholder="Email" required="">
					</div>
					</div>

					<div class="form-group row">
					<label for="inputPassword3" class="col-sm-4 col-form-label">Name</label>
					<div class="col-sm-8">
					<input type="text" name="name" class="form-control" value="{{$lead->buyer->name}}"  placeholder="Name" required>
					</div>
					</div>

					<div class="form-group row">
					<h5 style="color: #000; text-decoration: underline;">Additional Details</h5>
					</div>
					
					@foreach($fields as $field=>$value)
					<div class="form-group row">
						<label for="inputPassword3" class="col-sm-4 col-form-label">{{ucwords($field)}}</label>
						<div class="col-sm-8">
							<input type="text" name="fields[{{$field}}]" class="form-control" value="{{$value}}"  placeholder="{{$field}}" required>
						</div>
					</div>
					@endforeach
					<div class="form-group row">
						<div class="col-sm-12 style="float: right;">
							<button type="submit" class="btn btn-flat btn-primary" style="float: right;width: 150px">Save</button>
						</div>
					</div>
					</div>
					</div>
					</div>
					<!-- /.card-body -->
					</div>
					</form>
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