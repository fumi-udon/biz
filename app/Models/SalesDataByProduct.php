<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDataByProduct extends Model
{
    use HasFactory;

    protected $table = 'sales_data_by_products';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'product_name',
        'product_id',
        'product_type',
        'product_type_id',
        'extra',
        'extra_flg',
        'category_id',
        'category_name',
        'sub_category_name',
        'order_quantity',
        'unit_name',
        'price',
        'sub_price',
        'dispo_flg',
        'display_flg',
        'saison_id',
        'add_info',
        'add_txt',
        'order_datetime'    
    ]; 
}
