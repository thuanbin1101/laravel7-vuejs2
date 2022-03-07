<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Category;
class Product extends Model
{
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
