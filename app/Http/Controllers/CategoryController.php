<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Location;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

	private $order_by='brands.id DESC';

	private $limit=15;

	private $offset=0;
	
	function __construct() {
      
    }
	
	/**
     * Status
     *
     * @param  Request|$request //First Param
     * @since 1.1 //Version
     * @return array $result //Value Returned (use void if doesn't return)
     */
	private function status($code=200,$error=false,$message=""){
        return array(
          'code'=>$code,
          'error'=>$error,
          'message'=>$message
        );
    } 
	
	/*
	Location 
	*/
	
	function locationIndustry(Request $request,$state,$slug){
		$request->state=$state;
		return $this->industry($request,$slug);
	}
	
	/**
	* Industry page
	*/	
	function industry(Request $request,$slug){
		//$slug=$request->route('slug');
		$weight_config= config('brand.weight');
		$category=Category::select(DB::raw("category_id,category_name as title, meta_title as metaTitle, meta_description as metaDescription, meta_keywords as metaKeywords,IF(CR.parent_id IS NOT NULL, CR.parent_id, '0') as parentId"))
			->leftJoin('category_relation as CR', 'CR.child_id','=','category_id')
			->where('category_slug','=',strtolower($slug))->first();
		
		if(!$category){
			return response($this->status(404,true,__('Industry not found')),404);
		}

		$baseQuery=$this->baseQuery();
		//For location on category
		if($request->state){
			$state=State::select('id')->where('slug',$request->state)->first()->toArray();
			$request->state_id=$state['id'];
			//$baseQuery->where('BL.state_id', $state['id']);
		}				
		#Get Industry and sector data
		$industry=[];
		if($category->parentId>0){
			$industry=Category::select(DB::raw("category_name as title, category_slug slug"))->where("category_id",$category->parentId)->first();
			$filterSector=clone $baseQuery;
			$baseQuery->where('BC.sector_id', $category->category_id);
			$filters=$this->filters($baseQuery);

			//Replace the filter query for sector page only to get the child categories
			$filterSector->where('BC.industry_id', $category->parentId);
			$filterSector->where('S.status', 1);
			$filterSector->select(DB::raw('COUNT(brands.brand_id) as total'),'S.category_id as sector_id','S.category_name as name','S.category_slug as slug');
			$filterSector->groupBy('S.category_id');			
			$filterSector->orderByRaw("total DESC");
			$filterSector->limit(10);
			$filters['sectors']=$filterSector->get()->toArray();
			
			$SearchQuery=$this->filterQuery($baseQuery,$request);
			$SearchQuery=$this->sectorQuery($SearchQuery);			
		}else{
			$baseQuery->where('BC.industry_id', $category->category_id);
			$filters=$this->filters($baseQuery);
			$SearchQuery=$this->filterQuery($baseQuery,$request);
			$SearchQuery=$this->industryQuery($SearchQuery);
		}
		$meta=$category;
		$meta->parent=$industry;

		#Get canonical
		$canonical=DB::table('mapping_category')
		//->select('fi_slug','fi_catId','fi_cat_type')
		->select('slug','fi_catId','fi_cat_type')
		->where('slug',$slug)
		->get()
		->first();
		//print_r($canonical);

		if($canonical){
			//$meta->canonical="https://www.franchiseindia.com/business-opportunities/".$canonical->fi_slug.".".$canonical->fi_cat_type.$canonical->fi_catId;
			if(!$request->state){
				$meta->canonical="https://dealer.franchiseindia.com/dir/".$canonical->slug;
			}else{
				$meta->canonical="https://dealer.franchiseindia.com/loc-".$request->state."/".$canonical->slug;
			}
		}
		
		//Get total results
		$QueryTotal=clone $SearchQuery;
		$QueryTotal->getQuery()->selects = null;
		$total=$QueryTotal->select(DB::raw("COUNT(DISTINCT brands.brand_id) total"))->get()->first()->total;

		//Limit records
		if($request->has('offset')){
			$SearchQuery->offset($request->offset)->limit($this->limit);
		}else{
			$SearchQuery->offset(0)->limit($this->limit);
		}

		$SearchQuery->orderByRaw("isPaid DESC ,weightage ASC, isLogo DESC");
		$results=$SearchQuery->get()->toArray();
		foreach($results as $k=>$item){
			$locations = $this->getBrandLocations($item['brandId'])->pluck('stateName')->toArray();
			$results[$k]['locations']=$locations;
			$products = $this->getBrandProducts($item['brandId']);
			$results[$k]['products']=$products;
		}	
		return response()->json(array_merge($this->status(),['meta'=>$meta,'total'=>$total,'results'=>$results,'filters'=>$filters]));
	}

	/*
	* Location page
	*/		
	function location(Request $request){
		$slug=$request->route('slug');
		$meta=DB::table('special_package')->select('name as title')->where('slug',$slug)->get()->first();
		//print_r($meta);
		if(!$meta){
			return response($this->status(404,true,__('Location not found')),404);
		}
		$baseQuery=$this->baseQuery();
		$baseQuery->Join('brand_special_package as BSP', 'BSP.brand_id', '=', 'brands.brand_id');
		$baseQuery->Join('special_package as SP', 'SP.id', '=', 'BSP.location_investment_id');
		$baseQuery->where('SP.slug',$slug);
		$filters=$this->filters($baseQuery);
		
		$SearchQuery=$this->filterQuery($baseQuery,$request);
		$SearchQuery=$this->locationQuery($SearchQuery);

		//Get total results
		$QueryTotal=clone $SearchQuery;
		$QueryTotal->getQuery()->selects = null;
		$total=$QueryTotal->select(DB::raw("COUNT(DISTINCT brands.brand_id) total"))->get()->first()->total;
		
		//Limit records
		if($request->has('offset')){
			$SearchQuery->offset($request->offset)->limit($this->limit);
		}else{
			$SearchQuery->offset(0)->limit($this->limit);
		}
		$SearchQuery->orderByRaw("isPaid DESC ,weightage ASC");
		$results=$SearchQuery->get()->toArray();

		//$meta=['total'=>$total,'heading'=>'Distributorship Opportunities in '.ucwords($meta->name)];
		//$meta->total=$data['total'];

		//$results=$data['results'];
		foreach($results as $k=>$item){
			//print_r($item);
			$locations = $this->getBrandLocations($item['brandId'])->pluck('stateName')->toArray();
			$products = $this->getBrandProducts($item['brandId']);
			$results[$k]['locations']=$locations;
			$results[$k]['products']=$products;
		}	

		return response()->json(array_merge($this->status(),['meta'=>$meta,'total'=>$total,'results'=>$results,'filters'=>$filters]));
	}

	/*
	* Investment page
	*/		
	function investment(Request $request){
		$slug=$request->route('slug');
		$meta=DB::table('special_package')->select('name as title')->where('slug',$slug)->get()->first();
		if(!$meta){
			return response($this->status(404,true,__('Investment not found')),404);
		}
		
		$baseQuery=$this->baseQuery();
		$baseQuery->Join('brand_special_package as BSP', 'BSP.brand_id', '=', 'brands.brand_id');
		$baseQuery->Join('special_package as SP', 'SP.id', '=', 'BSP.location_investment_id');
		$baseQuery->where('SP.slug',$slug);
		$filters=$this->filters($baseQuery);

		$SearchQuery=$this->filterQuery($baseQuery,$request);
		$SearchQuery=$this->locationQuery($SearchQuery);

		//Get total results
		$QueryTotal=clone $SearchQuery;
		$QueryTotal->getQuery()->selects = null;
		$total=$QueryTotal->select(DB::raw("COUNT(DISTINCT brands.brand_id) total"))->get()->first()->total;

	
		//Limit records
		if($request->has('offset')){
			$SearchQuery->offset($request->offset)->limit($this->limit);
		}else{
			$SearchQuery->offset(0)->limit($this->limit);
		}
		$SearchQuery->orderByRaw("isPaid DESC ,weightage ASC");
		$results=$SearchQuery->get()->toArray();

		//$meta=['heading'=>'Distributorship Opportunities '.$meta->name];

		foreach($results as $k=>$item){
			$locations = $this->getBrandLocations($item['brandId'])->pluck('stateName')->toArray();
			$results[$k]['locations']=$locations;
			$products=[];
			$results[$k]['products']=$products;
		}	

		return response()->json(array_merge($this->status(),['meta'=>$meta,'total'=>$total,'results'=>$results,'filters'=>$filters]));
	}


	private function industryQuery($baseQuery){
		
		$baseQuery->select(DB::raw('DISTINCT brands.brand_id as brandId,brands.company_name  as brandName, brands.profile_name as slug, brands.comp_logo as logo, brands.max_investment,brands.min_investment,brands.prop_area_min as space,C.category_name as industry,S.category_name as sector,brands.weightage,C.category_slug as industrySlug,C.category_id as industryId,S.category_id as sectorId,IF(comp_logo IS NULL or comp_logo = "", 0, 1) as isLogo'), 
		DB::raw('(CASE WHEN weightage=219 AND BC.mapping_type=1 THEN 100 
		WHEN weightage<200 AND BC.mapping_type=1 THEN 20 
		WHEN weightage>300 AND weightage<400 AND BC.mapping_type=1 THEN 19 
		WHEN weightage=219 AND BC.mapping_type=2 THEN 18 
		WHEN weightage<200 AND BC.mapping_type=2 THEN 17 
		WHEN weightage>300 AND weightage<400 AND BC.mapping_type=2 THEN 16 
		WHEN weightage=229 AND BC.mapping_type=1 THEN 15 
		WHEN weightage=229 AND BC.mapping_type=2 THEN 14 
		WHEN weightage>400 AND weightage<500 AND BC.mapping_type=1 THEN 13 
		WHEN weightage>400 AND weightage<500 AND BC.mapping_type=2 THEN 12 
		WHEN weightage>800 THEN 0 END) as isPaid'));
		return $baseQuery;
	}


	/*
	* Sector
	* @slug|string
	*/
	private function sectorQuery($baseQuery){

		$baseQuery->Join('category_relation as CR', 'CR.child_id', '=', 'BC.sector_id');
		$baseQuery->select(DB::raw('DISTINCT brands.brand_id as brandId,brands.company_name  as brandName, brands.profile_name as slug, brands.comp_logo as logo, brands.max_investment,brands.min_investment,brands.prop_area_min as space,C.category_name as industry,S.category_name as sector,brands.weightage,C.category_slug as industrySlug,C.category_id as industryId,S.category_id as sectorId,IF(comp_logo IS NULL or comp_logo = "", 0, 1) as isLogo'),
		DB::raw('( CASE WHEN weightage=229 AND BC.mapping_type=1 THEN 100 
		WHEN weightage<200 AND BC.mapping_type=1 THEN 20 
		WHEN weightage>400 AND weightage<500 AND BC.mapping_type=1 THEN 19 
		WHEN weightage=229 AND BC.mapping_type=2 THEN 18 
		WHEN weightage<200 AND BC.mapping_type=2 THEN 17 
		WHEN weightage>400 AND weightage<500 AND BC.mapping_type=2 THEN 16 
		WHEN weightage=219 AND BC.mapping_type=1 AND CR.relation_type=1 THEN 15
		WHEN weightage=219 AND BC.mapping_type=1 AND CR.relation_type=2 THEN 14 
		WHEN weightage BETWEEN 300 AND 400 AND BC.mapping_type=1 AND CR.relation_type=1 THEN 13
		WHEN weightage BETWEEN 300 AND 400 AND BC.mapping_type=1 AND CR.relation_type=2 THEN 12 
		WHEN weightage BETWEEN 300 AND 400 AND BC.mapping_type=2 AND CR.relation_type=1 THEN 11  
		WHEN weightage BETWEEN 300 AND 400 AND BC.mapping_type=2 AND CR.relation_type=2 THEN 10
		WHEN weightage>800 THEN 0 END) as isPaid'));
	
		return $baseQuery;
	}
	
	private function locationQuery($baseQuery){
		$baseQuery->select(DB::raw('DISTINCT brands.brand_id as brandId,brands.company_name  as brandName, brands.profile_name as slug, brands.comp_logo as logo, brands.max_investment,brands.min_investment,brands.prop_area_min as space,C.category_name as industry,S.category_name as sector,brands.weightage,C.category_slug as industrySlug,C.category_id as industryId,S.category_id as sectorId'),
		DB::raw('(CASE WHEN weightage=339 THEN 20 
		WHEN weightage=439 THEN 19 
		WHEN weightage=539 THEN 18 
		WHEN weightage>800 THEN 0 END) as isPaid'));
		return $baseQuery;
	}
	
	private function investmentQuery($baseQuery){
		$baseQuery->select(DB::raw('DISTINCT brands.brand_id as brandId,brands.company_name  as brandName, brands.profile_name as slug, brands.comp_logo as logo, brands.max_investment,brands.min_investment,brands.prop_area_min as space,C.category_name as industry,S.category_name as sector,brands.weightage,C.category_slug as industrySlug,C.category_id as industryId,S.category_id as sectorId'),
		DB::raw('(CASE WHEN weightage=329 THEN 20 
		WHEN weightage=429 THEN 19 
		WHEN weightage=529 THEN 18 
		WHEN weightage>800 THEN 0 END) as isPaid'));	
		return $baseQuery;
	}
	
		/**
	 * BaseQuery
	*/
	private function baseQuery(){
		$query=Brand::whereIn('profile_status', ['12', '11']);
		//$query->Join('brand_categories AS BC', 'brands.brand_id', '=', 'BC.brand_id');
		$query->Join('brand_categories as BC', function($join){
			$join->on('BC.brand_id', '=', 'brands.brand_id');
			$join->on('BC.mapping_type','=',DB::raw("'1'"));
		});

		$query->leftJoin('brand_locations AS BL', 'brands.brand_id', '=', 'BL.brand_id');
		$query->Join('categories AS C', 'C.category_id', '=', 'BC.industry_id');
		$query->Join('categories AS S', 'S.category_id', '=', 'BC.sector_id');
		return $query;
	}


	/**
	 * SearchQuery
    */
	private function FilterQuery($query,$request){
		
		if($request->location){
			$state=State::select('id')->where('slug', $request->location)->get()->first();
			if($state){
				$request->merge(["state_id"=>$state->id]);
			}
		}
		if (!empty($request->state_id)) {
			$query->where('BL.state_id', $request->state_id);
		}
		
		if (!empty($request->sector_id)) {
			$query->where('BC.sector_id', $request->sector_id);
		}
		
		
		if (!empty($request->industry_id)) {
			$query->where('BC.industry_id', $request->industry_id);
		}
		
		if (!empty($request->weightage)) {
			$query->where('brands.weightage', $request->weightage);
		}
		
		
		if ($request->has('min_investment') && $request->has('max_investment')) {
			 $query->where('min_investment', '<=', $request->max_investment);
			 $query->where('max_investment', '>=', $request->min_investment);
		}

		if ($request->investment) {
			 $query->where('min_investment', '<=',$request->investment);
			 $query->where('max_investment', '>=', $request->investment);
		}
		return $query;
	}

	


	/*
	* Location filters
	*/
	private function filters($baseQuery){
		$filters=[];
		
		$filterSector=clone $baseQuery;
		$filterSector->select(DB::raw('COUNT(brands.brand_id) as total'),'S.category_id as sector_id','S.category_name as name','S.category_slug as slug');
		$filterSector->where('S.status', 1);
		$filterSector->groupBy('S.category_id');
		$filterSector->orderByRaw("total DESC");
		$filterSector->limit(10);
		$filters['sectors']=$filterSector->get()->toArray();
		
		$filterInvestment=clone $baseQuery;
		$filterInvestment->select(DB::raw('MIN(brands.min_investment) as min'),DB::raw('MAX(brands.max_investment) as max'));
		$filters['investment']=$filterInvestment->first()->toArray();	
		
		$filterLocation=clone $baseQuery;
		$filterLocation->select(DB::raw('COUNT(DISTINCT brands.brand_id) as total'),'ST.id as state_id','ST.name as stateName','ST.slug as stateSlug');
		$filterLocation->Join('states AS ST', 'ST.id', '=', 'BL.state_id');
		$filterLocation->groupBy('ST.id');
		$filterLocation->orderByRaw("total DESC");
		$filterLocation->limit(10);
		$loactionFilters=$filterLocation->get()->toArray();

		$filters['locations']=$loactionFilters;
		return $filters;
	}



	/*
	* Get brand locations 
	*/
	private function getBrandLocations($brand_id){
	 return DB::table('brand_locations')
		 ->select(DB::raw('DISTINCT states.name as stateName,states.region'))
		 ->join('states', 'states.id', '=', 'brand_locations.state_id')			
		 ->where('brand_id',$brand_id);
	}

	/*
	* Get products
	*/
	private function getBrandProducts($brand_id){
		$products=Product::where('brand_id',$brand_id)->get();
		foreach($products as $i=>$product){
			$products[$i]->image=$product->image;
		}
		return $products;
	}	


      /*
	* Get all categories.
      */
    function get($parentId=0){		
        $categories = Category::select(DB::raw("category_id as id, category_name as name, category_slug as slug, category_icon as icon, IF(CR.parent_id IS NOT NULL, CR.parent_id, '0') as parentId"))
		->leftJoin('category_relation as CR', function($join){
			$join->on('CR.child_id', '=', 'category_id');
			$join->on('CR.relation_type','=',DB::raw("'1'"));
		});
		//->where('status',1);

		if($parentId=='all'){
		//Get all 
		}else if(is_numeric($parentId) && $parentId>0){
			$categories->whereRaw("CR.parent_id ='".$parentId."'");			
		}else{
			$categories->whereRaw('CR.parent_id IS NULL');
		}
		
		$categories->orderByRaw("category_id ASC");		
        $data=$categories->get()->toArray();
        return response()->json($data);
	}


	/*
	* Get all categories.
	*/
    function getMap($parentId=0){		
        $categories = Category::select(DB::raw("category_id as id, category_name as name"))
		->leftJoin('category_relation as CR', function($join){
			$join->on('CR.child_id', '=', 'category_id');
			$join->on('CR.relation_type','=',DB::raw("'1'"));
		})
		->where('status',1);

		if($parentId=='all'){
		//Get all 
		}else if(is_numeric($parentId) && $parentId>0){
			$categories->whereRaw("CR.parent_id ='".$parentId."'");			
		}else{
			$categories->whereRaw('CR.parent_id IS NULL');
		}
		
		$categories->orderByRaw("category_id ASC");		
        $data=$categories->get()->toArray();
        return response()->json($data);
	}

	function sync_banners(){
		$files = Storage::files("categories/");
		$count=0;
		foreach($files as $path){

			if(!Storage::disk('s3')->exists($path) && Storage::exists($path) ) {
				$content = Storage::get($path);			
				Storage::disk('s3')->put($path, $content, 'public');
				$url = Storage::getFacadeRoot()->disk('s3')->url($path);	
				$count++;
				usleep(200000);
			}	
		
		}
		echo"********End--(".$count.")--***********";
	}

	function cron_activate_categories(){
		
		//Update Sectors
		$categories = Category::select(DB::raw("category_id,category_name,COUNT(category_id)as cnt"))
		->join('brand_categories', 'category_id', '=', 'sector_id')	
		->groupBy('category_id')
		->orderByDesc('cnt')
		->get();
		foreach ($categories as $item) {
			//echo"Updating ".$row['category_id']."....\n";
			$status=$item->cnt>3?"1":"0";	
			Category::query()->where('category_id', $item->category_id)
			->update(['status'=>$status]);
		}
		
		//Update industry
		$categories = Category::select(DB::raw("category_id,category_name,COUNT(category_id)as cnt"))
		->join('brand_categories', 'category_id', '=', 'industry_id')	
		->groupBy('category_id')
		->orderByDesc('cnt')
		->get();
		foreach ($categories as $item) {
			//echo"Updating ".$row['category_id']."....\n";
			$status=$item->cnt>3?"1":"0";	
			Category::query()->where('category_id', $item->category_id)
			->update(['status'=>$status]);
		}
	}	
}
