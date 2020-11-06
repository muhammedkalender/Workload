<?php

namespace App\Console\Commands;

use App\Facades\Service;
use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FeedJobsFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for feeding jobs table from from Apı';

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
        //TODO
        Service::driver('first-provider');
        Service::instance()->sendRequest();
        DB::table('jobs')->insert(Service::instance()->getMappedArray());

        Service::driver('second-provider');
        Service::instance()->sendRequest();
        DB::table('jobs')->insert(Service::instance()->getMappedArray());

        return 0;
    }
}
