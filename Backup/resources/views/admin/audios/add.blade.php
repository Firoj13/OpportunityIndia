@extends("admin/layouts.master")
@section('title','All '. ucfirst(app('request')->input('filter')) .' | ')
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Audio</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form id="editform" method="post" action="{{url('admin/audios/store')}}">
      {{csrf_field()}}
      {{ method_field('POST') }}

      <div class="row">
          <div class="col-md-1">

          </div>
        <div class="col-md-9">
          <div class="card card-primary" style="padding: 1rem">
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" name="name" id="inputName" class="form-control" value="" minlength="2" required>
              </div>
                <div class="form-group">
                <label for="inputStatus">Status</label>
                <select id="inputStatus" name="status" class="form-control custom-select" required>
                  <option disabled>Select one</option>
                  <option value="1">Active</option>
                  <option value="0">inactive</option>
                </select>
              </div>
                <div class="form-group">
                    <label for="inputAudioFile" class="col-sm-3 col-form-label">Select Audio</label>
                        <div style="margin-bottom: 10px" class="dnone" id="audio-preview">
                            <audio class="preview" controls="controls" src="/" type="audio/mp3"/>
                        </div>

                        <div class="custom-file">
                            <input type="file" name="audio" class="custom-file-input" id="upload-audio" accept="audio/*">
                            <label class="custom-file-label" for="customFile">Choose Audio</label>
                        </div>
                </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

      </div>
          <div class="row">
              <div class="col-md-1">

              </div>
              <div class="col-9">
                  <a href="{{url('admin/audios')}}" class="btn btn-secondary">Cancel</a>
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
        <script>


            $("#upload-audio").change(function () {
                let $fls = this.files[0];
                var src = URL.createObjectURL(this.files[0])

                if($fls.size > 5242880)
                {
                    toastr.error("Audio size less than 5 Mb");
                    return false;
                }else{
                    $("#audio-preview").show();
                    $("#audio-preview").find('.preview').attr('src',src)
                    if (window.FormData) {
                        formdata = new FormData();
                        formdata.append("_token",'{{ csrf_token() }}')
                        //document.getElementById("btn").style.display = "none";
                    }
                    formdata.append("audios[]", $fls);

                    uploadAudio(formdata).then((response)=>{
                        response.audios.forEach(function(audio) {
                            $("#audio-preview").append("<input type='hidden' name='audio_file' value='"+audio+"'/>");
                        });
                    });
                }
            })


            async function uploadAudio(formdata){
                return $.ajax({
                    url: baseUrl+"/admin/audios/audio/upload",
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false
                });
            }
            $('body').on('click', '.audio-delete', function(){
                let audioId=$(this).attr('data-id');
                $(this).parents('.audio-file').hide()
                if (articleId>0) {
                    $.post(baseUrl+"/admin/audios/delete/audio",{audioId:audioId,_token:'{{ csrf_token() }}'});
                }
            });

        </script>

    @endsection

  @endsection
