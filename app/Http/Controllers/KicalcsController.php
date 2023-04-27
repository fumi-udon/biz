<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\KitanoCurryAmount;

class KicalcsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the cals page dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('kicalcs');
    }

   /**
     * 「DB」. kitano_curry_amountsテーブル
     *  Ajax 通信形式
     *  スープの量を登録
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function reg_amounts(Request $request)
    {
        Log::debug('やっとだよ。カレー屋');
        Log::debug($request);
        $inputs = $request->all();
        // リクエストデータ取得
        $bouillons = $inputs['number'];
        Log::debug($bouillons);

        $r = $bouillons * 0.155;
        $roux = floor($r);

        $p = $bouillons * 0.0036;
        $poudre = floor($p);

        Log::debug($roux);
        Log::debug($poudre);

        try {
            $kitano_curry_amount  = new KitanoCurryAmount;
            $kitano_curry_amount ->bouillons = $bouillons;
            $kitano_curry_amount ->pate = $roux;
            $kitano_curry_amount ->poudre = $poudre;
            $kitano_curry_amount ->save();
            
            // 成功時の処理
        } catch (\Exception $e) {
            Log::debug($e);
        }

        return response()->json([
            'roux' => $roux,
            'poudre' => $poudre
         ]);
    }
}
