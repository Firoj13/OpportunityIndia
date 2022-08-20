<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Brand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\BrandActivation::class,
        Commands\SolrFullImport::class,
        Commands\SolrDeltaImport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('cron:ActivateMembership')->dailyAt('1:00');
		$schedule->command('cron:NotificationMembershipExpiry')->dailyAt('2:00');
        #$schedule->command('solr:deltaimport')->everyMinute();
        $schedule->command('solr:fullimport')->dailyAt('00:31');
        $schedule->command('solr:deltaimport')->hourly();
        $schedule->call('\App\Http\Controllers\SitemapController@index')->dailyAt('05:48')->timezone('Asia/Kolkata');
        $schedule->call('\App\Http\Controllers\SitemapController@rssfeed')->cron('0 */2 * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
