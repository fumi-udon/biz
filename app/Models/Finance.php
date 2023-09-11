<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    protected $table = 'finances';
    public $timestamps = true;
    protected $fillable = ['id', 'shop', 'name', 'article', 'zone', 'adress', 'comman1', 'comman2', 'comman3', 
        'comman4', 'recettes_main', 'recettes_sub', 'recettes_sub2', 'montant_init', 'montant_1', 'montant_2',     
        'chips', 'chips_sub', 'caisse', 'caisse_sub', 'caisse_ozark', 'cash', 'cash_sub', 'cheque', 'cheque_sub', 
        'card', 'card_sub', 'mode_pay_1', 'mode_pay_2', 'mode_pay_3', 'flg', 'cat', 'cat_1', 'cat_2', 'bravo', 
        'boo', 'dei', 'registre_date', 'registre_datetime', 'created_at', 'updated_at'];
}
