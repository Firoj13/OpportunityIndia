@extends("admin/layouts.master")
@section('title','All '. ucfirst(app('request')->input('filter')) .' | ')
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Buyer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form id="editform" method="post" action="{{url('admin/users/store')}}">
      {{csrf_field()}}
      {{ method_field('POST') }}

      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" name="name" class="form-control" value="" minlength="2" required>
              </div>
              <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email" name="email" class="form-control" value="" required>
              </div>
              <div class="form-group">
                <label for="inputClientCompany">Mobile
                <input type="phone" name="mobile" class="form-control" value="" required maxlength="10">
              </div>
              <div class="form-group">
                <label for="inputStatus">Status</label>
                <select id="inputStatus" name="status" class="form-control custom-select" required>
                  <option disabled>Select one</option>
                  <option value="1">Active</option>
                  <option value="0">inactive</option>
                </select>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
                  <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Account</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="" id="password" class="form-control" value="" minlength="8" required>
              </div>
              <div class="form-group">
                <label for="confirm-password">Confirm password</label>
                <input type="password" name="cpassword" placeholder="" class="form-control" value="" minlength="8" required>
              </div>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Save Changes" class="btn btn-success float-right">
        </div>
      </div>
      </form>
    </section>

    @section('page-js-script')
      <script>
        $( document ).ready(function() {
          $("#editform").validate();
        });        
      </script>
    @endsection
    
  @endsection