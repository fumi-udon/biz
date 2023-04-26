<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitanoCurryAmount extends Model
{
    use HasFactory;
    protected $table = 'kitano_curry_amounts';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'bouillons',
        'pate',
        'poudre'
    ]; 
}
