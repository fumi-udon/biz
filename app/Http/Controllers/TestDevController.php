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
     * get_riz_stock_data
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

        // 基準以下の場合はメールを送信
        // 今日の日付を取得
        $today = Carbon::today();
        // 今日の日付のレコードをカウント
        $count = ConditionType::whereDate('created_at', $today)->count();
        $riz_dline = 0;
        if ($count === 0) {
            // 未送信
            $riz_dline = Config::get('fumi_calc.riz_conso_alart');
            // 閾値を超えたらメール送信して db挿入
            $this->send_mail_db_reg($riz_dline, $riz_grammes,1);
        }else if($count === 1){
            // 1回のみ送信済
            $riz_dline = Config::get('fumi_calc.riz_conso_alart_2');
            // 閾値を超えたらメール送信して db挿入
            $this->send_mail_db_reg($riz_dline, $riz_grammes,2);
        }else if($count > 1){
            // 2回送信済
            logger()->info('[Win_タスクスケジューラ] 処理無し 2回送信済');
        }

        logger()->info('[Win_タスクスケジューラ] 設定値 / 消費量 : '.$riz_dline.' g / '.$riz_grammes.' g');
        logger()->info('[Win_タスクスケジューラ] 範囲 : '.$startOfDayString.'  - '.$endOfDayString);

        return view('dinner_stock', compact('startOfDayString','endOfDayString','riz_dline','riz_grammes','count'));
    }

    /**
     * 米の量閾値判定
     * 
     * 閾値を超える場合はMail 送信処理　DB レコード登録処理
     */
    public function send_mail_db_reg($riz_dline, $riz_grammes, $fois)
    {
        if($riz_dline < $riz_grammes){
            // Mail 送信 処理
            $subject ='Rice alert : consomation '.$riz_grammes.' g _ '.$fois.'回目';
            $body = 'dead line:'.$riz_dline.' g';
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
    }
}
