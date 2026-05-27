<?php

namespace App\Models;

use App\Traits\BelongsToErp;
use Illuminate\Database\Eloquent\Model;

class CryptoAsset extends Model
{
    use BelongsToErp;

    protected $fillable = [
        'user_id',
        'erp_id',
        'coin_id',
        'coin_symbol',
        'amount',
    ];
}
