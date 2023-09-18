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

        // select ボックス要素作成
        $patecurry = $this->get_select_values('patecurry');

        $tomate = $this->get_select_values('line_5piece');
        $onion = $this->get_select_values('line_5piece');
        $carottes = $this->get_select_values('line_5piece');        
        $piment = $this->get_select_values('line_5piece');
        $aubergine = $this->get_select_values('line_5piece');
        $courgette = $this->get_select_values('line_5piece');
        $pomme_de_terre = $this->get_select_values('line_5piece');

        $poireaux = $this->get_select_values('standard');
        $persil = $this->get_select_values('standard');
        $coreandre = $this->get_select_values('standard');
        $laitue = $this->get_select_values('line_2piece');
        $choux = $this->get_select_values('line_2piece');
        $apple = $this->get_select_values('line_2piece');

        
        return view('khouloud_commence_input', compact(
            'today',
            'patecurry',
            'tomate',
            'onion',
            'carottes',
            'piment',
            'aubergine',
            'courgette',
            'pomme_de_terre',
            'poireaux',
            'persil',
            'coreandre',
            'laitue',
            'choux',
            'apple',
        ));
    }

    /**
     * 登録 ページ
     */
    public function khouloud_commence_store(Request $request, $id=null, $params=null)
    {
        $inputs = $request->all();
        $today = (new DateTime())->format('Y-m-d');

        // session 格納
        \Session::flash('flash_message', 'MERCI<br>Les données sont envoyées correctement');
        \Session::flash('patecurry_now', $inputs['patecurry']);
        \Session::flash('tomate_now', $inputs['tomate']);
        \Session::flash('onion_now', $inputs['onion']);
        \Session::flash('carottes_now', $inputs['carottes']);
        \Session::flash('piment_now', $inputs['piment']);
        \Session::flash('aubergine_now', $inputs['aubergine']);
        \Session::flash('courgette_now', $inputs['courgette']);
        \Session::flash('pomme_de_terre_now', $inputs['pomme_de_terre']);
        \Session::flash('poireaux_now', $inputs['poireaux']);
        \Session::flash('persil_now', $inputs['persil']);
        \Session::flash('coreandre_now', $inputs['coreandre']);
        \Session::flash('laitue_now', $inputs['laitue']);
        \Session::flash('choux_now', $inputs['choux']);
        \Session::flash('apple_now', $inputs['apple']);
        
        // リダイレクト
        return redirect()->route('khouloud.commence.input')->with([
            //画面引継ぎsession格納
            'today' => $today,
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
                ['id' => '1', 'name' => 'un peu'],
                ['id' => '2', 'name' => 'moins que moitié'],
                ['id' => '3', 'name' => 'la moitié'],
                ['id' => '4', 'name' => 'beaucoup'],
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


}
