<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Brand;
use App\Models\BrandMembership;

class BrandActivation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:ActivateMembership';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change weightage of brand based on active membership.';

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
        
        //Deactivate
        $packages=BrandMembership::where('expiry_date',date('Y-m-d'))
        ->get();
        foreach($packages as $package){
            Brand::where('brand_id',$package->brand_id)->update(['weightage'=>'899']); 
        } 

        //Asctivate
        $packages=BrandMembership::where('activation_date',date('Y-m-d'))
        ->get();
        foreach($packages as $package){            
            Brand::where('brand_id',$package->brand_id)->update(['weightage'=>$package->plan->membership->weightage]); 
        }    

            
        $this->info('Done.');
    }
}