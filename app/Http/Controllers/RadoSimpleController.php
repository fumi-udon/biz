<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
        $date = now()->toDateString();
        // SSL エラー回避
        $response = Http::withoutVerifying()->get('https://bistronippon.com/api/orders', [
            'store' => 'currykitano',
            'date' => $date,
        ]);

        dd(collect($response->json()));

        $json_datas = [];

        return view('dev/rado_simple', compact("json_datas"));
    }

}
