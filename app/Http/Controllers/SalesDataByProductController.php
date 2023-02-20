<?php

namespace App\Http\Controllers;

use App\Models\SalesDataByProduct;
use App\Models\StockIngredient;
use App\Http\Requests\StoreSalesDataByProductRequest;
use App\Http\Requests\UpdateSalesDataByProductRequest;
use Illuminate\Support\Facades\Log;

use App\FumiLib\FumiTools;

class SalesDataByProductController extends Controller
{
    /**
     * Display a listing of the resource.SalesDataByProduct
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::debug('SalesDataByProductController:create呼ばれた');
        // ◆Cron に引越し検討 radodataload:info
        // Jsonデータをロード
        // 本日の注文商品履歴を取得してSalesDataByProductに入れる。
        $jsonData = '[
            {
            "id": 1,
            "table_number": 3,
            "serial_id": 789,
            "product_name": "ミートソーススパゲッティー",
            "product_id": "220",
            "product_type": "food",
            "product_toppings": {
            "パルメザンチーズ": 1,
            "ハム": 1,
            "たまご": 1,
            "ピーマン": 1
            },
            "product_price": 1000,
            "category_id": 3,
            "category_name": "パスタ",
            "order_quantity": 1,
            "order_datetime": "2023-02-18 15:20:00",
            "concurrent_connections": 2,
            "active_flag": true
            },
            {
            "id": 2,
            "table_number": 5,
            "serial_id": 234,
            "product_name": "マルゲリータ",
            "product_id": "239",
            "product_type": "food",
            "product_toppings": {
            "モッツァレラチーズ": 1,
            "バジル": 1,
            "トマトソース": 1
            },
            "product_price": 900,
            "category_id": 3,
            "category_name": "ピザ",
            "order_quantity": 2,
            "order_datetime": "2023-02-18 15:24:20",
            "concurrent_connections": 3,
            "active_flag": true
            },
            {
            "id": 3,
            "table_number": 2,
            "serial_id": 56,
            "product_name": "アイスコーヒー",
            "product_id": "298",
            "product_type": "drink",
            "product_toppings": null,
            "product_price": 300,
            "category_id": 1,
            "category_name": "ドリンク",
            "order_quantity": 1,
            "order_datetime": "2023-02-18 18:35:03",
            "concurrent_connections": 1,
            "active_flag": true
            },
            {
            "id": 5,
            "table_number": 1,
            "serial_id": 81,
            "product_name": "ポテトフライup2",
            "product_id": "101",
            "product_type": "food",
            "product_toppings": null,
            "product_price": 500,
            "category_id": 2,
            "category_name": "サイドメニュー",
            "order_quantity": 3,
            "order_datetime": "2023-02-18 18:35:04",
            "concurrent_connections": 6,
            "active_flag": true
            }
            ]';
        
        $datas = json_decode($jsonData, true);
        foreach ($datas as $order) {
            Log::debug($order);
            $productToppingsJson = json_encode($order['product_toppings']);
            $order_json = json_encode($order);
            
            SalesDataByProduct::updateOrCreate(
                [                    
                    'serial_id' => $order['serial_id'],
                    'order_datetime' => $order['order_datetime'],
                    'table_number' => $order['table_number'],
                    'product_id' => $order['product_id']
                ],
                [
                    'table_number' => $order['table_number'],
                    'serial_id' => $order['serial_id'],
                    'product_name' => $order['product_name'],
                    'product_id' => $order['product_id'],
                    'product_type' => $order['product_type'],
                    'product_toppings' => $productToppingsJson,
                    'product_price' => $order['product_price'],
                    'category_id' => $order['category_id'],
                    'category_name' => $order['category_name'],
                    'order_quantity' => $order['order_quantity'],
                    'order_datetime' => $order['order_datetime'],
                    'concurrent_connections' => $order['concurrent_connections'],
                    'active_flag' => $order['active_flag'],
                    'json_data' => $order_json
                ]
            );
        }
        $st_flg = true;
        return view('welcome')->with(['表示ステータス: ' => $st_flg]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSalesDataByProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesDataByProductRequest $request)
    {
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesDataByProduct  $salesDataByProduct
     * @return \Illuminate\Http\Response
     */
    public function show(SalesDataByProduct $salesDataByProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesDataByProduct  $salesDataByProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesDataByProduct $salesDataByProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalesDataByProductRequest  $request
     * @param  \App\Models\SalesDataByProduct  $salesDataByProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalesDataByProductRequest $request, SalesDataByProduct $salesDataByProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesDataByProduct  $salesDataByProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesDataByProduct $salesDataByProduct)
    {
        //
    }
}
