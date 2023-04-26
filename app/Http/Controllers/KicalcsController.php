<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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

        $auth_flg = false;
        $ermsg = "dummy ermsg";
        $gourl = "dummy url";

        return response()->json([
            'auth_flg' => $auth_flg,
            'gourl' => $gourl,
            'ermsg' => $ermsg
         ]);
    }
}
