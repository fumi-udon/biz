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
        $rizs = $this->get_select_values('rizs');

        /**
         * Satoの手動指示がある場合は優先表示
         * Aichaプレパレ用は　flg = 5
         * 
         */       
        $sato_instruction = SatoInstruction::where([
            //AMの指示を取得
            ['flg_int', '=', '5'],
            ['aply_date', '=', $today]
        ])->first();

        $yes_sato = false;
        if(! is_null($sato_instruction)){
            // サトの独自指示がある場合は viewをgetして処理終了
            $yes_sato = true;
        }
        /**
         * Aicha 入力米データ表示 / flg= 3
         * Sessionにデータ保持
         */
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('3', '7'); 
        \Session::flash('stock_ingredients', $stock_ingredients);

        return view('cuisine_diner_top', compact('today','rizs','sato_instruction','yes_sato'));
    }

    /**
     * select values
     * 追加：　　mode_inserts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_select_values($s_id){

        if($s_id == 'rizs'){
            // select ボックス要素作成
            $rizs = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'rien'],
                ['id' => '1', 'name' => 'moins que la moitié'],
                ['id' => '2', 'name' => 'la moitié'],
                ['id' => '3', 'name' => '1 casserole'],
                ['id' => '4', 'name' => '1 casserole et demi'],
                ['id' => '5', 'name' => '2 casserole'],
                ['id' => '6', 'name' => '2 casseroles et demi'],
                ['id' => '7', 'name' => 'plus de 3 casseroles'],
            ]);
            return $rizs;
        }

        if($s_id == 'mode_inserts'){
            // select ボックス要素作成
            $mode_inserts = collect([
                ['id' => '', 'name' => ''],
                ['id' => '6', 'name' => '上書き更新'],
                ['id' => '7', 'name' => '追加_TO_Aicha'],
                ['id' => '8', 'name' => '追加_TO_アンドレア'],
            ]);
            return $mode_inserts;
        }
}
}
