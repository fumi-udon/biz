<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
//Fumi 独自クラス
use App\FumiLib\FumiTools;
use Illuminate\Support\Facades\Log;

class BureauItemsController extends Controller
{
    /**
     * Index. 事務所から運ぶ在庫ページ表示
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($action_message = null)
    {
        // select ボックス要素作成
        $fromages = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
        ]);
        $tantans = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => 'moins 1'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
        ]);
        $rmn_tappers = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
        ]);

        $bbqs = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
        ]);

        $teri_bfs = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
        ]);

        $gyozas = collect([
            ['id' => '', 'name' => ''],
            ['id' => '0', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
        ]);

        $session__all = \Session::all();
        Log::debug($session__all);
        return view('bureau_items', compact('action_message','fromages', 'tantans', 'rmn_tappers', 'bbqs', 'teri_bfs', 'gyozas'));
    }

    /**
     * 登録処理
     * Detabase登録処理
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bureau_store(Request $request, $id=null, $params=null)    {

        $inputs = $request->all();

        // リクエストデータ取得 tantans
        $req_fmg = $inputs['fmg_list'];
        $req_tntn = $inputs['tntn_list'];
        $req_rmn = $inputs['rmn_list'];

        $req_bbq = $inputs['bbq_list'];
        $req_teri_bf = $inputs['teri_bf_list'];
        $req_gyoza = $inputs['rmn_gyoza'];


        // // StockIngredient テーブル 
        // date_default_timezone_set('Africa/Tunis');
        // $stock_ingredient = StockIngredient::updateOrCreate(
        //     [
        //         'registre_date' => date('Y-m-d'),
        //         'flg1' => 1
        //     ],
        //     [
        //         'udon_rest_15h' => $req_udn,
        //         'article1_rest' => $req_riz,
        //         'article2_rest' => $req_bil,
        //         'registre_date' => date('Y-m-d'),
        //         'registre_datetime' => now(),
        //     ]
        // );

        // // session 格納
        \Session::flash('flash_message', 'MERCI pour inputs!'.
            '<br>Frmage:'.$req_fmg.
            '<br>Tantan:'.$req_tntn.
            '<br>Ramen boites:'.$req_rmn.
            '<br>req_bbq boites:'.$req_bbq.
            '<br>req_teri_bf boites:'.$req_teri_bf.
            '<br>req_gyoza:'.$req_gyoza
        );

        // リダイレクト
        return redirect()->route('bureau.index')->with([
            //画面引継ぎsession格納 
            'fmg_now' => $req_fmg,
            'tntn_now' => $req_tntn,
            'tapper_now' => $req_rmn,
            'bbq_now' => $req_bbq,
            'teri_bf_now' => $req_teri_bf,
            'gyoza_now' => $req_gyoza,
            ]);
    }
}
