<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use Illuminate\Support\Facades\Config; // Configクラスをインポートする

//Fumi 独自クラス
use App\FumiLib\FumiTools;

use Illuminate\Support\Facades\Log;

class TaskOrderController extends Controller
{
    /**
     * Show the cals page dashboard.
     * Log::debug("XXXX:".$XXXX);
     * less +F /cygdrive/c/xampp/htdocs/business/storage/logs/laravel.log
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function matin8h()    {
        /**
         * Satoの手動指示がある場合は優先表示
         */
        $date_today = date_create()->format('Y-m-d');          
        $sato_instruction = SatoInstruction::where([
            //AMの指示を取得
            ['flg_int', '=', '1'],
            ['aply_date', '=', $date_today]
        ])->first();

        $yes_sato = false;
        if(! is_null($sato_instruction)){
            // サトの独自指示がある場合は viewをgetして処理終了
            //dd('サト指示あり'.$sato_instruction);
            $yes_sato = true;
        }
        return view('matin8h',compact('sato_instruction','yes_sato'));
    }

    /**
     * Chantal 15Hリンクから.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function soir15h()    {
        /**
         * Satoの手動指示がある場合は優先表示
         * PM用は flg 2
         */
        $date_today = date_create()->format('Y-m-d');   
        $sato_record = SatoInstruction::where([
            // PM 2
            ['flg_int', '=', '2'],
            ['aply_date', '=', $date_today]
        ])->first();

        if(! empty($sato_record)){
            //dd($sato_record);
            //サト指示有の為 表示
            $st_flg = 1;
            \Session::flash('sato_record', $sato_record);
            return view('soir15h')->with(['表示ステータス: ' => $st_flg]);
        }

        /**
         * アイシャデータ取得 PM id = 2
         * 
         */
        $stock_record = StockIngredient::where([
            ['flg1', '=', '1'],
            ['registre_date', '=', $date_today]
        ])->first();

        // ★TODO stock_recordが無い場合は以降するーしてviewをゲット
        if(empty($stock_record)){
            //アイシャデータ登録忘れの為エラーメッセージ表示
            $st_flg = 2;
            return view('soir15h')->with(['表示ステータス: ' => $st_flg]);
        }

        // PlanProduction テーブルから本日のうどん基準数を取得 (id=2 PM)
        $plan_production = PlanProduction::where([
            // PM 2
            ['id', '=', '2']
        ])->first();

        // Fumi 独自クラスインスタンス化
        $fumi_tools =new FumiTools();
        $return_ybi = $fumi_tools->fumi_get_youbi_for_table(date('w'));
        $column = 'udon_base_'.$return_ybi;

        // 本日の必要うどん数取得（曜日毎）
        $udon_base_cnt = $plan_production->$column;
        // 一玉から取れるうどんの数 portion_par_udon
        $portions = $plan_production->portion_par_udon;
        // 残りのうどん数（Aicha入力データ）取得
        $rests = $stock_record->udon_rest_15h;

        $result = (int)$udon_base_cnt - $rests;
        
        if ($result <= 0) {
            // 切る麺を０に設定
            $result = (int)0;
        } else {
                if($result %$portions != 0){
                    // $portions で割り切れない	小数点以下第一位表示			
                    $result = number_format($result / $portions, 1);
                    if($result <= 0.5){
                        // 0.5以下は0.5にする
                        $result = (float)0.5;
                    }
                }else{
                    // $portions で割り切れる 整数表示
                    $result = $result / $portions;
                }
            }

        // session 格納        
        \Session::flash('stock_record', $stock_record);

        // 表示ステータス 通常指示表示
        return view('soir15h',compact('result'))->with(['表示ステータス: ' => 0]);
    }

    /**
     * Show the cals page dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function task15h()    {
        return view('soir15h');
    }

    /**
     * アイシャ15時登録ページトップ.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bn_register_top(){    
            
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

        $session__all = \Session::all();
        Log::debug($session__all);

        return view('bn_register_ingredient', compact('rizs','bouillons'));
    }

    /**
     * アイシャ15時登録ページ 登録処理
     * Detabase登録処理
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bn_register_store(Request $request, $id=null, $params=null)    {

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

    /**
     * 朝8時のシャンタルの麺回し数表示
     * 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function task8h(Request $request)
    {
        // Post データ取得
        $attributes = $request->only(['rest_udn', 'actual_page_id']);
        // Sessionにデータ保持
        \Session::flash('rest_udn', $attributes['rest_udn']);
        $date_today = date_create()->format('Y-m-d'); 
        /**
         * Note取得
         * Table作るの面倒だから設定ファイルで
         */
        $note_today = Config::get('fumi_note_alice.'.$date_today);
        /**
         * Satoの手動指示がある場合は優先表示
         */
               
        $sato_instruction = SatoInstruction::where([
            //AMの指示を取得
            ['flg_int', '=', '1'],
            ['aply_date', '=', $date_today]
        ])->first();
        $yes_sato = false;
        if(! is_null($sato_instruction)){
            // サトの独自指示がある場合は viewをgetして処理終了
            //dd('サト指示あり'.$sato_instruction);
            $yes_sato = true;
            return view('matin8h',compact('sato_instruction','yes_sato','attributes','note_today'));
        }

        /**
         * table:plan_productions
         * ラーメンの数取得
         */
        // Fumi 独自クラスインスタンス化
        $fumi_tools =new FumiTools();
        $return_ybi = $fumi_tools->fumi_get_youbi_for_table(date('w'));
        $target_col = 'rmn_'.$return_ybi;
        //AM id 1
        $rmn_today = PlanProduction::where('id', '=', '1')->value($target_col);

         /**
         * table:plan_productions
         * うどんのベース数取得して計算
         */   
        // 一玉何麺とれるか 設定ファイルから取得
        $portions = (int)PlanProduction::where('id', '=', '1')->value('portion_par_udon');
        $rests = (int)$attributes['rest_udn'];

        // // DBから取得
        $return_ybi = $fumi_tools->fumi_get_youbi_for_table(date('w'));
        $target_col = 'udon_base_'.$return_ybi;

        // // TODO base数取得
        $udon_base_cnt = PlanProduction::where('id', '=', '1')->value($target_col);
        $result = (int)$udon_base_cnt - $rests;
  
        
        if ($result <= 0) {
            // 切る麺を０に設定
            $result = (int)0;
        } else {
            if($result %$portions != 0){
                // $portions で割り切れない	小数点以下第一位表示			
                $result = number_format($result / $portions, 1);
                if($result <= 0.5){
                    // 0.5以下は0.5にする
                    $result = (float)0.5;
                }
            }else{
                // $portions で割り切れる 整数表示
                $result = $result / $portions;
            }            
        }
        $udon_today = $result;
        //dd ($udon_today);
        
        
        return view('matin8h',compact('rmn_today','udon_today','sato_instruction','attributes','note_today'));
    }

    
}
