<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $name;
    protected $email;
    protected $Phone;
    protected $contreason;

    public function __construct($details)
    {
        $this->name           = $details['name'];
        $this->email          = $details['email'];
        $this->Phone          = $details['mobile'];
        $this->contreason     = $details['contreason'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Mark CC to Anuj if the enquiry is for Magazine
        if ($this->contreason == 'Subscribe to the Magazine')
            $sendMail = $this->cc('subscribe@franchiseindia.net');

        return $this->from('no-reply@franchiseindia.com')
            ->subject('Contact Us - OpportunityIndia.franchiseindia.com')
            ->view('frontend.mail.ContactUs')
            ->with([
                'name'          => $this->name,
                'email'         => $this->email,
                'phone'         => $this->Phone,
                'contreason'    => $this->contreason,
            ]);
    }
}
