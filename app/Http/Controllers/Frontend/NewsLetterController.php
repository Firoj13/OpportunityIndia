<?php

namespace App\Http\Controllers\Frontend;


use App\Models\FiNewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
define('EMAIL_MARKETER_API', 'http://mailer.franchiseindia.com/emailmarketer/xml.php');

class NewsLetterController extends Controller
{
    /**
     * @return mixed
     * function for checking and sending email
     */
    public function newsletter()
    {

        $email      = request()->email;
        $siteType   = request()->site_type;
        $randValue  = rand(100000, 9999999);
        $checkEmail = FiNewsLetter::query()->select('status')->where('email',$email)->where('site_type', $siteType)->orderby('nid','DESC')->first();
        $news       = 'subscribing';

        if(($checkEmail) > 0) {
            if($checkEmail->status == "S"){
                $news = 'alreadysubscribed';
                return view('newsletter/subscribe')->with(compact('news'));
            }
        }

        $source = "DOTCOM";
        if(!empty(Cookie::get('campaignSource')))
            $source = Cookie::get('campaignSource');

        // If no record exists, send the verification mail
        if (($checkEmail) == 0){
            $news    = 'subscribing';
            FiNewsLetter::query()->insert([
                'email'       => $email,
                'verify_code' => $randValue,
                'site_type'   => $siteType,
                'source_ref'  => $source
            ]);
           // if(!empty($email))
//                Mail::getFacadeRoot()->to($email)->send(new NewsLetterSubscribe($randValue));

        } else if ($checkEmail->status == "P"){
            $news = 'pending';

        } else if ($checkEmail->status == "U") {
            $news   = 'againsubscribe';
            FiNewsLetter::query()->where('email', $email)->where('site_type', $siteType)->update([ 'verify_code' => $randValue]);
         //   if(!empty($email))
//                Mail::getFacadeRoot()->to($email)->send(new NewsLetterSubscribe($randValue));

        } else if ($checkEmail->status == "S"){
            $news = 'subscribed';
        }

        return view('frontend.thanks')->with(compact('news'));
    }


}
