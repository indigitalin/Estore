<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunQueue extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run queue work and stop when jobs are finished.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        \Artisan::call('queue:work --stop-when-empty');
        $this->info('All queues processed successfully.');
        return 0;
    }
}
