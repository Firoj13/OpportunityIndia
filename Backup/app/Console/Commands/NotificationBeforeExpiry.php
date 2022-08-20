<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Brand;
use App\Models\BrandMembership;
use App\Mail\LeadMail;
use Mail;

class NotificationBeforeExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:NotificationMembershipExpiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send membership expiry email notification before 14 days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }  

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $date = date("Y-m-d");// current date
	   $aftertwoweeks = strtotime(date("Y-m-d", strtotime($date)) . " +2 week");
       $memberships=BrandMembership::where('expiry_date',$aftertwoweeks)->get();
        foreach($memberships as $membership){
            $brand=Brand::where('brand_id',$membership->brand_id);
			print_r($brand->user);			
				try {
				//Mail::mailer('sparkpost')//sparkpost
				//->to($sender->email)
				//->send(new MembershipExpiry($data));
			    //print_r("Success");
			} catch (Exception $ex) {
			    // Debug via $ex->getMessage();
			    return response($this->status(401,true,"Email could not be sent Error:".$ex->getMessage()),401);
			}				
        } 
            
        $this->info('Done.');
    }
}