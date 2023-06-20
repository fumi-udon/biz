<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

// MODELS
use App\Models\AuthHanabishi;
use App\Models\Responsable;

class CheckListController extends Controller
{

    /**
     * 閉店チェックList.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close_top(){

        // -------[本番環境でのみ処理]-------- START
        // 22時前は表示不可
        if (App::environment('production')) {            
            $currentDateTime = Carbon::now();
            if ($currentDateTime->hour < 22 ){
                // 22時前
                $error_message = "Nous sommes avant l'heure de fermeture. Veuillez patienter jusqu'à 22 heures<br><br>" 
                                ."Nahnu qabla waqt al-igla'. Yurja al-intidar hatta al-sa'at 22.";
                \Session::flash('error_message', $error_message);
                //時刻表示用
                $date = Carbon::now();
                $formattedDate = $date->format('H:i:s');
                \Session::flash('formattedDate', $formattedDate);            
                return view('error_page');
            }
        }
        // -------[本番環境でのみ処理]-------- END

        // 履歴表示
        $records = Responsable::where('type', 'close')
        ->where('charge', 'close_chk')
        ->where('fuseau_horaire', 1)
        ->get()    
        ->map(function ($record) {
            $record['formatted_created_at'] = Carbon::parse($record['created_at'])->format('d/m/Y _ H:i:s');
            return $record;
        })->sortByDesc('formatted_created_at')
        ->toArray();
        return view('chk_close_top', compact('records'));
    }

    /**
     * step1
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close_step1(Request $request)    {

        $inputs = $request->all();
        return view('chk_close_step1');
    }

    /**
     * step2
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close_step2(Request $request)    {

        $inputs = $request->all();
        // select ボックス要素作成
        $close_names = $this->create_data_selectbox("user_name");
        return view('chk_close_step2',compact('close_names'));
    }

    /**
     * 完了ページ
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close_garantie(Request $request)    {

        $inputs = $request->all();
        // 責任者 / password
        $close_name = $inputs['close_names_list'];
        $input_pass = $inputs['input_pass'];
        Log::debug($close_name);
        Log::debug($input_pass);
        // パスワード認証 
        $adminpass = AuthHanabishi::where('user_name', '=', $close_name)->value('password');
        // 認証チェック
        $auth_flg = false;

        if($adminpass === $input_pass){
            //パスワード認証OK
            $auth_flg = true; 
            //セッションに認証OKフラグ立てる
            $request->session()->put("auth_flg","true");
        }else {
            //管理者認証エラー
            $action_message = "[ERROR] Password is not correct ";
            // 現在の認証者名
            \Session::flash('close_name_now', $close_name);
            \Session::flash('action_message', $action_message);
            // select ボックス要素作成
            $close_names = $this->create_data_selectbox("user_name");
            return view('chk_close_step2', compact('action_message', 'close_names'));
        }

        \Session::flash('flash_message', 'Merci !  ' .$close_name. '   Bonne nuit :}');
        
        //退勤時間表示ページ
        $date = Carbon::now();
        $formattedDate = $date->format('H:i:s');

        // データベースに挿入
        $result_1 = Responsable::create(
            [
                'name' => $close_name,
                'type' => 'close',
                'charge' => 'close_chk',
                'fuseau_horaire' => 1,
            ]
        );

        return view('chk_garantie', compact('close_name', 'auth_flg', 'formattedDate'));
    }

    /**
     *  select box データ作成
     */
    public function create_data_selectbox($type)
    {
        $datas = null;
        // 
        if($type == "user_name"){
            // ユーザーネーム
            $datas = collect([
                ['id' => '', 'name' => ''],
                ['id' => 'fumi', 'name' => 'fumi'],
                ['id' => 'sato', 'name' => 'sato'],
                ['id' => 'bilel', 'name' => 'bilel'],
                ['id' => 'guest', 'name' => 'guest'],
            ]);
        }
        return $datas;
    }
}
