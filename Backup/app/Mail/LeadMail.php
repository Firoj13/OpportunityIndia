<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeadMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $buyerName;
    protected $buyerEmail;
    protected $buyerMobile;
    protected $sellerName;
    protected $isSellerPaid;

    public function __construct($details)
    {
        $this->buyerName         = $details['buyerName'];
        $this->buyerEmail        = $details['buyerEmail'];
        $this->buyerMobile       = $details['buyerMobile'];
        $this->sellerName        = $details['sellerName'];
        $this->isSellerPaid      = $details['isSellerPaid'];
		$this->showContactDetails = $details['showContactDetails'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //print_r($this->sellerName);
        return $this->from('no-reply@franchiseindia.com',$this->buyerName)
                ->subject('New Lead From DealerIndia')
                ->with([
                    'sellerName'=>$this->sellerName,
                    'buyerName'=>$this->buyerName,
                    'buyerEmail'=>$this->showContactDetails?$this->buyerEmail:"XXXXXXXX@xyz.com",
                    'buyerMobile'=>$this->showContactDetails?$this->buyerMobile:"XXXXXXXXXX",
                    'isSellerPaid'=>$this->isSellerPaid,
					'showContactDetails' => $this->showContactDetails,
                ])
                ->view('emails.seller_lead');
    }
}
