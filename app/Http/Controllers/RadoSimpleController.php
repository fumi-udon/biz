<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// use App\Models\SatoInstruction;
// use App\Models\PlanProduction;
// use App\Models\StockIngredient;
// use App\Models\AuthHanabishi;

class RadoSimpleController extends Controller
{
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
    public function index()
    {
        Log::debug("はい！私がラドさんコントローラっす");

        // TODO jsonデータ取得 rado_simple.blade.php に表示
        $json_datas = [];

        return view('dev/rado_simple', compact("json_datas"));
    }

}
