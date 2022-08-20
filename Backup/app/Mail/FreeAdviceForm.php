<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FreeAdviceForm extends Mailable
{
    use Queueable, SerializesModels;

    protected $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Expand My Brand";
        return $this->from('no-reply@franchiseindia.com')
                    ->bcc('techsupport@franchiseindia.com')
                    ->subject($subject.' enquiry at FranchiseIndia.com')
                    ->view('mail.expand-brand')
                    ->with(['details' => $this->details]);
    }
}
