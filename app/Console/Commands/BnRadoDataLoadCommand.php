<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BnRadoDataLoadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radodataload:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[FUMI_cron] Load Json datas from Rado server and insert to database';

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
     * Cron 設定したコマンド
     *
     * @return int
     */
    public function handle()
    {
        logger()->info('[FUMI_cron] 成功! This is Cron Command.');
        return 0;
    }
}
