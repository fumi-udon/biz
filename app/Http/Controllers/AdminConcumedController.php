<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする

//Fumi 独自クラス
use App\FumiLib\FumiTools;
use App\FumiLib\AdminConcumedTools;

class AdminConcumedController extends Controller
{
    /**
     * キタノ用. 検索
     * 
     * @return view
     */
    public function search_kitano($inputs, $collections)
    {
        $shops = $this->get_shop_list();

        // [商品] Start
        // 該当日の商品の消費量を全て（product_names.php定義）取得し
        // 商品名 => 消費数量 のcollectionクラスをreturnする.
        $product_seach_name = explode(',', Config::get('product_names.ki_product_names'));        
        $resultat_products = AdminConcumedTools::get_product_consodatas($collections, $product_seach_name);   
        $product_collect = collect($resultat_products);
        // [商品] End
        // view
        return $product_collect;
    }
    /**
     * conso. 検索
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request, $id=null, $params=null)
    {
        ini_set('display_errors', 'Off');
        $inputs = $request->all();
        // リクエストデータ取得
        $input_date = $inputs['input_date'];
        $shop = $inputs['shop_list'];
        // session 格納
        \Session::flash('input_date', $input_date);
        \Session::flash('shop_now', $shop);

        // [画面表示用 設定] 
        // SelectBox初期化 店リスト  
        $shops = $this->get_shop_list();

        // [食材消費量] Curl https通信＿SSL エラー回避
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            'store' => $shop,
            'date' => $input_date,
        ]);
        $collections = collect($response->json());

        if($shop == 'currykitano'){
            // キタノの場合の処理
            $product_collect = collect($this->search_kitano($inputs, $collections));

            // view
            return view('admin/admin_consumed', compact(
                    "product_collect",
                    "shops"
            ));

        }else{
            // ビストロ日本の場合の処理
        $total_qty_rmn = 0;
        $total_qty_udn = 0;        
        $ramen_datas = [];
        $udon_datas = [];
        //collectionクラスが格納される
        $paiko_collections_ary = [];

        //お米データ取得 collectionクラスが格納される (RIZ用)
        $rice_collections_ary = [];
        //お米使う商品名 
        $riz_plats_name = Config::get('product_names.riz_plats_name');        
        $riz_types_name = Config::get('product_names.riz_types_name');

        // fumi独自クラス
        $fumi_tools =new FumiTools();

        // [商品] Start
        // 該当日の商品の消費量を全て（product_names.php定義）取得し
        // 商品名 => 消費数量 のcollectionクラスをreturnする.
        $product_seach_name = explode(',', Config::get('product_names.product_names'));
        $resultat_products = AdminConcumedTools::get_product_consodatas($collections, $product_seach_name);   
        $product_collect = collect($resultat_products);
        // [商品] End

        // [Extra] Start
        // 該当日のエクストラの消費量を全て（product_names.php定義）取得し
        // 商品名 => 消費数量 のcollectionクラスをreturnする.
        $extra_seach_name = explode(',', Config::get('product_names.extra_names'));
        $resultat_extras = AdminConcumedTools::get_extra_consodatas($collections, $extra_seach_name);   
        $extra_collect = collect($resultat_extras);
        // [Extra] End

        // [Gyoza個数カウント] Start
        // 8pと12pの注文数を取得して消費個数を表示
        $resultat_gyozas = AdminConcumedTools::get_gyouza_count($collections);
        $gyoza_collect = collect($resultat_gyozas);
        // [Gyoza個数カウント] End

        foreach($collections as $collection) {
            //dd($collection);
            $items = collect($collection['items']);

           // dd($items->where('product_name_for_staff','namuru')->count());
            foreach($items as $item) {
                $item = collect($item);
                $product_name_for_staff = data_get($item, 'product_name_for_staff');
                $product_type_name_for_staff = data_get($item, 'product_type_name_for_staff');
                // ramen を使う料理名検索
                if ($product_name_for_staff === 'yksba' 
                || mb_stripos($product_name_for_staff, 'rmn') === 0
                || mb_stripos($product_name_for_staff, 'ramen') === 0
                || mb_stripos($product_name_for_staff, 'ramen') != false
                || mb_stripos($product_type_name_for_staff, 'RMN') === 0) {
                    // 消費数合計計算して表示用配列作成
                    $ramen_datas[] = $fumi_tools->fumi_get_cons_array($item, 'rmn');                    
                    // ramen消費数合計
                    $qty = data_get($item, 'qty'); 
                    $total_qty_rmn += $qty;
                    // Ramen消費数カウント END 

                }else if(mb_stripos($product_name_for_staff, 'udon') === 0
                || mb_stripos($product_name_for_staff, 'udn') === 0
                || mb_stripos($product_name_for_staff, 'udn') != false
                || mb_stripos($product_name_for_staff, 'udon') != false
                || mb_stripos($product_type_name_for_staff, 'UDN') === 0){
                    // UDON 用消費数合計計算して表示用配列作成
                    $udon_datas[] = $fumi_tools->fumi_get_cons_array($item, 'udn');
                    // UDON 用消費数合計
                    $qty = data_get($item, 'qty'); 
                    $total_qty_udn += $qty;
                }                
                //Paikoデータ取得
                $paiko_collection = $fumi_tools->fumi_get_paiko_type($item, 'all');
                if (! $paiko_collection->isEmpty()) {
                    $paiko_collections_ary[] = $paiko_collection;
                }
                
                //rice お米データ取得
                $riz_collection = $fumi_tools->fumi_get_consom_pn_staff($item, $riz_plats_name,$riz_types_name);
                if (! $riz_collection->isEmpty()) {
                    $rice_collections_ary[] = $riz_collection;
                }
                
            } // foreach インナー end
        }// foreach 親 end

        // rice start
        // 配列をループして集計する
        $riz_collections = collect($rice_collections_ary);
        // カンマを区切り文字として、文字列を配列に変換する
        $riz_plats = explode(',', $riz_plats_name);
        $riz_types = explode(',', $riz_types_name);
        
        // 配列の各要素にアクセスする
        $tatal_order = [];
        //集計結果
        $riz_resultats = collect();
        foreach ($riz_plats as $key) {
            $tatal_order = $riz_collections->pluck('products.'.$key)->sum();
            $riz_resultats->push([$key => $tatal_order]);
        }
        //dd($riz_resultats);
    // rice end

    // paiko start
        // 合計を初期化する
        $type_total = 0;
        $plat_total = 0;
        $katsu_total = 0;

        // 配列をループして集計する
        foreach ($paiko_collections_ary as $collections) {
            foreach ($collections as $item) {
                // "plat" の場合は $plat_total に加算する
                if (isset($item['plat'])) {
                    $plat_total += $item['plat']['qty'];
                }
                // "type" の場合は $type_total に加算する
                if (isset($item['type'])) {
                    $type_total += $item['type']['qty'];
                }
                // "katsu" の場合は $katsu_total に加算する
                if (isset($item['katsu'])) {
                    $katsu_total += $item['katsu']['qty'];
                }
            }
        }
        $paikos_ary = array('Type/Enfant'=> $type_total, 'Paiko (tapas)'=> $plat_total, 'Dunburi/Udon Katsu'=> $katsu_total);

        } // 　else end ビストロ日本終了 end

        // [画面表示用 設定] 
        // SelectBox初期化 店リスト  
        $shops = $this->get_shop_list();

        return view('admin/admin_consumed', compact(
                "product_collect",
                "extra_collect",
                "gyoza_collect",
                "ramen_datas",
                "total_qty_rmn",
                "udon_datas",
                "total_qty_udn",
                "paikos_ary",
                "riz_resultats",
                "shops"
        ));
    }

    /**
     * conso. 食材消費 index トップページ開く
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($btn = null, $page_id = null)
    {
        ini_set('display_errors', 'Off');
        $action_message = null;

        // select ボックス要素作成
        $shops = $this->get_shop_list();

        return view('admin/admin_consumed', compact('action_message','shops'));
    }

    /**
     * select box 作成 shop. 
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_shop_list($arg = null)
    {

        // select ボックス要素作成
        $shops = collect([
            ['id' => 'main', 'name' => 'bistro nippon'],
            ['id' => 'currykitano', 'name' => 'curry kitano'],
        ]);

        return $shops;
    }
}
