<?php

namespace App\Http\Controllers\Frontend;

use App\Models\AskFranchisor;
use App\Models\AskInvestor;
use App\Mail\FreeAdviceForm;
use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class AdviceController extends Controller
{
    /**
     * Function to insert free advice data
     * @param Request $request
     * @return bool
     */
    public function freeadvice(Request $request)
    {
		$this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|min:2',
            'mobile' => 'required|min:10',
        ]);

        $user = $request->optionsRadios;
        $name = $request->name;
        $pincode = $request->pincode;
        $email = $request->email;
        $mobile = $request->mobile;
        $details = $request->details;
        $newsLetter = $request->is_newsletter;
        $city = "";
        $state = "";
        $ip = $request->ip();
        $table = ($user == 'franchisor') ? AskFranchisor::query() : AskInvestor::query();

        $pincodeDetails = Pincode::query()->select('city', 'state')->where('pincode', $pincode)->first();
        if (!empty($pincodeDetails)) {
            $city  = ucfirst(strtolower($pincodeDetails->city));
            $state = ucfirst(strtolower($pincodeDetails->state));
        }

        $mailTo = ($user != 'franchisor') ? "subscribe@franchiseindia.net" : "mgaurav@franchiseindia.com";

        $users = $table->insert([
            'name' => $name,
            'city' => $city,
            'state' => $state,
            'pincode' => $pincode,
            'email' => $email,
            'mobile' => $mobile,
            'details' => $details,
            'ip' => $ip,
            'reg_source' => !empty(Cookie::get('campaignSource')) ? Cookie::get('campaignSource') : ""
        ]);

        //If insertion fails
        if (!$users)
            return response()->json('Insertion failed..!');

		Mail::getFacadeRoot()->to($mailTo)->bcc("techsupport@franchiseindia.com")->send(new FreeAdviceForm($request));

        if ($newsLetter == 1)
            NewsLetterController::createNewsLetter($request->input('email'), "fi");

        return 'true';
    }

    public function freeadviceHome(Request $request)
    {


        $name = $request->name;
        $pincode = $request->pincode;
        $email = $request->email;
        $mobile = $request->mobile;
        $details = $request->details;
        $newsLetter = $request->is_newsletter;
        $city = "";
        $state = "";
        $ip = $request->ip();

        $table = AskFranchisor::query();

        $pincodeDetails = Pincode::query()->select('city', 'state')->where('pincode', $pincode)->first();
        if (!empty($pincodeDetails)) {
            $city  = ucfirst(strtolower($pincodeDetails->city));
            $state = ucfirst(strtolower($pincodeDetails->state));
        }

        $mailTo = "subscribe@franchiseindia.net";

        $users = $table->insert([
            'name' => $name,
            'city' => $city,
            'state' => $state,
            'pincode' => $pincode,
            'email' => $email,
            'mobile' => $mobile,
            'details' => $details,
            'ip' => $ip,
            'reg_source' => !empty(Cookie::get('campaignSource')) ? Cookie::get('campaignSource') : ""
        ]);
        return response()->json($users);
        //If insertion fails
        if (!$users)
            return response()->json('Insertion failed..!');

        Mail::getFacadeRoot()->to($mailTo)->bcc("techsupport@franchiseindia.com")->send(new FreeAdviceForm($request));

        if ($newsLetter == 1)
            NewsLetterController::createNewsLetter($request->input('email'), "fi");

        return response()->json('true');
    }
}
