<?php

namespace App\Models;

use App\Traits\BelongsToErp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use BelongsToErp, SoftDeletes;

    protected $fillable = ['cat_name', 'type', 'erp_id'];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
