<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BuyerController extends Controller
{
    var $status=array(
        "code"=>200,
        "error"=>false,
        "message"=>"",
    );


    private function status($code=200,$error=false,$message=""){
        return array(
            'code'=>$code,
            'error'=>$error,
            'message'=>$message
        );
    }

    private function baseLeadQuery($useId){
        return DB::table('leads')
            ->select('leads.lead_id as leadId', 'leads.lead_type as leadType', 'leads.status as leadStatus', 'leads.created_at as leadCreated', 'brands.company_name as companyName', 'brands.profile_name as slug', 'categories.category_name as categoryName')
            ->join('leads_supplier', 'leads.lead_id', '=', 'leads_supplier.lead_id')
            ->join('brands', 'brands.brand_id', '=', 'leads_supplier.supplier_id')
            ->join('brand_categories', 'brand_categories.brand_id', '=', 'brands.brand_id')
            ->join('categories', 'categories.category_id', '=', 'brand_categories.industry_id')
            ->where('leads.user_id', '=', $useId);
    }

    function leadList(Request $request){
        $limit = ($request->limit > 100) ? 100 : $request->limit;
        $start =  $request->start;
        $user=$request->user();
		$baseQuery=$this->baseLeadQuery($useId);
		$countQuery=clone $baseQuery;
        $totalLeads = $countQuery->count();
		
        $leads =$baseQuery
			->orderBy('leads.created_at','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        return  response()->json(array_merge($this->status(),['totalLeads'=>$totalLeads, 'leads'=>$leads]));
    }


}
