<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class RapelleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rapelle:do';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'FUMI _ Cron: Bilelにリマインド ';

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
        logger()->info('This is FUMI s RapelleCron.');
        return 0;
    }
}
