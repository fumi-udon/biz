<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;
    protected $table = 'responsables';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'charge', 'type', 'fuseau_horaire', 'sub_int1', 'sub_int2', 'sub_1', 'sub_2'];

    /**
     * 整理可能モデルクエリの取得
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        // 100日前以前のレコードを自動削除
        return static::where('created_at', '<=', now()->subDays(2000));
    }
}
