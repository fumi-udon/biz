<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        /**
         * 入力データ表示
         * 'flg1' => xxxx TODO
         */
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('5', '14');

        \Session::flash('stock_ingredients', $stock_ingredients);
        
        return view('jesser_top', compact('stock_ingredients'));   
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
        \Session::flash('montant_initial', $montant_initial);
        
        return view('jesser_close_recettes', compact('montant_initial', 'close_names', 'fuseau_horaires'));   
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
        $recettes_and_init = round(($recettes_soir + $montant_initial), 1);
        $resultat = round($compte_in_caisse - $recettes_and_init , 1);
        // $resultat が $chips 以上の場合
        $bravo = false;
        // 集計結果とチップを突き合わせ
        $resultat = $resultat - $chips;
        if ($resultat >= 0) {
            // メッセージを変数に格納
            $resultat_message = "Fuseau horaires: ".$fuseau_horaires_display."<br><br>Bravo " .$close_name_now. "! <br> Vous avez fait un excellent travail";
            $bravo = true;
        } else {
            // 金額エラー
            $resultat_message = "<span style='color: red;'><b>Manque de pourboire  : ".$resultat."dt </b></span><br>"
                        ."<ul>Check:<li>&#9841; recompter le chips</li><li>&#9841; des reçus de la carte sont échappées </li>
                        <li>&#9841; chèque se cache en bas de la caisse </li></ul>";
            // Mail 送信
            $datas = [
                'log' => '[BN: finance panic]'.'Name:'.$close_name_now.'_'.$fuseau_horaires_display.' [resultat] '.$resultat,
                'type' => 10, // 10代: finance
                'color' => 'blue', // blue: finance
            ];
            $subject = 'BN: finance panic '.$fuseau_horaires_display;
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
                'bravo' => $bravo,
                'fuseau_horaires_display' => $fuseau_horaires_display
            ]);
            //$bodys = 'BN: finance panic '.$fuseau_horaires_display;xxxxxxxxxx TODO :コレクションクラス使おう viewで取得できるようにする　finance.mail.blade
            $to = ['fumi.0000000@gmail.com', 'admin@bistronippon.tn'];
            $cc = ['fumi.0000000@gmail.com']; // カーボンコピーの場合
            FumiTools::send_mail_db_reg(true, $to, $cc, $subject, $body, $datas);
        }
        // Sessionにデータ保持
        \Session::flash('recettes_soir', $inputs['recettes_soir']);
        \Session::flash('cash', $inputs['cash']);
        \Session::flash('cheque', $inputs['cheque']);
        \Session::flash('carte', $inputs['carte']);
        \Session::flash('chips', $inputs['chips']);
        \Session::flash('resultat', $resultat);
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
            'recettes_sub' => $recettes_and_init, // 売上と初期金額とチップの合計
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

        // 画面表示
        return view('jesser_close_recettes', compact('montant_initial','bravo', 
            'recettes_and_init','compte_in_caisse',
            'resultat_message', 'resultat','recettes_soir',
            'cash','cheque','carte','chips', 'close_name_now', 'auth_flg', 
            'close_names','fuseau_horaires', 'fuseau_horaires_display'
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
        $val = '';
        // \Session::flash('stock_ingredients', $stock_ingredients);
        
        return view('jesser_gestion_stock', compact('val'));   
    }
    /**
     * select values
     * 
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
