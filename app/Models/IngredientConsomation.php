<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientConsomation extends Model
{
    use HasFactory;

    protected $table = 'ingredient_consomations';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'ingredient_id',
        'ingredient_name',
        'ingredient_category',
        'ingredient_sub_id',
        'ingredient_sub_name',
        'ingredient_sub_category',
        'product_id',
        'product_name',
        'product_type',
        'category',
        'sub_category',
        'sup_id',
        'sup_name',
        'sup2_id',
        'sup2_name',
        'consommation',
        'consommation_sub',
        'unit_name',
        'unit_sub_name',
        'dispo_flg',
        'display_flg',
        'saison_id',
        'add_info',
        'add_txt'
    ]; 



    // ここで初期値を定義する
    // protected $attributes = [
    //     'clomun' => 1,
    // ];
}
