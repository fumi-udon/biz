<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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

        // Ramen消費数カウント
        $collections = collect($response->json());
        $total_qty = 0;
        $ramen_datas = [];

        foreach($collections as $collection) {    
            $items = collect($collection['items']);
            foreach($items as $item) {
                $item = collect($item);
                $product_name_for_staff = data_get($item, 'product_name_for_staff');
                // ramen を使う料理名検索
                if ($product_name_for_staff === 'yksba' 
                || strpos($product_name_for_staff, 'RMN') === 0
                || strpos($product_name_for_staff, 'rmn') === 0
                || strpos($product_name_for_staff, 'Rmn') === 0) {                    
                    // id
                    $order_id = data_get($item, 'order_id');
                    $created_at = data_get($item, 'created_at');
                    $formatted_date = \Carbon\Carbon::parse($created_at)->format('Y年m月d日 H時i分');
                    $product_type_name_for_staff = data_get($item, 'product_type_name_for_staff');
                    $qty = data_get($item, 'qty'); 
                    $ex_order = compact('order_id', 'formatted_date', 'product_name_for_staff','product_type_name_for_staff','qty');
                    $ramen_datas[] = $ex_order;
                    // ramen消費数合計
                    $total_qty += $qty;
                }
            }       

        }
        // Ramen消費数カウント END
        return view('admin/admin_consumed', compact("ramen_datas","total_qty"));
    }
}
