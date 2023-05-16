<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionType extends Model
{
    use HasFactory;
    
    // モデルの整理
    use Prunable;

    protected $table = 'condition_types';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'type',
        'kubun',
        'numero',
        'color',
        'sub1',
        'sub2'
    ];

    /**
     * 整理可能モデルクエリの取得
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        // 20日前以前のレコードを自動削除
        return static::where('created_at', '<=', now()->subDays(20));
    }
}
