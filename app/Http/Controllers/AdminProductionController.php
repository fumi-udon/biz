<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use App\Models\AuthHanabishi;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;

class AdminProductionController extends Controller
{

    //protected $fillable = ['aply_date','flg_int','override_tx_1'];
    

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
    public function index($action_message = null)
    {
        if ( ! (Session::has('auth_flg') && Session::get('auth_flg') == true) ) {
            //管理者認証エラー
            $action_message = "[管理トップ]認証エラーがありました。";
            return view('welcome', compact('action_message'));
        }
        // PlanProduction テーブルラーメン設定値を取得 id 1 ->only(['id', 'name'])
        $plan_production=PlanProduction::where('id',1)->first()->toArray();

        // PlanProduction テーブルUDON設定値を取得 AM / PM
        $plan_production_idtwo = PlanProduction::where('id',2)->first()->toArray();
        
        // Stock データ取得
        $stock_ingredients = $this->prendre_stock();
        return view('admin/admin_production', compact('plan_production','plan_production_idtwo','action_message', 'stock_ingredients'));
    }

    /**
     * finance. 売上財務ページ表示
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function finance($btn = null, $page_id = null)
    {
        if ( ! (Session::has('auth_flg') && Session::get('auth_flg') == true) ) {
            //管理者認証エラー
            $action_message = "[財務ページ不正アクセス] 認証エラーがありました。";
            return view('welcome', compact('action_message'));
        }
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
        return view('admin/admin_finance', compact("recettes_months","ramen_datas","total_qty"));
    }

    /**
     * 「検証」. 管理者ページ表示 　POST
     *  Ajax 通信形式
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin_validate(Request $request, $page_id = null)
    {
        $inputs = $request->all();
        Log::debug($inputs);
        Log::debug($inputs['input_pass']);

        // パスワード認証 
        $adminpass = AuthHanabishi::where('user_name', '=', 'admin_page')->value('password');
        Log::debug($adminpass);
        // 認証チェック
        $auth_flg = false;
        // エラーメッセージ表示変数初期化
        $ermsg = "";
        $gourl = "dummy url";
        if($adminpass === $inputs['input_pass']){
            //パスワード認証OK
            $auth_flg = true; 
            $ermsg = "OK TODO move page admin";
            //セッションに認証OKフラグ立てる
            $request->session()->put("auth_flg","true");
        }else {
            $ermsg = "誰だよあんた!!";
        }

        return response()->json([
            'auth_flg' => $auth_flg,
            'gourl' => $gourl,
            'ermsg' => $ermsg
         ]);
    }

    /**
     * サト独自データ. 作成
     * Log::debug("XXXX:".$XXXX);
     * less +F /cygdrive/c/xampp/htdocs/business/storage/logs/laravel.log
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     * 
     * sato_type, sato_date, sato_content
     */
    public function store(Request $request, $btn_name, $page_id = null)
    {
        $inputs = $request->all();
        Log::debug($inputs);

        //同じ日付 and 同じ区分のレコードがある場合は update 
        //無い場合は Insert
        $sato_instruction = SatoInstruction::updateOrCreate(
                [
                    'aply_date' => $inputs['sato_date'],
                    'flg_int' => $inputs['sato_type']
                ],
                [
                    'override_tx_1' => $inputs['sato_content'],
                ]
        );

        $action_message = "ラッキーガールのサト丸ちゃんのデータ登録。上から目線かよ！！";
   
        return redirect()->route('admin.index',['action_message' => $action_message])->with([
            //画面引継ぎsession格納
            'sato_date' => $inputs['sato_date'],
            'sato_type' => $inputs['sato_type'],
            'sato_content' => $inputs['sato_content']
            ]);
    }
    /**
     * update. データ更新
     * Log::debug("XXXX:".$XXXX);
     * less +F /cygdrive/c/xampp/htdocs/business/storage/logs/laravel.log
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $btn_name, $page_id = null)
    {
        Log::debug("request:".$request);
        $inputs = $request->all();

        // database 値を更新
        // ramen の場合 id 1 ラーメンカラムをupdate
        if($btn_name == "ramen"){
            //ramen id 1
            Log::debug("ramen update ifの中:".$btn_name);
            $resultat_id = PlanProduction::where('id', '1')->update([
                'rmn_mon' => $inputs['rmn_mon'],
                'rmn_tue' => $inputs['rmn_tue'],
                'rmn_wed' => $inputs['rmn_wed'],
                'rmn_thu' => $inputs['rmn_thu'],
                'rmn_fri' => $inputs['rmn_fri'],
                'rmn_sat' => $inputs['rmn_sat'],
                'rmn_sun' => $inputs['rmn_sun'],
            ]);
            Log::debug("resultatid:".$resultat_id);
            //更新メッセージ
            $action_message = "らーめん個数の更新だい！";
        }

        // udon の場合 id 1 / id 2 Udon のカラムをupdate
        if($btn_name == "udon"){
            // udon id 1
            Log::debug("UDON 更新:".$btn_name);
            $resultat_id = PlanProduction::where('id', '1')->update([
                'udon_base_mon' => $inputs['udon_base_mon'],
                'udon_base_tue' => $inputs['udon_base_tue'],
                'udon_base_wed' => $inputs['udon_base_wed'],
                'udon_base_thu' => $inputs['udon_base_thu'],
                'udon_base_fri' => $inputs['udon_base_fri'],
                'udon_base_sat' => $inputs['udon_base_sat'],
                'udon_base_sun' => $inputs['udon_base_sun'],
            ]);
            Log::debug("UDON AM:".$resultat_id);
             // udon id 2
             $resultat_pmid = PlanProduction::where('id', '2')->update([
                'udon_base_mon' => $inputs['udon_base_mon2'],
                'udon_base_tue' => $inputs['udon_base_tue2'],
                'udon_base_wed' => $inputs['udon_base_wed2'],
                'udon_base_thu' => $inputs['udon_base_thu2'],
                'udon_base_fri' => $inputs['udon_base_fri2'],
                'udon_base_sat' => $inputs['udon_base_sat2'],
                'udon_base_sun' => $inputs['udon_base_sun2'],
            ]);
            Log::debug("UDON PM:".$resultat_pmid);
            $action_message = "うどん個数の更新だい！";
        }
        
        return redirect()->route('admin.index',['action_message' => $action_message]);
    }

    /**
     * アイシャデータ取得
     * Log::debug("XXXX:".$XXXX);
     * 
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function prendre_stock(){
        Log::debug("prendre_stock:アイシャデータ取得");
        $stock_ingredients = DB::table('stock_ingredients')
             ->select(DB::raw("udon_rest_15h as udon, article1_rest as riz, article2_rest as bouillons, DATE_FORMAT(registre_date,'%m月%d日') as registre_date"))
             ->where('flg1', '<>', 9)
             ->limit(15)
             ->orderBy('registre_date', 'desc')
             ->get();
        //Log::debug($stock_ingredients);
        \Session::flash('stock_ingredients', $stock_ingredients);
        return $stock_ingredients;
    }
}
