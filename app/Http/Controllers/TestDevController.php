<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする
use Illuminate\Support\Collection;

// Mail 送信用
use Illuminate\Support\Facades\Mail;
use App\Mail\SendinBlueDemoEmail;
//Fumi 独自クラス
use App\FumiLib\FumiTools;
use App\FumiLib\AdminConcumedTools;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
use App\Models\ConditionType;
use Carbon\Carbon;

class TestDevController extends Controller
{
    /**
     * 米のストック管理用.
     *get_riz_stock_data
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stock_email()
    {
        // ovh cron setting 
        logger()->info('[Win_タスクスケジューラ] handle() _ 米のストック管理');
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
        logger()->info('[Win_タスクスケジューラ] 設定値 / 消費量 : '.$riz_dline.' g / '.$riz_grammes.' g');
        logger()->info('[Win_タスクスケジューラ] 範囲 : '.$startOfDayString.'  - '.$endOfDayString);

        // メールは一度しか送信しない仕様
        // 今日の日付を取得
        $today = Carbon::today();
        // 今日の日付のレコードをカウント
        $count = ConditionType::whereDate('created_at', $today)->count();
        if ($count === 0) {
            // レコードが存在しない場合（メール未送信）
            if($riz_dline < $riz_grammes){
                // Mail 送信 処理
                $subject ='Rice alert : consomation '.$riz_grammes.' g';
                $body = 'Veuillez vérifier le riz'.'  設定値 / 消費量 : '.$riz_dline.' g / '.$riz_grammes.' g';
                Mail::to('fuminippon@outlook.com')
                    ->cc(['satoe1227@gmail.com'])
                    ->send(new SendinBlueDemoEmail($subject, $body));
                     logger()->info('[Win_タスクスケジューラ] メール送信しました。');

                    // Mail送信 済/未 判定レコードを作成
                    $data = [
                        'type' => 1,
                        'kubun' => 1,
                        'numero' => 1,
                        'color' => 'red',
                        'sub1' => 1,
                        'sub2' => 2,
                    ];    
                    ConditionType::create($data);
            }
        }else{
            logger()->info('[Win_タスクスケジューラ] メール送信済の為、処理終了');
        }

        return view('dinner_stock', compact('startOfDayString','endOfDayString','riz_dline','riz_grammes','count'));
    }
}
