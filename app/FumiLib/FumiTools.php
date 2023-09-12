<?php

namespace App\FumiLib;

use Illuminate\Http\Request;
// Mail 送信用
use Illuminate\Support\Facades\Mail;
use App\Mail\SendinBlueDemoEmail;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
use App\Models\ConditionType;

use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use Carbon\Carbon;

class FumiTools
{
    public function hello()
    {
        return 'Hello world';
    }
   
    /**
     * stock_ingredientsテーブルデータ取得.
     *'flg1' => 3　アイシャの朝プレパレで入力する米の残量データ
     *'flg1' => 2　ビレルの閉店時登録データ
     *'flg1' => 1　15時のアイシャ登録在庫
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function get_stockIngredient_by_keys($flg, $sub_days)
    {
        $stock_ingredients = StockIngredient::where('flg1', $flg)
        ->where('registre_datetime', '>=', Carbon::now()->subDays($sub_days))
        ->orderBy('registre_datetime', 'desc')
        ->get();

        return $stock_ingredients;
    }

    /**
     * FUMI
     *  曜日をdbカラムに適合した文字列で返す 例 mon,tue...
     * 
     */
    public function fumi_get_youbi_for_table($ynum) {
        $youbi;
        $week = [
            'sun', //0
            'mon', //1
            'tue', //2
            'wed', //3
            'thu', //4
            'fri', //5
            'sat', //6
        ];

        $youbi = $week[$ynum];

        return $youbi;
    }

    /**
     * FUMI
     *  return 配列fumi_get_paiko_type
     * 
     */
    public function fumi_get_cons_array($item, $flg) {
        $product_name_for_staff = data_get($item, 'product_name_for_staff');
        $order_id = data_get($item, 'order_id');
        $created_at = data_get($item, 'created_at');
        $formatted_date = \Carbon\Carbon::parse($created_at)->format('Y年m月d日 H時i分');
        $product_type_name_for_staff = data_get($item, 'product_type_name_for_staff');
        $qty = data_get($item, 'qty'); 
        $ex_order = compact('order_id', 'formatted_date', 'product_name_for_staff','product_type_name_for_staff','qty');

        return $ex_order;
    }
    
    /**
     * FUMI
     *  return パイコータイプ 配列 
     * 
     */
    public function fumi_get_paiko_type($item) {
        // type, enfantパイコー配列
        $type_is_paikos=[];
        $plat_is_paikos=[];
        $katsu_is_paikos=[];
        $p_flg = false;
        //flag: plat > katsu > type > enfant
        $product_name_for_staff = data_get($item, 'product_name_for_staff');
        $product_type_name_for_staff = data_get($item, 'product_type_name_for_staff');
        if ($product_name_for_staff === 'paiko poulet') {
            // Plat パイコー
            $p_flg = 'plat';
        }else if(mb_stripos($product_type_name_for_staff, 'paiko') === 0
            || mb_stripos($product_type_name_for_staff, 'PAIKO') === 0
            || mb_stripos($product_type_name_for_staff, 'paiko') != false
            || mb_stripos($product_name_for_staff, 'enfant') === 0){
            // Type パイコーと子供メニュー
            $p_flg = 'type';
        }else if(mb_stripos($product_name_for_staff, 'katsu') === 0
            || mb_stripos($product_name_for_staff, 'Katsu') === 0
            || mb_stripos($product_name_for_staff, 'KATSU') != false){
            // katsu donburi/udon
            $p_flg = 'katsu';
        }
        $collection = collect();
        if($p_flg !== false){            
            // パイコーを使っている料理 yes
            $order_id = data_get($item, 'order_id');
            $created_at = data_get($item, 'created_at');
            $formatted_date = \Carbon\Carbon::parse($created_at)->format('Y年m月d日 H時i分');            
            $qty = data_get($item, 'qty');
            $ex_order = compact('order_id', 'formatted_date', 'product_name_for_staff','product_type_name_for_staff','qty');
            $collection->push([$p_flg => $ex_order]);        
        }     
        return $collection;
    }

