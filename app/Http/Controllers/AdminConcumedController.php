<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

//Fumi 独自クラス
use App\FumiLib\FumiTools;

class AdminConcumedController extends Controller
{
    /**
     * conso. 検索
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request, $id=null, $params=null)
    {
        $inputs = $request->all();
        // リクエストデータ取得
        $input_date = $inputs['input_date'];
        //dd($input_date);
        // session 格納
        \Session::flash('input_date', $input_date);

        // [食材消費量] Curl https通信＿SSL エラー回避
        // $aujourdhui = now()->format("Y-m-d");
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            //'store' => 'currykitano',
            'store' => 'main',
            'date' => $input_date,
        ]);

        $collections = collect($response->json());
        $total_qty_rmn = 0;
        $total_qty_udn = 0;        
        $ramen_datas = [];
        $udon_datas = [];
        //collectionクラスが格納される
        $paiko_collections_ary = [];

        //お米データ取得 collectionクラスが格納される (RIZ用)
        $rice_collections_ary = [];
        //お米使う商品名 TODO conf ファイルから取得
        $riz_plats_name = 'DONBURI,ONIGIRI,ENFANT RIZ,RIZ BLANC';
        $riz_types_name = 'DONBURI,RIZ,RIZ BLANC';
        $riz_extras_name = 'RIZ,RIZ BLANC';
        //dd ($collections);

        // fumi独自クラス
        $fumi_tools =new FumiTools();

        // TODO Start
        // extra_seach_name に記載したextraのオーダー数を取得する        
        $extra_collect = collect();        
        $extra_seach_name=['fmg','wkm','oeuf','spicy','diable','katsuobushi','ail','nori','riz','soup','gari','salad'];
        foreach($extra_seach_name as $key){
            $total_qty_extra = 0;
            foreach($collections as $collection) {
                $items = collect($collection['items']);
                $filtered = $items->filter(function ($order) {
                    return count($order['ingredients']) > 0;
                });
                //dd($filtered);
                $filtered_v2 = $filtered->map(function ($order) use ($key) {
                    $ingredients = collect($order['ingredients'])->filter(function ($ingredient) use ($key) {
                        return str_contains($ingredient['name_for_staff'], $key);
                    })->all();
                    return array_merge($order, ['ingredients' => $ingredients]);
                })->filter(function ($order) {
                    return count($order['ingredients']) > 0;
                });
                $total_qty_extra += collect($filtered_v2)->sum('qty');
                
            }
            $extra_collect->push([$key => $total_qty_extra]);
        }        
        //dd($extra_collect);
        // TODO end

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
                $riz_collection = $fumi_tools->fumi_get_consom_pn_staff($item, $riz_plats_name,$riz_types_name, $riz_extras_name);
                if (! $riz_collection->isEmpty()) {
                    $rice_collections_ary[] = $riz_collection;
                }
                
            } // foreach インナー end
        }// foreach 親 end
log::debug($total_qty_extra);
    // rice start
        // 配列をループして集計する
        $riz_collections = collect($rice_collections_ary);
        // カンマを区切り文字として、文字列を配列に変換する
        $riz_plats = explode(',', $riz_plats_name);
        $riz_types = explode(',', $riz_types_name);
        $riz_extras = explode(',', $riz_extras_name);

        // 配列の各要素にアクセスする
        $tatal_order = [];
        //集計結果
        $riz_resultats = collect();
        foreach ($riz_plats as $key) {
            $tatal_order = $riz_collections->pluck('products.'.$key)->sum();
            $riz_resultats->push([$key => $tatal_order]);
        }
        foreach ($riz_extras as $key) {
            $tatal_order = $riz_collections->pluck('extras.'.$key)->sum();
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
        $paikos_ary = array('Typeと子供メニュー'=> $type_total, 'パイコー（タパス）'=> $plat_total, 'かつ丼orうどんかつ'=> $katsu_total);
        
        // paiko end
        return view('admin/admin_consumed', compact("extra_collect","ramen_datas","total_qty_rmn","udon_datas","total_qty_udn","paikos_ary","riz_resultats"));
    }
    /**
     * conso. 食材消費 index トップページ開く
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($btn = null, $page_id = null)
    {
        $action_message = null;
        if ( ! (Session::has('auth_flg') && Session::get('auth_flg') == true) ) {
            //管理者認証エラー
            $action_message = "[食材消費ページ不正アクセス] 認証エラーがありました。";
            return view('welcome', compact('action_message'));
        }
        return view('admin/admin_consumed', compact('action_message'));
    }
}
