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

class TestDevController extends Controller
{
    /**
     * 米のストック管理用.
     *get_riz_stock_data
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stock_email()
    {
        Log::debug('『開発中』米のストック管理20時');
        $today = (new DateTime())->format('Y-m-d');
        // [食材消費量] Curl https通信＿SSL エラー回避
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            'store' => "main",
            'date' => $today,
        ]);
        $collections = collect($response->json());

        // Rizの消費量取得 [Start] 
        $startOfDay = (new DateTime('today'))->setTime(11, 0, 0);
        $endOfDay = (new DateTime('today'))->setTime(16, 0, 0);        
        $riz_grammes = AdminConcumedTools::get_riz_stock_data($collections,$startOfDay,$endOfDay);
        // Rizの消費量取得 [END]

        // Riz の閾値を超えたらアラートメール送信
        Log::debug('米 消費量:'.$riz_grammes); 
        if(Config::get('fumi_calc.riz_conso_alart') < $riz_grammes){
            // Mail 送信 OK 済
            // $subject ='Rice alert : conso '.$riz_grammes.' g';
            // $body = 'Veuillez vérifier le riz';
            // Mail::to('fumi.0000000@gmail.com')
            //     ->send(new SendinBlueDemoEmail($subject, $body));
            // Log::debug('[メール]送信しました。');            
            // //dd('取得範囲:'.$startOfDay.' - '.$endOfDay);
        }
        $str = 'test str';
        return view('welcome', compact('str'));
    }

}
