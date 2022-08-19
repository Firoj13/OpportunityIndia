<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Otp;
use App\Models\Lead;
use App\Models\Brand;
use Validator;
use Carbon\Carbon;
use Dusterio\LumenPassport\LumenPassport;
use App\Libraries\Textlocal;
use Illuminate\Support\Facades\DB;
use App\Helpers\UserHelper;

class UserController extends Controller
{
    var $status=array(
        "code"=>200,
        "error"=>false,
        "message"=>"",
    );
    
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
	/*
	* Check user exist
	*/
    public function verify(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [            
         'mobile' => 'required|regex:/^[\d]{9}[\d]$/' 
          ],[
            'mobile.required' => 'Please enter your mobile no.'
        ]);
		//return response($this->status(422,true,__('auth.signup_number_duplicate')),422);
        if($validator->fails()){
            return $this->validation_response($validator);
        }

        $user = User::where('mobile', $request->mobile)->first();
		
        if(!$user){
            $now = Carbon::now();
            $input = $request->all();                      
            $input['is_active'] = 0;
            $input['activated_at'] = $now->toDateTimeString();			
            $user = User::create($input);
        }
		
		$user = User::select(DB::raw("mobile,is_active,user_type,IF(password IS NULL,false,true) as hasPassword,credits, IF(last_logged_in IS NULL,true,false) as isNewUser"))->where('mobile', $request->mobile)->first();
		
