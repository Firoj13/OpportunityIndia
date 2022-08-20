<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use App\Models\States;
use App\Models\Cities;
use App\Models\BrandCategory;
use App\Models\BrandLocation;
use App\Models\Media;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class BrandController extends Controller
{
	var $S3_BUCKET="";
	var $LOGO_PATH = "brands/logo/";
	var $SLIDER_PATH = "brands/slider";
	var $BANNER_PATH = "brands/banner";

    var $status=array(
        "code"=>200,
        "error"=>false,
        "message"=>"",
    );


    function __construct() {
		$this->S3_BUCKET=config("constants.bucket_url");
    }


    public function welcome(Request $request){
        $this->status['message']="Welcome to homepage";
        return response()->json($this->status);
    }

    private function validation_response($validator){
		$errors=$validator->errors()->messages();
		array_walk_recursive($errors, function ($value, $key) use (&$error){
			$error = $value;
		}, $error);

        return response($this->status(422,true,$error),422);
    }

    private function status($code=200,$error=false,$message=""){
        return array(
          'code'=>$code,
          'error'=>$error,
          'message'=>$message
        );
    }

    public function create(Request $request){
    //sleep('5');
        $validator = Validator::make($request->all(), [
            'brandName'=>'required',
            'industryId'=>'required',
			'sectorId'=>'required',
			'name'=>'required',
            'address'=>'required',
			'mobile'=>'required',
			'description'=>'required',
			'businessType'=>'required'
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }
        $user = User::where('mobile', $request->mobile)->first();
        
       
        if($user!= null){
           if($user->user_type=='buyer'){
             return response($this->status(409,true,"Error: Number already registerd as buyer. Try to register with another number."),409);
           }        
           $user->email=$request->email;
           $user->name=$request->name;
           $user->save();
	  }else{
           $now = Carbon::now();
           $user = new User;
           $user->user_type="seller";
           $user->mobile=$request->mobile;
           $user->email=$request->email;
            $user->name=$request->name;
	    $user->password=bcrypt($request->password);
	    $user->is_active = 1;
            $user->activated_at = $now->toDateTimeString();
            $user->save();
        }

		$brandId=Brand::max('brand_id')+1;
		$slug = Str::slug($request->brandName, '-');
		//$slug=str_slug($request->brandName, "-");
        //Insert new user to database
        $now = Carbon::now();
		$brand = new Brand;
        $brand->user_id = $user->id;
		$brand->brand_id = $brandId;
        $brand->company_name= $request->brandName;
		$brand->profile_name= $slug;
        $brand->comp_city= $request->cityId;
		$brand->comp_state= $request->stateId;
		$brand->comp_address= $request->address;
        $brand->owner_name= $request->name;
		$brand->owner_email= $request->email;
		$brand->weightage= 899;
		$brand->estab_year= $request->establishmentYear;
		$brand->business_type= is_array($request->businessType)?implode(",",$request->businessType):$request->businessType;
		$brand->comp_desc= $request->description;
        $brand->activated_at= $now->toDateTimeString();
		$brand->profile_status=10;
        $brand->save();

		$user = User::select(DB::raw("mobile,is_active,user_type,name,is_verified"))->where('mobile', $request->mobile)->first();

		$user = User::where('mobile', $request->mobile)->first();
		$tokenResult = $user->createToken('Personal Access Token');
		$token = $tokenResult->token;
		if($request->remember_me)
			$token->expires_at = Carbon::now()->addWeeks(1);
		$token->save();
        //print_r($brand);
		//Add primary Industry and sector
        BrandCategory::updateOrCreate(['brand_id' => $brandId,'mapping_type' => 1],['industry_id' => $request->industryId,'sector_id' => $request->sectorId]);

		$user->brandId=	$brand->brand_id;
        return response()->json(array_merge($this->status(),['user'=>$user,'access_token'=>$tokenResult->accessToken]));
    }

	/*
	* Brand data on detail page
	* Brand Id
	*/
    public function index(Request $request,$brand_id){
        $brand =Brand::select(DB::raw("brands.brand_id as brandId,brands.company_name as brandName,brands.profile_name as slug,brands.comp_detail,brands.comp_desc,brands.comp_logo as logo,brands.max_investment investmentMax,brands.min_investment investmentMin,brands.estab_year,brands.margin_commission marginCommission,brands.distributor_terr_rights,anticipated_roi anticipatedRoi,brands.prop_area_min spaceMin,brands.prop_area_max spaceMax,brands.space_req_unit as spaceUnit,other_investment_req investmentReq, property_type as propertyType,payback_period paybackPeriod,IND.category_name as industry,IND.category_slug as industrySlug,IND.category_id as industryId,SEC.category_name as sector,SEC.category_slug as sectorSlug,SEC.category_id as sectorId,SEC.category_image as sectorImage, comp_state as state, comp_city as city"))
		->Join('brand_categories AS BC', 'brands.brand_id', '=', 'BC.brand_id')
		->Join('categories AS IND', 'IND.category_id', '=', 'BC.industry_id')
		->Join('categories AS SEC', 'SEC.category_id', '=', 'BC.sector_id')
		->leftJoin('states AS ST', 'brands.comp_state', '=', 'ST.id')
		->leftJoin('cities AS CI', 'brands.comp_city', '=', 'CI.id')
		->where('brands.brand_id', $brand_id)
        ->get();

        //print_r($brand->toArray());
        if($brand->isEmpty()){
            return response($this->status(404,true,__('Record not found')),404);
        }
        $response=$brand->first()->toArray();


        //Get images data
        $images = DB::table('brand_media')
        ->selectRaw('CONCAT("'.$this->S3_BUCKET.$this->SLIDER_PATH.'",media_url) as url,media_description')
        ->where('brand_id',$brand_id)
		->where('media_type',2)
		->where('media_subtype',1)
        ->get()
        ->toArray();

        #Get products data
        $products = Brand::find($brand_id)->products;
		foreach($products as $i=>$product){
			 $products [$i]->images = $product->images;
			 $products [$i]->attributes = $product->Attributes;	
		}
		
		#Get locations data
		 $locations_data=DB::table('brand_locations')
		 ->select('states.name as stateName','states.region','C.city_name as cityName')
		 ->join('states', 'states.id', '=', 'brand_locations.state_id')
		 ->leftjoin('cities as C', 'C.id', '=', 'brand_locations.city_id')
		 ->where('brand_id',$brand_id)
		 ->get()
		 ->toArray();
		$locations=array();
		#print_r($locations_data);
		#die;
        if(count($locations_data)>0){
			foreach($locations_data as $item){
				$locations[$item->region][$item->stateName][]=$item->cityName;
			}
		}

		#Get canonical
		$canonical=DB::table('mapping_brands')
		->select('row_id','profile_name','brand_id')
		->where('brand_id',$brand_id)
		->get()
		->first();
		
		if($canonical){
			//$response['canonical']="https://www.franchiseindia.com/brands/".$canonical->profile_name.".".$canonical->row_id;
			$response['canonical']="https://dealer.franchiseindia.com/manufacturer/".$canonical->profile_name."-".$canonical->brand_id;
		}

        #Merge data to response
        $response['locations']=$locations;
		$response['images']=$images;
        $response['products']=$products;
        $response['recommended']=$this->recommended($brand_id);
		return response()->json(array_merge($this->status(),['brand'=>$response]));
    }


	/*
	* Recommended
	* @id|int
	*/
	function recommended($brandId){
       $response = Brand::select('brands.brand_id as brandId','brands.company_name as brandName','brands.profile_name as slug','brands.comp_logo as logo','brands.max_investment', 'brands.min_investment','C.category_name as industry','C.category_slug')
		->Join('brand_categories AS BC', 'brands.brand_id', '=', 'BC.brand_id')
		->Join('categories AS C', 'C.category_id', '=', 'BC.industry_id')
		->where('brands.brand_id','!=',$brandId)
		->limit(3)
		->orderByRaw('RAND()')
		->get()
		->toArray();
		return $response;
	}


	/*
    * Get Brand Data on dashboard
    * $user
    */
    function dashboard(Request $request){
        $user=$request->user();

        $brand =Brand::select(DB::raw("brands.brand_id as brandId,brands.company_name companyName,brand_name as brandName,brands.comp_detail description ,alt_email as secondaryEmail,alt_mobileno as secondaryMobile,CONCAT('".$this->S3_BUCKET.$this->LOGO_PATH."',brands.comp_logo) as logo,brands.max_investment as investmentRangemax,brands.min_investment AS investmentRangemin,brands.margin_commission AS marginCommission ,brands.distributor_terr_rights exclusiveTerritorial,brands.prop_area_min AS spacemin,brands.prop_area_max AS spacemax,brands.space_req_unit as spaceunit,IND.category_name as industry,IND.category_slug as industrySlug,SEC.category_name as sector,SEC.category_slug as sectorSlug,SEC.category_image as sectorImage, comp_state as state, comp_city as city,no_dealers as dealersDistributor,ph_landline as landLine,comp_website as website,gst_no as gstNumber,pref_prop_location as prefPropLocation, is_finance_aid as financeAid, property_type as propertyType,payback_period as paybackPeriod, other_investment_req as investmentReq,anticipated_roi as anticipatedRoi"))
            ->Join('brand_categories AS BC', 'brands.brand_id', '=', 'BC.brand_id')
            ->Join('categories AS IND', 'IND.category_id', '=', 'BC.industry_id')
            ->Join('categories AS SEC', 'SEC.category_id', '=', 'BC.sector_id')
            ->leftJoin('states AS ST', 'brands.comp_state', '=', 'ST.id')
            ->leftJoin('cities AS CI', 'brands.comp_city', '=', 'CI.id')
            ->where('brands.user_id', $user->id)
            ->get()
			->first();

        if(empty($brand)){
            return response($this->status(404,true,__('Record not found')),404);
        }

		//print_r($brand);
		$response=$brand->toArray();

		//$logoPath=config('constants.bucket_url')."brands/logo/";
		//$response['logo']=$logoPath.$response['logo'];
		//Get Video Link
        $video = DB::table('brand_media')
            ->select('media_url','media_description')
            ->where('brand_id',$brand->brandId)
            ->where('media_type',1)
            ->where('media_subtype',3)
            ->get()
			->first();
			//print_r($video);
		if(!empty($video->media_url)){
			$response['companyVideo']=$video->media_url;
		}
        //Get images data
		$url=env('S3_BUCKET_URL','').'brands/slider/';
        $images = DB::table('brand_media')
			->selectRaw('CONCAT("'.$this->S3_BUCKET.$this->SLIDER_PATH.'",media_url) as url,id as sliderId,media_description')
            ->where('brand_id',$brand->brandId)
            ->where('media_type',2)
            ->where('media_subtype',1)
            ->get()
            ->toArray();



        #Get locations data
        $locations=DB::table('brand_locations')
            ->select('id','state_id as stateId','city_id as cityId')
            ->where('brand_id',$brand->brandId)
            ->get();
          #print_r($locations);

        #Get secondry categories data
        $categories=DB::table('brand_categories as BC')
            ->select('BC.id','BC.sector_id as sectorId','BC.industry_id as industryId')
            ->join('categories as SEC', 'SEC.category_id', '=', 'BC.sector_id')
			->join('categories as IND', 'IND.category_id', '=', 'BC.industry_id')
            ->where('BC.brand_id',$brand->brandId)
			->where('BC.mapping_type',2)
            ->get()
            ->toArray();

        #Merge data to response
        $response['secondaryIndustrySector']=$categories;
		$response['expansionlocation']=$locations;
        $response['sliderImages']=$images;
        return response()->json(array_merge($this->status(),['brand'=>$response]));
    }

    /*
    * Update Brand Details
    * $user
    */
    function update(Request $request){
        $user=$request->user();
		//print_r($user);
		if(!$user){
			return response($this->status(422,true,"Invalid user"),422);
		}
		$brandId = Brand::where('user_id', $user->id)->first()->brand_id;

        $data = array(
            "brand_name" => $request->brandName,
            "no_dealers" => $request->dealersDistributor,
            "ph_landline" => $request->landLine,
            "alt_email" => $request->secondaryEmail,
            "alt_mobileno" => $request->secondaryMobile,
            "pref_prop_location" => $request->prefPropLocation,
            "comp_website" => $request->website,
            "gst_no" => $request->gstNumber,
            "distributor_terr_rights" => $request->exclusiveTerritorial,
            "margin_commission" => $request->marginCommission,
            "is_finance_aid" => $request->financeAid,
            "property_type" => $request->propertyType,
            "payback_period" => $request->paybackPeriod,
            "other_investment_req" => $request->investmentReq,
            "anticipated_roi"  => $request->anticipatedRoi,
            "min_investment" => $request->investmentRangemin,
            "max_investment" => $request->investmentRangemax,
            "prop_area_min" => $request->spacemin,
            "prop_area_max" => $request->spacemax,
            "space_req_unit" => $request->spaceunit,
            "comp_detail" => $request->description,
			"profile_status"=>11,
        );

        $response = Brand::query()->where('brand_id', $brandId)->update($data);
		if(!empty($request->companyVideo)){
			$media = Media::updateOrCreate(
				['brand_id' => $brandId, 'media_type' => '1', 'media_subtype' => '3'],
				['media_url' =>$request->companyVideo]
			);
		}

		//Update Locations
	   if(!empty($request->expansionlocation)){
		   if(count($request->expansionlocation)>0){
		     foreach($request->expansionlocation as $item){
				if(!empty($item['stateId'])){
				   $data=[
					'brand_id' => $brandId,
					'state_id' => $item['stateId'],
				   ];
				   if(!empty($item['cityId'])){
					   $data['city_id'] = $item['cityId'];
				   }
				   if(!empty($item['id'])){
					BrandLocation::where('id',$item['id'])->update($data);
				   }else{
					BrandLocation::create($data);
				   }
				}
		     }
		   }
	   }
	   //Update Secondry industry
	   if(!empty($request->secondaryIndustrySector)){
		   if(count($request->secondaryIndustrySector)>0){
		     foreach($request->secondaryIndustrySector as $item){
				if(!empty($item['industryId'])){
				   //$mapping_type=$item['mapping_type']?$item['mapping_type']:2;
				   $data=[
					'brand_id' => $brandId,
					'industry_id' => $item['industryId'],
					'sector_id' => $item['sectorId'],
					'mapping_type' => 2
				   ];
				   if(!empty($item['id'])){
					BrandCategory::where('id',$item['id'])->update($data);
				   }else{
					BrandCategory::create($data);
				   }
				}
		     }
		   }
	   }
       return  response()->json(array_merge($this->status(200,false,"Brand updated."),['brand'=>$response]));
    }

	function deleteSecondryIndustry(Request $request){
        $user=$request->user();
		if(!empty($request->id)){
			$brandId = Brand::where('user_id', $user->id)->first()->brand_id;
			BrandCategory::where('id',$request->id)->where('brand_id',$brandId)->delete();
			return  response()->json($this->status(200,false,"Secondry industry deleted."));
		}
    }
	function deleteExpansion(Request $request){
        $user=$request->user();
		if(!empty($request->id)){
			$brandId = Brand::where('user_id', $user->id)->first()->brand_id;
			BrandLocation::where('id',$request->id)->where('brand_id',$brandId)->delete();
			return  response()->json($this->status(200,false,"Expansion location deleted."));
		}
    }
	function deleteSlider(Request $request){
        $user=$request->user();
		if(!empty($request->id)){
			$uploadPath = 'brands/slider/';
			$brandId = Brand::where('user_id', $user->id)->first()->brand_id;
			$existingFile=Media::where('id',$request->id)->get()->first()->media_url;
			if(!empty($existingFile)){
				$path=$uploadPath.basename($existingFile);
				Storage::disk('s3')->delete($path);
			}
			Media::where('id',$request->id)->where('brand_id',$brandId)->delete();
			return  response()->json($this->status(200,false,"Slider image deleted."));
		}
    }

    function uploadLogo(Request $request){

        $user=$request->user();
        $validator = Validator::make($request->all(), [
			'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=199',
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }
		$brandId = Brand::where('user_id', $user->id)->first()->brand_id;
		$uploadPath="brands/logo/";

		$existingFile=Brand::select('comp_logo')->where('brand_id', $brandId)->get()->first()->comp_logo;
		if(!empty($existingFile)){			
			try{
				$filePath=$uploadPath.basename($existingFile);
				//Storage::disk('s3')->delete($filePath);
			}catch(Exception $e){
				//print_r($e); 
			}
		}


		$filePath = $uploadPath.'logo_'.$brandId.'.jpg'; // enter logo path
        //Logo uploading
        if ($request->hasFile('file')) {
			echo "file";
			 $image = $request->file('file');
			 $image_resize = Image::make($image->getRealPath());
			 $image_resize = $image_resize->resize(199,'', function ($constraint) {
				$constraint->aspectRatio();
			 })->encode();
            
			//Storage::put($filePath, $image_resize, 'public');
			
			Storage::disk('s3')->put($filePath, $image_resize,'public');
			$url= Storage::disk('s3')->url($filePath);
        }
        $data = array(
			'comp_logo' => basename($url)
        );
		//print_r($data);

        Brand::query()->where('user_id', $user->id)->update($data);
        return  response()->json(array_merge($this->status(),['image'=>$url]));
    }

    function uploadSlider(Request $request){

        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:8048|dimensions:min_width=199',
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }

        $brandId = Brand::where('user_id', $user->id)->first()->brand_id;
			$sliderCounts=Media::where('brand_id',$brandId)
			->where('media_type',2)
			->where('media_subtype',1)
			->count();
        if($sliderCounts>=5){
			return response($this->status(409,true,"Error: You can upload 5 sliders only."),409);
        } 		
	
		$uploadPath = 'brands/slider/'; // enter logo path
        $filePath=$uploadPath.time().".jpg";
		//Slider Banner uploading
        if ($request->hasFile('file')) {
			$file = $request->file('file');
			$content = Image::make($file->getRealPath());
			 $content = $content->resize(1216,'', function ($constraint) {
				$constraint->aspectRatio();
			 })->encode();
			$content = $content->encode();
			Storage::disk('s3')->put($filePath, $content,'public');
			$url= Storage::disk('s3')->url($filePath);

            $data=[
				'brand_id' => $brandId,
                'media_type' => 2,
                'media_subtype' => 1,
                'media_url' => "/".basename($url),
                'updated_by' => $user->id
			];
			if(!empty($request->sliderId)){
				//Delete existing file from cloud
				$existingFile=Media::where('id',$request->sliderId)->get()->first()->media_url;
				if(!empty($existingFile)){
					$path=$uploadPath.basename($existingFile);
					Storage::disk('s3')->delete($path);
				}
				$response =Media::where('id',$request->sliderId)->update($data);
			}else{
				$response = Media::create($data);
			}
			return  response()->json(array_merge($this->status(),['slideimage'=>$url]));
        }
    }

	function addProduct(Request $request){
		$user=$request->user();
		$validator = Validator::make($request->all(), [
            'products' => 'required',
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }

		$brandId = Brand::where('user_id', $user->id)->first()->brand_id;

		if(!empty($request->products)){
		   if(count($request->products)>0){
		     foreach($request->products as $product){
				if(!empty($product['productName'])){
				   //$mapping_type=$item['mapping_type']?$item['mapping_type']:2;
				   $data=['brand_id'=>$brand->brand_id,'product_name'=>$product['productName'],'product_description'=>$product['productDesc'],'product_status' =>1];
				   if(!empty($item['productId'])){
					 $productId =$item['productId'];
					 Product::where('id',$productId)->update($data);
				   }else{
					 $productId =Product::create($data);
				   }

				   if(!empty($product['productVideo'])){
					  Product::brand_products_media($productId,$product['productVideo'],1);
				   }
				   //Add product Attbutes
				   foreach($attributes as $item){
					if(!empty($item['id'])){
						 Product::where('id',$productId)->update($data);
					}else{
					 $productId =Product::create($data);
					}
				   }

				}
		     }
		   }
	   }
	}

    function brandProduct(Request $request){

        $validator = Validator::make($request->all(), [
            'productName' => 'required|min:3',
            'productDesc'=>'required',
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }

        $user=$request->user();

        $brand = Brand::where('user_id', $user->id)->first();
        $data=['brand_id'=>$brand->brand_id,'product_name'=>$request->productName,'product_description'=>$request->productDesc,'product_status' =>1];

        $productId = Product::create($data)->product_id;
        if($request->productVideo!=''){
            Product::brand_products_media($productId,$request->productVideo,1);
        }

        $attName = $request->attributeName;
        $attValue = $request->attributeValue;
        $attributes = array_combine($attName, $attValue);

        foreach($attributes as $key => $value){

            Product::insertProductAttributes($productId,$key,$value);
        }

        $images = $request->file('productImages');
        foreach ($images as $prodImg){
            $imagePath = ''; // enter logo path
            $url = '';
            $extension =  $prodImg->extension();
            $prodImgPath = sprintf($imagePath, date('md')) . '/' . rand() . '.' . $extension;
            Storage::disk('s3')->put($prodImgPath, file_get_contents($prodImg), 'public');
            $url = Storage::disk('s3')->url($prodImgPath);
            Product::brand_products_media($productId,$url,2);
        }

        return response($this->status(200,false,"Product Inserted."));
    }

	function fileUpload(Request $request){
		$validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
		print_r($request->post());
		#$path="brands/banners";
		$path = $request->path;
		if(empty($path)){
			die("Path is empty...");
		}
        if($validator->fails()){
            return $this->validation_response($validator);
        }

		# Enter logo path
		$ext =  $request->file('file')->extension();
		if(!empty($request->fileName)){
			$path = $path . '/' . $request->fileName . '.' . $ext;
		}else{
			$path = $path . '/' . rand() . '.' . $ext;
		}
		$file = $request->file('file');

		if(!Storage::disk('s3')->exists($path)) {
			//$content = Storage::get($path);
			$content =file_get_contents($file);
			Storage::disk('s3')->put($path, $content, 'public');
			echo $url = Storage::getFacadeRoot()->disk('s3')->url($path);
		}
	}

	function sync_banners(){
		$files = Storage::files("brands/banners/");
		foreach($files as $path){
			if(!Storage::disk('s3')->exists($path) && Storage::exists($path) ) {
				$content = Storage::get($path);			
				Storage::disk('s3')->put($path, $content, 'public');
				echo $url = Storage::getFacadeRoot()->disk('s3')->url($path);			
			}	
		
		}
		echo"********End***********";
	}

	function sync_logos(){
		$files = Storage::files("brands/logo/");
		foreach($files as $path){
			if(!Storage::disk('s3')->exists($path) && Storage::exists($path) ) {
				$content = Storage::get($path);			
				Storage::disk('s3')->put($path, $content, 'public');
				echo $url = Storage::getFacadeRoot()->disk('s3')->url($path);			
			}	
		
		}		
		echo"********End***********";
	}
}
