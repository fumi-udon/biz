<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする
use Illuminate\Support\Collection;

//Fumi 独自クラス
use App\FumiLib\FumiTools;

use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
//model
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use App\Models\Finance;
use App\Models\AuthHanabishi;
use App\Models\Responsable;
use App\Models\StockAccessoire;
use App\Models\StockCuisineMain;

use Carbon\Carbon;

class JesserController extends Controller
{
    
    /**
     * 
     * ジェイセルトップページ
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jesser_top(){

        // 管理 支払い 実施日取得
        $effect_dates = $this->effectuer_day();

        /**
         * 入力データ表示
         * 'flg1' => xxxx TODO
         */
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('5', '14');

        \Session::flash('stock_ingredients', $stock_ingredients);
        
        return view('jesser_top', compact('stock_ingredients'));   
    }

    /**
     * 管理 支払い 実施日
     */
    public function effectuer_day(){

        // タイムゾーンを設定（例: アフリカのTunis）
        Carbon::setTestNow(Carbon::now()->tz('Africa/Tunis'));
        // 現在の日付を取得
        $today = Carbon::now();        
        // 第一週目の月曜日を取得
        $obj_first_mon = $today->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $obj_first_tue = $obj_first_mon->copy()->next(Carbon::TUESDAY);
        $obj_first_wed = $obj_first_mon->copy()->next(Carbon::WEDNESDAY);
        $obj_first_thu = $obj_first_mon->copy()->next(Carbon::THURSDAY);
        $obj_first_fri = $obj_first_mon->copy()->next(Carbon::FRIDAY);       
        $first_mon = $obj_first_mon->toDateString();
        $first_tue = $obj_first_tue->toDateString();
        $first_wed = $obj_first_wed->toDateString();
        $first_thu = $obj_first_thu->toDateString();
        $first_fri = $obj_first_fri->toDateString();
        // 第2週目の月曜日を計算
        $obj_second_mon = $obj_first_mon->copy()->addWeek();
        $obj_second_tue = $obj_second_mon->copy()->next(Carbon::TUESDAY);
        $obj_second_wed = $obj_second_mon->copy()->next(Carbon::WEDNESDAY);
        $obj_second_thu = $obj_second_mon->copy()->next(Carbon::THURSDAY);
        $obj_second_fri = $obj_second_mon->copy()->next(Carbon::FRIDAY);
        $second_mon = $obj_second_mon->toDateString();
        $second_tue = $obj_second_tue->toDateString();
        $second_wed = $obj_second_wed->toDateString();
        $second_thu = $obj_second_thu->toDateString();
        $second_fri = $obj_second_fri->toDateString();
        // 第3週目の月曜日を計算
        $obj_third_mon = $obj_second_mon->copy()->addWeeks();
        $obj_third_tue = $obj_third_mon->copy()->next(Carbon::TUESDAY);
        $obj_third_wed = $obj_third_mon->copy()->next(Carbon::WEDNESDAY);
        $obj_third_thu = $obj_third_mon->copy()->next(Carbon::THURSDAY);
        $obj_third_fri = $obj_third_mon->copy()->next(Carbon::FRIDAY);
        $third_mon = $obj_third_mon->toDateString();
        $third_tue = $obj_third_tue->toDateString();
        $third_wed = $obj_third_wed->toDateString();
        $third_thu = $obj_third_thu->toDateString();
        $third_fri = $obj_third_fri->toDateString();
        // 第4週目の月曜日を計算
        $obj_fourth_mon = $obj_first_mon->copy()->addWeeks(3);
        $obj_fourth_tue = $obj_fourth_mon->copy()->next(Carbon::TUESDAY);
        $obj_fourth_wed = $obj_fourth_mon->copy()->next(Carbon::WEDNESDAY);
        $obj_fourth_thu = $obj_fourth_mon->copy()->next(Carbon::THURSDAY);
        $obj_fourth_fri = $obj_fourth_mon->copy()->next(Carbon::FRIDAY);
        $fourth_mon = $obj_fourth_mon->toDateString();
        $fourth_tue = $obj_fourth_tue->toDateString();
        $fourth_wed = $obj_fourth_wed->toDateString();
        $fourth_thu = $obj_fourth_thu->toDateString();
        $fourth_fri = $obj_fourth_fri->toDateString();
        // 第5週目の月曜日を計算
        $obj_fifth_mon = $obj_fourth_mon->copy()->addWeeks();
        $obj_fifth_tue = $obj_fifth_mon->copy()->next(Carbon::TUESDAY);
        $obj_fifth_wed = $obj_fifth_mon->copy()->next(Carbon::WEDNESDAY);
        $obj_fifth_thu = $obj_fifth_mon->copy()->next(Carbon::THURSDAY);
        $obj_fifth_fri = $obj_fifth_mon->copy()->next(Carbon::FRIDAY);
        $fifth_mon = $obj_fifth_mon->toDateString();
        $fifth_tue = $obj_fifth_tue->toDateString();
        $fifth_wed = $obj_fifth_wed->toDateString();
        $fifth_thu = $obj_fifth_thu->toDateString();
        $fifth_fri = $obj_fifth_fri->toDateString();

        $dates = [
            // asia食材
            'stock_asia_1' => $second_tue,
            'stock_asia_2' => $fourth_tue,
            // オンバラージュ
            'stock_emballage_1' => $third_thu,                                     
            // 肉
            'stock_boeuf_1' => $second_wed,
            'stock_boeuf_2' => $fourth_wed,

            // STEG, SONET 毎月1回 月初めの火曜
            'steg_sonet' => $third_mon,
            // Cheque 月1回
            'cheque_1' => $second_mon,
        ];
        
        return $dates;
    }

    /**
     * 
     * works 本日のタスク
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jesser_works(){

        // 管理 支払い 実施日取得
        $effect_dates = $this->effectuer_day();

        // 曜日を取得 Fumi 独自クラスインスタンス化 
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));
        $now = Carbon::now();
        $le_date = $now->format('d');
        $now = Carbon::now();
        $date_ymd = $now->format('Y-m-d');

        /**
         * Satoの手動指示がある場合は優先表示
         * flg 13 [上書き]
         */
        $date_today = date_create()->format('Y-m-d');   
        $sato_record_override = SatoInstruction::where('flg_int', 13)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();
        if(! empty($sato_record_override)){
            //[上書き]サト指示有の為 表示
            \Session::flash('sato_record_override', $sato_record_override);
        }
        
        /**
         * Satoの手動指示がある場合は優先表示
         * flg 14 [追加]
         */
        $sato_record_add = SatoInstruction::where('flg_int', 14)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();
        if(! empty($sato_record_add)){
            //[上書き]サト指示有の為 表示
            \Session::flash('sato_record_add', $sato_record_add);
        }     
        return view('jesser_works', compact('daysoftheweek',
            'sato_record_override',
            'sato_record_add',
            'daysoftheweek',
            'le_date',
            'date_ymd',
            'effect_dates'
        ));   
    }    


    /**
     * 
     * finace リンクから 売上
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jesser_close_recettes(){
        // プルダウン 
        $close_names = $this->get_select_values('close_names');
        $fuseau_horaires = $this->get_select_values('fuseau_horaires');

        // 初期金額 id=7 sunカラムを流用
        $montant_initial = PlanProduction::where('id', '=', '7')->value('sun');
        
        // 登録データ取得 最新の20行のみ取得
        $finance_records = Finance::whereIn('flg', [11, 12, 13])
            ->orderBy('registre_datetime', 'desc')
            ->take(20)->get();

        \Session::flash('montant_initial', $montant_initial);
        
        return view('jesser_close_recettes', compact('montant_initial', 'close_names', 'fuseau_horaires', 'finance_records'));   
    }
  
    /**
     * finance. 当日のみの 売上財務ページ表示
     * 夜のジェイセル用
     * 当日の夜のみ表示設定 22h30～23h30
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function finance_journal(Request $request)
    {
        // リクエストデータ取得 
        $inputs = $request->all();
        $auth_pass_journal = $inputs["auth_pass_journal"];
        $auth_ok = AuthHanabishi::where('sub_1', 'finance')
        ->where('password', $auth_pass_journal)
        ->count();

        $todayDate = Carbon::now()->format('Y-m-d');

        if(! $auth_ok){
            //認証エラー
            \Session::flash('error_message', 'Error password! veuillez refaire sur la page!<div><a href="/jesser_top">Jesser top page</a></div>');
            \Session::flash('formattedDate', $todayDate);
            return view('error_page', compact("todayDate"));  
        }

        // -------[本番環境でのみ処理]-------- START
        // 11時前には帰らせないぞー 
        if (App::environment('production')) {            
            $nowSeconds = Carbon::now()->format(' H:i:s');

            //「秘密の制限時間」Lundch と Diner売上表示
            if(
                //現在時刻が範囲内
                ( strtotime($todayDate . ' 15:00:00') <= strtotime($todayDate . $nowSeconds) &&
                strtotime($todayDate . ' 17:00:00') >= strtotime($todayDate . $nowSeconds) )
              ||
                ( strtotime($todayDate . ' 22:30:00') <= strtotime($todayDate . $nowSeconds) &&
                strtotime($todayDate . ' 23:59:00') >= strtotime($todayDate . $nowSeconds) )
            ){
                // 時刻範囲内 表示OK
                $display_recette = true;

            }else{
                \Session::flash('error_message', 'Les recettes sont en cours de calcul ; veuillez accéder à la page après 15h00 pour le lunch ou après 22h30 pour le diner!  <div><a href="/jesser_top">Jesser top page</a></div>');
                \Session::flash('formattedDate', $todayDate . $nowSeconds);
                return view('error_page', compact("todayDate"));
            }

        }
        // -------[本番環境でのみ処理]-------- END

        // ◇Jsonコード取得 外部サーバー通信
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            'store' => 'main',
            'date' => $todayDate,
        ]);

        $collect = collect($response->json());
        // ランチ
        $filteredDataLunch = collect($collect)->filter(function ($item) use ($todayDate) {
            return !is_null($item['end_date']) &&
                strtotime($item['end_date']) >= strtotime($todayDate . ' 00:00:01') &&
                strtotime($item['end_date']) <= strtotime($todayDate . ' 17:00:00') ;
        });
        $total_lunch = $filteredDataLunch->sum('total');

        // ディナー
        $filteredDataDinner = collect($collect)->filter(function ($item)  use ($todayDate) {
            return !is_null($item['end_date']) &&
                strtotime($item['end_date']) >= strtotime($todayDate . '17:00:01') &&
                strtotime($item['end_date']) <= strtotime($todayDate . '23:59:59') ;
        });
        $total_diner = $filteredDataDinner->sum('total');

        // 一日売上合計
        $journal_recettes = $total_lunch + $total_diner;

        $alert_message = "Veuillez clôturer toutes les tables avant d'ouvrir la page";

        return view('jesser_finance_journal', compact("todayDate","journal_recettes", "total_lunch", "total_diner", "auth_ok", "alert_message"));
    }

    /**
     * 
     * zoom start
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function zoom_start(){
        $todayDate = Carbon::now()->format('Y-m-d');
        $nowSeconds = Carbon::now()->format(' H:i:s');
        //「秘密の制限時間」リンク表示
        if(
            ( strtotime($todayDate . ' 22:48:00') <= strtotime($todayDate . $nowSeconds) &&
            strtotime($todayDate . ' 23:59:00') >= strtotime($todayDate . $nowSeconds) )
        ){
            $zoom_ok = true;
            \Session::flash('zoom_ok', $zoom_ok);
            
        }else{
            $zoom_ok = false;
            \Session::flash('error_message', 'En cours.... ; veuillez accéder à la page de Meeting après 22h50!  <div><a href="/jesser_top">Return</a></div>');
            \Session::flash('formattedDate', $todayDate . $nowSeconds);
            return view('error_page', compact("todayDate"));
        }

        
        return view('jesser_zoom_start', compact('zoom_ok'));   
    }

    /**
     * 初期金額更新
     */
    public function jesser_close_updatemontan(Request $request, $id=null, $params=null){
        // Post データ取得
        $inputs = $request->all();
        $update_montant_initial = $inputs['update_montant_initial'];

        // 初期金額 id=7 sunカラムを流用
        $plan_production = PlanProduction::updateOrCreate(
            [
                'id' => 7
            ],
            [
                'sun' => $update_montant_initial,
            ]
         );

        $montant_initial = $update_montant_initial;
        \Session::flash('montant_initial', $montant_initial);
        \Session::flash('update_montant_initial', $update_montant_initial);
        
        return redirect()->route('jesser.close.recettes')->with([
            //画面引継ぎsession格納
            'update_montant_initial' => $update_montant_initial,
            'montant_initial' => $montant_initial,
            ]);
    }

    /**
     * finace envoyer ボタンから 売上査証
     */
    public function jesser_close_recettes_store(Request $request, $id=null, $params=null){
        // プルダウン 
        $close_names = $this->get_select_values('close_names');
        $fuseau_horaires = $this->get_select_values('fuseau_horaires');

        // Post データ取得
        $inputs = $request->all();
        $recettes_soir = $inputs['recettes_soir'];
        $cash = $inputs['cash'];
        $cheque = $inputs['cheque'];
        $carte = $inputs['carte'];
        $chips = $inputs['chips'];
        $close_name_now = $inputs['close_names_list']; // 
        $fuseau_horaires_now = (int)$inputs['fuseau_horaires_list'];
        $fuseau_horaires_display = $fuseau_horaires->where('id', $fuseau_horaires_now)->pluck('name')->first();
        $input_pass = $inputs['input_pass'];        

        // [認証] 責任者
        $res = $this->chk_responsable($input_pass, $close_name_now, 'pm');
        $auth_flg = $res['auth_flg'];
        // $action_message = $res['action_message'];

        if($auth_flg){
            // 成功
            // データベースに挿入
            $result_1 = Responsable::create(
                [
                    'name' => $close_name_now,
                    'type' => 'finance',
                    'charge' => 'recettes',
                    'fuseau_horaire' => $fuseau_horaires_now, // 11 am or 12 pm
                ]
            );
            
        }else{
            //認証失敗
            //exit;
        }

        // 初期金額 id=7 sunカラムを流用
        $montant_initial = PlanProduction::where('id', '=', '7')->value('sun');
        $compte_in_caisse = round(($cash + $cheque + $carte), 1);
        //$recettes_and_init = round(($recettes_soir + $montant_initial + $chips), 1);
        // 消す  $recettes_and_init = round(($recettes_soir + $montant_initial), 1);
        $recettes_and_init = round(($recettes_soir), 1);
        // [※注意 from 23.10.04]  仕様変更 recettes_and_initは初期金額を含んでいない売上生データ仕様に修正
        $resultat_is_chips = round($compte_in_caisse - $recettes_and_init , 1);
        // $resultat が $chips 以上の場合
        $bravo = false;
        // 集計結果とチップを突き合わせ
        $resultat = $resultat_is_chips - $chips;

        // 売上の大きさに応じて誤差許容範囲設定
        if ($recettes_soir <= 1000) {
            // 1000以下
            $plage_errur_accepte = 2;
        }elseif ($recettes_soir >= 1000 && $recettes_soir <= 1500) {
            // 1000～1500
            $plage_errur_accepte = 4;
        } elseif ($recettes_soir > 1500 && $recettes_soir <= 2000) {
            // 1500～2000
            $plage_errur_accepte = 6;
        }elseif ($recettes_soir > 2000 ) {
            // 2000以上
            $plage_errur_accepte = 8;
        }

        // 不足金のエラー

        // プラスのエラー
        if ($resultat >= 0 && $resultat <= $plage_errur_accepte) {
            // パーフェクトブラボー（集計結果が一致以上のプラスかつ、プラス誤差許容範囲以下）
            $resultat_message = "Fuseau horaires: ".$fuseau_horaires_display."<br><br>Bravo " .$close_name_now. "! <br> Vous avez fait un excellent travail";
            $bravo = true;
        }elseif($resultat >= $plage_errur_accepte){
            // プラス多すぎのエラー
            $resultat_message = "<span style='color: red;'><b>[Erreur] La caisse a un excès de ".$resultat."dt </b></span><br>"
                        ."<ul>Check:<li>&#9841; recompter des pourboire noté sur la fiche</li><li>&#9841; recompter à nouveau la caisse. </li></ul>";
        } else {
            // 不足金のエラー
            $resultat_message = "<span style='color: red;'><b>Manque de pourboire  : ".$resultat."dt </b></span><br>"
                        ."<ul>Check:<li>&#9841; recompter le chips</li><li>&#9841; des reçus de la carte sont échappées </li>
                        <li>&#9841; chèque se cache en bas de la caisse </li></ul>";
        }

        // Mail 送信
        if($bravo){
            $to = ['fumi.0000000@gmail.com'];
            $cc = ['satoe1227@outlook.com']; // カーボンコピーの場合
            $log_text = "★Success finance :" ;
        }else{
            // error
            $to = ['fmkz.ysn@gmail.com','admin@bistronippon.tn'];
            $cc = ['satoe1227@outlook.com']; // カーボンコピーの場合
            $log_text = "パニパニ万景峰号 :" ;
        }

        $datas = [
            'log' => $log_text.'Name:'.$close_name_now.'_'.$fuseau_horaires_display.' [resultat] '.$resultat,
            'type' => 10, // 10代: finance
            'color' => 'blue', // blue: finance
        ];
        $subject = $log_text . $resultat."dt";
        // コレクションを作成し、変数を設定します
        $body = new Collection([
            'close_name_now' => $close_name_now,
            'recettes_soir' => $recettes_soir,
            'montant_initial' => $montant_initial,
            'chips' => $chips,
            'recettes_and_init' => $recettes_and_init,
            'cash' => $cash,
            'carte' => $carte,
            'cheque' => $cheque,
            'compte_in_caisse' => $compte_in_caisse,
            'resultat' => $resultat,
            'resultat_is_chips' => $resultat_is_chips,                
            'bravo' => $bravo,
            'fuseau_horaires_display' => $fuseau_horaires_display
        ]);

        if (env('APP_ENV') == 'production') {
            // 本番環境の場合のみメール送信
            FumiTools::send_mail_db_reg(true, $to, $cc, $subject, $body, $datas);
        }else{
            Log::debug("[メール送信_send_mail_db_reg] 本番環境のみ");
        }

        // Sessionにデータ保持
        \Session::flash('recettes_soir', $inputs['recettes_soir']);
        \Session::flash('cash', $inputs['cash']);
        \Session::flash('cheque', $inputs['cheque']);
        \Session::flash('carte', $inputs['carte']);
        \Session::flash('chips', $inputs['chips']);
        \Session::flash('resultat', $resultat);
        \Session::flash('resultat_is_chips', $resultat_is_chips);
        
        \Session::flash('compte_in_caisse', $compte_in_caisse);
        \Session::flash('recettes_and_init', $recettes_and_init);
        \Session::flash('bravo', $bravo);
        // montant_initial
        \Session::flash('montant_initial', $montant_initial);        
        \Session::flash('resultat_message', $resultat_message);

        \Session::flash('close_name_now', $close_name_now);
        \Session::flash('fuseau_horaires_now', $fuseau_horaires_now);
        \Session::flash('fuseau_horaires_display', $fuseau_horaires_display);
        \Session::flash('auth_flg', $auth_flg);

        // db登録
        // $cash + $cheque + $carte  $recettes_soir + $montant_initial + $chips
        $finance = Finance::create([
            'shop' => 'bn',
            'name' => $close_name_now,
            'zone' => $fuseau_horaires_display,
            'recettes_main' => $recettes_soir,
            'recettes_sub' => $recettes_and_init, // [※注意 from 23.10.04]  仕様変更 recettes_and_initは初期金額を含んでいないレジの売上物理データ
            'montant_init' => $montant_initial,
            'montant_1' => $resultat,
            'chips' => $chips,
            'caisse' => $compte_in_caisse,
            'cash' => $cash,
            'cheque' => $cheque,
            'card' => $carte,
            'flg' => $fuseau_horaires_now, // AM:11 _ PM:12 _ Journal:13
            'cat' => 1,
            'bravo' => $bravo,
            'registre_date' => date('Y-m-d'),
            'registre_datetime' => now(),
        ]);        

        // 登録データ取得 最新の20行のみ取得
        $finance_records = Finance::whereIn('flg', [11, 12, 13])
            ->orderBy('registre_datetime', 'desc')
            ->take(20)->get();

        // 画面表示
        return view('jesser_close_recettes', compact('montant_initial','bravo', 
            'recettes_and_init','compte_in_caisse',
            'resultat_message', 'resultat','recettes_soir',
            'cash','cheque','carte','chips', 'close_name_now', 'auth_flg', 
            'close_names','fuseau_horaires', 'fuseau_horaires_display','resultat_is_chips',
            'finance_records'
         ));  
    }

    /**
     * 責任者 認証チェック
     */
    public function chk_responsable($input_pass, $close_name, $zone){
        // パスワード認証 
        $adminpass = AuthHanabishi::where('user_name', '=', $close_name)->value('password');
        // 認証チェック
        $auth_flg = false;
        if($adminpass === $input_pass){
            //パスワード認証OK
            $auth_flg = true;
        }else {
            //管理者認証エラー
            $action_message = "[ERROR] Password is not correct ";
            \Session::flash('action_message', $action_message);
        }

        //セッションに認証OKフラグ立てる
        \Session::flash('auth_flg', $auth_flg);
        \Session::flash('close_name_now', $close_name);        
        
        $data = [
            'auth_flg' => $auth_flg,
            'close_name' => $close_name
        ];
        return $data;
    }

    /**
     * 
     * Gestion de stock リンクから 在庫入力
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jesser_gestion_stock(){
        // 管理 支払い 実施日取得
        $effect_dates = $this->effectuer_day();
        $now = Carbon::now();
        $date_ymd = $now->format('Y-m-d');

        // 曜日を取得 Fumi 独自クラスインスタンス化 
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));
    
        // プルダウン 
        $papier_toilettes = $this->get_select_values('papier_toilettes');
        $papier_serviette = $this->get_select_values('papier_clients');

        // 50 pieces
        $plastique_chaud_750ml = $this->get_select_values('50_plus');
        $plastique_froide_500ml = $this->get_select_values('50_plus');
        $plastique_froide_1000ml = $this->get_select_values('50_plus');
        $bol_carton_rond = $this->get_select_values('50_plus');
        $pochette_en_papier = $this->get_select_values('50_plus');
        $sac_en_papier_L = $this->get_select_values('50_plus');

        // 100 pieces
        $aluminium_401 = $this->get_select_values('100_plus');
        $aluminium_701 = $this->get_select_values('100_plus');
        $aluminium_901 = $this->get_select_values('100_plus');
        $pot_de_sauce_30cc = $this->get_select_values('100_plus');

        $sac_petit = $this->get_select_values('sac_petit');
        $sac_grand = $this->get_select_values('sac_grand');
        $sac_poubelle = $this->get_select_values('sac_poubelle');
        $sac_transparant = $this->get_select_values('sac_transparant');        
        $tantan = $this->get_select_values('tantan');

        // アジア食材
        //$sauce_poisson = $this->get_select_values('asia_1');
        $pate_miso_20kg = $this->get_select_values('asia_1');
        $mirin_20kg = $this->get_select_values('asia_1');
        $algue_wakame = $this->get_select_values('asia_1');
        // $poudre_dashi = $this->get_select_values('asia_1');
        $shichimi = $this->get_select_values('asia_1');
        //$sauce_tomyum = $this->get_select_values('asia_1');
        //$sauce_toubanjyun = $this->get_select_values('asia_1');
  

        // ※順番重要:テーブル表示の順番と一致
        $columns = [
            'created_at',
            'essuie_jmb',
            'papier_toilettes',
            'plastique_chaud_750ml',
            'plastique_froide_500ml',
            'plastique_froide_1000ml',
            'papier_serviette',
            'aluminium_901',
            'aluminium_701',
            'aluminium_401',
            'pot_de_sauce_30cc',
            'bol_carton_rond',
            'article1', //'pochette_en_papier'
            'article2', //'sac_en_papier_L'  
            'sac_transparant',
            'sac_petit',
            'sac_grand',
            'sac_poubelle',
            'bicarbonate',
            'tahina_pate_du_sesame',
            'viande_hachee_poulet_congele',
            'viande_hachee_boeuf_congele',
            'tantan_boeuf',                 
             "pate_miso_20kg", 
            "mirin_20kg", "algue_wakame", 
            "shichimi",             
            //number
            "sauce_poisson","sauce_tomyum", "sauce_toubanjyun",
            "gari_gingimbre", "algue_nori","poudre_dashi", 
        ];

        $stock_accessoire = StockAccessoire::select($columns)
        ->orderBy('created_at', 'desc') // 'created_at' カラムを降順にソート
        ->limit(5) // 最新の5行を取得
        ->get();

        return view('jesser_gestion_stock', compact( 
            'papier_toilettes','papier_serviette',
            'sac_petit','sac_grand',
            'sac_poubelle','tantan', 'columns',
            'plastique_chaud_750ml',
            'plastique_froide_500ml',
            'plastique_froide_1000ml',
            'aluminium_901',
            'aluminium_701',
            'aluminium_401',
            'pot_de_sauce_30cc',
            'bol_carton_rond',
            'pochette_en_papier',
            'sac_en_papier_L',
            'sac_transparant',
            "pate_miso_20kg", 
            "mirin_20kg", "algue_wakame", 
            "shichimi", 
            'stock_accessoire', 
            'daysoftheweek',
            'effect_dates',
            'date_ymd',
         ));  
    }

    /**
     * stock データをdb登録
     */
    public function jesser_gestion_stock_store(Request $request, $id=null, $params=null){
        // フォームからのデータを取得
        $inputs = $request->only([
            'essuie_jmb',
            'papier_toilettes',
            'plastique_chaud_750ml',
            'plastique_froide_500ml',
            'plastique_froide_1000ml',
            'papier_serviette',
            'aluminium_901',
            'aluminium_701',
            'aluminium_401',
            'pot_de_sauce_30cc',
            'bol_carton_rond',
            'pochette_en_papier',
            'sac_en_papier_L',
            'sac_transparant',
            'sac_petit',
            'sac_grand',
            'sac_poubelle',
            'bicarbonate',
            'tahina_pate_du_sesame',
            'viande_hachee_poulet_congele',
            'viande_hachee_boeuf_congele',
            'tantan_boeuf',
            // asia _ select box
            "pate_miso_20kg", 
            "mirin_20kg", "algue_wakame", 
            "shichimi", 
            
            //number
            "sauce_poisson", 
            "sauce_tomyum", "sauce_toubanjyun",
            "gari_gingimbre", "algue_nori", "poudre_dashi",   
        ]);
        // 他のカラムのデータを設定  
        $inputs['flg'] = 1;
       
        // now データ設定
        $this->set_session_datas(true ,$inputs);

        // フォームデータをStockモデルを使用してインサート
        $inputs['article1'] = $inputs['pochette_en_papier'] ?? null;
        $inputs['article2'] = $inputs['sac_en_papier_L'] ?? null;
         $resultat= StockAccessoire::create($inputs);
        // store 
        \Session::flash("flash_message", true);

         return redirect()->route('jesser.gestion.stock')->with([
            //画面引継ぎsession格納
            'inputs' => $inputs,
            ]);
    }    

    /**
     * Now用セッションデータ設定
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function set_session_datas($flg ,$inputs){        
        
        // select box
        $keys_select_box = [
            'papier_toilettes',
            'papier_serviette',
            'plastique_chaud_750ml',
            'plastique_froide_500ml',
            'plastique_froide_1000ml',
            'aluminium_901',
            'aluminium_701',
            'aluminium_401',
            'pot_de_sauce_30cc',
            'bol_carton_rond',
            'pochette_en_papier',
            'sac_en_papier_L',
            'sac_petit',
            'sac_grand',
            'sac_poubelle',
            'sac_transparant',
            'tantan_boeuf',
            "pate_miso_20kg", 
            "mirin_20kg", "algue_wakame", 
            "shichimi", 
        ];        
        foreach ($keys_select_box as $key) {
            $nowKey = $key . '_now';
            if (isset($inputs[$key])) {
                \Session::flash($nowKey, $inputs[$key]);
            }
        }        
        
        // input number
        $keys = [
            'essuie_jmb',
            'bicarbonate',
            'tahina_pate_du_sesame',
            'viande_hachee_poulet_congele',
            'viande_hachee_boeuf_congele',
            // asia食材
            "sauce_poisson", 
            "sauce_tomyum", "sauce_toubanjyun",
            "gari_gingimbre", "algue_nori", "poudre_dashi",
        ];        
        foreach ($keys as $key) {
            if (isset($inputs[$key])) {
                \Session::flash($key, $inputs[$key]);
            }
        }       
        
    }

    /**
     * ディスプレイ用データ取得
     * 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_stock_display(){
        // 画面表示用にプルダウンのnameを格納した連想配列を作成 start
        // * [使用法] 
        // * 1.stock_ingredientsの表示対象のモデルデータを渡す
        // * 2.プルダウン集にプルダウンデータを追加 
        // * 3.articles_by_tableの数をプルダウンの数と一致させる

        // 表示対象モデルデータ
        $stock_accessoire = FumiTools::get_stock_accessoire_by_keys(1, '14');
        // プルダウン集 select ボックス要素作成
        // select ボックス要素作成
        $papier_toilettes = $this->get_select_values('papier_toilettes');
        $papier_clients = $this->get_select_values('papier_clients');
        $sac_petit = $this->get_select_values('sac_petit');
        $sac_grand = $this->get_select_values('sac_grand');
        $sac_poubelle = $this->get_select_values('sac_poubelle');
        $sac_transparant = $this->get_select_values('sac_transparant');
        $tantan = $this->get_select_values('tantan');
        // 50 pieces
        $plastique_chaud_750ml = $this->get_select_values('50_plus');
        $plastique_froide_500ml = $this->get_select_values('50_plus');
        $plastique_froide_1000ml = $this->get_select_values('50_plus');
        $bol_carton_rond = $this->get_select_values('50_plus');
        $pochette_en_papier = $this->get_select_values('50_plus');
        $sac_en_papier_L = $this->get_select_values('50_plus');
        
        // 100 pieces
        $aluminium_401 = $this->get_select_values('100_plus');
        $aluminium_701 = $this->get_select_values('100_plus');
        $aluminium_901 = $this->get_select_values('100_plus');
        $pot_de_sauce_30cc = $this->get_select_values('100_plus');
        // アジア食材
        //$sauce_poisson = $this->get_select_values('asia_1');
        $pate_miso_20kg = $this->get_select_values('asia_1');
        $mirin_20kg = $this->get_select_values('asia_1');
        $algue_wakame = $this->get_select_values('asia_1');
        // $poudre_dashi = $this->get_select_values('asia_1');
        $shichimi = $this->get_select_values('asia_1');
        // $sauce_tomyum = $this->get_select_values('asia_1');
        // $sauce_toubanjyun = $this->get_select_values('asia_1');

        $pulldowns = [$papier_toilettes, $papier_clients, $sac_petit, $sac_grand, $sac_poubelle, $tantan, 
                            $plastique_chaud_750ml, $plastique_froide_500ml, $plastique_froide_1000ml, $bol_carton_rond, 
                            $pochette_en_papier, $sac_en_papier_L,
                            $aluminium_401, $aluminium_701,$aluminium_901, $pot_de_sauce_30cc, $sac_transparant,
                            // asia食材
                            $pate_miso_20kg,
                            $mirin_20kg,
                            $algue_wakame,
                            $shichimi,
                     ];

        // テーブルのカラム名 を設定
        $columun_names = ["papier_toilettes", "papier_serviette", "sac_petit", "sac_grand", "sac_poubelle", "tantan_boeuf", 
                        "plastique_chaud_750ml", "plastique_froide_500ml", "plastique_froide_1000ml", "bol_carton_rond", "pochette_en_papier", "sac_en_papier_L",
                        "aluminium_401","aluminium_701","aluminium_901", "pot_de_sauce_30cc", "sac_transparant",
                        // asia食材
                        "pate_miso_20kg", 
                        "mirin_20kg", "algue_wakame", 
                        "shichimi", 
                        ];

        $stock_accessoire_display = FumiTools::get_display_datas_stock_accessoires($stock_accessoire, $pulldowns, $columun_names);

        //$newArray = array_combine($columun_names, $stock_accessoire_display);
        $displays = []; 
        foreach($stock_accessoire_display as $display){
            array_shift($display);
            $newArray[] = array_combine($columun_names, $display);
        }
        //dd($columun_names, $newArray);
        // 表示用にプルダウンのnameを格納した連想配列を作成 end

        return $displays;
    }

    /**
     * select values
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_select_values($s_id){

        if($s_id == 'asia_1'){
            // select ボックス要素作成
            $cols = collect([
                    ['id' => '', 'name' => ''],
                    ['id' => 1, 'name' => 1],
                    ['id' => 2, 'name' => 2],
                    ['id' => 3, 'name' => 3],
                    ['id' => 4, 'name' => 4],
                    ['id' => 5, 'name' => 5],
                    ['id' => 6, 'name' => 6],
                    ['id' => 7, 'name' => 7],
                    ['id' => 8, 'name' => 8],
                    ['id' => 9, 'name' => 9],
                    ['id' => 10, 'name' => 10],  
                    ['id' => 11, 'name' => 11],
                    ['id' => 12, 'name' => 12],              
            ]);
            return $cols;
        }

        if($s_id == '50_plus'){
            // select ボックス要素作成
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => 1, 'name' => 'moins que 50 pièces'],
                ['id' => 2, 'name' => 'beaucoup'],
            ]);
            return $cols;
        }
        if($s_id == '100_plus'){
            // select ボックス要素作成
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => 1, 'name' => 'moins que 100 pièces'],
                ['id' => 2, 'name' => 'beaucoup'],
            ]);
            return $cols;
        }

        if($s_id == 'papier_toilettes'){
            // select ボックス要素作成
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => 1, 'name' => 'moins que 10 pièces'],
                ['id' => 2, 'name' => 'moyenne'],
                ['id' => 3, 'name' => 'beaucoup'],
            ]);
            return $cols;
        }

        if($s_id == 'papier_clients'){
            // select ボックス要素作成
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => '1', 'name' => 'moins que 10 pièces'],
                ['id' => '2', 'name' => 'beaucoup'],
            ]);
            return $cols;
        }

        if($s_id == 'sac_petit'|| $s_id == 'sac_grand' || $s_id == 'sac_transparant'){
            // select ボックス要素作成
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => '1', 'name' => 'moins que 200 pièces'],
                ['id' => '2', 'name' => 'beaucoup'],
            ]);
            return $cols;
        }

        if($s_id == 'sac_poubelle'){
            // select ボックス要素作成
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => 1, 'name' => 'moins que 100 pièces'],
                ['id' => 2, 'name' => 'beaucoup'],
            ]);
            return $cols;
        }

        if($s_id == 'tantan'){
            // select ボックス要素作成
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => '1', 'name' => 'moins que 10 pièces'],
                ['id' => '2', 'name' => 'beaucoup'],
            ]);
            return $cols;
        }


        //時間帯
        if($s_id == 'fuseau_horaires'){
            // select ボックス要素作成
            $fuseau_horaires = collect([
                ['id' => '', 'name' => ''],
                ['id' => '11', 'name' => 'am'],
                ['id' => '12', 'name' => 'pm'],
                ['id' => '13', 'name' => 'journal'],
            ]);
            return $fuseau_horaires;
        }
        // close_names
        if($s_id == 'close_names'){
            // select ボックス要素作成
            $datas = collect([
                ['id' => '', 'name' => ''],
                ['id' => 'jesser', 'name' => 'jesser'],
                ['id' => 'jihen', 'name' => 'jihen'],
                ['id' => 'fumi', 'name' => 'fumi'],
                ['id' => 'sato', 'name' => 'sato'],
                ['id' => 'guest', 'name' => 'guest'],
            ]);
            return $datas;
        }
    }
}
