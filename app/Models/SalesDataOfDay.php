<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDataOfDay extends Model
{
    use HasFactory;

    protected $table = 'sales_data_of_days';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'sub_id',
        'shop_code',
        'shop_sub_code',
        'shop_data',
        'sales_am',
        'sales_am_datetime',
        'sales_pm',
        'sales_pm_datetime',
        'sales_kool',
        'sales_kool_datetime',
        'sales_total',
        'sales_total_datetime',      
        'sales_flg',
        'kool_flg',
        'category_id',
        'dispo_flg',
        'display_flg',
        'saison_id',
        'add_info',
        'add_txt',
        'daily_json_data',
    ];

    protected $casts = [
        'daily_json_data' => 'json'
    ];

}
