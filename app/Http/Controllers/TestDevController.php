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
use App\FumiLib\FumiValidation;
use App\FumiLib\AdminConcumedTools;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
use App\Models\ConditionType;
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use App\Models\StockCuisineMain;

use Carbon\Carbon;

class TestDevController extends Controller
{
    
    /**
     * ディナープレパレリスト表示. Aichaとアンドレア用
     * Udon は VIEWで固定表示 / 米とブイヨンはアイシャの入力値から計算
     * Aicha top page リンクから
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function preparer_diner(){

        // 曜日を取得 Fumi 独自クラスインスタンス化 
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));
        // select ボックス要素作成
        $mode_inserts = $this->get_select_values('mode_inserts');

        // Aicha 15時 入力データ取得 / flg= 3
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('3', '7'); 
        \Session::flash('stock_ingredients', $stock_ingredients);

        /**
         * Satoの手動指示がある場合は優先表示
         * flg 6:  上書き
         */
        $date_today = date_create()->format('Y-m-d');   
        $sato_record = SatoInstruction::where('flg_int', 6)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();

        $sato_text_flg = false;
        $sato_text_mode = 0;
        if(! empty($sato_record)){
            // 6:上書き
            $sato_text_mode = $sato_record->flg_int;
            //サト指示有の為 表示
            $sato_text_flg = true;
            \Session::flash('sato_record', $sato_record);
            \Session::flash('sato_text_mode', $sato_text_mode);

            // 上書きの時は強制的に表示
            if($sato_text_mode == 6){
                // View
                return view('preparer_diner',compact('daysoftheweek',
                    'sato_text_flg', 
                    'sato_record',
                    'mode_inserts',
                    'sato_text_mode'
            ));       
            }
        }

        // Aicha 入力データ取得 flg = 1
        // 7時間以内の最新レコード取得
        $hour_minus = 7;
        $stock_ingredient = StockIngredient::where('flg1', 1)
            ->where('registre_datetime', '>=', Carbon::now()->subHours($hour_minus))
            ->orderBy('registre_datetime', 'desc')
            ->first();

        // stock_recordが無い場合は以降するーしてviewをゲット
        $display_stock_flg = true;
        if(empty($stock_ingredient)){
            //アイシャがデータ登録忘れの為エラーメッセージ表示
            $display_stock_flg = false;

            // [処理終了]
            return view('preparer_diner',
                compact('daysoftheweek',
                        'stock_ingredient', 
                        'display_stock_flg', 
                        'sato_text_flg', 
                        'sato_record',
                        'mode_inserts',
                    ));
        }

        // Aicha入力データ取得
        $aicha_udon_rest_15h = (int)$stock_ingredient->udon_rest_15h;
        $aicha_riz = (int)$stock_ingredient->article1_rest;
        $aicha_bouillons = (int)$stock_ingredient->article2_rest;


        /**
         * サト指示 flg = 7(aicha) / 8(andorea) 
         * 追加
         */
        $sato_record_aicha = SatoInstruction::where('flg_int', 7)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();
        $sato_record_andrea = SatoInstruction::where('flg_int', 8)
        ->where('aply_date', $date_today)
        ->latest('updated_at')
        ->first();

        // udonの切る数を取得
        // PlanProduction テーブルUDON設定値を取得 15時アイシャ指示 Mix用 [ID] 
        $plan_production = PlanProduction::where('id',6)->first();

