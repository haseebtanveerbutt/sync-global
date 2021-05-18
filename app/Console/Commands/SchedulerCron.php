<?php

namespace App\Console\Commands;

use App\Jobs\SchedulerJob;
use App\Scheduler;
use Illuminate\Console\Command;

class SchedulerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Scheduler:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler cron job to import products from csv url';

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
        $schedulers=Scheduler::get();
        foreach ($schedulers as $scheduler) {
            SchedulerJob::dispatch($scheduler)->delay(30);
        }
    }
}
