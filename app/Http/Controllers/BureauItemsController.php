<?php
 /**
 * 事務所関連
 * _ Alice 在庫データ登録
 * 
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;
//Fumi 独自クラス
use App\FumiLib\FumiTools;
use App\FumiLib\AdminConcumedTools;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
use App\Models\ConditionType;
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;
use Carbon\Carbon;

class BureauItemsController extends Controller
{
    /**
    * article1_rest  : 米袋
    * article2_rest  : プードルマイス
    * article3_rest  : 坦々肉
    * article4_rest  : 
    * article5_rest  : 
    */

    /**
     * 事務所ストック入力トップページ
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bureau_stock_top()
    {        
        $today = (new DateTime())->format('Y-m-d');

        // 画面表示用にプルダウンのnameを格納した連想配列を作成 start
        // * [使用法] 
        // * 1.stock_ingredientsの表示対象のモデルデータを渡す
        // * 2.プルダウン集にプルダウンデータを追加 
        // * 3.articles_by_tableの数をプルダウンの数と一致させる

        // 表示対象モデルデータ
        $stock_ingredients = FumiTools::get_stockIngredient_by_keys('4', '14');

        // プルダウン集 select ボックス要素作成
        $article1s = $this->get_select_values('article1s'); // sac de riz
        $article2s = $this->get_select_values('article2s'); // carton de sauce de soja
        $article3s = $this->get_select_values('article3s'); // poudre du mais
        $article4s = $this->get_select_values('article4s'); // udon bols
        $article5s = $this->get_select_values('article5s'); // gyoza
        $pulldowns = [$article1s, $article2s, $article3s, $article4s, $article5s];
        
        // stock_ingredientテーブルのカラム名
        $columun_names = ["article1_rest", "article2_rest", "article3_rest", "article4_rest", "article5_rest"];        
        $stock_ingredients_display = FumiTools::get_display_datas($stock_ingredients, $pulldowns, $columun_names);
        // 表示用にプルダウンのnameを格納した連想配列を作成 end

        return view('bureau_stock_top', compact('today','article1s','article2s','article3s','article4s','article5s','stock_ingredients','stock_ingredients_display'));
    }

    /**
     * 事務所 登録処理
     * Detabase登録処理
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bureau_stock_store(Request $request, $id=null, $params=null)    {

        $inputs = $request->all();
        // リクエストデータ取得 
        $req_article1s = intval($inputs['article1s']);
        $req_article2s = intval($inputs['article2s']);
        $req_article3s = intval($inputs['article3s']);
        $req_article4s = intval($inputs['article4s']);
        $req_article5s = intval($inputs['article5s']);

        // StockIngredient テーブル
        //  事務所在庫データ
        // ※ 'flg1' => 4 
        date_default_timezone_set('Africa/Tunis');
        $stock_ingredient = StockIngredient::updateOrCreate(
            [
                'registre_date' => date('Y-m-d'),
                // 事務所在庫データ
                'flg1' => 4
            ],
            [
                'article1_rest' => $req_article1s,
                'article2_rest' => $req_article2s,
                'article3_rest' => $req_article3s,
                'article4_rest' => $req_article4s,
                'article5_rest' => $req_article5s,
                'registre_date' => date('Y-m-d'),
                'registre_datetime' => now(),
                // error回避：ダミーデータ挿入
                'udon_rest_15h' => 44,
            ]
        );

        // session 格納
        \Session::flash('flash_message', 'MERCI Alice! <br>Les données sont envoyées correctement'.'<br><br>Je voudrais refaire _ <a href="/bureau_stock_top"> oui </a>'
        );

        // リダイレクト
        return redirect()->route('bureau.stock.top')->with([
            //画面引継ぎ POST
            'article1_now' => $req_article1s,
            'article2_now' => $req_article2s,
            'article3_now' => $req_article3s,
            'article4_now' => $req_article4s,
            'article5_now' => $req_article5s
            ]);
    }

    /**
     * select values
     * 追加：　　mode_inserts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_select_values($s_id){
        //1
        if($s_id == 'article1s'){
            // select ボックス要素作成
            $article1s = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'moins que 3 sacs'],
                ['id' => '1', 'name' => 'entre 4 ～ 6 sacs'],
                ['id' => '2', 'name' => 'entre 7 ～ 10 sacs'],
                ['id' => '3', 'name' => 'plus que 10 sacs'],
            ]);
            return $article1s;
        }
        //2
        if($s_id == 'article2s'){
            // select ボックス要素作成
            $article2s = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'moins que 2 cartons'],
                ['id' => '1', 'name' => 'entre 3 ～ 5 cartons'],
                ['id' => '2', 'name' => 'entre 6 ～ 8 cartons'],
                ['id' => '3', 'name' => 'plus que 9 cartons'],
            ]);
            return $article2s;
        }
        // 3
        if($s_id == 'article3s'){
            // select ボックス要素作成
            $article3s = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'trés peu'],
                ['id' => '1', 'name' => 'un peu'],
                ['id' => '2', 'name' => 'moyen'],
                ['id' => '3', 'name' => 'beaucoup'],
            ]);
            return $article3s;
        }
        //4
        if($s_id == 'article4s'){
            // select ボックス要素作成 UDON
            $article4s = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => '0'],
                ['id' => '1', 'name' => 'demi bol'],
                ['id' => '2', 'name' => '1 bol et demi'],
                ['id' => '3', 'name' => '2 bol'],
                ['id' => '4', 'name' => '2 bols et demi'],
                ['id' => '5', 'name' => '3 bols'],
                ['id' => '6', 'name' => '3 bols et demi'],
            ]);
            return $article4s;
        }
        //5
        if($s_id == 'article5s'){
            // select ボックス要素作成 Gyoza
            $article5s = collect([
                ['id' => '', 'name' => ''],
                ['id' => '0', 'name' => 'moins que 10 sachets'],
                ['id' => '1', 'name' => 'moins que la moitié'],
                ['id' => '2', 'name' => 'présque la moitié'],
                ['id' => '3', 'name' => 'présque plein'],
            ]);
            return $article5s;
        }
}
}
