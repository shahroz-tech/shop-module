<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = [];

    // Each cart item belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each cart item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
