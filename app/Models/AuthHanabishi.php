<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthHanabishi extends Model
{
    use HasFactory;

    protected $table = 'auth_hanabishis';
    public $timestamps = true;

    protected $fillable = [
        'id', 'user_name', 'password', 'sub_1', 'flg_int', 'flg_boo', 'created_at', 'updated_at'
    ]; 

    // ここで初期値を定義する
    protected $attributes = [
        'sub_1' => "sub_1 dummy init data",
        'flg_int' => 0,
        'flg_boo' => 1,
    ];
}
