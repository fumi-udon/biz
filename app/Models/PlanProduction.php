<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanProduction extends Model
{
    use HasFactory;

    protected $table = 'plan_productions';
    public $timestamps = true;

    protected $fillable = [
        'rmn_mon', 'rmn_tue', 'rmn_wed', 'rmn_thu', 'rmn_fri', 'rmn_sat', 'rmn_sun', 
        'udon_base_mon', 'udon_base_tue', 'udon_base_wed', 'udon_base_thu', 'udon_base_fri', 'udon_base_sat', 'udon_base_sun',
        'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun',
    ]; 



    // ここで初期値を定義する
    // protected $attributes = [
    //     'clomun' => 1,
    // ];
}
