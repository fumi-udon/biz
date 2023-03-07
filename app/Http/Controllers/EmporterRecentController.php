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
        // select ボックス要素作成
        $shops = collect([
            ['id' => 'main', 'name' => 'bistro nippon'],
            ['id' => 'currykitano', 'name' => 'curry kitano'],
        ]);
        $types = collect([
            ['id' => '1', 'name' => 'all'],
            ['id' => '2', 'name' => 'emporter'],
        ]);
        return view('emporter_recent', compact('action_message','shops','types'));
    }

    /**
     * 注文データ全て表示検索
     * emporter_recent
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request, $type=null, $shop=null)
    {
        // select ボックス要素作成
        $shops = collect([
            ['id' => 'main', 'name' => 'bistro nippon'],
            ['id' => 'currykitano', 'name' => 'curry kitano'],
        ]);
        $types = collect([
            ['id' => '1', 'name' => 'all'],
            ['id' => '2', 'name' => 'emporter'],
        ]);

        $inputs = $request->all();
        // dd($inputs);
        // リクエストデータ取得
        $input_date = $inputs['input_date'];
        $input_type = $inputs['type_list'];
        $input_shop = $inputs['shop_list'];
        // session 格納
        \Session::flash('input_date', $input_date);
        \Session::flash('type_now', $input_type);
        \Session::flash('shop_now', $input_shop);
        // [食材消費量] Curl https通信＿SSL エラー回避 
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            //'store' => 'currykitano',
            'store' => $input_shop,
            'date' => $input_date,
        ]);
       
        $collections = collect($response->json());       
        // chat GPT  
        // all / emporter
        $filtered = collect();
        if(isset($input_type) && $input_type == 1){
            //all
            Log::debug('xxx: all  search_________ '.$input_type);
            $filtered = collect($collections)->where('addition_finished',1)->sortByDesc('end_date')->values()->toArray();
        }else{
            // emporter:2 
            $filtered = collect($collections)->where('takeout' ,'==', 1)->where('addition_finished',1)->sortByDesc('end_date')->values()->toArray();
        }
       
        if(empty($filtered)){
            $action_message = 'データ無いよー。ものほんの営業日っすか？';
            return view('emporter_recent', compact('action_message','shops','types'));
        }

        $collection = collect($filtered)->values()->toArray();        
        // 加工後のデータを格納する配列を初期化する
        $result = [];
        // Collectionの各要素に対して処理を行う
        collect($collection)->each(function ($order) use (&$result){
            $table_number = $order['table_number'];     
            $name = $order['name'];       
            foreach($order['items'] as $item){
                // ingredientsに値のあるデータが存在する場合に、必要なデータを加工する
                if ($item['ingredients']) {
                    // name_for_staffキーの値を取得し、カンマ区切りで結合する
                    $name_for_staff = collect($item['ingredients'])->pluck('name_for_staff')->implode(', ');

                    // 必要なデータを配列に追加する
                    $result[] = [
                        'table_number' => $table_number,
                        'name' => $name,
                        'product_name_for_staff' => $item['product_name_for_staff'],
                        'product_type_name_for_staff' => $item['product_type_name_for_staff'],
                        'qty' => $item['qty'],
                        'ingredients' => "($name_for_staff)"
                    ];
                } else {
                    // ingredientsに値がない場合は、必要なデータを配列に追加する
                    $result[] = [
                        'table_number' => $table_number,
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
        return view('emporter_recent', compact('result','shops','types'));
    }

    // 画面表示用のオブジェクト作成関連
    public function create_display_objects()
    {

    }
}
