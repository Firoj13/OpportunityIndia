<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Location;
use App\Models\State;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Libraries\Solr;

class SearchController extends Controller
{
   
	private $order_by='brands.id DESC';

	private $limit=15;

	private $offset=0;

	private $filter=[];
	
	function __construct() {
		$this->params=array(
			'sort'=>'isLogo desc, updatedAt desc',
			'json.nl'=>'map'
		);
		$this->query='*:*';
		$this->filter[]='status:12'; #Default filter to all queries

		$this->set_offsets($this->offset,$this->limit);
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
	
	private function set_offsets($offset,$limit){
		$this->offset=(int)$offset;
		$this->limit=(int)$limit;
	}
	
	private function filter($request){
		if(!empty($request->offset)){
			$this->offset=(int)$request->offset;
			$this->limit=$request->offset+$this->limit;
		}

		if (!empty($request->term)) {
			//$request->term=str_replace(' ', '', $request->term);
			$this->query=$request->term.'*';
		}
		
		if (!empty($request->locations)) {
			$this->filter[]='{!tag=STATE}state:('.str_replace(","," ",$request->locations).')';
		}
		
		if (!empty($request->categories)) {
			//print_r($request->categories);
			$this->filter[]='{!tag=INDUSTRY}industryId:('.str_replace(","," ",$request->categories).')';
		}
		
		if ($request->min>0 && $request->max>0) {
			$this->filter[]='(min_investment:['.$request->min.' TO '.$request->max.'] AND max_investment:['.$request->min.' TO '.$request->max.'])';
		}

		$this->params['json.facet']="{'min_investment' : 'min(min_investment)','max_investment' : 'max(max_investment)','locations':{type:'terms','field':'state','limit':10,domain:{excludeTags:STATE}},'categories':{'type':'terms','field':'industryId','limit':10,domain:{excludeTags:INDUSTRY}}}";			
	}	
	
	function index(Request $request){
		
		$this->filter($request);
		//$this->params['fl']='';//load all fields
		
		$this->params['fq']=$this->filter;
		$solr = new Solr('brands');
		$response=$solr->search($this->query, $this->offset, $this->limit,$this->params);
		//print_r($response);
		try{			
			//echo $solr->getUrl();
			
			
			$filters=$response->facets;
			if(count($filters->categories->buckets)){
				$values = array_column($filters->categories->buckets, 'val');
				$items = Category::select("category_id as sector_id","category_name as name","category_slug as slug")->whereIn('category_id', $values)->get();
				$filters->sectors=$items;
			}
			
			$response=$response->response;	
			
			$results=[];
			foreach($response->docs as $item){
				$array=$item;
				if(empty($item->industryId)){
					continue;
				}
				$array->industryId=(int)$item->industryId[0];
				$array->sectorId=(int)$item->sectorid[0];
				$array->sector=$item->sector[0];
				unset($array->sectorid);
				$results[]=$array;
			}
			
			$totalResults=$response->numFound;
			return response()->json(array_merge($this->status(),['total'=>$totalResults,'results'=>$results,'filters'=>$filters]));
		}
		catch(\Exception $e) {
			//print_r($e->getMessage());
			//echo $solr->getUrl();
			return response()->json(array_merge($this->status(),['total'=>0,'results'=>[]]));
		}
	}
	
	/*
	* Automatically
	*/
	function quickSearch(Request $request){
		$brands = Brand::select(DB::raw("brands.brand_id AS id,brands.company_name AS title,profile_name as slug,'brand' as type,category_name as category"))
            ->whereIn('profile_status', ['12', '11'])
            ->where('company_name', 'LIKE', "%".request()->term."%")
            ->orWhere('brand_name', 'LIKE', "%".request()->term."%")
			->Join('brand_categories AS BC', 'brands.brand_id', '=', 'BC.brand_id')
			->Join('categories AS IND', 'IND.category_id', '=', 'BC.industry_id');
			
		$results = Category::select(DB::raw("category_id AS id,category_name as title,category_slug as slug,'category' as type,'' as category"))
            ->where('category_name', 'LIKE', "%".request()->term."%")
			->where('status', 1)
            ->union($brands)
            ->take(20)
            ->get()
			->toArray();
		//print_r($results);
		$i=0;
		foreach ($results as $item) {
            $results[$i]['title'] = str_replace('/', '-or-', $results[$i]['title']);
            $results[$i]['title'] = str_replace('%2F', '/', $results[$i]['title']);
            $i++;
        }
		
		return response()->json(['results'=>$results]);
	}	
}
