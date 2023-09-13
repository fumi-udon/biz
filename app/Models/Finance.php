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


// recettes_mainカラムの値を小数点第一まで表示するメソッド
public function getRecettesMainAttribute($value)
{
    return number_format($value, null);
}

// recettes_subカラムの値を小数点第一まで表示するメソッド
public function getRecettesSubAttribute($value)
{
    return number_format($value, null);
}

    // montant_initカラムの値を小数点第一まで表示するメソッド
    public function getMontantInitAttribute($value)
    {
        return number_format($value, null);
    }

    // montant_1カラムの値を小数点第一まで表示するメソッド
    public function getMontant1Attribute($value)
    {
        return number_format($value, null);
    }

    // montant_2カラムの値を小数点第一まで表示するメソッド
    public function getMontant2Attribute($value)
    {
        return number_format($value, null);
    }

    // chipsカラムの値を小数点第一まで表示するメソッド
    public function getChipsAttribute($value)
    {
        return number_format($value, null);
    }

    // chips_subカラムの値を小数点第一まで表示するメソッド
    public function getChipsSubAttribute($value)
    {
        return number_format($value, null);
    }

    // caisseカラムの値を小数点第一まで表示するメソッド
    public function getCaisseAttribute($value)
    {
        return number_format($value, null);
    }

    // caisse_subカラムの値を小数点第一まで表示するメソッド
    public function getCaisseSubAttribute($value)
    {
        return number_format($value, null);
    }

    // caisse_ozarkカラムの値を小数点第一まで表示するメソッド
    public function getCaisseOzarkAttribute($value)
    {
        return number_format($value, null);
    }

    // cashカラムの値を小数点第一まで表示するメソッド
    public function getCashAttribute($value)
    {
        return number_format($value, null);
    }

    // cash_subカラムの値を小数点第一まで表示するメソッド
    public function getCashSubAttribute($value)
    {
        return number_format($value, null);
    }

    // chequeカラムの値を整数または小数点第一位まで表示するメソッド
    public function getChequeAttribute($value)
    {
        return number_format($value, null);
    }
    
    // cardカラムの値を整数または小数点第一位まで表示するメソッド
    public function getCardAttribute($value)
    {
        return number_format($value, null);
    }

    /**
     * 整理可能モデルクエリの取得
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        // 100日前以前のレコードを自動削除
        return static::where('created_at', '<=', now()->subDays(100));
    }

}
