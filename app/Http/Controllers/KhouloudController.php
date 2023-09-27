<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする
use Illuminate\Support\Collection;
//Fumi 独自クラス 
use App\FumiLib\FumiTools;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
use App\Models\PlanProduction;
use App\Models\SatoInstruction;
use App\Models\StockCuisineMain;

use Carbon\Carbon;

class KhouloudController extends Controller
{
    /**
     * メニュー ページ
     */
    public function khouloud_top()
    {
        $today = (new DateTime())->format('Y-m-d');
       
        return view('khouloud_top', compact('today'));
    }
    
    /**
     * 入力 ページ
     */
    public function khouloud_commence_input()
    {
        $today = (new DateTime())->format('Y-m-d');
        // 曜日を取得 Fumi 独自クラスインスタンス化 
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));

        // select ボックス要素作成
        $patecurry = $this->get_select_values('patecurry');
        $pomme_de_terre = $this->get_select_values('line_5piece');
        $apple = $this->get_select_values('line_2piece');
        
        /**
         * Satoの手動指示がある場合は優先表示
         * flg 11 [上書き]
         */
        $date_today = date_create()->format('Y-m-d');   
        $sato_record_override = SatoInstruction::where('flg_int', 11)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();
        if(! empty($sato_record_override)){
            //[上書き]サト指示有の為 表示
            \Session::flash('sato_record_override', $sato_record_override);
        }
        
        /**
         * Satoの手動指示がある場合は優先表示
         * flg 12 [追加]
         */
        $sato_record_add = SatoInstruction::where('flg_int', 12)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();
        if(! empty($sato_record_add)){
            //[上書き]サト指示有の為 表示
            \Session::flash('sato_record_add', $sato_record_add);
        }

        // 登録データ表示
        $columns = [
            'created_at',
            'patecurry',
            'pomme_de_terre',
            'apple',
            'bn1' // okonomiyaki
         ];

        $stock_cuisine_main = StockCuisineMain::select($columns)
            ->where('shop', '=', 'bn') // 最初の条件
            ->where('page_id', '=', 'khouloud_commence_input') // 条件
            ->where('fuseaux', '=', 'am')   // 条件
            ->orderBy('created_at', 'desc') // 'created_at' カラムを降順にソート
            ->limit(6) // 最新の5行を取得
            ->get();

        return view('khouloud_commence_input', compact(
            'today',
            'daysoftheweek',
            'patecurry',
            'pomme_de_terre',
            'apple',
            'stock_cuisine_main',
            'columns',
        ));
    }

    /**
     * 登録 ページ
     */
    public function khouloud_commence_store(Request $request)
    {
        $inputs = $request->all();
        $today = (new DateTime())->format('Y-m-d');
        // 曜日を取得 Fumi 独自クラスインスタンス化 
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));
        // session 格納
        \Session::flash('flash_message', 'MERCI<br>Les données sont envoyées correctement');
        \Session::flash('patecurry_now', $inputs['patecurry']);
        \Session::flash('pomme_de_terre_now', $inputs['pomme_de_terre']);
        \Session::flash('apple_now', $inputs['apple']);
        \Session::flash('okonomiyaki_now', $inputs['bn1']);
        
        \Session::flash('daysoftheweek', $daysoftheweek);

        // PlanProduction テーブルからカレー作り取得 (id=8)
        $plan_production = PlanProduction::where([
            // ID 8
            ['id', '=', '8']
        ])->first();
        $fumi_tools =new FumiTools();
        $column = $fumi_tools->fumi_get_youbi_for_table(date('w'));
        $curry = $plan_production->$column;

        // StockMainsテーブルに登録
        $inputs['shop'] = 'bn';
        $inputs['page_id'] = 'khouloud_commence_input';
        $inputs['fuseaux'] = 'am';
        $inputs['staff'] = 'khouloud';  
        StockCuisineMain::create($inputs);

        // method_name
        $method_name = 'store';

        // リダイレクト
        return redirect()->route('khouloud.commence.input')->with([
            //画面引継ぎsession格納
            'today' => $today,
            'method_name' => $method_name,
            'curry' => $curry,
            'daysoftheweek' => $daysoftheweek,
            ]);
    }

    /**
     * select values
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_select_values($s_id){
         // select ボックス
        if($s_id == 'patecurry'){
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => '1', 'name' => 'trés peu'],
                ['id' => '2', 'name' => 'un peu'],
                ['id' => '3', 'name' => 'moins que moitié'],
                ['id' => '4', 'name' => 'la moitié'],
                ['id' => '5', 'name' => 'plus que la moité'],
                ['id' => '6', 'name' => 'beaucoup'],
            ]);
            return $cols;
        }
         // select ボックス
         if($s_id == 'line_5piece'){
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => '1', 'name' => 'rien'],
                ['id' => '2', 'name' => 'moins que 5 pièces'],
                ['id' => '3', 'name' => 'moyen'],
                ['id' => '4', 'name' => 'beaucoup'],
            ]);
            return $cols;
        }

         // select ボックス
         if($s_id == 'line_2piece'){
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => '1', 'name' => 'rien'],
                ['id' => '2', 'name' => 'moins que 2 pièces'],
                ['id' => '3', 'name' => '3 pièces ～ 5 pièces'],
                ['id' => '4', 'name' => 'plus que 5 pièces'],
            ]);
            return $cols;
        }

        // select ボックス
        if($s_id == 'standard'){
            $cols = collect([
                ['id' => '', 'name' => ''],
                ['id' => '1', 'name' => 'rien'],
                ['id' => '2', 'name' => 'trés peu'],
                ['id' => '3', 'name' => 'un peu'],
                ['id' => '4', 'name' => 'moyen'],
                ['id' => '5', 'name' => 'beaucoup'],
            ]);
            return $cols;
        }

    }

    /**
     * select values
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function send_mail($bravo, $bodys){
            // Mail 送信
            $to = ['fumi.0000000@gmail.com'];
            $cc = ['satoe1227@outlook.com']; // カーボンコピーの場合
            $log_text = "[BN: ホルホルスタート] ";
    
            $datas = [
                'log' => $log_text.'Mail',
                'type' => 10, // 21: Khouloud系
                'color' => 'green', //  ホルホル
            ];
            $subject = $log_text;
            // コレクションを作成し、変数を設定します
            $body = new Collection([
                'test' => $bodys['test'],
            ]);
    
            if (env('APP_ENV') == 'production') {
                // 本番環境の場合のみメール送信
                FumiTools::send_mail_db_reg_khouloud(true, $to, $cc, $subject, $body, $datas);
            }else{
                Log::debug("[メール送信_send_mail_db_reg_khouloud ホルホル朝活メール] 本番環境のみ");
            }
    }

}
