<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class UpdateRankingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rankings';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ambassadors = User::ambassadors()->get();
        $bar = $this->output->createProgressBar($ambassadors->count());
        $bar->start();
        $ambassadors->each(function(User $user) use ($bar) {
            Redis::zadd('rankings', (int)$user->revenue, $user->name);
            $bar->advance();
        });
        $bar->finish();
        echo "\n";
    }
}
