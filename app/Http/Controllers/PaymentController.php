<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\HdfcCrypto;
use App\Helpers\PaytmCrypto;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Brand;
use App\Models\BrandMembership;
use App\Mail\SellerPaymentMail;
use App\Mail\PaymentConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
	
	function __construct() {
        
    }
    
	private function status($code=200,$error=false,$message=""){
        return array(
          'code'=>$code,
          'error'=>$error,
          'message'=>$message
        );
    }
	
	var $status=array(
        "code"=>200,
        "error"=>false,
        "message"=>"",
    );

    private function validation_response($validator){
		$errors=$validator->errors()->messages();
		array_walk_recursive($errors, function ($value, $key) use (&$error){
			$error = $value;
		}, $error);

        return response($this->status(422,true,$error),422);
    }
    
	function memberships(){
		 $results = Membership::select('id as membershipPlan','title','max_listings','type','sample_image','featured_text')
			->where('status',1)
			->get();
		$features=config('payment.features');
		//print_r($features);
		$response = array();
		foreach ($results as $result) {
			$price= DB::table('membership_plans')
				->select(DB::raw('plan_id as planId,title, price as amount,discount,term,info'))			
				->where('parent_id',$result->membershipPlan)
				->where('status',1)
				->get();
			$result->price=$price;
			if(isset($features[trim($result->title)]))
			$result->features=$features[trim($result->title)];
			$response[$result->type][]=$result;

		}
        return response()->json($response);
	}
	
	private function getPrice($planId){
		$plan=$this->getPlan($planId);
		return $plan->amount-$plan->discount;
	}
	
	private function getPlan($planId){
		return $price= DB::table('membership_plans as MP')
			->select(DB::raw('MP.plan_id as planId,MP.title,MP.price as amount,MP.discount,MP.term,M.weightage'))			
			->join('memberships as M', 'MP.parent_id', '=', 'M.id')
			->where('plan_id',$planId)			
			->get()
			->first();
	} 

	/**
	* Payment process
	*/
	function process(Request $request){
		
		$user=$request->user();
		if(empty($request->paymentMode) || empty($request->paymentMethod)){
			return response($this->status(401,true,"Select a payment method"),401);
		}
		//print_r($user);
		if(!$user){
			return response($this->status(401,true,"We are unable to process this request! Please try after some time"),401);
		}

		$brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
		$paymentMode=$request->paymentMode;
		$amount=(int)$this->getPrice($request->planId);

		$gstAmount=(int)($amount/100)*config('payment.GST_RATE');
        $total=(int)$amount+$gstAmount;
		$environment=env('APP_ENV', '');
		//$total=1;
		if($environment=='development' || $_SERVER['REMOTE_ADDR'] =='206.123.129.105'){
			$total=1;
		}
		$charges= config('payment.charges');

		$orderNo = $this->OnlinePayUniqRandomStr();
        $payment = new Payment();
        $payment->order_no = $orderNo;
        $payment->user_id = $user->id;
		$payment->brand_id = $brandId;
        $payment->name = $user->name;
        $payment->email = $user->email;
        $payment->phone = $user->mobile;
        $payment->city = $user->city;
        $payment->country = $user->country;
        $payment->plan_id = $request->planId;
        $payment->amount = $total;
        //$payment->coupon_id = !empty($request->input('coupon_id')) ? $request->input('coupon_id') : NULL;
        $payment->payment_mode = $request->paymentMode;
		$payment->payment_method = $request->paymentMethod;
		
        if (!$payment->save()) {
            Log::alert('Online Payment Details Insert Failed : ' . $userId . ' || ' . $orderNo);
            return response()->json('Please try after some time', 404);
        } else {
            //$emailData = new VerifyMailPayment($payment);
            //$emails = ['mali@franchiseindia.net'];
            //Mail::to($emails)->send($emailData);
        }

		 if($paymentMode=='paytm'){
            $paytmList = array();
            // Create an array having all required parameters for creating checksum.
            $paytmList["REQUEST_TYPE"] = 'DEFAULT';
            $paytmList["MID"] = config('payment.paytm.MERCHANT_MID');
            $paytmList["ORDER_ID"] =$orderNo;
            $paytmList["CUST_ID"] = $orderNo;
            $paytmList["INDUSTRY_TYPE_ID"] = config('payment.paytm.INDUSTRY_TYPE_ID');
            $paytmList["CHANNEL_ID"] = 'WEB';
            $paytmList["TXN_AMOUNT"] = (int)$total;
            $paytmList["WEBSITE"] = config('payment.paytm.MERCHANT_WEBSITE');
            $paytmList["CALLBACK_URL"] = config('payment.paytm.CALLBACK_URL');
            $paytmList["MSISDN"] =$user->mobile; //Mobile number of customer
            $paytmList["EMAIL"] = $user->email; //Email ID of customer
            //$paramList["VERIFIED_BY"] = ""; //
            //$paramList["IS_USER_VERIFIED"] = ""; //

            $checksum = paytmCrypto::getChecksumFromArray($paytmList,config('payment.paytm.PAYTM_MERCHANT_KEY'));

            $paytmList["CHECKSUMHASH"] = $checksum;

            $paymentDetails = array(
                'paytmList' => $paytmList
            );

        }else{
            $order_id = "order_id=" . urlencode($orderNo);
            $tid = "tid=" . urlencode(rand() . 1);
            $merchant_id = "merchant_id=" . urlencode(config('payment.hdfc.merchantKey'));
            $amount = "amount=" . urlencode($total);
            $currency = "currency=" . urlencode("INR");

            $redirect_url = "redirect_url=" . urlencode(config('payment.baseUrl')."?status=success");
            $cancel_url = "cancel_url=" . urlencode(config('payment.baseUrl')."?status=cancelled");
            $language = "language=" . urlencode("EN");
            $billing_name = "billing_name=" . urlencode($user->name);
            $billing_address = "billing_address=" . urlencode('Testing address');
            $billing_city = "billing_city=" . urlencode($user->city);
            $billing_state = "billing_state=" . urlencode('');
            $billing_zip = "billing_zip=" . urlencode('');
            $billing_country = "billing_country=" . urlencode("India");
            $billing_tel = "billing_tel=" . urlencode("9813646722"); //$user->mobile
            $billing_email = "billing_email=" . urlencode("mohd.ali999@gmail.com");//$user->email
            $payment_option = "payment_option=" . urlencode($payment->payment_method); //OPTCRDC -Credit Card OPTDBCRD -Debit CardOPTNBK-Net Banking OPTCASHC-Cash Card  OPTMOBP-Mobile Payments
            $card_type = "card_type=" . urlencode(str_replace("OPT", "", $payment->payment_method));//CRDC  -Credit CardDBCRD -Debit CardNBK -Net Banking CASHC -Cash Card  MOBP -Mobile Payments

             $merchant_data = $tid . "&" . $merchant_id . "&" . $order_id . "&" . $amount . "&" . $currency . "&" . $redirect_url . "&" . $cancel_url . "&" . $language . "&" . $billing_name . "&" . $billing_address . "&" . $billing_city . "&" . $billing_state . "&" . $billing_zip . "&" . $billing_country . "&" . $billing_tel . "&" . $billing_email . "&" . $payment_option . "&" . $card_type;

            $encrypted_data = HdfcCrypto::encrypt($merchant_data, config('payment.hdfc.workingKey')); // Method for encrypting the data.

			$rcvdString = HdfcCrypto::decrypt($encrypted_data, config('payment.hdfc.workingKey')); 
            
			
			$paymentDetails = array(
                'access_code' => config('payment.hdfc.accessCode'),
                'encRequest' => $encrypted_data,
            );
        }

        return $paymentDetails;
	}
	
	function hdfcCallBack(Request $request){
	    $encResponse = $request->encResp;
		$response = new \stdClass;
        //This is the response sent by the CCAvenue Server
        //$encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server
        $rcvdString = hdfcCrypto::decrypt($encResponse, config('payment.hdfc.workingKey'));  //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $status_message = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3)
                $order_status = $information[1];
            if ($i == 0)
                $order_id = $information[1];
            if ($i == 2)
                $bank_ref_no = $information[1];
            if ($i == 1)
                $tracking_id = $information[1];
            if ($i == 5)
                $payment_mode = $information[1];
            if ($i == 10)
                $amount = $information[1];
            if ($i == 11)
                $firstname = $information[1];
            if ($i == 18)
                $billingEmail = $information[1];
            if ($i == 8)
                $status_message = $information[1];
        }

        $txnid_temp = explode("-", $order_id);

        $txnid = $txnid_temp[0];
        $response->status = $order_status;
        $response->firstname = $firstname;
        $response->amount = $amount; //Please use the amount value from database
        $response->txnid = $txnid;
		$response->status_message = $status_message;
        $postedHash = '';
        $key = '';
        $productinfo = '';
        $response->email = $billingEmail;
        $salt = '';
		
		return $this->paymentVerifySuccess($response);		
	}
	
	function paytmCallBack(Request $request){
	    $encResponse = $request->encResp;
		$response = new \stdClass;
	}
	
	function successCallBack(Request $request,$txnid){
		echo "Payment....".$txnid;
		$response = new \stdClass;
		$response->txnid=$txnid;
		$response->status = "Success";
		$response->status_message="Status response";
		
		return $this->paymentVerifySuccess($response);
	}
    function paymentVerifySuccess($response)
    {
		#print_r($response);
		$txnid	=$response->txnid;
		$status_message	=$response->status_message;
		 if ($response->status === "Success") {
		    $paymentUpdate = Payment::query()->where('order_no', '=', $txnid)
                ->update(['payment_status' => config('payment.paymentStatus.Success'), 'status_message' => $status_message,'txnid'=>$txnid]);
            if (empty($paymentUpdate)) {
                Log::alert('Online Payment Success Update Failed : ' . $response->txnid);
            }

            $paymentDetail = Payment::query()->where('order_no', '=', $response->txnid)->first();
			$flag = $this->saveSellerMembership($paymentDetail);

            if ($flag) {
                //$paymentData = new SellerPaymentMail($paymentDetail);
                //$emailids = ['mali@franchiseindia.net'];
                //Mail::to($emailids)->send($paymentData);
                //mail to client
                //$paymentConfirmation = new PaymentConfirmationMail($paymentDetail);
                //Mail::to($paymentDetail->email)->send($paymentConfirmation);
            } else {
                Log::alert('Profile Membership (' . $paymentDetail->product_details . ') Details Insert Failed : ' . $paymentDetail->user_id . ' || ' . $paymentDetail->order_no);
            }
            //return redirect(config('payment.paymentsuccess'));
        } else if ($response->status === "Aborted") {
            $paymentUpdate = Payment::query()->where('order_no', '=', $txnid)
                ->update(['payment_status' => config('payment.paymentStatus.Cancelled'), 'status_message' => $status_message,'txnid'=>$txnid]);
            if (empty($paymentUpdate)) {
                Log::alert('Online Payment Success Update Failed : ' . $txnid);
            }
			echo config('payment.paymentcancelled');
			
            return redirect(config('payment.paymentcancelled'));
        } else if ($response->status === "Failure") {
            $paymentUpdate = Payment::query()->where('order_no', '=', $txnid)
                ->update(['payment_status' => config('payment.paymentStatus.Failed'), 'status_message' => $status_message,'txnid'=>$txnid]);
            if (empty($paymentUpdate)) {
                Log::alert('Online Payment Success Update Failed : ' . $txnid);
            }
			return redirect(config('payment.paymentcancelled'));
        } else {
            $paymentUpdate = Payment::query()->where('order_no', '=', $txnid)
                ->update(['payment_status' => config('payment.paymentStatus.Failed'), 'status_message' => $status_message,'txnid'=>$txnid]);
            if (empty($paymentUpdate)) {
                Log::alert('Online Payment Success Update Failed : ' . $txnid);
            }
           return redirect(config('payment.paymentcancelled'));
        }
    }

	 /**
     * @param $paymentDetail
     * @param $amount
     * @param $plan
     * @param $intCredits
     * @param $instResponse
     * @param $expiryDate
     * @return bool
     */
	function saveSellerMembership($payment)
    {
		$now = Carbon::now();	
		$membershipPlan=$this->getPlan($payment->plan_id);
	
		$expiryDate = $now->add($membershipPlan->term, 'day');
		$brand =Brand::query()->where('brand_id', '=', $payment->txnid)
            ->update(['weightage' => $membershipPlan->weightage]);

        $membership = new BrandMembership();
        $membership->brand_id = $payment->brand_id;
		$membership->payment_id = $payment->id;
		$membership->is_active = 1;
        $membership->plan_id = $payment->plan_id;
        $membership->activation_date = $now;
        $membership->expiry_date = $expiryDate;
        return $membership->save();
    }
	
	function saveInvestorMembership($payment)
    {
		$now = Carbon::now();	
		$membershipPlan=$this->getPlan($payment->plan_id);
	
		$expiryDate = $now->add($membershipPlan->term, 'day');
		$brand =User::query()->where('brand_id', '=', $payment->user_id)
            ->update(['ispaid' => 1]);

        $membership = new BrandMembership();
        $membership->brand_id = $payment->brand_id;
		$membership->payment_id = $payment->id;
		$membership->is_active = 1;
        $membership->plan_id = $payment->plan_id;
        $membership->activation_date = $now;
        $membership->expiry_date = $expiryDate;
        return $membership->save();
    }

	public function payments(Request $request){		
		$user=$request->user();
		$brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
		$membership=BrandMembership::select(DB::raw("MP.plan_id,DATE_FORMAT(activation_date, '%d-%M-%Y') as startDate,DATE_FORMAT(expiry_date, '%d-%M-%Y') as endDate,MP.title,M.type"))
		->Join('membership_plans AS MP', 'MP.plan_id', '=', 'brand_memberships.plan_id')
		->Join('memberships AS M', 'MP.parent_id', '=', 'M.id')
		->where('brand_memberships.brand_id',$brandId)
		->where('is_active',1)
		->get()
		->first();		
		return  response()->json(array_merge($this->status(),['plan'=>$membership]));
	}
	/**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Laravel\Lumen\Http\Redirector
     */
    public function paymentCancelled(Request $request)
    {
        $paymentUpdate = Payment::query()->where('order_no', '=', $request['txnid'])
           ->update(['payment_status' => config('payu.paymentStatus.Cancelled')]);
        if (empty($paymentUpdate))
            Log::alert('Online Payment Success Update Failed : ' . $request['txnid']);
        return redirect(config('payment.paymentcancelled'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Laravel\Lumen\Http\Redirector
     */
    public function paymentFailed(Request $request)
    {
        $paymentUpdate = Payment::query()->where('order_no', '=', $request['txnid'])
            ->update(['payment_status' => config('payu.paymentStatus.Failed')]);
        if (empty($paymentUpdate))
            Log::alert('Online Payment Success Update Failed : ' . $request['txnid']);
		return redirect(config('payment.paymentfailure'));
    }
	
	/**
     * Function to generate random int for user_rand_id column in OnlinePayment Model
     * @return int
     */
    protected function OnlinePayUniqRandomStr()
    {
        // Generate a unique 6 digit string using Laravel helper method
        $uniqId = mt_rand(1000, 150000000); //str_random(6);
        // Check whether the random string already exists in DB
        $chkExists = Payment::query()->where('order_no', $uniqId)->get();
        // If already exists, call the same function recursively
        if (count($chkExists->toArray()) > 0) {
            $this->OnlinePayUniqRandomStr();
        }
        return $uniqId;
    }
}
