<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする
use Illuminate\Support\Collection;

// Mail 送信用
use Illuminate\Support\Facades\Mail;
use App\Mail\SendinBlueDemoEmail;
use App\FumiLib\AdminConcumedTools;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;

class DinnerStockManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dinnerstock:manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command dinner stock management ';

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
        // ovh cron setting 
        logger()->info('[FUMI_cron] handle() _ 米のストック管理');
        $today = (new DateTime())->format('Y-m-d');
        // [食材消費量] Curl https通信＿SSL エラー回避
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            'store' => "main",
            'date' => $today,
        ]);
        $collections = collect($response->json());

        // Rizの消費量取得 [Start]
        $startOfDay = (new DateTime('today'))->setTime(17, 00, 0);
        $startOfDayString = $startOfDay->format('Y-m-d H:i:s');
        $endOfDay = (new DateTime('today'))->setTime(23, 0, 0);
        $endOfDayString = $endOfDay->format('Y-m-d H:i:s');
        $riz_grammes = AdminConcumedTools::get_riz_stock_data($collections,$startOfDay,$endOfDay);
        // Rizの消費量取得 [END]

        // 2 
        // 基準以下の場合はメールを送信
        // Riz の閾値を超えたらアラートメール送信 
        $riz_dline = Config::get('fumi_calc.riz_conso_alart');
        logger()->info('[FUMI_cron] 設定値 / 消費量 : '.$riz_dline.' g / '.$riz_grammes.' g');
        logger()->info('[FUMI_cron] 範囲 : '.$startOfDayString.'  - '.$endOfDayString);
        if($riz_dline < $riz_grammes){
            // Mail 送信 OK 済
            $subject ='Rice alert : consomation '.$riz_grammes.' g';
            $body = 'Veuillez vérifier le riz'.'  設定値 / 消費量 : '.$riz_dline.' g / '.$riz_grammes.' g';
            Mail::to('fuminippon@outlook.com')
                ->cc(['satoe1227@gmail.com'])
                ->send(new SendinBlueDemoEmail($subject, $body));       
            logger()->info('[FUMI_cron] メール送信しました。');
        }

        return 0;
    }
}
