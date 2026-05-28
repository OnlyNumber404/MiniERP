<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToErp
{
    /**
     * Boot the trait to add the global scope.
     */
    protected static function bootBelongsToErp()
    {
        static::addGlobalScope('erp', function (Builder $builder) {
            if (Auth::check() && Auth::user()->erp) {
                $builder->where('erp_id', Auth::user()->erp->id);
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->erp && empty($model->erp_id)) {
                $model->erp_id = Auth::user()->erp->id;
            }
        });
    }
}
