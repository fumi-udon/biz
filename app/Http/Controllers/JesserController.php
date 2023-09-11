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
        // 初期金額 id=7 sunカラムを流用
        $montant_initial = PlanProduction::where('id', '=', '7')->value('sun');
        \Session::flash('montant_initial', $montant_initial);
        
        return view('jesser_close_recettes', compact('montant_initial'));   
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jesser_close_recettes_store(Request $request, $id=null, $params=null){
        // Post データ取得
        $inputs = $request->all();
        $recettes_soir = $inputs['recettes_soir'];
        $cash = $inputs['cash'];
        $cheque = $inputs['cheque'];
        $carte = $inputs['carte'];
        $chips = $inputs['chips'];
        // 計算を実行し、小数点第一位までの精度を保持する

        // 初期金額 id=7 sunカラムを流用
        $montant_initial = PlanProduction::where('id', '=', '7')->value('sun');
        $compte_in_caisse = round(($cash + $cheque + $carte), 1);
        $recettes_and_init = round(($recettes_soir + $montant_initial + $chips), 1);
        $resultat = round($compte_in_caisse - $recettes_and_init , 1);
        // $resultat が $chips 以上の場合
        $bravo = false;
        if ($resultat >= 0) {
            // メッセージを変数に格納
            $resultat_message = "Bravo ! Vous avez fait un excellent travail";
            $bravo = true;
        } else {
            $resultat_message = "<span style='color: red;'><b>Manque  : ".$resultat."dt </b></span><br>"
                                ."<ul>Check:<li>&#9841; recompter le chips</li><li>&#9841; des reçus de la carte sont échappées </li><li>&#9841; chèque se cache en bas de la caisse </li></ul>";
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

        // 画面表示
        return view('jesser_close_recettes', compact('montant_initial','bravo', 
            'recettes_and_init','compte_in_caisse',
            'resultat_message', 'resultat','recettes_soir',
            'cash','cheque','carte','chips'
         ));  
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
}
