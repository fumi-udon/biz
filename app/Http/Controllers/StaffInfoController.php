<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffInfoController extends Controller
{
    /**
     * Index. スタッフ メニューページ表示 
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function staff_menu_top()
    {
        return view('staff_menu_top');
    }

    /**
     * contact_urgent
     */
    public function contact_urgent()
    {
        return view('contact_urgent');
    } 
}
