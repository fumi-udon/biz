<?php

namespace App\FumiLib;

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
use Carbon\Carbon;

class FumiValidation
{
    public function hello()
    {
        return 'Hello world';
    }

    /**
     * Int チェッカー
     */ 
    public static function checkInteger($variable, $variableName) {
        if (!is_int($variable)) {
            die("エラー: $variableName は整数型 (INT) ではありません。");
        }
    }
}