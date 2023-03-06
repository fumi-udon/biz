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
     *  return 配列fumi_get_paiko_type
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
    
    /**
     * FUMI
     *  return パイコータイプ 配列 
     * 
     */
    public function fumi_get_paiko_type($item) {
        // type, enfantパイコー配列
        $type_is_paikos=[];
        $plat_is_paikos=[];
        $katsu_is_paikos=[];
        $p_flg = false;
        //flag: plat > katsu > type > enfant
        $product_name_for_staff = data_get($item, 'product_name_for_staff');
        $product_type_name_for_staff = data_get($item, 'product_type_name_for_staff');
        if ($product_name_for_staff === 'paiko poulet') {
            // Plat パイコー
            $p_flg = 'plat';
        }else if(mb_stripos($product_type_name_for_staff, 'paiko') === 0
            || mb_stripos($product_type_name_for_staff, 'PAIKO') === 0
            || mb_stripos($product_type_name_for_staff, 'paiko') != false
            || mb_stripos($product_name_for_staff, 'enfant') === 0){
            // Type パイコーと子供メニュー
            $p_flg = 'type';
        }else if(mb_stripos($product_name_for_staff, 'katsu') === 0
            || mb_stripos($product_name_for_staff, 'Katsu') === 0
            || mb_stripos($product_name_for_staff, 'KATSU') != false){
            // katsu donburi/udon
            $p_flg = 'katsu';
        }
        $collection = collect();
        if($p_flg !== false){            
            // パイコーを使っている料理 yes
            $order_id = data_get($item, 'order_id');
            $created_at = data_get($item, 'created_at');
            $formatted_date = \Carbon\Carbon::parse($created_at)->format('Y年m月d日 H時i分');            
            $qty = data_get($item, 'qty');
            $ex_order = compact('order_id', 'formatted_date', 'product_name_for_staff','product_type_name_for_staff','qty');
            $collection->push([$p_flg => $ex_order]);        
        }     
        return $collection;
    }

    // $products 配列を初期化する関数
    function initAry($datas) {
        $initArys = [];
        foreach ($datas as $data) {
            $initArys[$data] = 0;
        }
        return $initArys;
    }
    /**
     * FUMI
     *  return 配列 
     *  引数はitemと文字列
     * 
     */
    public function fumi_get_consom_pn_staff($item, $products_str, $types_str) {
        $products_ary = explode(",", $products_str);
        $types_ary = explode(",", $types_str);

        $order_products = $this->initAry($products_ary);
        $order_types = $this->initAry($types_ary);
        $collection = collect();
        $flg=false;
        $flg_type=false;
        foreach ($order_products as $key => $i) {
            if (mb_stripos($item['product_name_for_staff'], $key) !== false) {
                $order_products[$key] += $item['qty'];
                $flg=true;
            }
        }
        foreach ($order_types as $key => $i) {
            if (mb_stripos($item['product_type_name_for_staff'], $key) !== false) {
                $order_types[$key] += $item['qty'];
                $flg_type=true;
            }
        }

        if($flg){
            // ある product_name_for_staff
            $collection->put('products',$order_products);
        }
        if($flg_type){
            // ある product_type_name_for_staff
            $collection->put('types',$order_types);
        }
        return $collection;
    }

}