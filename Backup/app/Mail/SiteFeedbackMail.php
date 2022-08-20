<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiteFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $Phone;
    protected $feedbackTopic;
    protected $feedback;
    protected $site;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->name           = $details['name'];
        $this->email          = $details['email'];
        $this->Phone          = $details['mobile'];
        $this->feedbackTopic  = $details['feedback_topic'];
        $this->feedback       = $details['feedback'];
        $this->site           = $details['site'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@franchiseindia.com')
            ->bcc('techsupport@franchiseindia.net')
            ->subject('Site Feedback - Opportunityindia.FranchiseIndia.com')
            ->view('frontend.mail.sitefeedback')
            ->with([
                'name'          => $this->name,
                'email'         => $this->email,
                'phone'         => $this->Phone,
                'feedbackTopic' => $this->feedbackTopic,
                'feedback'      => $this->feedback,
                'site'          => $this->site
            ]);
    }
}
