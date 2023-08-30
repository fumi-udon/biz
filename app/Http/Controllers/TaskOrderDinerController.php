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
//model
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use Carbon\Carbon;

class TaskOrderDinerController extends TaskOrderController
{
    /**
     * 入力ページ
     */
    public function cuisine_diner_top()
    {
        $today = (new DateTime())->format('Y-m-d');

        // select ボックス要素作成
        $oeufs = $this->get_select_values('oeufs');
        $omlettes = $this->get_select_values('omlettes');
        $fms = $this->get_select_values('fms');
        $laitues = $this->get_select_values('laitues');
        $okonomiyakis = $this->get_select_values('okonomiyakis');

        /**
         * Satoの手動指示がある場合は優先表示
         * flg 9:  ディナー オープン前 17h　Cuisinier
         * 
         */       
        $sato_instruction = SatoInstruction::where([
            //AMの指示を取得
            ['flg_int', '=', '9'],
            ['aply_date', '=', $today]
        ])->first();

        $yes_sato = false;
        if(! is_null($sato_instruction)){
            // サトの独自指示がある場合は viewをgetして処理終了
            $yes_sato = true;
        }

        /**
         * 入力データ表示
         * 'flg1' => 5　ディナーオープン前のキッチンスタッフ入力データ18時
         */
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('5', '14');
        \Session::flash('stock_ingredients', $stock_ingredients);
        
        return view('cuisine_diner_top', compact('today','oeufs','omlettes','fms','laitues','okonomiyakis','sato_instruction','yes_sato'));
    }

    /**
     * ディナープレパレリスト表示. 17時用 
     * 登録後に表示
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cuisine_diner_task(Request $request, $id=null, $params=null) {

        // 曜日を取得 Fumi 独自クラスインスタンス化 
        $fumi_tools =new FumiTools();
        $daysoftheweek = $fumi_tools->fumi_get_youbi_for_table(date('w'));

        // きゅいじにえー入力データ取得 / flg= 5 / 2週間 14
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('5', '14'); 
        \Session::flash('stock_ingredients', $stock_ingredients);

        /**
         * Satoの手動指示がある場合は優先表示
         * flg 9:  ディナー オープン前　Cuisinier 17H アレディン   [上書き] [追加]
         */
        $date_today = date_create()->format('Y-m-d');   
        $sato_record = SatoInstruction::where('flg_int', 9)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();

        $sato_text_flg = false;
        $sato_text_mode = 0;
        if(! empty($sato_record)){
            //dd($sato_record);
            // 9
            $sato_text_mode = $sato_record->flg_int;
            //サト指示有の為 表示
            $sato_text_flg = true;
            \Session::flash('sato_record', $sato_record);
            \Session::flash('sato_text_mode', $sato_text_mode);

            // 上書きの時は強制的に表示
            if($sato_text_mode == 9){
                // View
                return view('cuisine_diner_task',compact('daysoftheweek',
                    'sato_text_flg', 
                    'sato_record',
                    'sato_text_mode'
                ));       
            }
        }

        // 前ページ 入力データ取得 
        $inputs = $request->all();
       // dd($inputs);
        // リクエストデータ取得
        $req_oeufs = intval($inputs['oeufs']);
        $req_omlettes = intval($inputs['omlettes']);
        $req_fms = intval($inputs['fms']);
        $req_laitues = intval($inputs['laitues']);
        $req_okonomiyakis = intval($inputs['okonomiyakis']);

        /**
         * サト指示 [追加] flg = 10 
         * 追加
         */
        $sato_record = SatoInstruction::where('flg_int', 10)
            ->where('aply_date', $date_today)
            ->latest('updated_at')
            ->first();

        // View
        return view('cuisine_diner_task',compact('daysoftheweek',
            'stock_ingredients', 
            'sato_text_flg', 
            'sato_record',
            'sato_text_mode',
            'sato_record',
            'req_oeufs',
            'req_omlettes',
            'req_fms',
            'req_laitues',
            'req_okonomiyakis',
        ));
    } 

    /**
     * select values
     * 追加：　　mode_inserts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_select_values($s_id){


        if($s_id == 'oeufs'){
            // select ボックス要素作成
            $oeufs = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => 'moins que 6 p'],
                ['id' => '2', 'name' => '6 ～ 11 p'],
                ['id' => '3', 'name' => 'plus que 12 p'],
            ]);
            return $oeufs;
        }

        if($s_id == 'omlettes'){
            // select ボックス要素作成
            $omlettes = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => '1 p'],
                ['id' => '2', 'name' => '2 p'],
            ]);
            return $omlettes;
        }

        if($s_id == 'laitues'){
            // select ボックス要素作成
            $laitues = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => 'un peu'],
                ['id' => '2', 'name' => 'la moitié'],
                ['id' => '3', 'name' => 'plein'],
            ]);
            return $laitues;
        }

        if($s_id == 'fms'){
            // select ボックス要素作成
            $fms = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => '1 p'],
                ['id' => '2', 'name' => '2 p'],
                ['id' => '3', 'name' => '3 p'],
                ['id' => '4', 'name' => '4 p'],
                ['id' => '5', 'name' => '5 p'],
                ['id' => '6', 'name' => 'plus que 6p'],
            ]);
            return $fms;
        }

        if($s_id == 'okonomiyakis'){
            // select ボックス要素作成
            $okonomiyakis = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => '1 paquet'],
                ['id' => '2', 'name' => '2 paquets'],
            ]);
            return $okonomiyakis;
        }
}
}
