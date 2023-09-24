<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;
    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    function query_products()
    {
        return $this->hasMany(QueryProduct::class, 'query_id', 'id');
    }
    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
