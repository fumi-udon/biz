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
}