        // View
        return view('preparer_diner',compact('daysoftheweek',
            'stock_ingredient', 
            'display_stock_flg', 
            'sato_text_flg', 
            'sato_record',
            'aicha_udon_rest_15h',
            'aicha_riz',
            'aicha_bouillons',
            'mode_inserts',
            'sato_text_mode',
            'sato_record_aicha',
            'sato_record_andrea',
            'plan_production'
        ));
    }

    /**
     * サト指示こと付け登録 Page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addnote_diner_page(Request $request)
    {
        // select ボックス要素作成
        $mode_inserts = $this->get_select_values('mode_inserts');
        return view('preparer_diner_addnote',compact('mode_inserts'));
    } 

    /**
     * ディナー サト指示こと付け登録
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addnote_diner(Request $request)
    {
        // Post データ取得
        $inputs = $request->only(['note8h', 'note_date', 'mode_inserts_list']);
        $mode_insert = $inputs['mode_inserts_list'];

        // Sessionにデータ保持
        \Session::flash('note8h', $inputs['note8h']);
        \Session::flash('note_date', $inputs['note_date']);
        \Session::flash('mode_insert_now', $mode_insert);

        /**
         * Table作るの面倒だからサト指示テーブルを使う
         * flg 6 / 7(Aicha) / 8(andrea):  サト指示追加情報
         * 朝 買物用
         */               
        $sato_instruction = SatoInstruction::updateOrCreate(
            [
                'aply_date' => $inputs['note_date'],
                'flg_int' => $mode_insert
            ],
            [
                'override_tx_1' => $inputs['note8h'],
            ]
         );

        // select ボックス要素作成
        $mode_inserts = $this->get_select_values('mode_inserts');
        return view('preparer_diner_addnote',compact('sato_instruction', 'mode_inserts'));
    } 
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
        $today = (new DateTime())->format('Y-m-d');
   
        // 画面表示用にプルダウンのnameを格納した連想配列を作成 start
        // * [使用法] 
        // * 1.stock_ingredientsの表示対象のモデルデータを渡す
        // * 2.プルダウン集にプルダウンデータを追加 
        // * 3.articles_by_tableの数をプルダウンの数と一致させる

        // 表示対象モデルデータ
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('2', '7');

        // プルダウン集 select ボックス要素作成
        $chashus = $this->get_select_values('chashus');
        $paikos = $this->get_select_values('paikos');
        $poulet_crus = $this->get_select_values('poulet_crus');
        $laits = $this->get_select_values('laits');
        $rizs = $this->get_select_values('rizs');
        $pulldowns = [$chashus, $paikos, $poulet_crus, $laits, $rizs];
        
        // stock_ingredientテーブルのカラム名 
        $columun_names = ["chashu", "paiko", "poulet_cru", "lait", "riz"];        
        $stock_ingredients_display = FumiTools::get_display_datas($stock_ingredients, $pulldowns, $columun_names);
        // 表示用にプルダウンのnameを格納した連想配列を作成 end

        \Session::flash('stock_ingredients', $stock_ingredients);

        return view('stock_close_input', compact('today','paikos','poulet_crus', 'laits', 'rizs', 'stock_ingredients', 'stock_ingredients_display'));
    }

    /**
     * アイシャの買物リスト
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function preparer_matin()
    {
        $today = (new DateTime())->format('Y-m-d');

        // select ボックス要素作成
        $rizs = $this->get_select_values('rizs');

        /**
         * Satoの手動指示がある場合は優先表示
         * Aichaプレパレ用は　flg = 5
         * 
         */       
        $sato_instruction = SatoInstruction::where([
            //AMの指示を取得
            ['flg_int', '=', '5'],
            ['aply_date', '=', $today]
        ])->first();

        $yes_sato = false;
        if(! is_null($sato_instruction)){
            // サトの独自指示がある場合は viewをgetして処理終了
            $yes_sato = true;
        }
        /**
         * Aicha 入力米データ表示 / flg= 3
         * Sessionにデータ保持
         */
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('3', '7'); 
        \Session::flash('stock_ingredients', $stock_ingredients);

        return view('preparer_matin', compact('today','rizs','sato_instruction','yes_sato'));
    }
    
    /**
     * 朝 プレパレリスト表示
     * Aichaプレパレ用は　flg = 5
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function preparer_list(Request $request)
    {
        // Post データ取得
        $attributes = $request->only(['rizs_list', 'actual_page_id']);

        $req_riz = $attributes['rizs_list'];
        // Sessionにデータ保持
        \Session::flash('riz_now', $req_riz);
        $today = date_create()->format('Y-m-d'); 

        //req_rizをデータベース挿入
        $stock_ingredient = StockIngredient::updateOrCreate(
            [
                'registre_date' => date('Y-m-d'),
                'flg1' => 3
            ],
            [
                'riz' => $req_riz,
                'registre_date' => date('Y-m-d'),
                'registre_datetime' => now(),
                // error回避：ダミーデータ挿入
                'udon_rest_15h' => 88,
            ]
        );

        /**
         * Satoの手動指示がある場合は優先表示
         * flt 5
         */               
        $sato_instruction = SatoInstruction::where([
            //AMのプレパレ指示を取得
            ['flg_int', '=', '5'],
            ['aply_date', '=', $today]
        ])->first();
        $yes_sato = false;
        if(! is_null($sato_instruction)){
            // サトの独自指示がある
            $yes_sato = true;
        }

        /**
         * Aicha 入力米データ表示 / flg= 3
         */
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('3', '7');
        // Sessionにデータ保持
        \Session::flash('stock_ingredients', $stock_ingredients);

        // select ボックス要素作成
        $rizs = $this->get_select_values('rizs');
        return view('preparer_matin', compact('today','req_riz','rizs','sato_instruction','yes_sato'));
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
        // 閉店時ビレル入力データ登録
        // ※ 'flg1' => 2
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

        // 画面表示用にプルダウンのnameを格納した連想配列を作成 start
        $stock_ingredients_display = $this->get_stock_display_flg2();
        // 表示用にプルダウンのnameを格納した連想配列を作成 end

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
            return view('courses_matin',compact('stock_ingredients','sato_text_flg', 'sato_record', 'stock_ingredients_display'));
        }

        // ビレル入力データ取得 flg = 2
        // 14時間以内の最新レコード取得 (月曜日の場合は日曜日を考慮)
        $hour_minus = 14;
        if($daysoftheweek = 'mon'){$hour_minus = $hour_minus + 30;}
        $stock_record = StockIngredient::where('flg1', 2)
            ->where('registre_datetime', '>=', Carbon::now()->subHours($hour_minus))
            ->orderBy('registre_datetime', 'desc')
            ->first();

        // stock_recordが無い場合は以降するーしてviewをゲット
        if(empty($stock_record)){
            //ビレルがデータ登録忘れの為エラーメッセージ表示
            $st_flg = 2;
            return view('courses_matin',compact('stock_ingredients', 'stock_ingredients_display'))->with(['表示ステータス: ' => $st_flg]);
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
        // validation
        FumiValidation::checkInteger($bilel_paiko, 'bilel_paiko'.': '.$bilel_paiko);

        /**
         * 鶏肉購入枚数 
         */ 
        // paiko        
        $paiko_base = $paiko_plan_production->$daysoftheweek;
        // Bilelパイコーの数字を計算用に変換（プルダウンのIDを変えたので残量と一致しない）        
        $paikos_for_calc = $this->get_select_values('paikos_for_calc');
        $rest_paiko = $paikos_for_calc->where('id', $bilel_paiko)->pluck('name')->first();
        $inox_requis = (int)$paiko_base - $rest_paiko;
        // 負の場合は0に設定
        $inox_requis = ($inox_requis < 0) ? 0 : $inox_requis;
        $result_paiko = $inox_requis * 4;  // inoxボックス1個は鶏肉4枚相当

        // chashu
        $chashu_base = $chashu_plan_production->$daysoftheweek;
        $result_chashu = (int)$chashu_base - $bilel_chashu;
        // 負の場合は0に設定
        $result_chashu = ($result_chashu < 0) ? 0 : $result_chashu;

        // poulet cru
        $poulet_cru_base = $poulet_cru_plan_production->$daysoftheweek;
        $result_poulet_cru = (int)$poulet_cru_base - $bilel_poulet_cru;
        // 負の場合は0に設定
        $result_poulet_cru = ($result_poulet_cru < 0) ? 0 : $result_poulet_cru;

        // 鶏の購入枚数を計算
        $courses_poulet = $result_paiko + $result_chashu + $result_poulet_cru;

        // [牛乳] 入力データが2以下の場合は4pac購入依頼
        // bladeテンプレートで巻き取る

        // りんご買うかどうか？ ホルートの朝の入力値を見る
        $stock_cuisine_main = StockCuisineMain::select('apple')
        ->where('shop', '=', 'bn') // 最初の条件
        ->where('page_id', '=', 'khouloud_commence_input') // 条件
        ->where('fuseaux', '=', 'am')   // 条件
        ->orderBy('created_at', 'desc') // 'created_at' カラムを降順にソート
        ->first();        

        // 表示ステータス 通常指示表示
        return view('courses_matin',compact('stock_cuisine_main', 'stock_record','courses_poulet','bilel_lait', 'stock_ingredients', 'stock_ingredients_display'))->with(['表示ステータス: ' => 0]);
    }

    /**
     * ディスプレイ用データ取得
     * 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_stock_display_flg2(){
        // 画面表示用にプルダウンのnameを格納した連想配列を作成 start
        // * [使用法] 
        // * 1.stock_ingredientsの表示対象のモデルデータを渡す
        // * 2.プルダウン集にプルダウンデータを追加 
        // * 3.articles_by_tableの数をプルダウンの数と一致させる

        // 表示対象モデルデータ
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('2', '14');

        // プルダウン集 select ボックス要素作成
        // select ボックス要素作成
        $chashus = $this->get_select_values('chashus');
        $paikos = $this->get_select_values('paikos');
        $poulet_crus = $this->get_select_values('poulet_crus');
        $laits = $this->get_select_values('laits');
        $rizs = $this->get_select_values('rizs');
        $pulldowns = [$chashus, $paikos, $poulet_crus, $laits, $rizs];
        
        // stock_ingredientテーブルのカラム名
        $columun_names = ["chashu", "paiko", "poulet_cru", "lait", "riz"];     
        $stock_ingredients_display = FumiTools::get_display_datas($stock_ingredients, $pulldowns, $columun_names);
        // 表示用にプルダウンのnameを格納した連想配列を作成 end

        return $stock_ingredients_display;
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
    /**
     * プレパレ こと付け登録
     * 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addnote_preparer(Request $request)
    {
        // Post データ取得
        $inputs = $request->only(['note8h', 'note_date']);
        // Sessionにデータ保持
        \Session::flash('note8h', $inputs['note8h']);
        \Session::flash('note_date', $inputs['note_date']);
        //$date_today = date_create()->format('Y-m-d'); 

        /**
         * Table作るの面倒だからサト指示テーブルを使う
         * flg_int 5
         * 朝 買物用
         */               
        $sato_instruction = SatoInstruction::updateOrCreate(
            [
                'aply_date' => $inputs['note_date'],
                'flg_int' => 5
            ],
            [
                'override_tx_1' => $inputs['note8h'],
            ]
         );
        // select ボックス要素作成
        $rizs = $this->get_select_values('rizs');
        return view('preparer_matin',compact('sato_instruction', 'rizs'));
    }
    /**
     * select values
     * 追加：　　mode_inserts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_select_values($s_id){

            if($s_id == 'rizs'){
                // select ボックス要素作成
                $rizs = collect([
                    ['id' => '', 'name' => ''],
                    ['id' => '0', 'name' => 'rien'],
                    ['id' => '1', 'name' => 'moins que la moitié'],
                    ['id' => '2', 'name' => 'la moitié'],
                    ['id' => '3', 'name' => '1 casserole'],
                    ['id' => '4', 'name' => '1 casserole et demi'],
                    ['id' => '5', 'name' => '2 casserole'],
                    ['id' => '6', 'name' => '2 casseroles et demi'],
                    ['id' => '7', 'name' => 'plus de 3 casseroles'],
                ]);
                return $rizs;
            }

        if($s_id == 'chashus'){
            // select ボックス要素作成
            $chashus = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => '0'],
                ['id' => '1', 'name' => '1'],
                ['id' => '2', 'name' => '2'],
                ['id' => '3', 'name' => '3'],
                ['id' => '4', 'name' => '4'],
                ['id' => '5', 'name' => '5'],
                ['id' => '6', 'name' => '6'],
                ['id' => '7', 'name' => '7'],
            ]);
            return $chashus;
        }

        if($s_id == 'paikos'){
            // select ボックス要素作成
            $paikos = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => '0'],
                ['id' => '1', 'name' => '1 paquet'],
                ['id' => '2', 'name' => '1 paquet et demi'],
                ['id' => '3', 'name' => '2 paquets'],
                ['id' => '4', 'name' => '2 paquets et demi'],
                ['id' => '5', 'name' => '3 paquets'],
                ['id' => '6', 'name' => '3 paquets et demi'],
                ['id' => '7', 'name' => '4 paquets'],
                ['id' => '8', 'name' => '4 paquets et demi'],
                ['id' => '9', 'name' => '5 paquets'],
                ['id' => '10', 'name' => '5 paquets et demi'],
                ['id' => '11', 'name' => '6 paquets'],
                ['id' => '12', 'name' => '6 paquets et demi'],
                ['id' => '13', 'name' => '7 paquets'],
                ['id' => '99', 'name' => 'plus que 7 paquets'],
            ]);
            return $paikos;
        }

        if($s_id == 'paikos_for_calc'){
            // select ボックス要素作成
            $paikos_for_calc = collect([
                ['id' => 0, 'name' => 0],
                ['id' => 1, 'name' => 1],
                ['id' => 2, 'name' => 1.5],
                ['id' => 3, 'name' => 2],
                ['id' => 4, 'name' => 2.5],
                ['id' => 5, 'name' => 3],
                ['id' => 6, 'name' => 3.5],
                ['id' => 7, 'name' => 4],
                ['id' => 8, 'name' => 4.5],
                ['id' => 9, 'name' => 5],
                ['id' => 10, 'name' => 5.5],
                ['id' => 11, 'name' => 6],
                ['id' => 12, 'name' => 6.5],
                ['id' => 13, 'name' => 7],
                ['id' => 99, 'name' => 99],
            ]);
            return $paikos_for_calc;
        }

        if($s_id == 'poulet_crus'){
            // select ボックス要素作成
            $poulet_crus = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => 'moyen'],
                ['id' => '2', 'name' => 'beaucoup'],
            ]);
            return $poulet_crus;
        }

        if($s_id == 'laits'){
            // select ボックス要素作成
            $laits = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => '1 ～ 3 paquets'],
                ['id' => '4', 'name' => 'plus que 4 paquets'],
            ]);
            return $laits;
        }

        if($s_id == 'mode_inserts'){
            // select ボックス要素作成
            $mode_inserts = collect([
                ['id' => '', 'name' => ''],
                ['id' => '6', 'name' => '上書き更新'],
                ['id' => '7', 'name' => '追加_TO_Aicha'],
                ['id' => '8', 'name' => '追加_TO_アンドレア'],
            ]);
            return $mode_inserts;
        }
    }

    /**
     * [開発].
     * send mail
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dev_send_email(){
            // Mail 送信 処理
            $subject ='TEST FUMI : Mail';
            $body = 'できんじゃーーん';
            Mail::to('admin@bistronippon.tn')
                ->cc(['fumi.0000000@gmail.com'])
                ->send(new SendinBlueDemoEmail($subject, $body));
                 logger()->info('[FUMI dev] メール送信しました。');

                // Mail送信 済/未 判定レコードを作成
    }
}
