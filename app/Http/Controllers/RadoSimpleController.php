<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
 

// use App\Models\SatoInstruction;
// use App\Models\PlanProduction;
// use App\Models\StockIngredient;
// use App\Models\AuthHanabishi;

class RadoSimpleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // 初期設定 setting init
    }


    /**
     * Index. 管理者ページ表示
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lists = [now()->format('Y-m'), 
            now()->modify("-1 months")->format("Y-m")];

        $recettes_months = [];
        foreach($lists as $datemonth){
            // SSL エラー回避
            $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
                //'store' => 'currykitano',
                'store' => 'main',
                'date' => $datemonth,
            ]);
            $collc = collect($response->json());

            $recettes_months[] = [(string)$datemonth => $collc->pluck('total')->sum()];
        }

        // [食材消費量] Curl https通信＿SSL エラー回避
        $aujourdhui = now()->modify("-2 months")->format("Y-m-d");
        $response2 = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            //'store' => 'currykitano',
            'store' => 'main',
            'date' => $aujourdhui,
        ]);

        // Ramen消費数カウント
        $collections2 = collect($response2->json());
        $total_qty = 0;
        $i = 0;
        $ramen_datas = [];

        foreach($collections2 as $collection) {    
            $items = collect($collection['items']);
            foreach($items as $item) {
                $item = collect($item);
                $i++;
                $product_name_for_staff = data_get($item, 'product_name_for_staff');

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
                    $total_qty += $qty;
                }
            }       

        }
        // Ramen消費数カウント END
        $json_datas = [];

        return view('dev/rado_simple', compact("recettes_months","ramen_datas","total_qty"));
    }

}
