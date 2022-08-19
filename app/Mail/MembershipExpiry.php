<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipExpiry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $sellerName;
    protected $brandName;
    protected $brandId;
    protected $planName;
    protected $startDate;
	protected $endDate;
	protected $fee;

    public function __construct($details)
    {
        $this->sellerName   = $details['sellerName'];
        $this->brandName    = $details['brandName'];
		$this->brandId      = $details['brandId'];
        $this->planName     = $details['planName'];
        $this->startDate    = $details['startDate'];
        $this->endDate      = $details['endDate'];
		$this->fee			= $details['fee'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //print_r($this->sellerName);
        return $this->from('no-reply@franchiseindia.com',"Dealer India")
			->subject('Membership Expiry Notification')
			->with([
				'sellerName'=>$this->sellerName,
				'brandName'=>$this->brandName,
				'brandId'=>$this->brandId,
				'planName'=>$this->planName,			
				'startDate'=>$this->startDate,
				'endDate'=>$this->endDate,
				'fee'=>$this->fee,
			])
			->view('emails.membership_expiry');
    }
}
