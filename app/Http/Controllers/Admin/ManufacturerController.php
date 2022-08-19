<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Brand; 
use App\Models\Product;    
use App\Models\Category;
use App\Models\BrandLocation;
use App\Models\BrandCategory;
use App\Models\BrandLanguage;
use App\Models\BrandMembership;
use App\Models\MembershipPlan;
use App\Models\Membership;
use App\Models\User;
use App\Models\Otp;
use App\Models\Media;
use Validator;
use Redirect;
use Venturecraft\Revisionable\Revision;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Carbon\Carbon;

class ManufacturerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('manage-manufactures')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view leads");
        }

        $brands=Brand::select('brand_id','user_id','company_name','profile_name','profile_status','weightage','created_at')->orderByRaw("created_at DESC");
        
        if($request->has('search')){
            $brands->whereRaw("brand_id = '".$request->search."' OR company_name LIKE '%".$request->search."%' OR profile_name LIKE '%".$request->search."%'");           
        }   

        $brands=$brands->paginate(20);
        //print_r($brands);

        return view('admin.manufacturer.index',compact('brands'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function approval(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('approve-manufactures')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view leads");
        }

        $brands=Brand::select('brand_id','company_name','profile_name','profile_status','created_at')
        ->orderByRaw("created_at DESC");
        
        if($request->search){
            $brands->whereRaw("(brand_id = '".$request->search."' OR company_name LIKE '%".$request->search."%')");
        }

        if(!empty($request->status)){
            $brands->whereRaw("profile_status = '".$request->status."'");
        }else{
             $brands->whereRaw("profile_status IN (10,11)");
        }

        $brands=$brands->paginate(20);
        return view('admin.manufacturer.approval',compact('brands'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function leads(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('manufacturer-leads')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view leads");
        }

        $brands=DB::table('brands')
        ->selectRaw("brand_id,company_name, count(*) AS total,sum(case when lead_type = 'general' then 1 else 0 end) AS general,
            sum(case when lead_type = 'direct' then 1 else 0 end) AS direct")
        ->leftjoin('leads_supplier as LS', 'LS.supplier_id', '=', 'brands.brand_id')
        ->join('leads as L', 'L.lead_id', '=', 'LS.lead_id')
        ->groupBy('brand_id')
        ->groupBy('lead_type');
        
        if(!empty($request->search)){
            $brands->whereRaw("brand_id ='".$request->search."' OR company_name LIKE '%".$request->search."%'");
        }

        $brands=$brands->paginate(20);
        return view('admin.manufacturer.leads',compact('brands'));
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function leads_detail(Request $request,$brandId){
        if(!Auth::user()->hasPermissionTo('manufacturer-leads')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view leads");
        }

        $brands=DB::table('brands')
        ->selectRaw("brand_id, company_name, L.created_at, count(L.lead_id) AS total,
            sum(case when L.created_at = NOW() AND  lead_type = 'general' then 1 else 0 end) AS today_general,
            sum(case when  WEEK(L.created_at) = WEEK(NOW()) AND lead_type = 'general'then 1 else 0 end) AS week_general,
            sum(case when  L.created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()  AND  lead_type = 'general' then 1 else 0 end) AS month_general,
            sum(case when L.created_at = NOW() AND lead_type = 'direct' then 1 else 0 end) AS today_direct,
            sum(case when  WEEK(L.created_at) = WEEK(NOW()) AND lead_type = 'direct' then 1 else 0 end) AS week_direct,
            sum(case when  L.created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() AND lead_type = 'direct' then 1 else 0 end) AS month_direct,            
            sum(case when lead_type = 'general' then 1 else 0 end) AS general,
            sum(case when lead_type = 'direct' then 1 else 0 end) AS direct")
        ->leftjoin('leads_supplier as LS', 'LS.supplier_id', '=', 'brands.brand_id')
        ->leftjoin('leads as L', 'L.lead_id', '=', 'LS.lead_id')
        ->groupBy('brand_id')
        ->groupBy('lead_type')
        ->whereRaw("brand_id ='".$brandId."'")
        ->first();

        return view('admin.manufacturer.leaddetail',compact('brands'));

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function history(Request $request){
        if(!Auth::user()->hasPermissionTo('manufacturer-history')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view leads");
        }
        $revisions = Revision::with('revisionable')
        ->where('revisionable_type','App\Models\Brand')
        ->orderByRaw("updated_at DESC"); 

        if(!empty($request->date)){       
            $date=date('Y-m-d',strtotime($request->date));
            $revisions->whereRaw("DATE(revisions.created_at) = '".$date."'");
        } 

        if(!empty($request->id)){       
            $revisions->whereRaw("revisions.revisionable_id = '".$request->id."'");
        } 

        $revisions =$revisions->paginate(20);
        return view('admin.manufacturer.history',compact('revisions'));        
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function payments(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('payments')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view payments");
        }
        $packages=Membership::get();
       
        $brands=Brand::selectraw('brands.brand_id,company_name,M.title packageTitle,M.type packageType,BM.expiry_date')
        ->whereRaw('brands.weightage<899')
        ->Join('brand_memberships as BM', function($join){
            $join->on('BM.brand_id', '=', 'brands.brand_id');
            $join->on('BM.activation_date','<',DB::raw("Now()"));
        })
        ->leftjoin('membership_plans as MP', 'MP.plan_id', '=', 'BM.plan_id')
        ->leftjoin('memberships as M', 'M.id', '=', 'MP.parent_id')
        ->orderByRaw('BM.created_at DESC');

        if($request->brandId>0){
            $brands->where('brands.brand_id',$request->brandId);
        }
        if($request->package>0){
            $brands->where('M.id',$request->package);
        }

        if(!empty($request->endDate)){
            $brands->where('expiry_date',$request->endDate);
        }

        $brands=$brands->paginate(20);
        return view('admin.manufacturer.payments',compact('brands','packages'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function payment(Request $request,$brandId)
    {

        $brand=Brand::select('brand_id','company_name')->where('brand_id',$brandId)->first();

        $packages=BrandMembership::where('brand_id',$brandId)
        ->get();

        $plans=Membership::get();

        return view('admin.manufacturer.payment',compact('plans','brand','packages'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function store_payment(Request $request)
    {

        $selectedPlan=MembershipPlan::where('parent_id',$request->packageId)->where('title',$request->packageTerm)
        ->first();
        if(!$selectedPlan){
            return back()->with("warning", "Select a valid package")->withInput();
        }

        // Check if package already for same duration
        $packages=BrandMembership::where('brand_id',$request->brandId)
        ->get();
        $activationDate=date('Y-m-d', strtotime($request->activationDate));

        foreach ($packages as $key => $package) {      
            //Check for activation date overlap           
            if($activationDate>=$package->activation_date && $activationDate<=$package->expiry_date){
                return back()->with("warning", "Already have active package for selected date")->withInput();      
                break;
            }                
        }
        
        //print_r($selectedPlan);
        $expiryDate=date('Y-m-d', strtotime($activationDate. ' + '.$selectedPlan->term.' days'));

        $brandMembership = new BrandMembership;
        $brandMembership->brand_id=$request->brandId;
        $brandMembership->activation_date=$activationDate;
        $brandMembership->plan_id=$selectedPlan->plan_id;
        $brandMembership->expiry_date=$expiryDate;
        $brandMembership->save();

        //Update brand weitage if package starts from today
        //echo $brandMembership->activation_date."==".date('Y-m-d');
        //die;
        if($brandMembership->activation_date<=date('Y-m-d')){
            $brand=Brand::where('brand_id',$brandMembership->brand_id)->first();
            $brand->weightage=$selectedPlan->membership->weightage;
            $brand->save();
        }
        return back()->with("added", "Package added");

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function delete_payment(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('payments')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to delete payments");
        }

        $package=BrandMembership::where('id',$request->id)->whereRaw('CURDATE() BETWEEN activation_date AND     expiry_date')->first();
        if($package){
            Brand::where('brand_id',$package->brand_id)->update(['weightage'=>'899']);
        }

        BrandMembership::where('id',$request->id)->delete();

        echo "done";
        
    }

    public function add($id=0)
    {   
        $brand = new Brand;
        $states=State::get();
        $industries=$this->getIndustries()->get();
        return view('admin.manufacturer.add',compact('industries','brand','states'));
    }

    public function edit($id)
    {   
        $industries=Category::getIndustries();        
        $states=State::get();
        $brand = Brand::firstOrNew(['brand_id'=> $id]);        
       
        $languages=$brand->languages()->get();  

        foreach($languages as $lang){
            $brand->languages[$lang->language]=$lang;
        }
        //print_r($brand->state->cities);
        //die;  
        return view('admin.manufacturer.edit',compact('industries','brand','states'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //sleep('5');
        $validator = Validator::make($request->all(), [
            'companyName.en'=>'required',
            'industryId'=>'required',
            'sectorId'=>'required',
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'description.en'=>'required',
            'businessType'=>'required'
        ]);
        
        $post=$request->all();

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
            //return back()->with("warning", $errors)->withInput();
        }

        $now = Carbon::now();

        //Create User        
        $user = User::firstOrNew(['mobile'=>$request->phone]);
        if($request->user_type)
        {
            $user->user_type=$request->user_type;
        }else{
            $user->user_type="seller";
        }
        $user->mobile=$request->phone;
        $user->email=$request->userEmail;
        $user->name=$request->name;
        $user->password=bcrypt($request->password);
        $user->is_active = 1;
        $user->activated_at = $now->toDateTimeString();
        $user->save();

        $brand = Brand::firstOrNew(['brand_id'=>$request->brand_id]);
        if(empty($request->brand_id)){
            //Create Brand
            $msg="Brand added ";
            $brand->profile_name= Str::slug($request->companyName['en'], '-');
            $brandId=Brand::max('brand_id')+1;
            
            $brand->brand_id = $brandId;
            $brand->user_id = $user->id;
            $brand->activated_at= $now->toDateTimeString();         
        }else{
            //Update Brand
           $msg="Brand updated ";
           $brandId=$request->brand_id;
           $brand->user_id = $user->id;
        }

        //Move logo to S3 from temp
        if(!empty($request->comapnylogo)){
            $uploadPath = 'brands/logo/';
            if(Storage::exists($request->comapnylogo)) {
				$content = Storage::get($request->comapnylogo);
				$content = Image::make($content);
				$content = $content->resize(199,'', function ($constraint) {
					$constraint->aspectRatio();
				})->encode();
					
                Storage::disk('s3')->put($uploadPath.basename($request->comapnylogo), $content, 'public');
                Storage::delete($request->comapnylogo);
                $brand->comp_logo = basename($request->comapnylogo);
            } 
        }

        $brand->company_name= $request->companyName['en']; 
        $brand->brand_name = $request->brandName['en'];      
        $brand->comp_desc= $request->description['en']; 
        $brand->comp_detail = $request->companyDetails['en'];
        $brand->comp_city= $request->cityId;
        $brand->comp_state= $request->stateId;
        $brand->comp_address= $request->address;
        $brand->owner_name= $request->name;
        $brand->owner_email= $request->userEmail;
        $brand->estab_year= $request->establishmentYear;
        $brand->business_type= is_array($request->businessType)?implode(", ",$request->businessType):$request->businessType;                
        
        $brand->no_dealers = $request->dealersDistributor;
        $brand->ph_landline = $request->landLine;
        $brand->alt_email = $request->secondaryEmail;
        $brand->alt_mobileno = $request->secondaryMobile;
        $brand->pref_prop_location = $request->prefPropLocation;
        $brand->comp_website = $request->website;
        $brand->gst_no= $request->gstNumber;
        $brand->distributor_terr_rights = $request->exclusiveTerritorial;
        $brand->margin_commission = $request->marginCommission;
        $brand->is_finance_aid = $request->financeAid;
        $brand->property_type = $request->propertyType;
        $brand->payback_period = $request->paybackPeriod;
        $brand->other_investment_req = $request->investmentReq;
        $brand->anticipated_roi  = $request->anticipatedRoi;
        $brand->min_investment = $request->investment['min'];
        $brand->max_investment = $request->investment['max'];
        $brand->prop_area_min = $request->space['min'];
        $brand->prop_area_max = $request->space['max'];
        $brand->space_req_unit = $request->spaceUnit;
        
        $brand->profile_status=$request->status>0?$request->status:11;
        
        $brand->save();

        $langs = config('constants.languages');        
        foreach($langs as $key=>$lang){
            if(!empty($request->companyName[$key])){
                $brandLanguage=BrandLanguage::firstOrNew(array('brand_id' => $brandId,'language'=>$key));                    
                $brandLanguage->brand_id=$brand->brand_id;
                $brandLanguage->language=$key;
                $brandLanguage->company_name=$request->companyName[$key];
                $brandLanguage->brand_name=$request->brandName[$key];
                $brandLanguage->comp_desc=$request->description[$key];
                $brandLanguage->comp_detail=$request->companyDetails[$key];
                $brandLanguage->save();
                //print_r( $brandLanguage);
            }
        }
		
		//Add Primary Industry and Sector
		if(!empty($request->industryId) && !empty($request->sectorId)){			
			$brands=BrandCategory::updateOrCreate(['brand_id' => $brandId,'mapping_type' => 1],['industry_id' => $request->industryId,'sector_id' => $request->sectorId]);
		}

        if(!empty($request->companyVideo)){
            $media = Media::updateOrCreate(
                ['brand_id' => $brandId, 'media_type' => '1', 'media_subtype' => '3'],
                ['media_url' =>$request->companyVideo]
            );
        }
        //Move Media file to S3 from temparary folder
        if($request->sliders){
            $uploadPath = 'brands/slider/';
            foreach($request->sliders as $slider){
                if(Storage::exists($slider)) {
                    $content = Storage::get($slider);
					$content = Image::make($content);
					$content = $content->resize(1216,'', function ($constraint) {
						$constraint->aspectRatio();
					})->encode();
					
                    Storage::disk('s3')->put($uploadPath.basename($slider), $content, 'public');
                    Storage::delete($slider);
                    Media::create(
                    ['brand_id' => $brandId, 'media_type' => '2', 'media_subtype' => '1','media_url' =>"/".basename($slider)]);
                }
            }
        }
        
		//Move Media file to S3 from temparary folder
        if($request->banner){
			$banner =$request->banner;
            $uploadPath = 'brands/banners/';
			if(Storage::exists($banner)) {
				$content = Storage::get($banner);     
				$content = Image::make($content);
				$content = $content->resize(1216,'', function ($constraint) {
					$constraint->aspectRatio();
				})->encode();

				Storage::disk('s3')->put($uploadPath.basename($banner), $content, 'public');
				Storage::delete($banner);
				$media = Media::updateOrCreate(
					['brand_id' => $brandId, 'media_type' => '2', 'media_subtype' => '2'],
					['media_url' =>"/".basename($banner)]
				);

			}
        }
       //Add/Update categories
       if(!empty($request->categories)){
            $this->addCategories($brandId,$request->categories);
        }

       //Update locations
       if(!empty($request->locations)){
            $this->addLocations($brandId,$request->locations);
        }

       return back()->with("added", $msg);
    }
    
    /*
    * Add/Update Secondry Categories
    */  
    private function addCategories($brandId,$categories){
        #Add product Attbutes
        foreach($categories as $category){
			if(!empty($category['industry']) && empty($category['sector'])){
			   $data=[
				'brand_id' => $brandId,
				'industry_id' => $category['industry'],
				'sector_id' => $category['sector'],
				'mapping_type' => 2
			   ];
				if(!empty($category['id'])){
					BrandCategory::where('id',$category['id'])->update($data);    
				}else{
					BrandCategory::create($data);
				}
			}
        }
    }
    
    /*
    * Add/Update Location
    */  
    private function addLocations($brandId,$locations){
        #Add product location
        foreach($locations as $location){
			if(!empty($location['state'])){
			   $data=[
				'brand_id' => $brandId,
				'state_id' => $location['state'],
				'city_id' => $location['city']
			   ];
				if(!empty($location['id'])){
					BrandLocation::where('id',$location['id'])->update($data);    
				}else{
					BrandLocation::create($data);
				}
			}
		}
    }


	/*TODO delete Category*/
	public function deleteCategory(Request $request){
		BrandCategory::where('id',$request->id)->delete();
		echo "{deleted}";
	}


	/*TODO delete location*/
	public function deleteLocation(Request $request){
		BrandLocation::where('id',$request->id)->delete();
		echo "{deleted}";
	}
	
	public function deleteMedia(Request $request){
		Media::where('id',$request->id)->delete();
		echo "{deleted}";
	}
	
	public function deleteLogo(Request $request){
		Brand::where('brand_id',$request->brandId)->update(['comp_logo'=>'']);
		echo "{done}";
	}
	
	public function orderMedia(Request $request){
		//Media::where('id',$request->id)->delete();
		echo "{done}";
	}

	public function otp(Request $request){
		if($request->brandId>0){
			$brand=Brand::firstWhere('brand_id',$request->brandId);
			$user = $brand->user; 
			if($user){
				$otp_no = mt_rand(100000,999999); 

				$checkotp = Otp::where('mobile', $user->mobile)->first();
				if($checkotp != null){
					Otp::where('otp_id', $checkotp->otp_id)->delete();
				}	
				$otp = new Otp;
				$otp->user_id = $user->id;
				$otp->mobile = $user->mobile;
				$otp->otp = $otp_no;
				$otp->save();
				return response()->json(['mobile'=>$user->mobile,'otp'=>$otp_no]);
			}
			return response()->json(['otp'=>"We are unable to process this request! Please try after some time"]);
		}
		return response()->json(['otp'=>"We are unable to process this request! Please try after some time"]);
	}

    public function status(Request $request){
        if($request->brandId>0){
            $brand=Brand::firstWhere('brand_id',$request->brandId);
            $brand->profile_status=$request->status;
            $brand->save();
        }
        echo "1";
    }
    

    private function getIndustries(){
        $categories = Category::select(DB::raw("category_id as id, category_name as name,DATE_FORMAT(updated_at,'%Y/%m/%d') updatedAt, category_slug as slug, status"))
        ->leftJoin('category_relation as CR', function($join){
            $join->on('CR.child_id', '=', 'category_id');
            $join->on('CR.relation_type','=',DB::raw("'1'"));
        });
        $categories->whereRaw('CR.parent_id IS NULL');
        return $categories->orderByRaw("category_id ASC");  
    }

    private function getsectors($id){
        $categories = Category::select(DB::raw("category_id as id, category_name as name,DATE_FORMAT(updated_at,'%Y/%m/%d') updatedAt, category_slug as slug, status"))
        ->leftJoin('category_relation as CR', function($join){
            $join->on('CR.child_id', '=', 'category_id');
            $join->on('CR.relation_type','=',DB::raw("'1'"));
        })->whereRaw("CR.parent_id ='".$id."'");
        return $categories->orderByRaw("category_id ASC");  
    }

    function fileUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:8048',
        ]);
        //print_r($request->post());
        $baseFolder="temp";
 
        if(empty($baseFolder)){
            die("Base folder is empty...");
        }
        if($validator->fails()){
            //return $this->validation_response($validator);
        }
        $files=$request->file('images');
        $images=[];
        if(count($files)){
            foreach($files as $indx=>$file){
                # Enter logo path
                $ext =  $file->extension();
                if(!empty($file->fileName)){
                    $path = $baseFolder . '/' . $file->fileName . '.' . $ext;
                }else{
                    $path = $baseFolder . '/' . rand() . '.' . $ext;
                }
                //echo $path."\n";
                $content =file_get_contents($file);
                Storage::put($path, $content, 'public');
                $images[]=$path;
            }
        }
        return response()->json(['images'=>$images]);
    }    

}