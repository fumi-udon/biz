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
        'table_number',
        'serial_id',
        'product_name',
        'product_id',
        'product_type',
        'product_toppings',
        'product_price',
        'category_id',
        'category_name',
        'order_quantity',
        'order_datetime',
        'concurrent_connections',
        'active_flag',
        'json_data'
    ];
    
        /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'json_data' => 'json',
    ];
}
