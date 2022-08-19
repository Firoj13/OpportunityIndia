@extends("admin/layouts.master")
@section('content')
@php $langs = config('constants.languages'); 
$business_types = config('constants.business_type'); 
@endphp    
   <!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">Add New Manufacturer</h1>
         </div>
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
                  <form id="editform" class="form-horizontal" method="post" action="{{url('admin/manufacturer/store')}}">
                     {{csrf_field()}}
                     {{ method_field('POST') }}                     
                     <div class="row">
                        <div class="col-sm-9 manubktab">
                           <ul class="nav nav-tabs">
                              <li class="nav-item">
                                 <a class="nav-link active" data-toggle="tab" href="#primary">Primary Details</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" data-toggle="tab" href="#secondry">Secondary Details</a>
                              </li>
                           </ul>
                           <!-- Tab panes -->
                           <div class="tab-content">
                              <div class="tab-pane container active" id="primary">
                                 <div class="card-body">

                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Establishment Year</label>
                                       <div class="col-sm-8">
                                          <select class="form-control" name="establishmentYear">
                                          	<option>Select Establishment Year</option>
                                             @for($i=1970;$i<=date('Y');$i++) 
                                             	<option {{$brand->estab_year==$i?'selected':''}}>{{$i}}</option>
                                             @endfor
                                          </select>
                                       </div>
                                    </div>
                                    <div class="select-container">
	                                    <div class="form-group row">
	                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Primary industry</label>
	                                       <div class="col-sm-8">
	                                          <select class="form-control select-industry" name="industryId" required>
	                                             <option value="">Select Primary industry</option>
	                                             @foreach($industries as $industry) 
	                                             	<option value="{{$industry->id}}">{{$industry->name}}</option>
	                                             @endforeach
	                                          </select>
	                                       </div>
	                                    </div>
	                                    <div class="form-group row">
	                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Primary Sector</label>
	                                       <div class="col-sm-8">
	                                          <select class="form-control select-sector" name="sectorId" required>
	                                             <option value="">Select Primary Sector</option>
	                                          </select>
	                                       </div>
	                                    </div>
                                	</div>
                                    <div class="form-group row ">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Look For</label>
                                       <div class="col-sm-8">
                                          <ul class="ds inline">
                                          @foreach($business_types as $type)
                                             <li> <input type="checkbox" name="businessType[]" value="{{$type}}" > {{$type}}</li>
                                          @endforeach
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Name</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="name" class="form-control" value="{{ old('name', isset($brand->user) ? $brand->user->name : '') }}"  placeholder="Name" required>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Primary Phone</label>
                                       <div class="col-sm-2">
                                          <select class="form-control">
                                             <option>+91</option>
                                          </select>
                                       </div>
                                       <div class="col-sm-6">
                                          <input type="text" name="phone" class="form-control" value="{{ old('phone', isset($brand->user) ? $brand->user->mobile : '') }}"  placeholder="Phone" maxlength="10" minlength="10" required>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Email</label>
                                       <div class="col-sm-8">
                                          <input type="email" name="userEmail" class="form-control"  value="{{ old('userEmail', isset($brand->user) ? $brand->user->email : '') }}" placeholder="Email" required>
                                       </div>
                                    </div>
                                    <div class="select-container">
                                       <div class="form-group row">
                                          <label for="inputPassword3" class="col-sm-4 col-form-label">State</label>
                                          <div class="col-sm-8">
                                             <select class="form-control select-state" name="stateId" required >
                                                <option value="">Select State</option>
                                                @foreach($states as $data)
                                                	<option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group row">
                                          <label for="inputPassword3" class="col-sm-4 col-form-label">City</label>
                                          <div class="col-sm-8">
                                             <select class="form-control select-city" name="cityId" required>
                                                <option value="">Select City</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="tab-pane container" id="secondry">
                                 <div class="card-body">
                                    <div class="form-group row">
                                      <label  class="col-sm-3 col-form-label">Languages</label>
                                      <div class="col-sm-9">
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
                                                         <input type="text" name="companyName[{{$key}}]" class="form-control"  placeholder="Company Name (in {{$lang}})"  required>
                                                      </div>
                                                   </div>

                                                   <div class="form-group row">
                                                      <div class="col-sm-12">
                                                         <input type="text" name="brandName[{{$key}}]" class="form-control"  placeholder="Brand Name (in {{$lang}})" required>
                                                      </div>
                                                   </div>
                                                   <div class="form-group row">
                                                      <div class="col-sm-12">
                                                         <textarea class="form-control" name="description[{{$key}}]" rows="3" placeholder="Description (in {{$lang}}) ..." required></textarea>
                                                      </div>
                                                   </div>                                                   
                                                   <div class="form-group row">                          
                                                      <div class="col-sm-12">
                                                         <textarea class="form-control" name="companyDetails[{{$key}}]" rows="3" placeholder="Company detail (in {{$lang}})..."></textarea>
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
                                       <label class="col-sm-4 col-form-label">Secondary Email</label>
                                       <div class="col-sm-8">
                                          <input type="email" name="secondaryEmail" class="form-control" value="" placeholder="Email">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label  class="col-sm-4 col-form-label">Secondary  Phone</label>
                                       <div class="col-sm-2">
                                          <select class="form-control">
                                             <option>+91</option>
                                          </select>
                                       </div>
                                       <div class="col-sm-6">
                                          <input type="text" name="secondaryMobile" class="form-control" value="" placeholder="Phone" maxlength="10">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Address</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="address" class="form-control" value="" placeholder="Address" required="">
                                       </div>
                                    </div>                                    
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Website</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="website" class="form-control" value="" placeholder="Website">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">GST No.</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="gstNumber" class="form-control" value="" placeholder="GST No." maxlength="15">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Exclusive Territorial Rights given to the Distributor</label>
                                       <div class="col-sm-8">
                                          <ul class="ds inline">
                                             <li>  <input type="radio" name="exclusiveTerritorial" checked value="1"> Yes</li>
                                             <li>  <input type="radio" name="exclusiveTerritorial" value="0"> No
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Margin or Commission percentage</label>
                                       <div class="col-sm-8">
											<input type="text" name="marginCommission" class="form-control" value="" placeholder="" maxlength="10">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Financial Aid provoided</label>
                                       <div class="col-sm-8">
                                          <ul class="ds inline">
                                             <li>  <input type="radio" name="financeAid" checked value="1"> Yes</li>
                                             <li>  <input type="radio" name="financeAid" value="0"> No</li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Property Type</label>
                                       <div class="col-sm-8">
                                       	<input type="text" name="propertyType" class="form-control" value="" placeholder="">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Preferred Property Loction</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="prefPropLocation" class="form-control" value="" placeholder="">
                                       </div>
                                    </div>                                    
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Payback Period</label>
                                       <div class="col-sm-8">
											<input type="text" name="paybackPeriod" class="form-control" placeholder="">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Other Investment Request</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="investmentReq" class="form-control" placeholder="Other Investment Request">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Anticipated ROI?</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="anticipatedRoi" class="form-control" placeholder="Anticipated ROI?">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Investment Range</label>
                                       <div class="col-sm-4">
											          <input type="tel" name="investment[min]" class="form-control" placeholder="Min" required="">
                                       </div>
                                       <div class="col-sm-4">
											          <input type="tel" name="investment[max]" class="form-control" placeholder="Max" required="">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Company Logo </label>
                                       <div class="col-sm-8">
                                          <div class="form-group">
                                             <!-- <label for="customFile">Custom File</label> -->
						                    <div style="margin-bottom: 10px" class="dnone" id="logo-preview">
						                      <img class="preview" src=""/>
						                    </div>                                             

                                             <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="upload-logo" accept="image/*">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                             </div>
                                             Note :  * Image Size 199x81
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Company Video</label>
                                       <div class="col-sm-8">
						                    <div style="margin-bottom: 10px" class="dnone" id="video-preview">
						                      <img width="420" height="315" src="https://img.youtube.com/vi/tgbNymZ7vqY/default.jpg"/>
						                    </div>                                       	
                                          <div class="input-group">
                                             <!-- <label for="customFile">Custom File</label> -->
			                                  <input id="youtube-url" type="text" class="form-control" name="companyVideo" placeholder="Enter youtube video url" >
						                      <div class="input-group-append">
						                          <div class="input-group-text" title="Upload video"><i class="fab fa-youtube"></i></div>
						                      </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label  class="col-sm-4 col-form-label">Company Banners</label>
                                       <div class="col-sm-8">
                                          <div class="form-group">
                                            <!-- <label for="customFile">Custom File</label> -->
                                      		<!--<div style="margin-bottom: 10px" class="dnone" id="slider-preview"></div>-->
                                          <ul class="sliders" class="dnone" id="slider-preview"></ul>   
                                            <div class="custom-file">
                                               <input type="file" class="custom-file-input" id="upload-slider" multiple accept="image/*">
                                               <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                             Note: For better Result upload this size 1216x430
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Space Required</label>
                                       <div class="col-sm-3">
                                       		<input type="text" name="space[min]" class="form-control" placeholder="Min">
                                       </div>
                                       <div class="col-sm-3">
                                       		<input type="text" name="space[max]" class="form-control" placeholder="Max">
                                       </div>
                                       <div class="col-sm-2">
                                          <select class="form-control" name="spaceUnit">
                                            <option>Sq. ft</option>
                                            <option>Sq. mtr</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Secondary Industry/Sector</label>
                                       <div class="col-sm-8">
                                          <table class="table table-bordered" id="categorty-table">
                                             <thead>
                                             </thead>
                                             <tbody>
                                                <tr class="select-container">
                                                   <td width="50%">
                                                      <select class="form-control select-industry" name="industry[]">
                                                         <option value="">Select Industry</option>
			                                             @foreach($industries as $industry) 
			                                             	<option value="{{$industry->id}}">{{$industry->name}}</option>
			                                             @endforeach                                                         
                                                      </select>
                                                   </td>
                                                   <td width="50%">
                                                      <select class="form-control select-sector" name="sector[]">
                                                         <option value="">Sector</option>
                                                      </select>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <button type="button" class="btn btn-info add-categorty">Add More</button>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Expansion Location</label>
                                       <div class="col-sm-8">
                                          <table class="table table-bordered" id="location-table">
                                             <thead>
                                             </thead>
                                             <tbody>
                                                <tr class="select-container">
                                                   <td>
                                                      <select class="form-control select-state" name="locations[0][state]">
                                                         <option value="">Select State</option>
                                                         <option value="Pan India">Pan India</option>
                                                         <option value="North India">North India</option>
                                                         <option value="South India">South India</option>
                                                         <option value="East India">East India</option>
                                                         <option value="West India">West India</option>

			                                             @foreach($states as $data)
			                                             	<option value="{{$data->id}}">{{$data->name}}</option>
			                                             @endforeach                                                         
                                                      </select>
                                                   </td>
                                                   <td>
                                                      <select class="form-control select-city" name="locations[0][city]">
                                                         <option value="">city</option>
                                                      </select>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <button type="button" class="btn btn-info add-location">Add More</button>
                                       </div>
                                    </div>
                                 </div>
                           </div>
                        </div>
                      </div>
                        <div class="col-sm-3">
                           <div class="back margin-top40">
                              <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">Status</label>
                                 <div class="col-sm-8">
                                    <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio" id="customRadio2" name="status" checked="" value="12">
                                       <label for="customRadio2" class="custom-control-label">Approve</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio" id="customRadio1" name="status" value="10" >
                                       <label for="customRadio1" class="custom-control-label">Reject</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-6">
                                    <button type="submit" class="btn btn-block btn-success btn-flat">Save</button>
                                 </div>
                                 <div class="col-sm-6">
                                    <button type="reset" class="btn btn-block btn-secondary btn-flat">Cancel</button>
                                 </div>
                              </div>                              
                           </div>
                           <div class="form-group row">
                              <div class="col-sm-12">&nbsp;</div>
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
   <!-- /.container-fluid -->
