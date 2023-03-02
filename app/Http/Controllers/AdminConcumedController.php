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
     * conso. 食材消費
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($btn = null, $page_id = null)
    {
        if ( ! (Session::has('auth_flg') && Session::get('auth_flg') == true) ) {
            //管理者認証エラー
            $action_message = "[食材消費ページ不正アクセス] 認証エラーがありました。";
            return view('welcome', compact('action_message'));
        }

        // [食材消費量] Curl https通信＿SSL エラー回避
        $aujourdhui = now()->format("Y-m-d");
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            //'store' => 'currykitano',
            'store' => 'main',
            'date' => $aujourdhui,
        ]);

        $collections = collect($response->json());
        $total_qty_rmn = 0;
        $total_qty_udn = 0; 
        $ramen_datas = [];
        $udon_datas = [];

        // fumi独自クラス
        $fumi_tools =new FumiTools();
        foreach($collections as $collection) {    
            $items = collect($collection['items']);
            // test
            //var_dump($items->pluck('product_name_for_staff'));
            // test end
            foreach($items as $item) {
                $item = collect($item);
                $product_name_for_staff = data_get($item, 'product_name_for_staff');
                // ramen を使う料理名検索
                if ($product_name_for_staff === 'yksba' 
                || mb_stripos($product_name_for_staff, 'rmn') === 0
                || mb_stripos($product_name_for_staff, 'ramen') === 0
                || mb_stripos($product_name_for_staff, 'ramen') != false) {  
                    // 消費数合計計算して表示用配列作成
                    $ramen_datas[] = $fumi_tools->fumi_get_cons_array($item, 'rmn');
                    // ramen消費数合計
                    $qty = data_get($item, 'qty'); 
                    $total_qty_rmn += $qty;
                    // Ramen消費数カウント END 

                }else if(mb_stripos($product_name_for_staff, 'udon') === 0
                || mb_stripos($product_name_for_staff, 'udn') === 0
                || mb_stripos($product_name_for_staff, 'udn') != false
                || mb_stripos($product_name_for_staff, 'udon') != false){
                    // UDON 用消費数合計計算して表示用配列作成
                    $udon_datas[] = $fumi_tools->fumi_get_cons_array($item, 'udn');
                    // UDON 用消費数合計
                    $qty = data_get($item, 'qty'); 
                    $total_qty_udn += $qty;
                }
                
            }       

        }
        
        return view('admin/admin_consumed', compact("ramen_datas","total_qty_rmn","udon_datas","total_qty_udn"));
    }
}
