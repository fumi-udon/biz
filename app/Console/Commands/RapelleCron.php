<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする
use Illuminate\Support\Collection;

// Mail 送信用
use Illuminate\Support\Facades\Mail;
use App\Mail\SendinBlueDemoEmail;
use App\FumiLib\AdminConcumedTools;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
//Fumi 独自クラス
use App\FumiLib\FumiTools;
// Model
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use Carbon\Carbon;

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
        // Fumi 独自クラスインスタンス化
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));
         
        // ビレル入力データ取得 flg = 2
        // 2時間以内の最新レコード取得 (月曜日の場合は日曜日を考慮)
        $hour_minus = 1;
        if($daysoftheweek = 'mon'){$hour_minus = $hour_minus + 24;}
        $stock_record = StockIngredient::where('flg1', 2)
            ->where('registre_datetime', '>=', Carbon::now()->subHours($hour_minus))
            ->orderBy('registre_datetime', 'desc')
            ->first();

        // stock_recordが無い場合は以降するーしてviewをゲット
        $forget = false;
        if(empty($stock_record)){
            //ビレルがデータ登録忘れ
            $forget = true;
        }

        if($forget){
            // // Mail 送信 OK 済
            $subject ='BistroNippon: Bilel forget alart';
            $body = '閉店時の在庫チェック忘れ。ingrédients à la fermeture';
            Mail::to('fuminippon@outlook.com')
                ->cc(['satoe1227@gmail.com'])
                ->send(new SendinBlueDemoEmail($subject, $body));       
            logger()->info('TODO [FUMI_cron] Bilel forget Alartメール実装');
        }

        return 0;
    }
}