    // $products 配列を初期化する関数
    function initAry($datas) {
        $initArys = [];
        foreach ($datas as $data) {
            $initArys[$data] = 0;
        }
        return $initArys;
    }
    /**
     * FUMI
     *  return 配列 
     *  引数はitemと文字列
     * 
     */
    public function fumi_get_consom_pn_staff($item, $products_str, $types_str) {
        $products_ary = explode(",", $products_str);
        $types_ary = explode(",", $types_str);

        $order_products = $this->initAry($products_ary);
        $order_types = $this->initAry($types_ary);
        $collection = collect();
        $flg=false;
        $flg_type=false;
        foreach ($order_products as $key => $i) {
            if (mb_stripos($item['product_name_for_staff'], $key) !== false) {
                $order_products[$key] += $item['qty'];
                $flg=true;
            }
        }
        foreach ($order_types as $key => $i) {
            if (mb_stripos($item['product_type_name_for_staff'], $key) !== false) {
                $order_types[$key] += $item['qty'];
                $flg_type=true;
            }
        }

        if($flg){
            // ある product_name_for_staff
            $collection->put('products',$order_products);
        }
        if($flg_type){
            // ある product_type_name_for_staff
            $collection->put('types',$order_types);
        }
        return $collection;
    }

    /**
     * 画面表示用にプルダウンのnameを格納した連想配列を作成
     * 
     * 詳細リンク 登録データの表示をわかり易くする。　例：riz entre 4 ～ 6 sacs とか
     * 
     * [使用法] 
     * 1.stock_ingredientsの表示対象のモデルデータを渡す
     * 2.pulldowns プルダウン集にプルダウンデータを追加 
     * 3.columun_names _ stock_ingredientsテーブルのカラム名を配列で指定
     * [注意] pulldownsとcolumun_namesのデータ数と順番は必ず一致させること。
     */
    public static function get_display_datas($stock_ingredients, $pulldowns, $columun_names)   {

        // 表示用のレコード 入れ子の連想配列
        $display_datas = [];
        // レコードをループ
        foreach ($stock_ingredients as $stock_ingredient) {
           
            $articles_by_table = []; // 配列初期化
            $num_columns = count($columun_names);
            for ($i = 0; $i < $num_columns; $i++) {
                $column_name = $columun_names[$i];
                $article_value = $stock_ingredient->{$column_name};
                // ここで $article_value を利用する処理を行う
                $articles_by_table[] = $article_value;
            }


            $matchingName = '';
            $display_data = [$stock_ingredient->registre_datetime]; // 配列を初期化

            for ($i = 0; $i < count($pulldowns); $i++) {
                foreach ($pulldowns[$i] as $ellements) {
                    if ($ellements['id'] === (string)$articles_by_table[$i]) {
                        $display_data[] = $ellements['name']; //配列に追加
                        break;
                    }
                }
            }      
            $display_datas[] = $display_data;
        }
        // 表示用にプルダウンのnameを格納した連想配列を作成 end

        return $display_datas;
    }

    /**
     * メール送信とDB登録処理
     * @pram subject,body,log,type,color
     * 
     */
    public static function send_mail_db_reg($flg, $to, $cc, $subject, $body, $datas)
    {
        if($flg){
            // Mail 送信 処理
            $log = $datas['log'];
            $type = (int)$datas['type']; // 10代: finance
            $color = $datas['color']; // blue: finance

            Mail::to($to)
                ->cc($cc)
                ->send(new SendinBlueDemoEmail($subject, $body));
                 logger()->info($log);

                // Mail送信 済/未 判定レコードを作成
                $data = [
                    'type' => $type, //
                    'kubun' => $type,
                    'numero' => $type,
                    'color' => $color,
                    'sub1' => $type,
                    'sub2' => $type,
                ]; 
                ConditionType::create($data);
        }
    }
}