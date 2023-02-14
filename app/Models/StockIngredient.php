<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIngredient extends Model
{
    use HasFactory;
    protected $table = 'stock_ingredients';
    public $timestamps = true;

    protected $fillable = [
        'id','udon_rest_15h','udon_rest_a','article1_rest','article2_rest',
        'pudding_mt','pudding_sm','oeuf','article3_rest','article4_rest','article5_rest',
        'flg1','boo1','registre_date','registre_datetime'
    ]; 

    // ここで初期値を定義する
    protected $attributes = [
        'flg1' => 1,
        'boo1' => 0,
    ];
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
