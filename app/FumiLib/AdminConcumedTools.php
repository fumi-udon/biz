<?php

namespace App\FumiLib;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class AdminConcumedTools
{
    /**
     * Extra検索
     * 
     * 該当日のエクストラの消費量を全て（product_names.php定義）取得し
     * 商品名 => 消費数量 のcollectionクラスをreturnする.   
     */
    public static function get_extra_consodatas($collections, $extra_seach_name, $arg_flg = null ) {
       
        $collects_resultat = collect();
        foreach($extra_seach_name as $key){
            $total_qty_extra = 0;
            foreach($collections as $collection) {
                $items = collect($collection['items']);
                $filtered = $items->filter(function ($order) {
                    return count($order['ingredients']) > 0;
                });
                $filtered_v2 = $filtered->map(function ($order) use ($key) {
                    $ingredients = collect($order['ingredients'])->filter(function ($ingredient) use ($key) {
                        return str_contains($ingredient['name_for_staff'], $key);
                    })->all();
                    return array_merge($order, ['ingredients' => $ingredients]);
                })->filter(function ($order) {
                    return count($order['ingredients']) > 0;
                });
                $total_qty_extra += collect($filtered_v2)->sum('qty');
                
            }
            $collects_resultat->push([$key => $total_qty_extra]);
        }
        return $collects_resultat;
    }
    /**
     * 餃子個数計算
     * 
     * 該当日のエクストラの消費量を全て（product_names.php定義）取得し
     * 商品名 => 消費数量 のcollectionクラスをreturnする.   
     */
    public static function get_gyouza_count($collections, $arg_flg = null ) {
        $collects_resultat = collect();
        // Gyoza 消費量を把握するテスト
        $gyoza_8p_qty = 0;
        $gyoza_12p_qty  = 0;
        foreach($collections as $order) {
            // ※注文毎の処理
            // order: 各テーブル毎の注文データ（全員分の商品格納）
            $items = collect($order['items']);
            // items: テーブル単位の注文商品データ群(type/extraの情報が格納)
            $filtered = $items->filter(function ($product) {
                // 提供済のみフィルター
                return $product['is_served'] == 1 ;
            });
            $filtered = $filtered->filter(function ($unit)  {                
                return str_contains($unit['product_name_for_staff'], 'gyoza');
            });
            $filtered8p = $filtered->filter(function ($unit)  {                
                return str_contains($unit['product_type_name_for_staff'], '8 p');
            });
            $gyoza_8p_qty += collect($filtered8p)->sum('qty');

            $filtered12p = $filtered->filter(function ($unit)  {                
                return str_contains($unit['product_type_name_for_staff'], '12 p');
            });
            $gyoza_12p_qty += collect($filtered12p)->sum('qty');      
        }
        //dd($gyoza_8p_qty * 8, $gyoza_12p_qty * 12);
        // Gyoza 消費量を把握するテストend
        $collects_resultat->push(['gyoza 8p' => $gyoza_8p_qty * 8, 'gyoza 12p' => $gyoza_12p_qty * 12]);
        return $collects_resultat;
    }

    /**
     * 商品検索
     * 
     * 該当日の消費量を全て（product_names.php定義）取得し
     * 商品名 => 消費数量 のcollectionクラスをreturnする.   
     */
    public static function get_product_consodatas($collections, $product_seach_name, $arg_flg = null ) {
        $collects_resultat = collect();

        foreach($product_seach_name as $key){
            $total_qty = 0;
            $create_time=[];
            foreach($collections as $order) {
                // ※注文毎の処理
                // order: 各テーブル毎の注文データ（全員分の商品格納）
                $items = collect($order['items']);
                // items: テーブル単位の注文商品データ群(type/extraの情報が格納)
                $filtered = $items->filter(function ($product) {
                    // 提供済のみフィルター
                    return $product['is_served'] == 1;
                });

                // 注文単位でkey（商品名）に一致したデータ 例＞TABLE1のramen sojaの数 等
                $collect_by_key = $filtered->filter(function ($unit) use ($key) {
                    return str_contains($unit['product_name_for_staff'], $key);
                })
                ->reject(function ($unit) {
                    return empty($unit);
                })
                ->all();
               // $collect_by_key = collect($collect_by_key)->pluck('product_name_for_staff','qty');

                $total_qty += collect($collect_by_key)->sum('qty');
            }            
            $collects_resultat->push([$key => $total_qty]);
        }

        return $collects_resultat;
    }

}