</section>
@section('page-js-script')
    <script>
    	var industries={!!@json_encode($industries)!!};
    	var states={!!@json_encode($states)!!};

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

	    	$("#upload-logo").change(function () {
            let $fls = this.files[0];
            var src = URL.createObjectURL(this.files[0])
            var image = new Image();
            //Set the Base64 string return from URL as source.
            image.src = src;                       
            //Validate the File Height and Width.
            image.onload = function () {
            var width=this.width;
            var height=this.height;
            if(width > 199 || width < 199 || (height > 81 || height < 81))
            {
               toastr.error("Image size 199x81 required!");
               return false;
            }else{
               $("#logo-preview").show();
               $("#logo-preview").find('.preview').attr('src',src)
               if (window.FormData) {
                  formdata = new FormData();
                  formdata.append("_token",'{{ csrf_token() }}')
                  //document.getElementById("btn").style.display = "none";
               }
               formdata.append("images[]", $fls);                           
               
               upload(formdata).then((response)=>{
                  response.images.forEach(function(image) {
                    $("#logo-preview").append("<input type='hidden' name='comapnylogo' value='"+image+"'/>"); 
                  });                  
            });
            }      
            };
          })

         $("#upload-slider").change(function () {
            if (window.FormData) {
                 formdata = new FormData();
                 formdata.append("_token",'{{ csrf_token() }}')
             //  document.getElementById("btn").style.display = "none";
            }

            var i = 0, len = this.files.length, img, reader, file;
            $("#slider-preview").show();

              var ercount = 0;
               for ( ; i < len; i++ ) {

               file = this.files[i];
               localStorage.setItem("error", 2);
               let src = URL.createObjectURL(file);
               var image = new Image();
               //Set the Base64 string return from URL as source.
               image.src = src;                       
               //Validate the File Height and Width.
               image.onload = function () {
               var width=this.width;
               var height=this.height;
               if(width > 1216 || width < 1216 || (height > 430 || height < 430))
               {
                  ercount++;
                  showImgError(ercount);
                  localStorage.setItem("error", 1);
               }}      
                  if(localStorage.getItem("error")==2){
                  if (!!file.type.match(/image.*/)) {
                        //showUploadedItem(e.target.result, file.fileName);                  
                  let li=$("<li/>");
                  li.append('<img class="preview" src="'+src+'"/>')
                  li.append('<span class="slider-delete icon-delete"><i class="fas fa-trash"></i></span>');                                     
                  $("#slider-preview").append(li)

                      if (formdata) {
                          formdata.append("images[]", file);
                          localStorage.setItem("error", 2);
                      }
                  }
                  }
               }
               if(formdata) {
                  upload(formdata).then((response)=>{
                     response.images.forEach(function(image) {
                        $("#slider-preview").append("<input type='hidden' name='sliders[]' value='"+image+"'/>"); 
                     });                  
                   }); 
               } 
            })

