<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReduceEstitence extends Command
{
    protected $signature = 'landini:reduce-estitence {amount=1}';

    protected $description = 'Reduces Estitence of all characters by specified value';

    public function handle()
    {
        \App\Jobs\ReduceEstitence::dispatchNow($this->argument('amount'));

        return Command::SUCCESS;
    }
}
