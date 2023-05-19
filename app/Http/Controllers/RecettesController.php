<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecettesController extends Controller
{
    /**
     * Index. 初期ページ表示
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function recettes_index()
    {

        $data = '';
        Log::debug('レシピ集コントローラ HELLO!');

        return view('recettes_top', compact('data'));
    }

    /**
     * 米
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function riz_jp()
    {

        $data = '';
        Log::debug('レシピ集コントローラ riz_jp!');

        return view('recettes/riz_jp', compact('data'));
    }
}
