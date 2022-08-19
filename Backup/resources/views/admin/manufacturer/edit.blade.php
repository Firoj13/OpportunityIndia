@extends("admin/layouts.master")
@section('content')
@php $langs = config('constants.languages'); 
$business_types = config('constants.business_type'); 
if(Auth::user()->getRole() == 'Data Executive'){
   $readonly = 'readonly=""';  
   $disabled = 'disabled';
}else{
   $readonly = '';  
   $disabled = '';
}
@endphp   

<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">Edit Manufacturer</h1>
         </div>
         <div class="col-sm-6" style="text-align: right;">
            <a href="{{url('admin/manufacturers/history')}}"><button class="btn btn-secondary btn-flat" type="button">View History</button></a>
            <a href="{{url('admin/manufacturers/leads/'.$brand->brand_id)}}"><button class="btn btn-secondary btn-flat" type="button">View leads</button></a>
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
                     <input type="hidden" name="brand_id" value="{{$brand->brand_id}}">                     
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
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Brand Id</label>
                                       <div class="col-sm-8">
                                          <input type="text" class="form-control" value="{{$brand->brand_id}}" readonly="">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Slug</label>
                                       <div class="col-sm-8">
                                          <input type="text" class="form-control" value="{{$brand->profile_name}}" readonly="">
                                       </div>
                                    </div>
                                     <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Type</label>
                                       <div class="col-sm-8">
                                          <select {{$disabled}} class="form-control" name="user_type">
                                             <option value="">Select Type</option>
                                                <option value="buyer" {{isset($brand->user) && $brand->user->user_type == 'buyer' ? 'selected':''}}>Buyer</option>
                                                <option value="seller" {{isset($brand->user) && $brand->user->user_type == 'seller' ? 'selected':''}}>Seller</option>
                                          </select>
                                       </div>
                                    </div>                                  

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
                                                   <option {{isset($brand->primary) && $brand->primary->industry_id==$industry->id?'selected':''}} value="{{$industry->id}}">{{$industry->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       @php 
                                       $sectors =isset($brand->primary)?App\Models\Category::getSectors($brand->primary->industry_id):[] ;
                                       @endphp

                                       <div class="form-group row">
                                          <label for="inputPassword3" class="col-sm-4 col-form-label">Primary Sector</label>
                                          <div class="col-sm-8">
                                             <select class="form-control select-sector" name="sectorId" required>
                                                <option value="">Select Primary Sector</option>
                                                @foreach($sectors as $sector) 
                                                   <option {{$brand->primary->sector_id==$sector->id?'selected':''}} value="{{$sector->id}}">{{$sector->name}}</option>
                                                @endforeach                                                
                                             </select>
                                          </div>
                                       </div>
                                 </div>
                                    <div class="form-group row ">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Look For</label>
                                       <div class="col-sm-8">
                                          <ul class="ds inline">
                                          @foreach($business_types as $type)
                                             <li> <input type="checkbox" name="businessType[]" {{Illuminate\Support\Str::contains($brand->business_type,$type)?'checked':''}} value="{{$type}}" > {{$type}}</li>
                                          @endforeach
                                          </ul>
                                       </div>
                                    </div>


                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Name</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="name" class="form-control" value="{{ old('name', isset($brand->user) ? $brand->user->name : '') }}"  placeholder="Name" required {{ $readonly }}>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Phone</label>
                                       <div class="col-sm-2">
                                          <select class="form-control" {{ $disabled }}>
                                             <option>+91</option>
                                          </select>
                                       </div>
                                       <div class="col-sm-6">
                                          <input type="text" name="phone" class="form-control" value="{{ old('phone', isset($brand->user) ? $brand->user->mobile : '')}}"  placeholder="Phone" maxlength="10" minlength="10" required {{ $readonly }}>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Email</label>
                                       <div class="col-sm-8">
                                          <input type="email" name="userEmail" class="form-control"  value="{{ old('userEmail', isset($brand->user) ? $brand->user->email : '') }}" placeholder="Email" required {{ $readonly }}>
                                       </div>
                                    </div>
                                    <div class="select-container">
                                       <div class="form-group row">
                                          <label for="inputPassword3" class="col-sm-4 col-form-label">State</label>
                                          <div class="col-sm-8">
                                             <select class="form-control select-state" name="stateId" required >
                                                <option value="">Select State</option>                      @foreach($states as $data)
                                                   <option {{$brand->comp_state==$data->id?'selected':''}} value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group row">
                                          <label for="inputPassword3" class="col-sm-4 col-form-label">City</label>
                                          <div class="col-sm-8">
                                             <select class="form-control select-city" name="cityId" required>
                                                <option value="">Select City</option>
                                                @if($brand->state)
                                                @foreach($brand->state->cities as $city)
                                                   <option {{$brand->comp_city==$city->id?'selected':''}} value="{{$city->id}}">{{$city->city_name}}</option>
                                                @endforeach                        
                                                @endif                        
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
                                                         <input type="text" name="companyName[{{$key}}]" class="form-control"  placeholder="Company Name (in {{$lang}})" value="{{isset($brand->languages[$key])?$brand->languages[$key]->company_name:''}}"  required>
                                                      </div>
                                                   </div>

                                                   <div class="form-group row">
                                                      <div class="col-sm-12">
                                                         <input type="text" name="brandName[{{$key}}]" class="form-control"  placeholder="Brand Name (in {{$lang}})" value="{{isset($brand->languages[$key])?$brand->languages[$key]->brand_name:''}}" required>
                                                      </div>
                                                   </div>
                                                   <div class="form-group row">
                                                      <div class="col-sm-12">
                                                         <textarea class="form-control" name="description[{{$key}}]" rows="3" placeholder="Description (in {{$lang}}) ..." required>{{isset($brand->languages[$key])?$brand->languages[$key]->comp_desc:''}}</textarea>
                                                      </div>
                                                   </div>                                                   
                                                   <div class="form-group row">                          
                                                      <div class="col-sm-12">
                                                         <textarea class="form-control" name="companyDetails[{{$key}}]" rows="3" placeholder="Company detail (in {{$lang}})...">{{isset($brand->languages[$key])?$brand->languages[$key]->comp_detail:''}}</textarea>
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
                                          <input type="email" name="secondaryEmail" class="form-control" value="{{$brand->alt_email}}" placeholder="Email">
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
                                          <input type="text" name="secondaryMobile" class="form-control" value="{{old('secondaryMobile',$brand->alt_mobileno)}}" placeholder="Phone" maxlength="10">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Address</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="address" class="form-control" value="{{old('address',$brand->comp_address)}}" placeholder="Address" required>
                                       </div>
                                    </div>                                    
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Website</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="website" class="form-control" value="{{old('website',$brand->comp_website)}}" placeholder="Website">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">GST No.</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="gstNumber" class="form-control" value="{{old('gstNumber',$brand->gst_no)}}" placeholder="GST No." maxlength="15">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Exclusive Territorial Rights given to the Distributor</label>
                                       <div class="col-sm-8">
                                          <ul class="ds inline">
                                             <li><input type="radio" name="exclusiveTerritorial" {{$brand->distributor_terr_rights?'checked':''}} value="1"> Yes</li>
                                             <li><input type="radio" {{!$brand->distributor_terr_rights?'checked':''}} name="exclusiveTerritorial" value="0"> No
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Margin or Commission percentage</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="marginCommission" class="form-control" value="{{old('marginCommission',$brand->margin_commission)}}" placeholder="" maxlength="10">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Financial Aid provoided</label>
                                       <div class="col-sm-8">
                                          <ul class="ds inline">
                                             <li><input type="radio" name="financeAid" checked value="1"> Yes</li>
                                             <li><input type="radio" name="financeAid" value="0"> No</li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Property Type</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="propertyType" class="form-control" value="{{old('propertyType',$brand->property_type)}}" placeholder="">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Preferred Property Loction</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="prefPropLocation" class="form-control" value="" placeholder="Preferred Property" value="{{old('prefPropLocation',$brand->pref_prop_location)}}">
                                       </div>
                                    </div>                                    
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Payback Period</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="paybackPeriod" class="form-control" placeholder="" value="{{old('paybackPeriod',$brand->payback_period)}}">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Other Investment Request</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="investmentReq" class="form-control" placeholder="Other Investment Request" value="{{old('investmentReq',$brand->other_investment_req)}}">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Anticipated ROI?</label>
                                       <div class="col-sm-8">
                                          <input type="text" name="anticipatedRoi" class="form-control" placeholder="Anticipated ROI?" value="{{old('anticipatedRoi',$brand->anticipated_roi)}}">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-4 col-form-label">Investment Range</label>
                                       <div class="col-sm-4">
                                           <input type="tel" name="investment[min]" class="form-control" placeholder="Min" value="{{$brand->min_investment}}" required="" minlength="3">
                                       </div>
                                       <div class="col-sm-4">
                                           <input type="tel" name="investment[max]" class="form-control" placeholder="Max" value="{{$brand->max_investment}}" required="" minlength="3">
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Company Logo </label>
                                       <div class="col-sm-8">
                                          <div class="form-group">
                                          <!-- <label for="customFile">Custom File</label> -->
                                            <div class ="logo-image {{empty($brand->comp_logo)?'dnone':''}}" style="margin-bottom: 10px" id="logo-preview">
                                              <img class="preview" src="{{env('S3_BUCKET_URL','').'brands/logo/'.trim($brand->comp_logo,'/')}}"/>
											  <span class="logo-delete icon-delete" data-id="{{$brand->brand_id}}"><i class="fas fa-trash"></i></span>
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
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">HomePage Banner</label>
                                       <div class="col-sm-8">
                                          <div class="form-group ">
                                          <!-- <label for="customFile">Custom File</label> -->
                                            <div class ="home-banner {{empty($brand->banner)?'dnone':''}}" style="margin-bottom: 10px" id="banner-preview">
                                              <img class="preview" src="{{$brand->banner?env('S3_BUCKET_URL','').'brands/banners/'.trim($brand->banner->media_url,'/'):''}}"/>
											  <span class="banner-delete icon-delete" data-id="{{$brand->banner?$brand->banner->id:''}}"><i class="fas fa-trash"></i></span>
                                            </div>                                             

                                             <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="upload-banner" accept="image/*">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                             </div>
                                             Note :  * Image Size 589x363
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="inputPassword3" class="col-sm-4 col-form-label">Company Video</label>
                                       <div class="col-sm-8">
                                      <div style="margin-bottom: 10px" class=" {{empty($brand->video)?'dnone':''}} " id="video-preview">
                                        <img width="420" height="315" src="{{$brand->video?$brand->getyoutubethumb($brand->video->media_url):''}}"/>
                                      </div>                                        
                                          <div class="input-group">
                                             <!-- <label for="customFile">Custom File</label> -->
                                           <input id="youtube-url" type="text" class="form-control" name="companyVideo" placeholder="Enter youtube video url" value="{{$brand->video?$brand->video->media_url:''}}" >
                                           <div class="input-group-append">
                                               <div class="input-group-text" title="Upload video"><i class="fab fa-youtube"></i></div>
                                           </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label  class="col-sm-4 col-form-label">Company Sliders</label>
                                       <div class="col-sm-8">
                                          <div class="form-group">
                                            <!-- <label for="customFile">Custom File</label> -->
											  <ul class="sliders" class="{{count($brand->sliders)>0?'':'dnone'}}" id="slider-preview">
												  @foreach($brand->sliders as $slider)
													 <li>
														<img  src="{{env('S3_BUCKET_URL','').'brands/slider/'.trim($slider->media_url,'/')}}"/>
														<span class="slider-delete icon-delete" data-id="{{$slider->id}}"><i class="fas fa-trash"></i></span>
													  </li>							
												  @endforeach
											  </ul>
                                             
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
                                             <input type="text" name="space[min]" class="form-control" placeholder="Min" value="{{$brand->prop_area_min}}">
                                       </div>
                                       <div class="col-sm-3">
                                             <input type="text" name="space[max]" class="form-control" placeholder="Max" value="{{$brand->prop_area_max}}">
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
                                                @if(count($brand->secondry)>0)
                                                @foreach($brand->secondry as $indx=>$item)
                                                <tr class="select-container">
                                                   <td width="50%">
                                                      <input type="hidden" name="categories[{{$indx}}][id]" value="{{$item->id}}">
                                                      <select class="form-control select-industry" name="categories[{{$indx}}][industry]">
                                                         <option value="">Select Industry</option>
                                                         @foreach($industries as $industry) 
                                                            <option {{$item->industry_id==$industry->id?'selected':''}} value="{{$industry->id}}">{{$industry->name}}</option>
                                                         @endforeach    
                                                      </select>
                                                   </td>
                                                   @php 
                                                   $sectors =App\Models\Category::getSectors($item->industry_id) ;
                                                   @endphp
                                                   <td width="50%">
                                                      <select class="form-control select-sector" name="categories[{{$indx}}][sector]">
                                                         <option value="">Select Sector</option>
                                                         @foreach($sectors as $data)
                                                            <option {{$item->sector_id==$data->id?'selected':''}} value="{{$data->id}}">{{$data->name}}</option>
                                                         @endforeach                                              
                                                      </select>
                                                   </td>
												   <td><a class="delete" data-id="{{$item->id}}"><i class=" fas fa-trash"></i></a></td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr class="select-container">
                                                  <td width="50%">
                                                      <select class="form-control select-industry" name="categories[0][industry]">
                                                         <option value="">Select Industry</option>
                                                         @foreach($industries as $industry) 
                                                            <option value="{{$industry->id}}">{{$industry->name}}</option>
                                                         @endforeach    
                                                      </select>
                                                   </td>
                                                   <td width="50%">
                                                      <select class="form-control select-sector" name="categories[0][sector]">
                                                         <option value="">Select Sector</option>
                                                      </select>
                                                   </td>                      
                                                </tr>
                                                @endif
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
                                                @if(count($brand->locations)>0)
                                                @foreach($brand->locations as $indx=>$location)
                                                <tr class="select-container">
                                                   <td width="50%">
                                                      <input type="hidden" value="{{$location->id}}" name="locations[{{$indx}}][id]">
                                                      <select class="form-control select-state" name="locations[{{$indx}}][state]">
                                                         <option value="">Select State</option>
                                                         <option {{$location->state_id=='Pan India'?'selected':''}} value="Pan India">Pan India</option>
                                                         <option {{$location->state_id=='North India'?'selected':''}} value="North India">North India</option>
                                                         <option {{$location->state_id=='South India'?'selected':''}} value="South India">South India</option>
                                                         <option {{$location->state_id=='East India'?'selected':''}} value="East India">East India</option>
                                                         <option {{$location->state_id=='West India'?'selected':''}} value="West India">West India</option>
                                                         @foreach($states as $data)
                                                            <option {{$location->state_id==$data->id?'selected':''}} value="{{$data->id}}">{{$data->name}}</option>
                                                         @endforeach
                                                      </select>
                                                   </td>
                                                   <td width="50%">
                                                      <select class="form-control select-city" name="locations[{{$indx}}][city]">
                                                         <option value="">Select City</option>
                                                         @if($location->state)
														 @foreach($location->state->cities as $data)
                                                            <option {{$location->city_id==$data->id?'selected':''}} value="{{$data->id}}">{{$data->city_name}}</option>
                                                         @endforeach
														 @endif
                                                      </select>
                                                   </td>
												   <td><a class="delete" data-id="{{$location->id}}"><i class=" fas fa-trash"></i></a></td>
                                                </tr>
												@if($indx>20)
													@break
												@endif
                                                @endforeach
                                                @else
                                                <tr class="select-container">
                                                  <td width="50%">
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
                                                   <td width="50%">
                                                      <select class="form-control select-sector" name="locations[0][city]">
                                                         <option value="">Select City</option>
                                                      </select>
                                                   </td>                      
                                                </tr>
                                                @endif                                                
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
                                       <input class="custom-control-input" type="radio" id="customRadio2" name="status"  value="12" {{$brand->profile_status==12?'checked':''}} >
                                       <label for="customRadio2" class="custom-control-label">Approve</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio" id="customRadio1" name="status" value="9" {{($brand->profile_status==9 || $brand->profile_status==8)?'checked':''}}>
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
		 const MAX_SLIDER=5; 	
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
                  toastr.error("Image dimension 199x81 required!");
                  return false;
               }else{

                  $("#logo-preview").show();
                  //var src = URL.createObjectURL(this.files[0])
                  $("#logo-preview").find('.preview').attr('src',src)
                  if (window.FormData) {
                     formdata = new FormData();
                     formdata.append("_token",'{{ csrf_token() }}')
                     //document.getElementById("btn").style.display = "none";
                  }
                  formdata.append("images[]", $fls);              
                  upload(formdata).then((response)=>{
                     console.log(response.images);
                     response.images.forEach(function(image) {
                       $("#logo-preview").append("<input type='hidden' name='comapnylogo' value='"+image+"'/>"); 
                     });                  
                  });
               }   
            }
          })

         $("#upload-banner").change(function () {
            let $fls = this.files[0];
            var src = URL.createObjectURL(this.files[0])
            var image = new Image();
            //Set the Base64 string return from URL as source.
            image.src = src;                       
            //Validate the File Height and Width.
            image.onload = function () {
               var width=this.width;
               var height=this.height;
               if(width > 589 || width < 589 || (height > 363 || height < 363))
               {
                  toastr.error("Image dimension 589x363 required!");
                  return false;
               }else{

                  $("#banner-preview").show();
                  $("#banner-preview").find('.preview').attr('src',src)
                  if (window.FormData) {
                     formdata = new FormData();
                     formdata.append("_token",'{{ csrf_token() }}')
                     //document.getElementById("btn").style.display = "none";
                  }
                  formdata.append("images[]", $fls);              
                  upload(formdata).then((response)=>{
                     response.images.forEach(function(image) {
                       $("#banner-preview").append("<input type='hidden' name='banner' value='"+image+"'/>"); 
                     });                  
                  });
               }   
            }   
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

            async function upload(formdata){alert('helllo');
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
                  $.get(baseUrl+"/api/categories/"+id,function(result){
                  // Add options
                  $(container).find(".select-sector").html('<option value="">Select Sector</option>');
                  result.forEach(function (item, index) {
                  $(container).find(".select-sector").append('<option value="' + item.id + '">' + item.name + '</option>');
                  });
               });
            });


            $("form" ).on( "change", ".select-state", function() { 
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
			let id=$(this).attr('data-id');
			$.get(baseUrl+"/admin/manufacturers/delete/category/"+id);
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
			let id=$(this).attr('data-id');
			$.get(baseUrl+"/admin/manufacturers/delete/location/"+id);
         });  

		$('body').on('click', '.slider-delete', function(){
            let id=$(this).attr('data-id');
			$(this).parents('li').remove()
			if (id>0) {
				$.post(baseUrl+"/admin/manufacturers/delete/media",{id:id,_token:'{{ csrf_token() }}'});
			}
         });

		$('body').on('click', '.banner-delete', function(){
            let id=$(this).attr('data-id');
			$(this).parents('.home-banner').hide()
			if (id>0) {
				$.post(baseUrl+"/admin/manufacturers/delete/media",{id:id,_token:'{{ csrf_token() }}'});
			}
         });		 
		
		$('body').on('click', '.logo-delete', function(){
            let brandId=$(this).attr('data-id');
			$(this).parents('.logo-image').hide()
			if (brandId>0) {
				$.post(baseUrl+"/admin/manufacturers/delete/logo",{brandId:brandId,_token:'{{ csrf_token() }}'});
			}
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
