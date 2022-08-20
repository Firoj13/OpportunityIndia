@extends("admin/layouts.master")
@section('content')
@php $langs = config('constants.languages'); @endphp
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-3"><h3>Edit Product</h3></div>
         <!-- /.col -->
         <div class="col-sm-9" >
            <a href="{{url('admin/products/history')}}" class="btn btn-block btn-secondary btn-flat" style="float: right;width: 250px;">View History</a>
         </div>
         <!-
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <form id="editform" class="form-horizontal" method="post" action="{{url('admin/product/store')}}">
                     {{csrf_field()}}
                     {{ method_field('POST') }}  
                     <input type="hidden" name="brandId" value="{{$product->brand->brand_id}}">
                     <input type="hidden" name="productId" value="{{$product->product_id}}">
                     <div class="row">
                        <div class="col-sm-9">
                           <h2>{{$product->brand->company_name}}</h2>
                           <div class="card-body">

                                    <div class="form-group row">
                                      
                                      <div class="col-sm-12">
                                        <div class="card card-primary card-outline card-outline-tabs">
                                            <div class="card-header p-0 border-bottom-0">
                                              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                @foreach($langs as $key=>$lang)
                                                <li class="nav-item">
                                                  <a class="nav-link {{$key=='en'?'active':''}}" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-{{$key}}" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">{{$lang}}</a>
                                                </li>
                                                @endforeach
                                              </ul>
                                            </div>
                                            <div class="card-body">
                                              <div class="tab-content" id="custom-tabs-four-tabContent">
                                                @foreach($langs as $key=>$lang)
                                                <div class="tab-pane fade {{$key=='en'?'show active':''}}" id="custom-tabs-four-{{$key}}" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                  <div class="form-group row">
                                                      <div class="col-sm-12">
                                                         <input type="text" name="productName[{{$key}}]" class="form-control"  placeholder="Product Name (in {{$lang}})" value="{{isset($product->languages[$key])?$product->languages[$key]->product_name:''}}"  required maxlength="255">
                                                      </div>
                                                   </div>

                                                   <div class="form-group row">
                                                      <div class="col-sm-12">
                                                         <textarea class="form-control" name="description[{{$key}}]" rows="3" placeholder="Description (in {{$lang}}) ..." required>{{isset($product->languages[$key])?$product->languages[$key]->description:''}}</textarea>
                                                      </div>
                                                   </div>                                                   
                                                </div>
                                                @endforeach
                                             </div>
                                          </div>
                                       </div> 
                                    </div> 
                                </div>   
                                <div class="form-group row">
                                   <label for="inputPassword3" class="col-sm-3 col-form-label">Product Video</label>
                                   <div class="col-sm-9">
					                      <div style="margin-bottom: 10px" class="{{empty($product->video)?'dnone':''}}" id="video-preview">
					                        <img width="420" height="315" src="{{$product->video?$product->getyoutubethumb($product->video->media_url):''}}"/>
					                      </div>                                       	
                                  <div class="input-group">
		                                <input id="youtube-url" type="text" class="form-control" name="companyVideo" placeholder="Enter youtube video url" >
					                      <div class="input-group-append">
					                          <div class="input-group-text" title="Upload video"><i class="fab fa-youtube"></i></div>
					                      </div>
                              </div>
                              </div>
                                </div>
                                <div class="form-group row">
                                   <label  class="col-sm-3 col-form-label">Product Images</label>
                                   <div class="col-sm-9">
                                      <div class="form-group">
                                        <!-- <label for="customFile">Custom File</label> -->
                                  		<div style="margin-bottom: 10px" class="{{count($product->images)>0?'':'dnone'}}" id="banner-preview">
                                  		@foreach($product->images as $slider)
                                            <img src="{{env('S3_BUCKET_URL','').'brands/product/'.$slider->media_url}}" width="450px"/>
                                        @endforeach    
                                  		</div>
                                         
                                        <div class="custom-file">
                                           <input type="file" class="custom-file-input" id="upload-banner" multiple accept="image/*">
                                           <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                         Note:Max 5 Images and Only
                                      </div>
                                   </div>
                                </div>

                              <div class="form-group row">
                                 <label class="col-sm-3 col-form-label">Product Specification</label>
                                 <div class="col-sm-9">
	                                  <table class="table table-bordered" id="attribute-table">
	                                     <thead>
	                                     </thead>
	                                     <tbody>
	                                     	      
	                                     	@if(count($product->Attributes)>0)
		                                     	@foreach($product->Attributes as $indx=>$attribute)

		                                        <tr>
		                                        	<input type="hidden" name="attribute[{{$indx}}][id]" value="{{$attribute->product_attr_id}}">
		                                           <td width="50%"><input class="form-control" type="text" name="attribute[{{$indx}}][key]" placeholder="Specification Title" value="{{$attribute->attribute_column}}" maxlength="255"></td>

		                                           <td width="50%"><input class="form-control" type="text" name="attribute[{{$indx}}][value]" placeholder="Specification Value" value="{{$attribute->attribute_value}}" maxlength="255"></td>
		                                           <td><a class="delete"><i class=" fas fa-trash"></i></a></td>
		                                        </tr>
		                                        @endforeach
		                                    @else
		                                        <tr>
		                                           <td width="50%"><input class="form-control" type="text" name="attribute[0][key]" value="" placeholder="Specification Title" maxlength="255"></td>
		                                           <td width="50%"><input class="form-control" type="text" name="attribute[0][value]" value=""placeholder="Specification Value" maxlength="255"></td>
                                               <td><a class="delete"><i class=" fas fa-trash"></i></a></td>
		                                        </tr>
	                                        @endif
	                                     </tbody>
	                                   </table>
                                 	<div class="row">
                                 		<div class="col-12">
                                 			<button type="button" style="width: 100%" class="add-more btn btn-secondary">Add More</button>
                                 		</div>
                                 	</div>	
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="back">
                              <div class="form-group row">
                                 <div class="col-sm-6">
                                    <button type="submit" class="btn btn-block btn-success btn-flat">Save</button>
                                 </div>
                                 <div class="col-sm-6">
                                    <a href="{{url('/admin/products/'.$product->brand->brand_id)}}"><button type="button" class="btn btn-block btn-secondary btn-flat">Cancel</button></a>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="inputPassword3" class="col-sm-4 col-form-label">Status</label>
                                 <div class="col-sm-8">
                                    <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" checked="">
                                       <label for="customRadio2" class="custom-control-label">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" >
                                       <label for="customRadio1" class="custom-control-label">InActive</label>
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <!-- /.card-header -->
               <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   </div>
   <!-- /.container-fluid -->
