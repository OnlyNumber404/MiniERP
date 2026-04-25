<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['cat_name', 'type'];

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}