<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KicalcsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the cals page dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('kicalcs');
    }
}
