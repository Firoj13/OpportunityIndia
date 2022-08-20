<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

class SolrDeltaImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solr:deltaimport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync delta database changes to solr.';

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
        
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://localhost:8983/solr/brands/dataimport?indent=on&wt=json',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_VERBOSE=> 0,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'command=delta-import&verbose=false&clean=false&commit=true&core=brands&name=dataimport',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $this->info($response);
    }
}