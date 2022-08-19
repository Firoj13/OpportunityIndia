<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstaSubMagazineMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $magEmail;
    protected $magMobile;

    public function __construct($details)
    {
        $this->magEmail        = $details['email'];
        $this->magMobile       = $details['mobile'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //print_r($this->sellerName);
        return $this->from('no-reply@franchiseindia.com','OpportunityIndia')
                ->subject('Subscribe To Franchise World Magazine')
                ->with([
                    'email'=>$this->magEmail,
                    'phone'=>$this->magMobile,
                ])
                ->view('frontend.mail.instaSubscribeMagazine');
    }
}
