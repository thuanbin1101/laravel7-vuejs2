<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    // use SoftDeletes;
    protected $dates = ['deleted_at'];
    //
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