</section>
<!-- /.content -->
@section('page-js-script')
    <script>
	$( document ).ready(function() { 
	  	$("#editform").validate();
	  	$("#youtube-url").on('change keydown paste input', function(){
    		let url=$(this).val();
    		let youtubeId=youtube_parser(url)
    		let thumbnail='https://img.youtube.com/vi/'+youtubeId+'/default.jpg';
    		if(matchYoutubeUrl(url)){	    			
				let img=$('<img width="420" height="315" frameborder="0"/>')
				    .attr("src",thumbnail);
				$("#video-preview").show().html(img);
    		}else{	    			
    			$("#video-preview").hide();
    		}
    	});
        
        $("#upload-banner").change(function (e) {
		    if ((this.files.length+$("#banner-preview img").length)>5) {
		        alert("Only 5 files accepted.");
		        e.preventDefault();
		        return;
		    }
			   if (window.FormData) {
			        formdata = new FormData();
			        formdata.append("_token",'{{ csrf_token() }}')
			    //  document.getElementById("btn").style.display = "none";
			   }

		      var i = 0, len = this.files.length, img, reader, file;
		      $("#banner-preview").show();

		        for ( ; i < len; i++ ) {
		            file = this.files[i];

		            if (!!file.type.match(/image.*/)) {
                        //showUploadedItem(e.target.result, file.fileName);
		            	let src = URL.createObjectURL(file)
		            	let img='<img class="preview" width="400px" src="'+src+'"/>'
		            	$("#banner-preview").append(img)

		                if (formdata) {
		                    formdata.append("images[]", file);
		                }
		            }   
		         }

               if(formdata) {
		        	   upload(formdata).then((response)=>{
			        	   response.images.forEach(function(image) {
						      $("#banner-preview").append("<input type='hidden' name='banners[]' value='"+image+"'/>"); 
						   });     	        		
		        	    }); 
		         } 
          	})

          	async function upload(formdata){
	            return $.ajax({
	               url: baseUrl+"/admin/manufacturer/image/upload",
	               type: "POST",
	               data: formdata,
	               processData: false,
	               contentType: false
	            });
          	}

			$(".add-more").click(function(){
				add_row();
			});

			$('#attribute-table').on('click', '.delete', function(){
				$(this).parents('tr').remove();

			});	

			function add_row(){
        		let len=$('#attribute-table tr').length;
				let input1=$('<input class="form-control" type="text" name="attribute['+len+'][key]" value="" placeholder="Specification Title" maxlength="255">');
				let input2=$('<input class="form-control" type="text" name="attribute['+len+'][value]" value="" placeholder="Specification Value" maxlength="255">');

				let tr=$('<tr/>');
				let td=$('<td/>');
				tr.append($('<td/>').append(input1));
				tr.append($('<td/>').append(input2));

				tr.append('<td><a class="delete"><i class=" fas fa-trash"></i></a></td>');
				$('#attribute-table').append(tr);
			}


			function youtube_parser(url){
			    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
			    var match = url.match(regExp);
			    return (match&&match[7].length==11)? match[7] : false;
			}

			function matchYoutubeUrl(url) {
			   var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
			   if(url.match(p)){
			      return url.match(p)[1];
			   }
			   return false;
			}

	});
    </script>	
	@endsection    
@endsection