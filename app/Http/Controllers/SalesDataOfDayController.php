<?php

namespace App\Http\Controllers;

use App\Models\SalesDataOfDay;
use App\Http\Requests\StoreSalesDataOfDayRequest;
use App\Http\Requests\UpdateSalesDataOfDayRequest;

use Carbon\Carbon;

class SalesDataOfDayController extends Controller
{
    /**
     * Display a listing of the resource.
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
        // TODO (★cron引越し予定)
        // Json データで売上を取得してdatabase挿入
        
        // 売上 json data 取得
        $json = '[
            {
              "ID": 1,
              "table_number": 3,
              "serial_ID": "GHI789",
              "product_name": "ミートソーススパゲッティー",
              "product_type": "food",
              "product_toppings": {
                "パルメザンチーズ": 1,
                "ハム": 1,
                "たまご": 1,
                "ピーマン": 1
              },
              "product_price": 1000,
              "order_quantity": 1,
              "order_datetime": "2023-02-18T15:20:00+09:00",
              "concurrent_connections": 2,
              "active_flag": true,
              "category_id": 3,
              "category_name": "パスタ"
            },
            {
              "ID": 2,
              "table_number": 1,
              "serial_ID": "JKL012",
              "product_name": "コーヒー",
              "product_type": "drink",
              "product_toppings": {
                "ミルク": 1,
                "砂糖": 2
              },
              "product_price": 300,
              "order_quantity": 2,
              "order_datetime": "2023-02-18T17:35:00+09:00",
              "concurrent_connections": 1,
              "active_flag": true,
              "category_id": 4,
              "category_name": "ドリンク"
            },
            {
              "ID": 3,
              "table_number": 2,
              "serial_ID": "MNO345",
              "product_name": "サラダ",
              "product_type": "food",
              "product_toppings": {
                "チキン": 1,
                "トマト": 1,
                "アボカド": 1
              },
              "product_price": 800,
              "order_quantity": 1,
              "order_datetime": "2023-02-18T18:10:00+09:00",
              "concurrent_connections": 3,
              "active_flag": false,
              "category_id": 5,
              "category_name": "サラダ"
            }
        ]';

        $data = json_decode($json, true);

        foreach ($data as $order) {
            // key 注文日
            $order_date_json = Carbon::parse($order['order_datetime']);
            $order_date_json = $order_date_json->format('Ymd');

            $salesdataofday = SalesDataOfDay::updateOrCreate(
                [
                    'order_date' => $order_date_json
                ],
                [
                    'daily_json_data' => $order,
                ]
            );
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSalesDataOfDayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesDataOfDayRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesDataOfDay  $salesDataOfDay
     * @return \Illuminate\Http\Response
     */
    public function show(SalesDataOfDay $salesDataOfDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesDataOfDay  $salesDataOfDay
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesDataOfDay $salesDataOfDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalesDataOfDayRequest  $request
     * @param  \App\Models\SalesDataOfDay  $salesDataOfDay
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalesDataOfDayRequest $request, SalesDataOfDay $salesDataOfDay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesDataOfDay  $salesDataOfDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesDataOfDay $salesDataOfDay)
    {
        //
    }
}
