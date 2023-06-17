<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class CheckListController extends Controller
{

    /**
     * 閉店チェックList.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close_top(){    
            
        // input create
        // select ボックス要素作成
        $rizs = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
        ]);
        $bouillons = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => 'moins 1L'],
            ['id' => '1', 'name' => '1L'],
            ['id' => '2', 'name' => '2L'],
            ['id' => '3', 'name' => '3L'],
            ['id' => '4', 'name' => '4L'],
            ['id' => '5', 'name' => '5L'],
        ]);
        // select ボックス要素作成 END

        $session__all = \Session::all();
        Log::debug($session__all);

        return view('chk_close_top', compact('rizs','bouillons'));
    }

    /**
     * アイシャ15時登録ページ 登録処理
     * Detabase登録処理
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close_store(Request $request)    {

        $inputs = $request->all();

        // リクエストデータ取得
        $req_udn = $inputs['udon_rest_8h'];
        $req_riz = $inputs['rizs_list'];
        $req_bil = $inputs['bouillons_list'];

        // StockIngredient テーブル
        date_default_timezone_set('Africa/Tunis');
        $stock_ingredient = StockIngredient::updateOrCreate(
            [
                'registre_date' => date('Y-m-d'),
                'flg1' => 1
            ],
            [
                'udon_rest_15h' => $req_udn,
                'article1_rest' => $req_riz,
                'article2_rest' => $req_bil,
                'registre_date' => date('Y-m-d'),
                'registre_datetime' => now(),
            ]
        );

        // session 格納
        \Session::flash('flash_message', 'MERCI Aicha!'.
            '<br>UDON:'.$req_udn.
            '<br>RIZ:'.$req_riz.
            '<br>BOUILLONS:'.$req_bil
        );

        // リダイレクト
        return redirect()->route('bn.register.top')->with([
            //画面引継ぎsession格納
            'udon_rest_8h' => $req_udn,
            'riz_now' => $req_riz,
            'bouillon_now' => $req_bil,
            ]);
    }
}
