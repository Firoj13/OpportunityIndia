<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Brand;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Libraries\Textlocal;
use App\Mail\LeadMail;
use Mail;
use App\Helpers\UserHelper;

class LeadController extends Controller
{
    
    private function status($code=200,$error=false,$message=""){
        return array(
          'code'=>$code,
          'error'=>$error,
          'message'=>$message
        );
    }

    /*
	 * Create Lead
	*/
	function createLead(Request $request){
		$user=$request->user();
		//$userId=$user->id
		$userId=$user->id;
		$now = Carbon::now();

		$validator = Validator::make($request->all(), [                      
			'LeadType' => 'required',			
		]);
			
		if($validator->fails()){
			return $this->validation_response($validator);       
		}   
		//Check duplicate Lead
		if(!empty($request->brandId)){
			$lead = Lead::select('leads.lead_id')->where('user_id',$userId)->where('ls.supplier_id',$request->brandId)->join('leads_supplier as ls', 'ls.lead_id', '=', 'leads.lead_id')->get()->first();
			//print_r($lead);
			if($lead){
				//return response($this->status(401,true,"You already applied for this supplier."),401);
			}
		}
		
		//$buyer=User::select('is_verified')->where('id',$userId)->first();
		//print_r($user->is_verified);

		$input=[
			'user_id'=>$userId,
			'lead_type'=>$request->LeadType,
			'status'=>$user->is_verified?3:1
		];
		

		$leadId = Lead::create($input)->lead_id;		

		if(!empty($leadId)){
			if($request->brandId>0){
				DB::table('leads_supplier')->insertOrIgnore(['lead_id'=>$leadId,'supplier_id'=>$request->brandId,'mapping_timestamp'=>$now]);
			}
			$this->onLeadgeneration($leadId, $request->brandId, $user);
			
			return response(['leadId'=>$leadId]); 	
		}else{
			return response($this->status(401,true,__('Error occured while proceesing you request.Please try again')),401);
		}

	}

	private function onLeadgeneration($leadId, $brandId, $buyer){
	    //Send message from gateway
	    $seller=Brand::where('brands.brand_id',$brandId)
	    	->get()
	    	->first();
	    if($seller && $buyer){
			$this->sendEmailNotificatio($leadId, $buyer, $seller);	
		}
	}

    private function sendEmailNotificatio($leadId, $buyer, $seller){
		/*Send Email*/
		$environment=env('APP_ENV', '');
		if($environment=='development'){
    		$seller->email="mali@opportunityindia.com";
    		$seller->name="User";
    	}
		$seller->name=!empty($seller->name) ? $seller->name : "User";
		$showContactDetails=true;
		if(!$seller->isPaid()){				
			$monthlyLeadCount = DB::table('leads')
				->join('leads_supplier as ls', 'ls.lead_id', '=', 'leads.lead_id')
				->whereRaw('MONTH(created_at) = MONTH(NOW())')
				->whereRaw('YEAR(created_at) = YEAR(NOW())')
				->where('ls.supplier_id',$seller->brand_id)
				->count();
			if($monthlyLeadCount > 10){
				$showContactDetails=false;
				Lead::where('lead_id' , $leadId)->update(['is_hidden'=>'Y']);
			}
		}
    	if(!empty($seller->email)){
	    	$data = [
	    		'buyerName' => $buyer->name,
	    		'buyerEmail' => $buyer->email,
	    		'buyerMobile' => $buyer->mobile,
	    		'sellerName' => $seller->name,
	    		'sellerEmail' => $seller->email,
	    		'isSellerPaid'=>$seller->isPaid()? true : false,
				'showContactDetails' => $showContactDetails
	    	];

			try {
				Mail::mailer('sparkpost')//sparkpost
				->to($seller->email)
				->send(new LeadMail($data));
			    //print_r("Success");
			} catch (Exception $ex) {
			    // Debug via $ex->getMessage();
			    return response($this->status(401,true,"Email could not be sent Error:".$ex->getMessage()),401);
			}
		}
    } 
    
    private function send_sms($buyer,$seller){
	    $sender  = "FranIn";
	    $numbers = array($mobile);
	    $textlocal = new Textlocal("tech@businessex.com","",env('SMS_GATEWAY_API', false));    
	    $sender = 'FranIn';
		$message=sprintf("Dear %s, Your Franchiseindia.com verification code is %s FRANCHISE INDIA HOLDINGS LIMITED",'user',$otp->otp);
	    //$message = 'Dear user, Your verification code is '.$otp->otp;   
		try {
		  $response = $textlocal->sendSms($numbers, $message, $sender);
		}
		catch(\Exception $e) {				
			return response($this->status(401,true,"SMS gateway Error: ".$e->getMessage()),401);
		}
    }

	/*
	 * Submit Lead
	*/
	function submitLead(Request $request){
		$user=$request->user();

		$validator = Validator::make($request->all(), [                      
			'leadId' => 'required|numeric',
		]);
		
		if($validator->fails()){
			return $this->validation_response($validator);       
		}   
		$now = Carbon::now();
		
		//Donot call if verified by OTP
		if($user->is_verified==1){	
			Lead::where('lead_id',$request->leadId)->update(['status'=>2]);	
		}

		$input=[];

		if($request->industry){
			$input[]=['lead_id'=>$request->leadId,'attribute_name'=>'industry','attribute_value'=>$request->industry];
		}

		if($request->sector){
			$input[]=['lead_id'=>$request->leadId,'attribute_name'=>'sector','attribute_value'=>$request->sector];
		}

		if($request->investment){
			$input[]=['lead_id'=>$request->leadId,'attribute_name'=>'investment','attribute_value'=>$request->investment];
		}
		if($request->details){
			$input[]=['lead_id'=>$request->leadId,'attribute_name'=>'details','attribute_value'=>$request->details];
		}
		if($request->roi){
			$input[]=['lead_id'=>$request->leadId,'attribute_name'=>'roi','attribute_value'=>$request->roi];
		}
		if($request->risk){
			$input[]=['lead_id'=>$request->leadId,'attribute_name'=>'risk','attribute_value'=>$request->risk];
		}
		
		//print_r($input);
		DB::table('leads_details')->insertOrIgnore($input);

		return response($this->status(200,true,"Lead generated."));   
	}

    private function validation_response($validator){
		$errors=$validator->errors()->messages();
		array_walk_recursive($errors, function ($value, $key) use (&$error){
			$error = $value;
		}, $error);

        return response($this->status(422,true,$error),422);
    }
}
