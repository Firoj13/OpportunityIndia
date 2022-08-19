<?php
/**
 * Created by PhpStorm.
 * User: vasanthmuthusamy
 * Date: 02-10-2017
 * Time: 16:34
 */
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SellerPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $orderId;
    protected $name;
    protected $email;
    protected $mobile;
    protected $address;
    protected $amount;
    protected $details;
    protected $payStatus;
    protected $payDate;
    protected $gstNo;


    public function __construct($payMailArr)
    {
        $this->orderId   = $payMailArr['orderId'];
        $this->name      = $payMailArr['name'];
        $this->email     = $payMailArr['email'];
        $this->mobile    = $payMailArr['mobile'];
        $this->address   = $payMailArr['address'];
        $this->amount    = $payMailArr['amount'];
        $this->details   = $payMailArr['details'];
        $this->payStatus = $payMailArr['payStatus'];
        $this->payDate   = $payMailArr['payDate'];
        $this->gstNo     = $payMailArr['gstNo'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$emailsCc=[];
        $mailSend  = $this->from('no-reply@franchiseindia.com')
                          ->cc($emailsCc)
                          ->bcc('mohd.ali999@gmail.com');
        
        if ($this->payStatus == 1) {
            $mailSend = $mailSend->subject('Membership Upgradion - Payment Success');
        } else {
            $mailSend = $mailSend->subject('Membership Upgradion - Payment Failed');
        }
                    
        return $mailSend->view('mail.generalpayment')
                    ->with([
                        'orderId'   => $this->orderId,
                        'name'      => $this->name,
                        'email'     => $this->email,
                        'mobile'    => $this->mobile,
                        'address'   => $this->address,
                        'amount'    => $this->amount,
                        'details'   => $this->details,
                        'payStatus' => $this->payStatus,
                        'payDate'   => $this->payDate,
                        'gstNo'     => $this->gstNo,
                    ]);

    }
}
