<?php

namespace App\Console\Commands;

use App\ErrorLog;
use App\Jobs\SchedulerJob;
use App\Scheduler;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SchedulerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:daily';

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
        $new = new ErrorLog();
        $new->message = "testing testing";
        $new->save();
//        $schedulers=Scheduler::get();
//        $start = Carbon::now();
//
//        foreach ($schedulers as $scheduler) {
//            $job = new SchedulerJob($scheduler);
//            $job->delay($start->addSeconds(30));
//
//            dispatch($job);
//        }

    }
}
