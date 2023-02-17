<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Mail\SendinBlueDemoEmail;
use Illuminate\Support\Facades\Mail;
use Swift_Message;

use App\Models\IngredientConsomation;

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
     *e Index.
     * Log::debug("xxxxxx");
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $subject = "例 BN メールのタイトルはこんな感じ"; 
        $body = "本文っす。SendInBlueで送信できました。";

        //Mail 送信プログラム練習用
        // Mail::to('admin@bistronippon.tn')
        // ->cc('fumi.0000000@gmail.com')
        // ->bcc('fumi.0000000@gmail.com')
        // ->send((new SendinBlueDemoEmail($subject, $body))
        //     ->withSwiftMessage(function (Swift_Message $message) {
        //         $message->getHeaders()
        //                 ->addTextHeader('Content-Type', 'text/plain; charset=UTF-8');
        //     })
        // );
        //Mail 送信プログラム練習用 end

        DB::statement(
            'CREATE TEMPORARY TABLE temp_table_radojson (
                id INT(11),
                name VARCHAR(255),
                age INT(11)
            )'
        );
        DB::table('temp_table_radojson')->insert([
            ['id' => 1, 'name' => 'John Doe', 'age' => 25],
            ['id' => 2, 'name' => 'Jane Doe', 'age' => 30],
            ['id' => 3, 'name' => 'Bob Smith', 'age' => 35],
        ]);
        
        $temp_table_radojson = DB::table('temp_table_radojson')
            ->select(DB::raw("`id`, `name`, `age`"))
            ->limit(100)
            ->get();

        //TODO) 食材（例：レモン）に対応する 商品名(例：トムヤムラーメン)/消費量のMap作成
        //TODO) 

        $dummy = "ConsumedFoodQuantityController dummy data サンプル";
        return view('consumed_food_quantity', compact('dummy', 'temp_table_radojson'));
    }
}
