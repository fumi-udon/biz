<?php

namespace App\Console\Commands;

//お掃除テーブル
use App\Models\StockIngredient;
use App\Models\SatoInstruction;

use Illuminate\Support\Facades\Log;
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
        logger()->info('[FUMI_cron] table clean up (一年前以前のデータを削除).');

        // // table clean up (一年前以前のデータを削除)
        $deleteDate = date("Y-m-d", strtotime("-1 year"));
        $deleteRecords = StockIngredient::where('registre_date', '<=', $deleteDate)->get();
        foreach($deleteRecords as $deleteRecord) {
            $deleteRecord->delete();
        }

        $deleteRecords = SatoInstruction::where('aply_date', '<=', $deleteDate)->get();
        foreach($deleteRecords as $deleteRecord) {
            $deleteRecord->delete();
        }  

        return 0;
    }
}
