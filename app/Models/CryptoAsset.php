<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoAsset extends Model
{
    protected $fillable = [
        'user_id',
        'coin_id',
        'coin_symbol',
        'amount',
    ];
}
