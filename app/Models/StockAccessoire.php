<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAccessoire extends Model
{
    use HasFactory;

    protected $table = 'stock_accessoires';
    public $timestamps = true;

    protected $fillable = [
        'essuie_jmb',
        'papier_toilettes',
        'plastique_chaud_750ml',
        'plastique_froide_500ml',
        'plastique_froide_1000ml',
        'papier_serviette',
        'aluminium_901',
        'aluminium_701',
        'aluminium_401',
        'pot_de_sauce_30cc',
        'bol_carton_rond',
        'sac_transparant',
        'sac_petit',
        'sac_grand',
        'sac_poubelle',
        'bicarbonate',
        'tahina_pate_du_sesame',
        'viande_hachee_poulet_congele',
        'viande_hachee_boeuf_congele',
        'tantan_boeuf',
        'article1',
        'article2',
        'article3',
        'article4',
        'article5',
        'article6',
        'article7',
        'article8',
        'article9',
        'article10',
        'sub1',
        'sub2',
        'sub3',
        'color',
        'flg',
        'flg2',
        // asia _ select box
        "sauce_poisson", "pate_miso_20kg", 
        "mirin_20kg", "algue_wakame", 
        "poudre_dashi", "shichimi", 
        "sauce_tomyum", "sauce_toubanjyun",
        //number
        "gari_gingimbre", "algue_nori",
    ]; 

    /**
     * 整理可能モデルクエリの取得
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        // レコードを自動削除
        return static::where('created_at', '<=', now()->subDays(500));
    }

}
