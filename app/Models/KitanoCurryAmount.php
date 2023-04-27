<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Prunable;

class KitanoCurryAmount extends Model
{
    use HasFactory;
    
    // モデルの整理
    use Prunable;

    protected $table = 'kitano_curry_amounts';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'bouillons',
        'pate',
        'poudre'
    ];

    /**
     * 整理可能モデルクエリの取得
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        // 2日前以前のレコードを自動削除
        return static::where('created_at', '<=', now()->subDays(2));
    }
}
