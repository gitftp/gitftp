<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'My Testing command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('cron')->info(new \Exception('asd'));
    }
}
