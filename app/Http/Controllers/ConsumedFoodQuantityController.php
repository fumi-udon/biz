<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsumedFoodQuantityController extends Controller
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
     * Index. 
     * Log::debug("xxxxxx");
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Log::debug("ConsumedFoodQuantityController呼ばれたよ");
        // 一時テーブル作成サンプル
        DB::statement('CREATE TEMPORARY TABLE temp_table_conso (id INT, name VARCHAR(255), age INT)');
        DB::table('temp_table_conso')->insert([
            ['id' => 1, 'name' => 'John Doe', 'age' => 25],
            ['id' => 2, 'name' => 'Jane Doe', 'age' => 30],
            ['id' => 3, 'name' => 'Bob Smith', 'age' => 35],
        ]);

        $temp_table_conso = DB::table('temp_table_conso')
             ->select(DB::raw("id, name, age"))
             ->limit(100)
             ->get();

        $dummy = "ConsumedFoodQuantityController dummy data サンプル";
        return view('consumed_food_quantity', compact('dummy', 'temp_table_conso'));
    }
}
