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
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
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

    /**
     * Gestion page.
     * stock_close_input
     * ビレルが閉店時に入力
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stock_close_input()
    {
        // ovh cron setting 
        //logger()->info('[Win_タスクスケジューラ] handle() _ 米のストック管理');
        $today = (new DateTime())->format('Y-m-d');
        // // [食材消費量] Curl https通信＿SSL エラー回避
        // $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
        //     'store' => "main",
        //     'date' => $today,
        // ]);
        // $collections = collect($response->json());

        // input create
        // select ボックス要素作成
        $paikos = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '1.5', 'name' => '1.5'],
            ['id' => '2', 'name' => '2'],
            ['id' => '2.5', 'name' => '2.5'],
            ['id' => '3', 'name' => '3'],
            ['id' => '3.5', 'name' => '3.5'],
            ['id' => '4', 'name' => '4'],
            ['id' => '4.5', 'name' => '4.5'],
            ['id' => '5', 'name' => '5'],
            ['id' => '5.5', 'name' => '5.5'],
            ['id' => '6', 'name' => '6'],
            ['id' => '6.5', 'name' => '6.5'],
            ['id' => '7', 'name' => '7'],
        ]);
        $poulet_crus = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => 'rien'],
            ['id' => '1', 'name' => 'moyen'],
            ['id' => '2', 'name' => 'beaucoup'],
        ]);

        $laits = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => 'rien'],
            ['id' => '1', 'name' => '1 ～ 3 paquets'],
            ['id' => '4', 'name' => 'plus que 4 paquets'],
        ]);

        // select ボックス要素作成
        $rizs = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
            ['id' => '6', 'name' => '6'],
            ['id' => '7', 'name' => '7'],
            ['id' => '8', 'name' => '8'],
            ['id' => '9', 'name' => '9'],
            ['id' => '10', 'name' => '10'],
        ]);
        $session__all = \Session::all();
        Log::debug($session__all);

        return view('stock_close_input', compact('today','paikos','poulet_crus', 'laits', 'rizs'));
    }

    /**
     * Bilel 閉店時登録ページ 登録処理
     * Detabase登録処理
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stock_close_store(Request $request, $id=null, $params=null)    {

        $inputs = $request->all();

        // リクエストデータ取得 
        $req_chashu = intval($inputs['chashu']);
        $req_paiko = floatval($inputs['paikos_list']);
        $req_poulet_cru = intval($inputs['poulet_crus_list']);
        $req_riz = intval($inputs['rizs_list']);
        $req_laits = intval($inputs['laits_list']);

        //dd($inputs);
        // StockIngredient テーブル
        date_default_timezone_set('Africa/Tunis');
        $stock_ingredient = StockIngredient::updateOrCreate(
            [
                'registre_date' => date('Y-m-d'),
                'flg1' => 2
            ],
            [
                'chashu' => $req_chashu,
                'paiko' => $req_paiko,
                'poulet_cru' => $req_poulet_cru,
                'riz' => $req_riz,
                'lait' => $req_laits,
                'registre_date' => date('Y-m-d'),
                'registre_datetime' => now(),
                // error回避：ダミーデータ挿入
                'udon_rest_15h' => 99,
            ]
        );

        // session 格納
        \Session::flash('flash_message', 'MERCI Bilel! <br>Les données sont envoyées correctement'.'<br><br>Je voudrais refaire _ <a href="/stock_close_input"> oui </a>'
        );

        // リダイレクト
        return redirect()->route('stock.close.input')->with([
            //画面引継ぎsession格納
            'chashu' => $req_chashu,
            'paiko_now' => $req_paiko,
            'poulet_cru_now' => $req_poulet_cru,
            'riz_now' => $req_riz,
            'lait_now' => $req_laits
            ]);
    }

    /**
     * 朝の買物リスト表示.
     * courses pour le matin リンクから
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function courses_matin()    {

        // Fumi 独自クラスインスタンス化
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));

        /**
         * Bilel入力データ表示
         */
         // 2週間以内のデータ取得
         $stock_ingredients = StockIngredient::where('flg1', 2)
            ->where('registre_datetime', '>=', Carbon::now()->subDays(14))
            ->orderBy('registre_datetime', 'desc')
            ->get();

        /**
         * Satoの手動指示がある場合は優先表示
         * 朝の買物用は flg 4 / flg 3はアリス
         */
        $date_today = date_create()->format('Y-m-d');   
        $sato_record = SatoInstruction::where([
            ['flg_int', '=', '4'],
            ['aply_date', '=', $date_today]
        ])->first();

        if(! empty($sato_record)){
            //dd($sato_record);
            //サト指示有の為 表示
            $sato_text_flg = 1;
            \Session::flash('sato_record', $sato_record);
            return view('courses_matin',compact('stock_ingredients','sato_text_flg', 'sato_record'));
        }

        // ビレル入力データ取得 flg = 2
        // 14時間以内の最新レコード取得 (月曜日の場合は日曜日を考慮)
        $hour_minus = 14;
        if($daysoftheweek = 'mon'){$hour_minus = $hour_minus + 24;}
        $stock_record = StockIngredient::where('flg1', 2)
            ->where('registre_datetime', '>=', Carbon::now()->subHours($hour_minus))
            ->orderBy('registre_datetime', 'desc')
            ->first();

        // stock_recordが無い場合は以降するーしてviewをゲット
        if(empty($stock_record)){
            //ビレルがデータ登録忘れの為エラーメッセージ表示
            $st_flg = 2;
            return view('courses_matin',compact('stock_ingredients'))->with(['表示ステータス: ' => $st_flg]);
        }

        // PlanProduction テーブルから基準データ取得 (パイコー、チャーシュー、生の鶏肉)
        $paiko_plan_production = PlanProduction::where([
            // パイコーデータ　id = 3
            ['id', '=', '3']
        ])->first();

        $chashu_plan_production = PlanProduction::where([
            // チャーシューデータ　id = 4
            ['id', '=', '4']
        ])->first();

        $poulet_cru_plan_production = PlanProduction::where([
            // 生の鶏肉データ　id = 5
            ['id', '=', '5']
        ])->first();

        // Bilel入力データ取得
        $bilel_chashu = $stock_record->chashu;
        $bilel_paiko = $stock_record->paiko;
        $bilel_poulet_cru = $stock_record->poulet_cru;
        $bilel_riz = $stock_record->riz;
        $bilel_lait = (int)$stock_record->lait;

        /**
         * 鶏肉購入枚数
         */
        // paiko
        $paiko_base = $paiko_plan_production->$daysoftheweek;
        $inox_requis = (int)$paiko_base - $bilel_paiko;
        $result_paiko = $inox_requis * 4;  // inoxボックス1個は鶏肉4枚相当
        // chashu
        $chashu_base = $chashu_plan_production->$daysoftheweek;
        $result_chashu = (int)$chashu_base - $bilel_chashu;
        // poulet cru
        $poulet_cru_base = $poulet_cru_plan_production->$daysoftheweek;
        $result_poulet_cru = (int)$poulet_cru_base - $bilel_poulet_cru;
        // 鶏の購入枚数を計算        
        $courses_poulet = $result_paiko + $result_chashu + $result_poulet_cru;

        // [牛乳] 入力データが2以下の場合は4pac購入依頼
        // bladeテンプレートで巻き取る

        // 表示ステータス 通常指示表示
        return view('courses_matin',compact('stock_record','courses_poulet','bilel_lait', 'stock_ingredients'))->with(['表示ステータス: ' => 0]);
    }
    /**
     * 朝 こと付け登録
     * 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addnote_courses(Request $request)
    {
        // Post データ取得
        $inputs = $request->only(['note8h', 'note_date']);
        // Sessionにデータ保持
        \Session::flash('note8h', $inputs['note8h']);
        \Session::flash('note_date', $inputs['note_date']);
        //$date_today = date_create()->format('Y-m-d'); 

        /**
         * Table作るの面倒だからサト指示テーブルを使う
         * flg_int 4
         * 朝 買物用
         */               
        $sato_instruction = SatoInstruction::updateOrCreate(
            [
                'aply_date' => $inputs['note_date'],
                'flg_int' => 4
            ],
            [
                'override_tx_1' => $inputs['note8h'],
            ]
         );
        return view('courses_matin',compact('sato_instruction'));
    }
}
