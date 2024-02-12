<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCallLogJob;
use Illuminate\Console\Command;

class UpdateCallLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-call-log-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UpdateCallLogJob::dispatch();

        return Command::SUCCESS;
    }
}
