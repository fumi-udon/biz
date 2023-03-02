<?php

namespace App\FumiLib;

use Illuminate\Http\Request;
use App\Models\SatoInstruction;
use App\Models\PlanProduction;

class FumiTools
{
    public function hello()
    {
        return 'Hello world';
    }
   
    
    /**
     * FUMI
     *  曜日をdbカラムに適合した文字列で返す 例 mon,tue...
     * 
     */
    public function fumi_get_youbi_for_table($ynum) {
        $youbi;
        $week = [
            'sun', //0
            'mon', //1
            'tue', //2
            'wed', //3
            'thu', //4
            'fri', //5
            'sat', //6
        ];

        $youbi = $week[$ynum];

        return $youbi;
    }

    /**
     * FUMI
     *  return 配列
     * 
     */
    public function fumi_get_cons_array($item, $flg) {
        $product_name_for_staff = data_get($item, 'product_name_for_staff');
        $order_id = data_get($item, 'order_id');
        $created_at = data_get($item, 'created_at');
        $formatted_date = \Carbon\Carbon::parse($created_at)->format('Y年m月d日 H時i分');
        $product_type_name_for_staff = data_get($item, 'product_type_name_for_staff');
        $qty = data_get($item, 'qty'); 
        $ex_order = compact('order_id', 'formatted_date', 'product_name_for_staff','product_type_name_for_staff','qty');

        return $ex_order;
    }
}