        return response()->json(array_merge($this->status(),['user'=>$user]));
    }


    public function register(Request $request)
    {	
		$validatorRules=[
			'mobile'=>'required|regex:/^[\d]{9}[\d]$/',
			'user_type'=>'required',
		];
		
		if(!empty($request->otp)){
			$validatorRules['otp']= 'required|numeric';
			$checkotp = Otp::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
			if(!($checkotp)){
				return response($this->status(404,true,__('Invalid OTP')),404);
			}
		}else if($request->password){
			$validatorRules['password']= 'required|confirmed|min:8';			
		}
		$validator = Validator::make($request->all(), $validatorRules);
        if($validator->fails()){
            return $this->validation_response($validator);
        }

        #If already registerd 
        $user = User::where('mobile', $request->mobile)->first();
       
        if ($user != null) {
			$this->login($request);
            //return response($this->status(422,true,__('Mobile number regsiterd alredy with us')),422);
         }
        
        #Insert new user to database 
        $now = Carbon::now();
        $update = array(
            'user_type' => $request->user_type,
            'is_active' => 1,
            'activated_at' => $now->toDateTimeString(),
        );
		
		if(!empty($request->password)){
			$update['password'] = bcrypt($request->password);
		}
		
		#if registerd with otp verify 
		if(!empty($request->otp)){
			$update['is_verified']= 1;
			$update['verified_at'] = $now->toDateTimeString();
		}

		#if request name 
		if(!empty($request->name)){
			$update['name']=$request->name;
		}

		#if request email 
		if(!empty($request->email)){
			$update['email']=$request->email;
		}
		
		$user = User::where('mobile', $request->mobile)->first();
		if($user!= null){
			$user = User::where('mobile',$request->mobile)->update($update);
		}else{
			$update['mobile']= $request->mobile;
			$user = User::create($update);
		}

		#Get the updated user
        $user = User::where('mobile', $request->mobile)->where('is_active',1)->first();
		$tokenResult = $user->createToken('Personal Access Token');
		$token = $tokenResult->token;        
		if ($request->remember_me)
			$token->expires_at = Carbon::now()->addWeeks(1);
		$token->save();
		$accessToken=$tokenResult->accessToken;		
		return response(array_merge($this->status(),['user' => $user,'access_token'=>$accessToken]));
    }

   public function register_buyer(Request $request)
    {	
		$validatorRules=[
			'mobile'=>'required|regex:/^[\d]{9}[\d]$/',
			'user_type'=>'required',
			'email' => 'required',
		];
		$validator = Validator::make($request->all(), $validatorRules);
        if($validator->fails()){
            return $this->validation_response($validator);
        }
        #Insert new user to database 
        $now = Carbon::now();
        $update = array(
			'mobile' => $request->mobile,
			'email' => $request->email,
			'name' => $request->name,
            'user_type' => $request->user_type,
            'is_active' => 1,
            'activated_at' => $now->toDateTimeString(),
        );
		
		$user = User::where('mobile', $request->mobile)->first();
		if($user!= null){
			$user = User::where('mobile',$request->mobile)->update($update);
		}else{
			$update['mobile']= $request->mobile;
			$user = User::create($update);
		}

		#Get the updated user
        $user = User::where('mobile', $request->mobile)->first();
		$user->skipOtp=true;
		return response(array_merge($this->status(),['user' => $user]));
    }

    //Login
    public function login(Request $request)
    {
		
		if(!empty($request->otp)){
			//Login with OTP
			$validator = Validator::make($request->all(), [                      
				'mobile'=>'required|regex:/^[\d]{9}[\d]$/',
				'otp' => 'required|numeric|min:6',    
			]);
			if($validator->fails()){
				return $this->validation_response($validator);       
			}         
			//

			$otp = Otp::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
			if(!($otp && $request->otp!='123456')){
				return response($this->status(401,true,__('Invalid OTP')),401);
			}else{
				Otp::where('otp_id', $otp->otp_id)->delete();
				$user = User::where('mobile', $request->mobile)->first();
			}
		}else{
			//Login with password
			$validator = Validator::make($request->all(), [            
				'mobile'=>'required|regex:/^[\d]{9}[\d]$/',
				'password' => 'required|min:8',            
			]);
			if($validator->fails()){
				return $this->validation_response($validator);       
			}         
			
			$user = User::where('mobile', $request->mobile)->first();          
			if(!$user || !Hash::check($request->password, $user->password)){
				return response($this->status(401,true,"You have entered an invalid username or password"),401);
			}
		}

		if($user){
			$now = Carbon::now();
			 User::where('id',$user->id)->update(['last_logged_in'=>$now]);

			if($user->brand){
				$brandId= $user->brand->brand_id;
				$user->brandId=$brandId;
			}
			if(!empty($user->membership)){
				$user->isPaid=true;
			}

			$tokenResult = $user->createToken('Personal Access Token');
			$token = $tokenResult->token;        
			if ($request->remember_me)
				$token->expires_at = Carbon::now()->addWeeks(1);
			$token->save();
			return response(array_merge($this->status(),['user' => $user,'access_token'=>$tokenResult->accessToken]));
		}
    }

    //Send Login OTP to user
    public function sendOTP(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|regex:/^[\d]{9}[\d]$/'            
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        } 

        $mobile = $request->mobile; 
        $user = User::where('mobile', $mobile)->first();
        $otp_no = mt_rand(100000,999999); 

        $checkotp = Otp::where('mobile', $request->mobile)->first();
        if($checkotp != null){
            Otp::where('otp_id', $checkotp->otp_id)->delete();
        }
		//Create a Buyer in DB
		if($user == null){ 		
			$now = Carbon::now();
            $input = $request->all();
			$input['mobile']=$request->mobile;
            $input['is_active'] = 0;
            $input['user_type'] = "buyer";
            $input['activated_at'] = $now->toDateTimeString();      
            $user = User::create($input);
		}
        if($user != null){
            $otp = new Otp;
            $otp->user_id = $user->user_id>0?$user->user_id:0;
            $otp->mobile = $user->mobile;
            $otp->otp = $otp_no;            
            if(!($otp->save())){
                return response($this->status(401,true,"We are unable to process this request! Please try after some time"),401);
            }
            
            //Send message from gateway
            $sender  = "FranIn";
            $numbers = array($mobile);
            $textlocal = new Textlocal("tech@businessex.com","",env('SMS_GATEWAY_API', '1++g9O7/P/o-rclEr1gNlXZ1UJeUry2SwhlGud4392'));    
            $sender = 'FranIn';
			$message=sprintf("Dear %s, Your Franchiseindia.com verification code is %s FRANCHISE INDIA HOLDINGS LIMITED",'user',$otp->otp);
            //$message = 'Dear user, Your verification code is '.$otp->otp;   
			try {
			  $response = $textlocal->sendSms($numbers, $message, $sender);
			}
			catch(\Exception $e) {				
				return response($this->status(401,true,"SMS gateway Error: ".$e->getMessage()),401);
			}
                        
            //print_r($response);
  
            //Fake Response
            $response = new \stdClass();
            $response->status='success';
            if($response->status=='success'){
                return response($this->status(200,false,"OTP has been sent to your register mobile number"));
            }
        }else{
            return response($this->status(404,true,"Mobile number not registerd with us"));
        }   
 
    }
	
	//Login 
    public function resetPassword(Request $request)
    {
		if(!empty($request->otp)){
			//Login with OTP
			$validator = Validator::make($request->all(), [                      
				'mobile'=>'required|regex:/^[\d]{9}[\d]$/',
				'password' => 'required|numeric|min:8',
				'otp' => 'required|numeric|min:6',				
			]);
			
			if($validator->fails()){
				return $this->validation_response($validator);       
			}         
			//  
			$otp = Otp::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
			if($otp){
				User::where('mobile', $request->mobile)->update(['password'=> bcrypt($request->password)]);
				return response($this->status(200,true,"Password changed."));
			}else{
				return response($this->status(400,true,"OTP Did not Matched."),400);
			}
		}
	}
	/*
	 * Get
	*/
    public function get(Request $request){
        $user=$request->user();
        if($user->brand){
            echo "brand";
        }else{
            echo "No company";
        }

        return response($user);
    }
	
	
	function update(Request $request){
        $user = $request->user();
		$user = User::where('id',$user->id)->get()->first();
		$update=[];
		if(!empty($request->email)){
			$user->email=$request->email;
		}
		if(!empty($request->name)){
			$user->name=$request->name;
		}
		$user->save();
		return response(array_merge($this->status(),['user' => $user]));
	}
	
	function changePassword(Request $request){
        $user = $request->user();
        $now = Carbon::now();
		$user=User::select('password','id')->where('id',$user->id)->get()->first();
		if($user && Hash::check($request->oldPassword, $user->password)){
            if($request->newPassword === $request->confirmPassword){
                $update = array(
                    'password' => bcrypt($request->newPassword),
                    'updated_at' => $now->toDateTimeString(),
                );
				
                User::where('id',$user->id)->update($update);
                return response($this->status(200,false,"Password Changed."));
            } else{
                return response($this->status(400,true,"Confirm Password Did not Matched."),400);
            }
        } else{
            return response($this->status(400,true,"Old Password Did not Matched."),400);
        }
    }

	function submitFeedback(Request $request){
        $user = $request->user();
        $now = Carbon::now();
        DB::table('feedback')->insertOrIgnore(['feed_user'=>$user->id, 'feed_name'=>$request->name,'feed_email'=>$request->email,'feed_mobile'=>$request->mobile, 'feed_topic' =>$request->topic, 'feed_text'=>$request->feedback, 'feed_datetime' =>$now]);
        return response($this->status(200,true,"Feedback Submitted."));
    }


    /*
	 * Logout
	*/
    public function logout(Request $request)
    {        
        $isUser = $request->user()->token()->revoke();
        if($isUser){
            return response($this->status(200,false,"Successfully logged out"));           
        }
        else{
            return response($this->status(200,true,"Something went wrong."));        
        }            
    }

	
	
	public function getGeneralLeads(Request $request){
        $user=$request->user();
		$offset=$request->page*20;
        $items =DB::table('leads as l')
            ->select('u.name','u.mobile','u.email','l.lead_id as leadId', 'l.lead_type as leadType', 'l.status', 'l.created_at as createdAt')
			->join('users as u', 'l.user_id', '=', 'u.id')
            ->where('l.lead_type','general')
            ->where('l.status',2)
            ->orderBy('l.created_at', 'DESC')
			->offset($offset)
			->limit(20)
            ->get();

        $leads = array();
        if(count($items)>0){
            foreach($items as $item){
                $leads[] = array(
                    'leadId' => $item->leadId,
                    'leadType' => $item->leadType,
					'name' => $item->name,
					'phone' => UserHelper::maskPhoneNumber($item->mobile),
					'email' => UserHelper::maskEmail($item->email),
                    'attributes' => $this->leadAttributes($item->leadId),
                    'leadStatus' => $item->status,
                    'addedOn' => date("M j, Y",strtotime($item->createdAt)),
                );
            }
        }

        return response()->json(array_merge($this->status(),['leads'=>$leads]));
    } 
    
	public function buyLead(Request $request){
		$user=$request->user();
		$now = Carbon::now();
		$leadId=$request->leadId;
		$brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
		if(empty($brandId)){
			return response($this->status(400,true,"Something went wrong."));
		}
		if($user->credits<=0){
			return response($this->status(402,true,"Insufficient credit balance"),402);
		}
		//print_r($brandId);
		if($brandId>0){
			DB::table('leads_supplier')->insertOrIgnore(['lead_id'=>$leadId,'supplier_id'=>$brandId,'mapping_timestamp'=>$now]);
			DB::table('leads')->where('lead_id',$leadId)->update(['lead_type'=>'direct']);
			$user->decrement('credits', 15);
			$user->save();
		}
		return response()->json($this->status());
	}
    
	private function leadAttributes($leadId){
        return DB::table('leads_details')
            ->select('attribute_name as title','attribute_value as value')
            ->where('lead_id',$leadId)
            ->get()
            ->toArray();
    }
	
    public function getSellerLeads(Request $request){
        $user=$request->user();
		$brand = Brand::where('user_id', $user->id)->first();
		$brandId = $brand->brand_id;
		$offset=$request->page*20;
		$items=DB::table('leads as l')
            ->select('u.mobile','u.name','email','l.lead_id as leadId', 'l.lead_type as leadType', 'l.status', 'l.created_at as createdAt','is_hidden')
            ->join('leads_supplier as ls', 'ls.lead_id', '=', 'l.lead_id')
			->join('users as u', 'l.user_id', '=', 'u.id')
            ->where('l.lead_type','direct')
            ->where('ls.supplier_id',$brandId)
            ->orderBy('l.created_at', 'DESC')
			->offset($offset)
			->limit(20);
		$isVisible=true;
		if(!$brand->isPaid()){
			$isVisible=false;
		}

		$items=$items->get();
        $leads = array();
        if(count($items)>0){
            foreach($items as $item){
                $leads[] = array(
                    'leadId' => $item->leadId,
                    'leadType' => $item->leadType,
					'phone' => (!$brand->isPaid() && $item->is_hidden == 'Y')? UserHelper::maskPhoneNumber($item->mobile) : $item->mobile,
					'name' => $item->name,
					'email' => (!$brand->isPaid() && $item->is_hidden == 'Y')? UserHelper::maskEmail($item->email) : $item->email,
                    'attributes' => $this->leadAttributes($item->leadId),
                    'leadStatus' => $item->status,
                    'addedOn' => date("M j, Y",strtotime($item->createdAt)),
					'isHidden' => $item->is_hidden==='Y' ? true : false,
                );
            }
        }

		$hiddenLeads = DB::table('leads as l')
			->join('leads_supplier as ls', 'ls.lead_id', '=', 'l.lead_id')
			->where('ls.supplier_id',$brandId)
			->where('l.is_hidden',"Y")
			->count();
        return response()->json(array_merge($this->status(),['leads'=>$leads, 'hiddenLeads'=> $hiddenLeads]));
    }
	
	/*
	* Get Buyers Lead
	*/
	public function getBuyersLeads(Request $request){
        $user=$request->user();
        $items =DB::table('leads as l')
            ->select('l.lead_id as leadId', 'l.lead_type as leadType', 'l.status', 'l.created_at as createdAt','b.brand_id','b.profile_name','b.company_name','SEC.category_name as sector')
            ->leftjoin('leads_supplier as ls', 'ls.lead_id', '=', 'l.lead_id')
			->leftjoin('brands as b', 'ls.supplier_id', '=', 'b.brand_id')
			->leftjoin('brand_categories as bc', 'bc.brand_id', '=', 'b.brand_id')
			->leftjoin('categories as SEC', 'SEC.category_id', '=', 'bc.sector_id')
			->where('l.user_id',$user->id)
            ->orderBy('l.created_at', 'DESC')
            ->get();

        $leads = array();
        if(count($items)>0){
            foreach($items as $item){
				
                $leads[] = array(
                    'leadId' => $item->leadId,
                    'companyId' => $item->brand_id,
					'companySlug' => $item->profile_name,
					'companyName' => $item->company_name,
					'sector' => $item->sector,
					'leadType' => $item->leadType,
                    'attributes' => $this->leadAttributes($item->leadId),
                    'leadStatus' => $item->status,
                    'addedOn' => date("d-m-Y",strtotime($item->createdAt)),
                );
            }
        }

        return response()->json(array_merge($this->status(),['leads'=>$leads]));
    } 

	
}
