<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする

//Fumi 独自クラス
use App\FumiLib\FumiTools;


class EmporterRecentController extends Controller
{
    /**
     * Index.　トップ　アンポルテ表示
     * emporter_recent
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($action_message = null)
    {
        return view('emporter_recent', compact('action_message'));
    }

    /**
     * 直近アンポルテ表示検索
     * emporter_recent
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request, $id=null, $params=null)
    {
        $inputs = $request->all();
        // リクエストデータ取得
        $input_date = $inputs['input_date'];
        //dd($input_date);
        // session 格納
        \Session::flash('input_date', $input_date);

        // [食材消費量] Curl https通信＿SSL エラー回避
        // $aujourdhui = now()->format("Y-m-d");
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            //'store' => 'currykitano',
            'store' => 'main',
            'date' => $input_date,
        ]);
        
        $collections = collect($response->json());
        // chat GPT  
        $filtered = collect($collections)->where('takeout' ,'==', 1)->where('addition_finished',1)->sortByDesc('end_date')->slice(0, 3)->values()->toArray();
        if(empty($filtered)){
            $action_message = 'データ無いよー。ものほんの営業日っすか？';
            return view('emporter_recent', compact('action_message'));
        }

        $collection = collect($filtered)->values()->toArray();        
        // 加工後のデータを格納する配列を初期化する
        $result = [];
        // Collectionの各要素に対して処理を行う
        collect($collection)->each(function ($order) use (&$result){
            $name = $order['name'];       
            foreach($order['items'] as $item){
                // ingredientsに値のあるデータが存在する場合に、必要なデータを加工する
                if ($item['ingredients']) {
                    // name_for_staffキーの値を取得し、カンマ区切りで結合する
                    $name_for_staff = collect($item['ingredients'])->pluck('name_for_staff')->implode(', ');

                    // 必要なデータを配列に追加する
                    $result[] = [
                        'name' => $name,
                        'product_name_for_staff' => $item['product_name_for_staff'],
                        'product_type_name_for_staff' => $item['product_type_name_for_staff'],
                        'qty' => $item['qty'],
                        'ingredients' => "($name_for_staff)"
                    ];
                } else {
                    // ingredientsに値がない場合は、必要なデータを配列に追加する
                    $result[] = [
                        'name' => $name,
                        'product_name_for_staff' => $item['product_name_for_staff'],
                        'product_type_name_for_staff' => $item['product_type_name_for_staff'],
                        'qty' => $item['qty'],
                        'ingredients' => ''
                    ];
                }
            }
        });
        // chat GPT edn
        return view('emporter_recent', compact('result'));
    }
}
