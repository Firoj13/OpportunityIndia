<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class HomeController extends Controller
{

    private function status($code=200,$error=false,$message=""){
        return array(
          'code'=>$code,
          'error'=>$error,
          'message'=>$message
        );
    }
	
	function index(){
		return response()->json($this->status(),401);	
	}

	/*
	* Get Home API	
	*/
     function get(){
		 //sleep(10);
		$S3BucketPath=env('S3_BUCKET_URL','https://img.franchiseindia.com/');
		//Get banner weight from config
		$weight_config= config('constants.weightage');
		//print_r($weight_config);
		$bannerWeight=[$weight_config['homepage_banner_paid'], $weight_config['homepage_banner_proxy']]; 
		$premiumWeight=[$weight_config['homepage_premium_paid'],$weight_config['homepage_premium_proxy']];
		$superWeight=[$weight_config['homepage_super_paid'],$weight_config['homepage_super_proxy']];
		$featuredWeight=[$weight_config['homepage_featured_paid'],$weight_config['homepage_featured_proxy']];
		
		$response=array();

        $banners = Brand::selectRaw('DISTINCT brands.brand_id as brandId,brands.company_name as brandName,brands.profile_name as slug,brands.comp_logo as logo,brands.prop_area_min as space, brand_media.media_url as image,C.category_name as industry,S.category_name as sector,C.category_id as industryId,S.category_id as sectorId,payback_period as paybackPeriod,anticipated_roi as anticipatedRoi')
			->join('brand_media', function($join){
				$join->on('brands.brand_id','=','brand_media.brand_id'); // Join the users table with either of these columns
				$join->where('media_type','=','2');
				$join->where('media_subtype','=','2');
				$join->limit(1);
			})
			->Join('brand_categories AS BC',function($join){
				$join->on('brands.brand_id', '=', 'BC.brand_id');
				$join->where('BC.mapping_type', '=', '1');
			})
			->Join('categories AS C', 'C.category_id', '=', 'BC.industry_id')
			->Join('categories AS S', 'S.category_id', '=', 'BC.sector_id')
			->whereIn('weightage',$bannerWeight)			
			->whereIn('profile_status', ['12', '11'])
			->limit(4)
			->orderBy('weightage', 'asc')
			->get()
			->toArray();
 		foreach($banners as $k=>$item){
			$locations = $this->getBrandLocations($item['brandId'])->pluck('stateName')->toArray();
			$banners[$k]['image']=$S3BucketPath.'brands/banners/'.trim($item['image'],'/');
			$banners[$k]['locations']=$locations;
		}


        $premium = Brand::select('brands.brand_id as brandId','brands.company_name as brandName','brands.profile_name as slug','brands.comp_logo as logo','brands.max_investment', 'brands.min_investment','brands.prop_area_min as space','payback_period as paybackPeriod','anticipated_roi as anticipatedRoi','C.category_name as industry','C.category_slug as industrySlug','S.category_name as sector','C.category_id as industryId','S.category_id as sectorId','payback_period as paybackPeriod')
			->Join('brand_categories AS BC',function($join){
				$join->on('brands.brand_id', '=', 'BC.brand_id');
				$join->where('BC.mapping_type', '=', '1');
			})
			->Join('categories AS C', 'C.category_id', '=', 'BC.industry_id')
			->Join('categories AS S', 'S.category_id', '=', 'BC.sector_id')
			->whereIn('weightage',$premiumWeight)
			->whereIn('profile_status', ['12', '11'])
			->limit(4)
			->orderBy('weightage', 'desc')			
			->get()
			->toArray();
 		foreach($premium as $k=>$item){
			$locations = $this->getBrandLocations($item['brandId'])->pluck('stateName')->toArray();
			//$locations = ['Delhi','Faridabad','Gurgoan','Mumbai','Rewari'];
			$premium[$k]['locations']=$locations;
		}


		$super = Brand::select('brands.brand_id as brandId','brands.company_name as brandName','brands.profile_name as slug','brands.comp_logo as logo','brands.max_investment', 'brands.min_investment','brands.prop_area_min as space','C.category_name as industry','C.category_slug as industrySlug','S.category_name as sector','C.category_id as industryId','S.category_id as sectorId','payback_period as paybackPeriod','anticipated_roi as anticipatedRoi')
			->Join('brand_categories AS BC',function($join){
				$join->on('brands.brand_id', '=', 'BC.brand_id');
				$join->where('BC.mapping_type', '=', '1');
			})
			->Join('categories AS C', 'C.category_id', '=', 'BC.industry_id')
			->Join('categories AS S', 'S.category_id', '=', 'BC.sector_id')
			->whereIn('weightage',$superWeight)
			->whereIn('profile_status', ['12', '11'])
		    ->limit(8)
			->orderBy('weightage', 'desc')
			->get()
			->toArray();
		foreach($super as $k=>$item){
			$locations = $this->getBrandLocations($item['brandId'])->pluck('stateName')->toArray();
			//$locations = ['Delhi','Faridabad','Gurgoan','Mumbai','Rewari'];
			$super[$k]['locations']=$locations;
		}


		$featured = Brand::select('brands.brand_id as brandId','brands.company_name  as brandName','brands.profile_name as slug','brands.comp_logo as logo','brands.max_investment', 'brands.min_investment','brands.prop_area_min as space','C.category_name as industry','C.category_slug as industrySlug','S.category_name as sector','C.category_id as industryId','S.category_id as sectorId','payback_period as paybackPeriod','anticipated_roi as anticipatedRoi')
			->Join('brand_categories AS BC',function($join){
				$join->on('brands.brand_id', '=', 'BC.brand_id');
				$join->where('BC.mapping_type', '=', '1');
			})
			->Join('categories AS C', 'C.category_id', '=', 'BC.industry_id')
			->Join('categories AS S', 'S.category_id', '=', 'BC.sector_id')
			->whereIn('weightage',$featuredWeight)
			->whereIn('profile_status', ['12', '11'])
		    ->limit(30)
			->orderBy('weightage', 'desc')
			->get()
			->toArray();
 		foreach($featured as $k=>$item){
			$locations = $this->getBrandLocations($item['brandId'])->pluck('stateName')->toArray();
			//$locations = ['Delhi','Faridabad','Gurgoan','Mumbai','Rewari'];
			$featured[$k]['locations']=$locations;
		}
		
		//Testimonials
		$testimonials=DB::table('testimonial')
		 ->select(DB::raw('company_name as company,description as summary,image_url as image'))
		 ->limit(10)
		 ->get()		 
		 ->toArray();

		//Events 
		$events=DB::table('events')
		 ->select(DB::raw("title eventName,DATE_FORMAT(start_date,'%d %M %Y') eventDate,end_date,media_url eventImage,redirection_url eventUrl"))
		 ->whereRaw("start_date>now()")
		 ->orderByRaw("start_date ASC")
		 ->limit(10)
		 ->get()		 
		 ->toArray();		
		
        $response['banners']=$banners;		
        $response['premium']=$premium;
        $response['super']=$super;
		$response['featured']=$featured;
		$response['testimonials']=$testimonials;
		$response['events']=$events;
        return response()->json($response);
	}


	/*
	* Testimonials	
	*/
	function testimonials(Request $request){

		$offset=($request->offset)?$request->offset:0;
		$limit=($request->limit && $request->limit<=50)?$request->limit:10;

		$Query=DB::table('testimonial')->select(DB::raw('company_name as company,description as summary,image_url as image'));
		//Limit records
		if($request->has('offset')){
			$Query->offset($offset)->limit($limit);
		}else{
			$Query->offset(0)->limit($limit);
		}
		$testimonials=$Query->get()->toArray();
		return response()->json(array_merge($this->status(),['testimonials'=>$testimonials]));
	}

	/*
	* Footer 	
	*/
	function getFooter(){
		 $parents = Category::select(DB::raw("category_id as id, category_name as name, category_slug as slug, category_icon as icon, IF(CR.parent_id IS NOT NULL, CR.parent_id, '0') as parentId"))
		->leftJoin('category_relation as CR', function($join){
			$join->on('CR.child_id', '=', 'category_id');
			$join->on('CR.relation_type','=',DB::raw("'1'"));
		})
		->where('status',1)
		->whereRaw('CR.parent_id IS NULL');
		$parents->orderByRaw("category_id ASC");	
        $parents=$parents->get()->toArray();
		//print_r($parents);
		$items=[];
		foreach($parents as $parent){
			 $childs = Category::select(DB::raw("category_id as id, category_name as name, category_slug as slug, category_icon as icon, IF(CR.parent_id IS NOT NULL, CR.parent_id, '0') as parentId"))
			->leftJoin('category_relation as CR', function($join){
				$join->on('CR.child_id', '=', 'category_id');
				$join->on('CR.relation_type','=',DB::raw("'1'"));
			})
			->where('status',1)
			->where('parent_id',$parent['id']);
			$childs->orderByRaw("category_id ASC");	
			$childs=$childs->get()->toArray();
			$items[(int)$parent['id']]=$childs;
			array_unshift($items[$parent['id']],$parent);
		}
		$categories=[];
		foreach($items as $item){
		  if(count($item)>1){
		    $categories[]=$item;
		  }
		}
		$locations = DB::table('special_package as SP')
		 ->select(DB::raw('SP.name as title,SP.slug'))
		 ->where('SP.status',1)
		 ->where('SP.type',1)
		 ->limit(30)
		 ->get()
		 ->toArray();

        return response()->json(["categories"=>$categories,"locations"=>$locations]);
	}
	

	private function getBrandLocations($brand_id){
	 return DB::table('brand_locations')
		 ->select('states.name as stateName','states.region')
		 ->join('states', 'states.id', '=', 'brand_locations.state_id')			
		 ->where('brand_id',$brand_id);
	}
}