function showImgError($cnt){
   if($cnt==1)toastr.error("Image size 1216x430 required!");
}

          	async function upload(formdata){
	            return $.ajax({
	               url: baseUrl+"/admin/manufacturer/image/upload",
	               type: "POST",
	               data: formdata,
	               processData: false,
	               contentType: false
	            });
          	}

   			$("form" ).on( "change", ".select-industry", function() {
             	let id=$(this).val();
             	let container=$(this).parents('.select-container');
             	console.log(container);
   	            $.get(baseUrl+"/api/categories/"+id,function(result){
   	           	// Add options
   	           	$(container).find(".select-sector").html('<option value="">Select Sector</option>');
   					result.forEach(function (item, index) {
   					$(container).find(".select-sector").append('<option value="' + item.id + '">' + item.name + '</option>');
   					});
   	         });
   			});


          	$("form" ).on( "change", ".select-state", function() {
               hidefromothers($(this));	
          		let id=$(this).val();
               let container=$(this).parents('.select-container');
               const sarr = ["Pan India", "North India", "South India", "East India","West India"];
               if(sarr.indexOf(this.value) != -1){
                  container.last().find('td:eq(1)').hide()
                  return false;
               }else{
                  if(container.last().find('td:eq(1) select').is(":visible") == false) 
                  {
                        container.last().find('td:eq(1)').show();
                  } 
               }

	            $.get(baseUrl+"/api/cities/"+id,function(result){
	            	// Add options
	            	$(container).find(".select-city").html("<option value=''>Select city</option>");
					   result.forEach(function (item, index) {
						   $(container).find(".select-city").append('<option value=' + item.id + '>' + item.name + '</option>');
					   });
	            });

          	});

         function hidefromothers($obj)
         {
            console.log($obj);
            $slarr = $(".select-state:not(':first') option:selected").map(function() {return $(this).val();}).get();
            $(".select-state:not(':first') option").show()
            $($slarr).each(function(e,v){
               $(".select-state:not(':first') option[value='"+v+"']").hide()
            })
         }   

			function add_catgory_row(){
            let cnt=$('#categorty-table tr').length;
				let industrySelect=$("<select name='categories["+cnt+"][industry]' class='form-control select-industry'><option value=''>Select Industry</option></select>");
				let sectorSelect=$("<select name='categories["+cnt+"][sector]' class='form-control select-sector'><option value=''>Select Sector</option></select>");

				$.each(industries, function (index, value) {
				  $(industrySelect).append($('<option/>', { 
				      value: value.id,
				      text : value.name 
				  }));
				});

				
				let tr=$('<tr class="select-container"/>');
				let td=$('<td/>');
				tr.append($('<td/>').append(industrySelect));
				tr.append($('<td/>').append(sectorSelect));

				tr.append('<td><a class="delete"><i class=" fas fa-trash"></i></a></td>');
				$('#categorty-table').append(tr);
			}

			$(".add-categorty").click(function(){
				add_catgory_row();
			});

			$('#categorty-table').on('click', '.delete', function(){
				$(this).parents('tr').remove();
			});

			function add_location_row(){
            let cnt=$('#location-table tr').length;
				let stateSelect=$("<select name='locations["+cnt+"][state]' class='form-control select-state'><option value=''>Select State</option><option value='Pan India'>Pan India</option><option value='North India'>North India</option><option value='South India'>South India</option><option value='East India'>East India</option><option value='West India'>West India</option></select>");
				let citySelect=$("<select name='locations["+cnt+"][city]' class='form-control select-city'><option value=''>Select City</option></select>");

				$.each(states, function (index, value) {
				  $(stateSelect).append($('<option/>', { 
				      value: value.id,
				      text : value.name 
				  }));
				});

				
				let tr=$('<tr class="select-container"/>');
				let td=$('<td/>');
				tr.append($('<td/>').append(stateSelect));
				tr.append($('<td/>').append(citySelect));

				tr.append('<td><a class="delete"><i class=" fas fa-trash"></i></a></td>');
				$('#location-table').append(tr);
			}

			function matchYoutubeUrl(url) {
			   var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
			   if(url.match(p)){
			      return url.match(p)[1];
			   }
			   return false;
			}

			$(".add-location").click(function(){
				add_location_row();
			});

			$('#location-table').on('click', '.delete', function(){
				$(this).parents('tr').remove();
			});	

			function youtube_parser(url){
			    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
			    var match = url.match(regExp);
			    return (match&&match[7].length==11)? match[7] : false;
			}

      });        
      </script>
    @endsection
@endsection
