<?php

namespace App\Http\Controllers;

use App\Models\SalesDataByProduct;
use App\Http\Requests\StoreSalesDataByProductRequest;
use App\Http\Requests\UpdateSalesDataByProductRequest;

class SalesDataByProductController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSalesDataByProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesDataByProductRequest $request)
    {
        // Jsonデータをロードしてデータベースに入れる
        // 全てのオーダー商品履歴を取得して入れる。
        $jsonData = $request->json()->all();

        // 例1
        SalesDataByProduct::create([
            'id' => $jsonData['id'],
            'product_name' => $jsonData['product_name'],
            'date' => $jsonData['date'],
            'price' => $jsonData['price']
        ]);
        
        // 例2
        SalesDataByProduct::updateOrCreate(
            ['id' => $jsonData['id']],
            [
                'product_name' => $jsonData['product_name'],
                'category_name' => $jsonData['category_name'],
                'extra_name' => $jsonData['extra_name'],
                'date' => $jsonData['date'],
                'price' => $jsonData['price']
            ]
        );

        return response()->json(['success' => true]);
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
