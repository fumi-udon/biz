<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatoInstruction extends Model
{
    use HasFactory;

    protected $table = 'sato_instructions';
    public $timestamps = true;

    protected $fillable = ['override_tx_1', 'override_tx_2', 'override_tx_3', 'flg_int', 'flg_boo', 'aply_date']; 



    // ここで初期値を定義する
    protected $attributes = [
        'flg_boo' => 1,
        'override_tx_2' => 'simple 2',
        'override_tx_3' => 'simple 3',
    ];
}
